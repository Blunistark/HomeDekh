<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../auth/session_check.php'; // Ensures only admin (owner) can access
require_once '../config/db.php';

header('Content-Type: application/json');

// Input Validation
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

if (!isset($_POST['property_id'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid input. Missing property_id.']);
    exit;
}

$property_id = filter_var($_POST['property_id'], FILTER_VALIDATE_INT);

if (!$property_id || $property_id <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid property ID provided.']);
    exit;
}

$conn->begin_transaction();

try {
    // 1. Fetch and delete property gallery images (main image is part of this table too if is_thumbnail=true)
    $stmt_fetch_gallery_images = $conn->prepare("SELECT image_path FROM property_images WHERE property_id = ?");
    if (!$stmt_fetch_gallery_images) throw new Exception("Prepare failed (fetch gallery images): " . $conn->error);
    $stmt_fetch_gallery_images->bind_param("i", $property_id);
    if (!$stmt_fetch_gallery_images->execute()) throw new Exception("Execute failed (fetch gallery images): " . $stmt_fetch_gallery_images->error);
    
    $result_gallery_images = $stmt_fetch_gallery_images->get_result();
    while ($row_image = $result_gallery_images->fetch_assoc()) {
        if (!empty($row_image['image_path']) && file_exists('../' . $row_image['image_path'])) {
            if (!unlink('../' . $row_image['image_path'])) {
                // Log error, but don't halt transaction if DB cleanup is more critical
                error_log("Failed to delete gallery image file: " . $row_image['image_path'] . " for property ID: " . $property_id);
            }
        }
    }
    $stmt_fetch_gallery_images->close();

    // 2. Fetch and delete property contact image (if stored separately in properties table)
    $stmt_fetch_contact_image = $conn->prepare("SELECT contact_image_path FROM properties WHERE id = ?");
    if (!$stmt_fetch_contact_image) throw new Exception("Prepare failed (fetch contact image): " . $conn->error);
    $stmt_fetch_contact_image->bind_param("i", $property_id);
    if (!$stmt_fetch_contact_image->execute()) throw new Exception("Execute failed (fetch contact image): " . $stmt_fetch_contact_image->error);

    $result_contact_image = $stmt_fetch_contact_image->get_result();
    if ($row_contact = $result_contact_image->fetch_assoc()) {
        if (!empty($row_contact['contact_image_path']) && file_exists('../' . $row_contact['contact_image_path'])) {
            if (!unlink('../' . $row_contact['contact_image_path'])) {
                error_log("Failed to delete contact image file: " . $row_contact['contact_image_path'] . " for property ID: " . $property_id);
            }
        }
    }
    $stmt_fetch_contact_image->close();

    // 3. Delete from related tables using foreign key constraints (if ON DELETE CASCADE is set)
    // Or manually delete if constraints are not set or for safety.
    // Order of deletion matters if there are no ON DELETE CASCADE.
    // Start with tables that reference `properties` or are leaf nodes in dependency.

    $related_tables_stmts_sql = [
        "DELETE FROM property_amenities WHERE property_id = ?",
        "DELETE FROM additional_services WHERE property_id = ?",
        "DELETE FROM nearby_places WHERE property_id = ?",
        "DELETE FROM room_types WHERE property_id = ?",
        "DELETE FROM property_images WHERE property_id = ?", // Deletes records after files are unlinked
        "DELETE FROM saved_properties WHERE property_id = ?" // If users can save/favorite properties
    ];

    foreach ($related_tables_stmts_sql as $sql) {
        $stmt = $conn->prepare($sql);
        if (!$stmt) throw new Exception("Prepare failed (delete related data - \"{$sql}\"): " . $conn->error);
        $stmt->bind_param("i", $property_id);
        if (!$stmt->execute()){
            // Log error but continue to attempt deleting other related data and the main property.
            // If a critical FK prevents property deletion, the final delete will fail and rollback.
             error_log("Execute failed (delete related data - \"{$sql}\" for property ID {$property_id}): " . $stmt->error);
        }
        $stmt->close();
    }

    // 4. Delete from properties table
    $stmt_delete_property = $conn->prepare("DELETE FROM properties WHERE id = ?");
    if (!$stmt_delete_property) throw new Exception("Prepare failed (delete property): " . $conn->error);
    $stmt_delete_property->bind_param("i", $property_id);
    if (!$stmt_delete_property->execute()) throw new Exception("Execute failed (delete property): " . $stmt_delete_property->error);
    
    $affected_rows = $stmt_delete_property->affected_rows;
    $stmt_delete_property->close();

    if ($affected_rows > 0) {
        $conn->commit();
        echo json_encode(['success' => true, 'message' => 'Property and all related data deleted successfully.']);
    } else {
        // This might happen if the property was already deleted by another request.
        // If related data was cleaned up but property itself wasn't found, consider it a success for the user.
        // However, if no rows were affected anywhere, it might be an issue.
        // For simplicity, if main property delete affects 0 rows, assume it was already gone.
        // If previous steps threw exceptions, this won't be reached.
        $conn->commit(); // Commit deletion of any related data that might have occurred.
        echo json_encode(['success' => true, 'message' => 'Property not found (already deleted or invalid ID), related data cleanup attempted.']);
    }

} catch (Exception $e) {
    $conn->rollback();
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => "An error occurred: " . $e->getMessage()
    ]);
} finally {
    if (isset($conn) && $conn->ping()) { // Check if connection is still alive before closing
        $conn->close();
    }
}
?>
