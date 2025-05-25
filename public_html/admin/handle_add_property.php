<?php
// 1. Include session_check.php and db.php
require_once '../auth/session_check.php'; // Ensures only admin (owner) can access
require_once '../config/db.php';

// Define upload constants
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5 MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/gif', 'image/webp']);
define('PROPERTY_IMG_UPLOAD_DIR', '../uploads/property_images/');
define('CONTACT_AVATAR_UPLOAD_DIR', '../uploads/contact_avatars/');

// 3. Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    // Return JSON error for AJAX requests
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit();
}

// Start transaction
$conn->begin_transaction();

try {
    // 4. Retrieve and Validate Data
    $errors = [];

    // **Basic Info**
    $property_name = trim($_POST['property-name'] ?? '');
    $property_type = trim($_POST['property-type'] ?? '');
    $property_category = trim($_POST['property-category'] ?? '');
    $property_rating_str = trim($_POST['property-rating'] ?? '');
    $property_rating = $property_rating_str !== '' ? (float)$property_rating_str : null;

    $property_reviewcount_str = trim($_POST['property-reviewcount'] ?? '');
    $property_reviewcount = $property_reviewcount_str !== '' ? (int)$property_reviewcount_str : null;
    
    $base_price_str = trim($_POST['property-price'] ?? '');
    $base_price = $base_price_str !== '' ? (float)$base_price_str : 0;


    if (empty($property_name)) $errors[] = "Property name is required.";
    if (empty($property_type)) $errors[] = "Property type is required.";
    if (empty($property_category)) $errors[] = "Property category is required.";
    if ($base_price <= 0) $errors[] = "Base price must be greater than 0.";


    // **Description**
    $short_description = trim($_POST['short-description'] ?? ''); 
    $long_description = trim($_POST['long-description'] ?? '');
    $meta_description = trim($_POST['meta-description'] ?? ''); 

    $db_description = !empty($long_description) ? $long_description : $short_description;


    // **Location**
    $address = trim($_POST['address'] ?? '');
    $landmark = trim($_POST['landmark'] ?? ''); 
    $distance_str = trim($_POST['distance'] ?? ''); 
    $distance = $distance_str !== '' ? (float)$distance_str : null;

    $map_latitude_str = trim($_POST['map_latitude'] ?? '');
    $map_latitude = $map_latitude_str !== '' ? (float)$map_latitude_str : null;
    $map_longitude_str = trim($_POST['map_longitude'] ?? '');
    $map_longitude = $map_longitude_str !== '' ? (float)$map_longitude_str : null;


    if (empty($address)) $errors[] = "Address is required.";
    if ($map_latitude !== null && (!is_numeric($map_latitude) || $map_latitude < -90 || $map_latitude > 90)) $errors[] = "Invalid latitude value.";
    if ($map_longitude !== null && (!is_numeric($map_longitude) || $map_longitude < -180 || $map_longitude > 180)) $errors[] = "Invalid longitude value.";


    // **Property Status**
    $property_status_input = trim($_POST['property-status'] ?? 'draft');
    $status_map = [
        'draft' => 'unavailable', // Or a specific 'draft' status if your DB supports it
        'pending' => 'unavailable', // Or a specific 'pending' status
        'active' => 'available'
    ];
    $final_db_status = $status_map[strtolower($property_status_input)] ?? 'unavailable';


    // **Contact Info**
    $contact_name = trim($_POST['contact-name'] ?? ''); 
    $contact_phone = trim($_POST['contact-phone'] ?? ''); 
    $contact_email = trim($_POST['contact-email'] ?? ''); 
    // $whatsapp_template_message = trim($_POST['whatsapp-template-message'] ?? ''); // Not stored in properties table as per schema

    // **Special Offer**
    $has_special_offer = isset($_POST['has-special-offer']) ? 1 : 0; 
    $special_offer_text = trim($_POST['special-offer-text'] ?? ''); 
    if ($has_special_offer && empty($special_offer_text)) {
        $errors[] = "Special offer text is required when 'Has Special Offer' is checked.";
    }
    if (!$has_special_offer) {
        $special_offer_text = null; 
    }

    $owner_id = $_SESSION['user_id'];

    // Helper function for image upload
    function upload_image_file($file_key, $upload_dir, &$errors_array_ref) {
        if (isset($_FILES[$file_key]) && $_FILES[$file_key]['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES[$file_key];
            if ($file['size'] > MAX_FILE_SIZE) {
                $errors_array_ref[] = "File '{$file['name']}' exceeds max size of " . (MAX_FILE_SIZE / 1024 / 1024) . "MB.";
                return null;
            }
            if (!in_array($file['type'], ALLOWED_IMAGE_TYPES)) {
                $errors_array_ref[] = "File '{$file['name']}' has an invalid type. Allowed: JPEG, PNG, GIF, WebP.";
                return null;
            }
             if (!file_exists($upload_dir) && !mkdir($upload_dir, 0777, true)) {
                $errors_array_ref[] = "Upload directory '{$upload_dir}' does not exist and could not be created.";
                return null;
            }
            $filename = uniqid('', true) . '_' . basename($file['name']);
            $destination = $upload_dir . $filename;
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                return str_replace('../', '', $destination); // Store path relative to public_html root
            } else {
                $errors_array_ref[] = "Failed to move uploaded file '{$file['name']}'. Check permissions for {$upload_dir}.";
                return null;
            }
        } elseif (isset($_FILES[$file_key]) && $_FILES[$file_key]['error'] !== UPLOAD_ERR_NO_FILE) {
            $errors_array_ref[] = "Error uploading file '{$_FILES[$file_key]['name']}': Error code " . $_FILES[$file_key]['error'];
        }
        return null;
    }

    $main_image_path = upload_image_file('main-image-upload', PROPERTY_IMG_UPLOAD_DIR, $errors);
    $contact_image_path = upload_image_file('contact-image-upload', CONTACT_AVATAR_UPLOAD_DIR, $errors);

    $gallery_image_paths = [];
    if (isset($_FILES['gallery-image-upload'])) {
        $gallery_files = $_FILES['gallery-image-upload'];
        if (is_array($gallery_files['name'])) {
            for ($i = 0; $i < count($gallery_files['name']); $i++) {
                if ($gallery_files['error'][$i] === UPLOAD_ERR_OK) {
                    $single_gallery_file = [
                        'name' => $gallery_files['name'][$i],
                        'type' => $gallery_files['type'][$i],
                        'tmp_name' => $gallery_files['tmp_name'][$i],
                        'error' => $gallery_files['error'][$i],
                        'size' => $gallery_files['size'][$i]
                    ];
                    // Temporarily assign to $_FILES for upload_image_file helper
                    $_FILES['gallery_temp_file'] = $single_gallery_file;
                    $gallery_path_raw = upload_image_file('gallery_temp_file', PROPERTY_IMG_UPLOAD_DIR, $errors);
                    if ($gallery_path_raw) $gallery_image_paths[] = $gallery_path_raw;
                    unset($_FILES['gallery_temp_file']);
                } elseif ($gallery_files['error'][$i] !== UPLOAD_ERR_NO_FILE) {
                     $errors[] = "Error uploading gallery file '{$gallery_files['name'][$i]}': Error code " . $gallery_files['error'][$i];
                }
            }
        }
    }
    
    if (!empty($errors)) {
        throw new Exception(implode("<br>", $errors));
    }

    // Insert into properties (core info only)
    $sql_insert_property = "INSERT INTO properties (
            owner_id, name, address, latitude, longitude, description, status,
            property_type, short_description, meta_description, property_category, base_price
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert_property = $conn->prepare($sql_insert_property);
    if (!$stmt_insert_property) throw new Exception("Prepare failed (properties): " . $conn->error);
    $stmt_insert_property->bind_param(
        "issddssssssd",
        $owner_id, $property_name, $address, $map_latitude, $map_longitude, $db_description, $final_db_status,
        $property_type, $short_description, $meta_description, $property_category, $base_price
    );
    if (!$stmt_insert_property->execute()) throw new Exception("Execute failed (properties): " . $stmt_insert_property->error);
    $property_id = $conn->insert_id;
    $stmt_insert_property->close();
    // Insert into property_contacts
    $sql_insert_contact = "INSERT INTO property_contacts (property_id, contact_name, contact_phone, contact_email, contact_image_path) VALUES (?, ?, ?, ?, ?)";
    $stmt_insert_contact = $conn->prepare($sql_insert_contact);
    if (!$stmt_insert_contact) throw new Exception("Prepare failed (property_contacts): " . $conn->error);
    $stmt_insert_contact->bind_param("issss", $property_id, $contact_name, $contact_phone, $contact_email, $contact_image_path);
    if (!$stmt_insert_contact->execute()) throw new Exception("Execute failed (property_contacts): " . $stmt_insert_contact->error);
    $stmt_insert_contact->close();
    // Insert into property_special_offers
    $sql_insert_offer = "INSERT INTO property_special_offers (property_id, has_special_offer, special_offer_text) VALUES (?, ?, ?)";
    $stmt_insert_offer = $conn->prepare($sql_insert_offer);
    if (!$stmt_insert_offer) throw new Exception("Prepare failed (property_special_offers): " . $conn->error);
    $stmt_insert_offer->bind_param("iis", $property_id, $has_special_offer, $special_offer_text);
    if (!$stmt_insert_offer->execute()) throw new Exception("Execute failed (property_special_offers): " . $stmt_insert_offer->error);
    $stmt_insert_offer->close();
    // Insert into property_reviews (initial values)
    $sql_insert_review = "INSERT INTO property_reviews (property_id, rating, review_count) VALUES (?, ?, ?)";
    $stmt_insert_review = $conn->prepare($sql_insert_review);
    if (!$stmt_insert_review) throw new Exception("Prepare failed (property_reviews): " . $conn->error);
    $stmt_insert_review->bind_param("idi", $property_id, $property_rating, $property_reviewcount);
    if (!$stmt_insert_review->execute()) throw new Exception("Execute failed (property_reviews): " . $stmt_insert_review->error);
    $stmt_insert_review->close();

    if ($main_image_path) {
        $stmt_insert_main_image = $conn->prepare("INSERT INTO property_images (property_id, image_path, is_thumbnail) VALUES (?, ?, TRUE)");
        if (!$stmt_insert_main_image) throw new Exception("Prepare failed (main image): " . $conn->error);
        $stmt_insert_main_image->bind_param("is", $property_id, $main_image_path);
        if (!$stmt_insert_main_image->execute()) throw new Exception("Execute failed (main image): " . $stmt_insert_main_image->error);
        $stmt_insert_main_image->close();
    }
    foreach ($gallery_image_paths as $gallery_path) {
        $stmt_insert_gallery_image = $conn->prepare("INSERT INTO property_images (property_id, image_path, is_thumbnail) VALUES (?, ?, FALSE)");
        if (!$stmt_insert_gallery_image) throw new Exception("Prepare failed (gallery image): " . $conn->error);
        $stmt_insert_gallery_image->bind_param("is", $property_id, $gallery_path);
        if (!$stmt_insert_gallery_image->execute()) throw new Exception("Execute failed (gallery image for {$gallery_path}): " . $stmt_insert_gallery_image->error);
        $stmt_insert_gallery_image->close();
    }

    if (isset($_POST['room_type_name']) && is_array($_POST['room_type_name'])) {
        $room_names = $_POST['room_type_name'];
        $room_prices = $_POST['room_type_price'] ?? [];
        $room_capacities = $_POST['room_type_capacity'] ?? [];
        $room_descriptions = $_POST['room_type_description'] ?? []; 

        // Corrected column name from price_per_night to price_per_month
        $stmt_insert_room = $conn->prepare("INSERT INTO room_types (property_id, name, price_per_month, capacity, description) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt_insert_room) throw new Exception("Prepare failed (room_types): " . $conn->error);

        for ($i = 0; $i < count($room_names); $i++) {
            $r_name = trim($room_names[$i]);
            $r_price_str = trim($room_prices[$i] ?? '0');
            $r_price = $r_price_str !== '' ? (float)$r_price_str : 0;
            $r_capacity_str = trim($room_capacities[$i] ?? '1');
            $r_capacity = $r_capacity_str !== '' ? (int)$r_capacity_str : 1;
            $r_desc = trim($room_descriptions[$i] ?? '');

            if (empty($r_name) || $r_price <= 0 || $r_capacity <= 0) {
                continue;
            }
            // Changed price_per_night to price_per_month to match schema
            $stmt_insert_room->bind_param("isdis", $property_id, $r_name, $r_price, $r_capacity, $r_desc);
            if (!$stmt_insert_room->execute()) throw new Exception("Execute failed (room_type {$r_name}): " . $stmt_insert_room->error);
        }
        $stmt_insert_room->close();
    }

    if (isset($_POST['amenities']) && is_array($_POST['amenities'])) {
        $amenity_ids = $_POST['amenities'];
        $stmt_insert_amenity = $conn->prepare("INSERT INTO property_amenities (property_id, amenity_id) VALUES (?, ?)");
        if (!$stmt_insert_amenity) throw new Exception("Prepare failed (property_amenities): " . $conn->error);
        foreach ($amenity_ids as $amenity_id) {
            $aid = intval($amenity_id);
            if ($aid > 0) {
                $stmt_insert_amenity->bind_param("ii", $property_id, $aid);
                if (!$stmt_insert_amenity->execute() && $conn->errno !== 1062) { // Ignore duplicate entry errors
                     throw new Exception("Execute failed (property_amenity ID {$aid}): " . $stmt_insert_amenity->error);
                }
            }
        }
        $stmt_insert_amenity->close();
    }

    if (isset($_POST['service_name']) && is_array($_POST['service_name'])) {
        $service_names = $_POST['service_name'];
        $service_prices = $_POST['service_price'] ?? [];
        $service_descriptions = $_POST['service_description'] ?? [];
        $stmt_insert_service = $conn->prepare("INSERT INTO additional_services (property_id, name, price, description) VALUES (?, ?, ?, ?)");
        if (!$stmt_insert_service) throw new Exception("Prepare failed (additional_services): " . $conn->error);
        for ($i = 0; $i < count($service_names); $i++) {
            $s_name = trim($service_names[$i]);
            $s_price_str = trim($service_prices[$i] ?? '0');
            $s_price = $s_price_str !== '' ? (float)$s_price_str : 0;
            $s_desc = trim($service_descriptions[$i] ?? '');
            if (empty($s_name)) continue;
            $stmt_insert_service->bind_param("isds", $property_id, $s_name, $s_price, $s_desc);
            if (!$stmt_insert_service->execute()) throw new Exception("Execute failed (service {$s_name}): " . $stmt_insert_service->error);
        }
        $stmt_insert_service->close();
    }

    if (isset($_POST['nearby_place_name']) && is_array($_POST['nearby_place_name'])) {
        $place_names = $_POST['nearby_place_name'];
        $place_types = $_POST['nearby_place_type'] ?? [];
        $place_distances = $_POST['nearby_place_distance_km'] ?? [];
        $stmt_insert_place = $conn->prepare("INSERT INTO nearby_places (property_id, name, type, distance_km) VALUES (?, ?, ?, ?)");
        if (!$stmt_insert_place) throw new Exception("Prepare failed (nearby_places): " . $conn->error);
        for ($i = 0; $i < count($place_names); $i++) {
            $p_name = trim($place_names[$i]);
            $p_type = trim($place_types[$i] ?? '');
            $p_distance_str = trim($place_distances[$i] ?? '0');
            $p_distance = $p_distance_str !== '' ? (float)$p_distance_str : 0;
            if (empty($p_name)) continue;
            $stmt_insert_place->bind_param("issd", $property_id, $p_name, $p_type, $p_distance);
            if (!$stmt_insert_place->execute()) throw new Exception("Execute failed (nearby_place {$p_name}): " . $stmt_insert_place->error);
        }
        $stmt_insert_place->close();
    }

    $conn->commit();
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'message' => 'Property added successfully!', 'property_id' => $property_id]);
    exit();

} catch (Exception $e) {
    $conn->rollback();
    header('Content-Type: application/json');
    http_response_code(500); // Internal Server Error for exceptions
    echo json_encode(['success' => false, 'message' => "Failed to add property: " . $e->getMessage()]);
    exit();
} finally {
    if (isset($conn)) {
       // $conn->close(); // Connection might be closed automatically at script end
    }
}
?>
