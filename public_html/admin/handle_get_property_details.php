<?php
header('Content-Type: application/json');

// 1. Include session_check.php and db.php
require_once '../auth/session_check.php'; // Ensures only admin (owner) can access
require_once '../config/db.php';

try {
    // 4. Expect a property_id as a GET parameter. Validate.
    if (!isset($_GET['property_id'])) {
        http_response_code(400); // Bad Request
        echo json_encode(['error' => true, 'message' => 'Property ID is required.']);
        exit();
    }
    $property_id = filter_var($_GET['property_id'], FILTER_VALIDATE_INT);
    if ($property_id === false || $property_id <= 0) {
        http_response_code(400); // Bad Request
        echo json_encode(['error' => true, 'message' => 'Invalid Property ID.']);
        exit();
    }

    // 5. Fetch Property Core Details
    $stmt_property = $conn->prepare("SELECT * FROM properties WHERE id = ?");
    if (!$stmt_property) {
        throw new Exception("Prepare failed (property details): " . $conn->error);
    }
    $stmt_property->bind_param("i", $property_id);
    if (!$stmt_property->execute()) {
        throw new Exception("Execute failed (property details): " . $stmt_property->error);
    }
    $result_property = $stmt_property->get_result();
    if ($result_property->num_rows === 0) {
        http_response_code(404); // Not Found
        echo json_encode(['error' => true, 'message' => 'Property not found.']);
        exit();
    }
    $property_details = $result_property->fetch_assoc();
    $stmt_property->close();

    // 6. Fetch Associated Data

    // Images
    $stmt_images = $conn->prepare("SELECT image_path, is_thumbnail FROM property_images WHERE property_id = ? ORDER BY is_thumbnail DESC, id ASC");
    if (!$stmt_images) throw new Exception("Prepare failed (images): " . $conn->error);
    $stmt_images->bind_param("i", $property_id);
    if (!$stmt_images->execute()) throw new Exception("Execute failed (images): " . $stmt_images->error);
    $result_images = $stmt_images->get_result();
    $images = ['main_image' => null, 'gallery' => []];
    while ($row_image = $result_images->fetch_assoc()) {
        if ($row_image['is_thumbnail']) {
            $images['main_image'] = $row_image['image_path'];
        } else {
            $images['gallery'][] = $row_image['image_path'];
        }
    }
    // If no specific thumbnail, pick first gallery image as main if available
    if (!$images['main_image'] && !empty($images['gallery'])) {
        $images['main_image'] = $images['gallery'][0];
        // Optionally remove it from gallery if you want it exclusively as main
        // array_shift($images['gallery']);
    }
    $stmt_images->close();
    $property_details['images'] = $images;


    // Room Types
    $stmt_rooms = $conn->prepare("SELECT * FROM room_types WHERE property_id = ? ORDER BY id ASC");
    if (!$stmt_rooms) throw new Exception("Prepare failed (room types): " . $conn->error);
    $stmt_rooms->bind_param("i", $property_id);
    if (!$stmt_rooms->execute()) throw new Exception("Execute failed (room types): " . $stmt_rooms->error);
    $result_rooms = $stmt_rooms->get_result();
    $property_details['room_types'] = $result_rooms->fetch_all(MYSQLI_ASSOC);
    $stmt_rooms->close();

    // Selected Amenities (IDs)
    $stmt_amenities = $conn->prepare("SELECT amenity_id FROM property_amenities WHERE property_id = ?");
    if (!$stmt_amenities) throw new Exception("Prepare failed (amenities): " . $conn->error);
    $stmt_amenities->bind_param("i", $property_id);
    if (!$stmt_amenities->execute()) throw new Exception("Execute failed (amenities): " . $stmt_amenities->error);
    $result_amenities = $stmt_amenities->get_result();
    $selected_amenity_ids = [];
    while ($row_amenity = $result_amenities->fetch_assoc()) {
        $selected_amenity_ids[] = (int)$row_amenity['amenity_id'];
    }
    $property_details['selected_amenity_ids'] = $selected_amenity_ids;
    $stmt_amenities->close();

    // Additional Services
    $stmt_services = $conn->prepare("SELECT * FROM additional_services WHERE property_id = ? ORDER BY id ASC");
    if (!$stmt_services) throw new Exception("Prepare failed (services): " . $conn->error);
    $stmt_services->bind_param("i", $property_id);
    if (!$stmt_services->execute()) throw new Exception("Execute failed (services): " . $stmt_services->error);
    $result_services = $stmt_services->get_result();
    $property_details['additional_services'] = $result_services->fetch_all(MYSQLI_ASSOC);
    $stmt_services->close();

    // Nearby Places
    $stmt_nearby = $conn->prepare("SELECT * FROM nearby_places WHERE property_id = ? ORDER BY id ASC");
    if (!$stmt_nearby) throw new Exception("Prepare failed (nearby places): " . $conn->error);
    $stmt_nearby->bind_param("i", $property_id);
    if (!$stmt_nearby->execute()) throw new Exception("Execute failed (nearby places): " . $stmt_nearby->error);
    $result_nearby = $stmt_nearby->get_result();
    $property_details['nearby_places'] = $result_nearby->fetch_all(MYSQLI_ASSOC);
    $stmt_nearby->close();


    // 7. Construct Response & 8. Return JSON Response
    echo json_encode($property_details);

} catch (Exception $e) {
    // 9. Error Handling
    // Avoid sending 500 for user errors like "not found", already handled.
    // This catch block is more for unexpected server/SQL errors.
    if (http_response_code() === 200) { // If no specific error code was set prior
      http_response_code(500); // Internal Server Error
    }
    echo json_encode([
        'error' => true,
        'message' => $e->getMessage()
    ]);
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?>
