<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../auth/session_check.php'; // Ensures only admin (owner) can access
require_once '../config/db.php';

header('Content-Type: application/json');

// Input Validation
if (!isset($_POST['action']) || !isset($_POST['property_ids']) || !is_array($_POST['property_ids'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid input. Missing action or property_ids.']);
    exit;
}

$action = trim($_POST['action']);
$property_ids_raw = $_POST['property_ids'];
$property_ids = array_map('intval', $property_ids_raw); // Sanitize to array of ints
$property_ids = array_filter($property_ids, function($id) { return $id > 0; }); // Remove invalid IDs (e.g., 0 or non-numeric after intval)

if (empty($property_ids)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'No valid property IDs provided.']);
    exit;
}

if (!in_array($action, ['activate', 'deactivate', 'delete'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid action specified.']);
    exit;
}

$conn->begin_transaction();
$success_count = 0;
$error_messages = [];
$overall_success = true;

try {
    if ($action === 'activate') {
        $stmt = $conn->prepare("UPDATE properties SET status = 'available' WHERE id = ?");
        if (!$stmt) throw new Exception("Prepare failed (activate): " . $conn->error);
        foreach ($property_ids as $id) {
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $success_count++;
                }
            } else {
                $error_messages[] = "Failed to activate property ID {$id}: " . $stmt->error;
                $overall_success = false;
            }
        }
        $stmt->close();
    } elseif ($action === 'deactivate') {
        $stmt = $conn->prepare("UPDATE properties SET status = 'unavailable' WHERE id = ?");
        if (!$stmt) throw new Exception("Prepare failed (deactivate): " . $conn->error);
        foreach ($property_ids as $id) {
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                 if ($stmt->affected_rows > 0) {
                    $success_count++;
                }
            } else {
                $error_messages[] = "Failed to deactivate property ID {$id}: " . $stmt->error;
                $overall_success = false;
            }
        }
        $stmt->close();
    } elseif ($action === 'delete') {
        // Prepare statements for fetching image paths
        $stmt_fetch_prop_images = $conn->prepare("SELECT image_path FROM property_images WHERE property_id = ?");
        $stmt_fetch_contact_img = $conn->prepare("SELECT contact_image_path FROM properties WHERE id = ?");

        // Prepare statements for deletions
        $stmt_del_amenities = $conn->prepare("DELETE FROM property_amenities WHERE property_id = ?");
        $stmt_del_services = $conn->prepare("DELETE FROM additional_services WHERE property_id = ?");
        $stmt_del_nearby = $conn->prepare("DELETE FROM nearby_places WHERE property_id = ?");
        $stmt_del_rooms = $conn->prepare("DELETE FROM room_types WHERE property_id = ?");
        $stmt_del_images = $conn->prepare("DELETE FROM property_images WHERE property_id = ?");
        $stmt_del_saved = $conn->prepare("DELETE FROM saved_properties WHERE property_id = ?");
        $stmt_del_property = $conn->prepare("DELETE FROM properties WHERE id = ?");

        if (!$stmt_fetch_prop_images || !$stmt_fetch_contact_img || !$stmt_del_amenities || !$stmt_del_services || !$stmt_del_nearby || !$stmt_del_rooms || !$stmt_del_images || !$stmt_del_saved || !$stmt_del_property) {
            throw new Exception("Prepare failed (delete sub-queries): " . $conn->error);
        }

        foreach ($property_ids as $id) {
            // Fetch and delete property gallery images
            $stmt_fetch_prop_images->bind_param("i", $id);
            if ($stmt_fetch_prop_images->execute()) {
                $result_images = $stmt_fetch_prop_images->get_result();
                while ($row_image = $result_images->fetch_assoc()) {
                    if (!empty($row_image['image_path']) && file_exists('../' . $row_image['image_path'])) {
                        if(!unlink('../' . $row_image['image_path'])) {
                             $error_messages[] = "Failed to delete image file: " . $row_image['image_path'];
                        }
                    }
                }
            } else {
                 $error_messages[] = "Failed to fetch property images for ID {$id}: " . $stmt_fetch_prop_images->error;
                 $overall_success = false; continue; // Skip to next property if critical info fetch fails
            }
            
            // Fetch and delete contact image
            $stmt_fetch_contact_img->bind_param("i", $id);
             if ($stmt_fetch_contact_img->execute()) {
                $result_contact_img = $stmt_fetch_contact_img->get_result();
                if($row_contact_img = $result_contact_img->fetch_assoc()){
                    if (!empty($row_contact_img['contact_image_path']) && file_exists('../' . $row_contact_img['contact_image_path'])) {
                         if(!unlink('../' . $row_contact_img['contact_image_path'])) {
                             $error_messages[] = "Failed to delete contact image file: " . $row_contact_img['contact_image_path'];
                         }
                    }
                }
            } else {
                 $error_messages[] = "Failed to fetch contact image for ID {$id}: " . $stmt_fetch_contact_img->error;
                 $overall_success = false; continue;
            }


            // Delete related records
            $related_stmts_map = [
                $stmt_del_amenities, $stmt_del_services, $stmt_del_nearby, 
                $stmt_del_rooms, $stmt_del_images, $stmt_del_saved
            ];
            foreach($related_stmts_map as $del_stmt) {
                $del_stmt->bind_param("i", $id);
                if(!$del_stmt->execute()) { 
                     $error_messages[] = "Failed to delete related data for property ID {$id}: " . $del_stmt->error;
                     $overall_success = false; // Mark as overall failure if any sub-deletion fails
                }
            }
            if(!$overall_success) continue; // If any related data deletion failed, skip deleting the main property to investigate.
            
            // Delete main property record
            $stmt_del_property->bind_param("i", $id);
            if ($stmt_del_property->execute()) {
                 if ($stmt_del_property->affected_rows > 0) {
                    $success_count++;
                } else {
                     // Property might have been deleted by another concurrent request or ID was invalid.
                     // Not necessarily an error to halt the whole batch if other IDs are valid.
                }
            } else {
                $error_messages[] = "Failed to delete property ID {$id}: " . $stmt_del_property->error;
                $overall_success = false;
            }
        }
        // Close all prepared statements for delete
        $stmt_fetch_prop_images->close();
        $stmt_fetch_contact_img->close();
        $stmt_del_amenities->close();
        $stmt_del_services->close();
        $stmt_del_nearby->close();
        $stmt_del_rooms->close();
        $stmt_del_images->close();
        $stmt_del_saved->close();
        $stmt_del_property->close();
    }

    if ($overall_success && empty($error_messages)) {
        $conn->commit();
        echo json_encode(['success' => true, 'message' => ucfirst($action) . " action completed. Successfully processed {$success_count} properties."]);
    } else {
        $conn->rollback();
        // If overall_success is false OR there are error messages, it means something went wrong.
        $final_message = "Some operations failed during bulk {$action}. Processed {$success_count} successfully.";
        if (!empty($error_messages)) {
            $final_message .= " Errors: " . implode("; ", $error_messages);
        }
        http_response_code(500); 
        echo json_encode(['success' => false, 'message' => $final_message]);
    }

} catch (Exception $e) {
    $conn->rollback();
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => "An exception occurred: " . $e->getMessage()
    ]);
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?>
