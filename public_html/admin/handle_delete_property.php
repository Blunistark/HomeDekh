<?php
header('Content-Type: application/json');

// 1. Include session_check.php and db.php
require_once '../auth/session_check.php'; // Ensures only admin (owner) can access
require_once '../config/db.php';

// Helper function to delete a file if it exists
function delete_file_from_server($filepath_relative_to_root) {
    if (!empty($filepath_relative_to_root)) {
        // Construct full path. Assumes this script is in public_html/admin/
        // and paths in DB are like 'uploads/property_images/...'
        $full_path = __DIR__ . '/../' . $filepath_relative_to_root;
        if (file_exists($full_path)) {
            if (!unlink($full_path)) {
                // Optionally log this error, but don't necessarily fail the whole process
                // error_log("Failed to delete file: " . $full_path);
                return false; // Indicate failure
            }
        }
    }
    return true; // Indicate success or file didn't exist
}

// 3. Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['success' => false, 'message' => 'Invalid request method. Only POST is allowed.']);
    exit();
}

// 4. Retrieve property_id from POST data. Validate it.
$property_id = filter_input(INPUT_POST, 'property_id', FILTER_VALIDATE_INT);
if (!$property_id || $property_id <= 0) {
    http_response_code(400); // Bad Request
    echo json_encode(['success' => false, 'message' => 'Invalid or missing Property ID.']);
    exit();
}

$conn->begin_transaction();

try {
    // 5. Fetch Image Paths
    $all_image_paths = [];

    // Fetch contact_image_path from properties table
    // Assuming the field name is contact_image_path as used in add/edit scripts
    $stmt_contact_img = $conn->prepare("SELECT contact_image_path FROM properties WHERE id = ?");
    if (!$stmt_contact_img) throw new Exception("Prepare failed (fetch contact image path): " . $conn->error);
    $stmt_contact_img->bind_param("i", $property_id);
    if (!$stmt_contact_img->execute()) throw new Exception("Execute failed (fetch contact image path): " . $stmt_contact_img->error);
    $result_contact_img = $stmt_contact_img->get_result();
    if ($row_contact_img = $result_contact_img->fetch_assoc()) {
        if (!empty($row_contact_img['contact_image_path'])) {
            $all_image_paths[] = $row_contact_img['contact_image_path'];
        }
    }
    $stmt_contact_img->close();
    // No need to 404 if property doesn't exist yet, deletion will just fail or do nothing.

    // Fetch main and gallery images from property_images
    $stmt_prop_imgs = $conn->prepare("SELECT image_path FROM property_images WHERE property_id = ?");
    if (!$stmt_prop_imgs) throw new Exception("Prepare failed (fetch property images): " . $conn->error);
    $stmt_prop_imgs->bind_param("i", $property_id);
    if (!$stmt_prop_imgs->execute()) throw new Exception("Execute failed (fetch property images): " . $stmt_prop_imgs->error);
    $result_prop_imgs = $stmt_prop_imgs->get_result();
    while ($row_prop_img = $result_prop_imgs->fetch_assoc()) {
        if (!empty($row_prop_img['image_path'])) {
            $all_image_paths[] = $row_prop_img['image_path'];
        }
    }
    $stmt_prop_imgs->close();

    // 6. Database Deletion
    $stmt_delete_property = $conn->prepare("DELETE FROM properties WHERE id = ?");
    if (!$stmt_delete_property) {
        throw new Exception("Prepare failed (delete property): " . $conn->error);
    }
    $stmt_delete_property->bind_param("i", $property_id);
    if (!$stmt_delete_property->execute()) {
        throw new Exception("Execute failed (delete property): " . $stmt_delete_property->error);
    }

    $affected_rows = $stmt_delete_property->affected_rows;
    $stmt_delete_property->close();

    if ($affected_rows === 0) {
        // Property might have already been deleted or ID was invalid.
        // Since images are fetched first, this might seem redundant, but it's a good check.
        $conn->rollback(); // Nothing was actually deleted from properties table
        http_response_code(404); // Not Found
        echo json_encode(['success' => false, 'message' => 'Property not found or already deleted.']);
        exit();
    }

    // 7. Delete Image Files
    $file_deletion_errors = false;
    foreach ($all_image_paths as $image_path) {
        if (!delete_file_from_server($image_path)) {
            $file_deletion_errors = true;
            // Log this: error_log("Failed to delete image file during property deletion: {$image_path} for property ID {$property_id}");
        }
    }

    if ($file_deletion_errors) {
        // Decide on atomicity: either rollback or commit with a warning.
        // For now, let's commit the DB changes but warn about file deletion.
        // The alternative is to throw new Exception("Partial failure: DB deleted but some files failed to delete.")
        // which would then rollback. For this implementation, we'll commit and just log the file errors.
        $conn->commit();
        echo json_encode([
            'success' => true, // DB change was successful
            'message' => 'Property deleted from database, but some image files might not have been removed. Please check server logs.',
            'detail' => 'File deletion issues encountered.'
        ]);
    } else {
        $conn->commit();
        echo json_encode(['success' => true, 'message' => 'Property deleted successfully.']);
    }

} catch (Exception $e) {
    $conn->rollback();
    http_response_code(500); // Internal Server Error
    echo json_encode([
        'success' => false,
        'message' => 'Error deleting property: ' . $e->getMessage()
    ]);
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?>
