<?php
header('Content-Type: application/json');

// 1. Include session_check.php and db.php
require_once '../auth/session_check.php'; // Ensures only admin (owner) can access
require_once '../config/db.php';

// Helper function to delete a file if it exists (same as in other scripts)
function delete_file_from_server($filepath_relative_to_root) {
    if (!empty($filepath_relative_to_root)) {
        $full_path = __DIR__ . '/../' . $filepath_relative_to_root;
        if (file_exists($full_path)) {
            if (!unlink($full_path)) {
                // error_log("Failed to delete file: " . $full_path);
                return false;
            }
        }
    }
    return true;
}

// 4. Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['success' => false, 'message' => 'Invalid request method. Only POST is allowed.']);
    exit();
}

// 5. Retrieve action and property_ids from POST data
$action = trim($_POST['action'] ?? '');
$property_ids_raw = $_POST['property_ids'] ?? [];

// 6. Validate inputs
if (empty($action) || !in_array($action, ['activate', 'deactivate', 'delete'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['success' => false, 'message' => 'Invalid or missing action.']);
    exit();
}

if (empty($property_ids_raw) || !is_array($property_ids_raw)) {
    http_response_code(400); // Bad Request
    echo json_encode(['success' => false, 'message' => 'Property IDs must be provided as an array.']);
    exit();
}

$property_ids = [];
foreach ($property_ids_raw as $id) {
    $validated_id = filter_var($id, FILTER_VALIDATE_INT);
    if ($validated_id && $validated_id > 0) {
        $property_ids[] = $validated_id;
    } else {
        http_response_code(400); // Bad Request
        echo json_encode(['success' => false, 'message' => 'All Property IDs must be valid positive integers. Invalid ID found: ' . htmlspecialchars($id)]);
        exit();
    }
}

if (empty($property_ids)) {
    http_response_code(400); // Bad Request
    echo json_encode(['success' => false, 'message' => 'No valid property IDs provided.']);
    exit();
}

// Create ? placeholders for IN clause
$placeholders = implode(',', array_fill(0, count($property_ids), '?'));
// Create type string for bind_param (all "i" for integers)
$types = str_repeat('i', count($property_ids));


$conn->begin_transaction();

try {
    // 7. Perform Action
    switch ($action) {
        case 'activate':
            $new_status = 'available'; // Assuming 'available' is the DB representation for 'Active'
            $stmt_update_status = $conn->prepare("UPDATE properties SET status = ? WHERE id IN ({$placeholders})");
            if (!$stmt_update_status) throw new Exception("Prepare failed (activate): " . $conn->error);
            
            $bind_params = array_merge([$new_status], $property_ids);
            $bind_types = "s" . $types; // "s" for status, then "i" for each id
            
            $stmt_update_status->bind_param($bind_types, ...$bind_params);
            if (!$stmt_update_status->execute()) throw new Exception("Execute failed (activate): " . $stmt_update_status->error);
            $affected_rows = $stmt_update_status->affected_rows;
            $stmt_update_status->close();
            $conn->commit();
            echo json_encode(['success' => true, 'message' => "Successfully activated {$affected_rows} properties."]);
            break;

        case 'deactivate':
            $new_status = 'unavailable'; // Assuming 'unavailable' is for 'Inactive'
            $stmt_update_status = $conn->prepare("UPDATE properties SET status = ? WHERE id IN ({$placeholders})");
            if (!$stmt_update_status) throw new Exception("Prepare failed (deactivate): " . $conn->error);

            $bind_params = array_merge([$new_status], $property_ids);
            $bind_types = "s" . $types;

            $stmt_update_status->bind_param($bind_types, ...$bind_params);
            if (!$stmt_update_status->execute()) throw new Exception("Execute failed (deactivate): " . $stmt_update_status->error);
            $affected_rows = $stmt_update_status->affected_rows;
            $stmt_update_status->close();
            $conn->commit();
            echo json_encode(['success' => true, 'message' => "Successfully deactivated {$affected_rows} properties."]);
            break;

        case 'delete':
            // 1. Fetch all image paths for all selected properties
            $all_image_paths_to_delete = [];
            $sql_fetch_images = "
                (SELECT contact_image_path AS image_path FROM properties WHERE id IN ({$placeholders}) AND contact_image_path IS NOT NULL AND contact_image_path != '')
                UNION
                (SELECT image_path FROM property_images WHERE property_id IN ({$placeholders}) AND image_path IS NOT NULL AND image_path != '')
            ";
            $stmt_fetch_images = $conn->prepare($sql_fetch_images);
            if (!$stmt_fetch_images) throw new Exception("Prepare failed (fetch images for delete): " . $conn->error);
            
            // Params for IN clause are repeated for UNION, so double the property_ids and types
            $delete_image_fetch_params = array_merge($property_ids, $property_ids);
            $delete_image_fetch_types = $types . $types;

            $stmt_fetch_images->bind_param($delete_image_fetch_types, ...$delete_image_fetch_params);
            if (!$stmt_fetch_images->execute()) throw new Exception("Execute failed (fetch images for delete): " . $stmt_fetch_images->error);
            $result_images = $stmt_fetch_images->get_result();
            while ($row = $result_images->fetch_assoc()) {
                $all_image_paths_to_delete[] = $row['image_path'];
            }
            $stmt_fetch_images->close();

            // 2. Execute a single DELETE FROM properties WHERE id IN (...)
            $stmt_delete = $conn->prepare("DELETE FROM properties WHERE id IN ({$placeholders})");
            if (!$stmt_delete) throw new Exception("Prepare failed (bulk delete): " . $conn->error);
            $stmt_delete->bind_param($types, ...$property_ids);
            if (!$stmt_delete->execute()) throw new Exception("Execute failed (bulk delete): " . $stmt_delete->error);
            $affected_rows = $stmt_delete->affected_rows;
            $stmt_delete->close();

            if ($affected_rows === 0 && count($property_ids) > 0) {
                // None of the specified properties were found.
                $conn->rollback();
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'No matching properties found for deletion.']);
                exit();
            }
            
            // 3. If DB deletion is successful, commit.
            $conn->commit();

            // 4. Then, loop through the stored image paths and delete files.
            $file_deletion_errors = false;
            foreach ($all_image_paths_to_delete as $image_path) {
                if (!delete_file_from_server($image_path)) {
                    $file_deletion_errors = true;
                    // error_log("Bulk delete: Failed to delete image file: {$image_path}");
                }
            }

            if ($file_deletion_errors) {
                echo json_encode([
                    'success' => true, // DB part was successful
                    'message' => "Successfully deleted {$affected_rows} properties from database, but some image files might not have been removed. Please check server logs.",
                    'detail' => 'File deletion issues encountered.'
                ]);
            } else {
                echo json_encode(['success' => true, 'message' => "Successfully deleted {$affected_rows} properties and associated images."]);
            }
            break;

        default: // Should have been caught by initial validation
            throw new Exception("Invalid action specified.");
    }

} catch (Exception $e) {
    $conn->rollback();
    http_response_code(500); // Internal Server Error
    echo json_encode([
        'success' => false,
        'message' => 'Error performing action: ' . $e->getMessage()
    ]);
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?>
