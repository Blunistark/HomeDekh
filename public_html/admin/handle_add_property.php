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
    $_SESSION['error_message'] = "Invalid request method.";
    header("Location: add-property.php");
    exit();
}

// Start transaction
$conn->begin_transaction();

try {
    // 4. Retrieve and Validate Data
    $errors = [];

    // **Basic Info**
    $property_name = trim($_POST['property-name'] ?? '');
    $property_type = trim($_POST['property-type'] ?? ''); // Assumed new field
    $property_category = trim($_POST['property-category'] ?? ''); // Assumed new field
    $property_rating = !empty(trim($_POST['property-rating'] ?? '')) ? (int)trim($_POST['property-rating']) : null; // Assumed new field
    $property_reviewcount = !empty(trim($_POST['property-reviewcount'] ?? '')) ? (int)trim($_POST['property-reviewcount']) : null; // Assumed new field
    // $property_price = trim($_POST['property-price'] ?? ''); // This is general, room types have specific prices. Will omit from main properties table for now.

    if (empty($property_name)) $errors[] = "Property name is required.";
    if (empty($property_type)) $errors[] = "Property type is required.";
    if (empty($property_category)) $errors[] = "Property category is required.";


    // **Description**
    $short_description = trim($_POST['short-description'] ?? ''); // Can be stored in a new field if needed, or combined.
    $long_description = trim($_POST['long-description'] ?? '');
    $meta_description = trim($_POST['meta-description'] ?? ''); // Assumed new field

    // For the `properties` table, we have `description`. Let's use $long_description for it.
    // $short_description can be stored in a new field `short_description`
    if (empty($long_description) && !empty($short_description)) $db_description = $short_description;
    elseif (!empty($long_description)) $db_description = $long_description;
    else $db_description = null;


    // **Location**
    $address = trim($_POST['address'] ?? '');
    $landmark = trim($_POST['landmark'] ?? ''); // Assumed new field
    $distance = trim($_POST['distance'] ?? ''); // Assumed new field (e.g. "2km from city center")
    $map_latitude = !empty(trim($_POST['map_latitude'] ?? '')) ? trim($_POST['map_latitude']) : null;
    $map_longitude = !empty(trim($_POST['map_longitude'] ?? '')) ? trim($_POST['map_longitude']) : null;

    if (empty($address)) $errors[] = "Address is required.";
    if ($map_latitude !== null && (!is_numeric($map_latitude) || $map_latitude < -90 || $map_latitude > 90)) $errors[] = "Invalid latitude value.";
    if ($map_longitude !== null && (!is_numeric($map_longitude) || $map_longitude < -180 || $map_longitude > 180)) $errors[] = "Invalid longitude value.";


    // **Property Status**
    $property_status_input = trim($_POST['property-status'] ?? 'draft');
    // DB schema has ENUM('available', 'booked', 'unavailable')
    // Task asks for 'Draft', 'Pending', 'Active'.
    // Let's map: Draft -> unavailable, Pending -> unavailable, Active -> available
    $status_map = [
        'draft' => 'unavailable',
        'pending' => 'unavailable',
        'active' => 'available'
    ];
    $final_db_status = $status_map[strtolower($property_status_input)] ?? 'unavailable';


    // **Contact Info**
    $contact_name = trim($_POST['contact-name'] ?? ''); // Assumed new field
    // $contact_title = trim($_POST['contact-title'] ?? ''); // Optional, not adding for now
    $contact_phone = trim($_POST['contact-phone'] ?? ''); // Assumed new field
    // $contact_whatsapp = trim($_POST['contact-whatsapp'] ?? ''); // Optional, can be same as phone or new field
    $contact_email = trim($_POST['contact-email'] ?? ''); // Assumed new field
    // $whatsapp_template_message = trim($_POST['whatsapp-template-message'] ?? ''); // Optional
    // $include_mention = isset($_POST['include-mention']); // UI specific, not stored directly

    // **Special Offer**
    $has_special_offer = isset($_POST['has-special-offer']); // Assumed new field (BOOL/TINYINT)
    $special_offer_text = trim($_POST['special-offer-text'] ?? ''); // Assumed new field (TEXT)
    if ($has_special_offer && empty($special_offer_text)) {
        $errors[] = "Special offer text is required when 'Has Special Offer' is checked.";
    }
    if (!$has_special_offer) {
        $special_offer_text = null; // Ensure it's null if no offer
    }


    // Owner ID from session
    $owner_id = $_SESSION['user_id'];



    // 5. Handle Image Uploads
    $main_image_path = null;
    $gallery_image_paths = [];
    $contact_image_path = null; // Not in properties schema, will store path if uploaded

    // Helper function for image upload
    function upload_image($file_key, $upload_dir, &$errors_array) {
        if (isset($_FILES[$file_key]) && $_FILES[$file_key]['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES[$file_key];
            if ($file['size'] > MAX_FILE_SIZE) {
                $errors_array[] = "File '{$file['name']}' exceeds max size of " . (MAX_FILE_SIZE / 1024 / 1024) . "MB.";
                return null;
            }
            if (!in_array($file['type'], ALLOWED_IMAGE_TYPES)) {
                $errors_array[] = "File '{$file['name']}' has an invalid type. Allowed: JPEG, PNG, GIF, WebP.";
                return null;
            }
            $filename = uniqid('', true) . '_' . basename($file['name']);
            $destination = $upload_dir . $filename;
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                return $destination; // Return path relative to script, or adjust as needed for DB storage
            } else {
                $errors_array[] = "Failed to move uploaded file '{$file['name']}'. Check permissions.";
                return null;
            }
        } elseif (isset($_FILES[$file_key]) && $_FILES[$file_key]['error'] !== UPLOAD_ERR_NO_FILE) {
            $errors_array[] = "Error uploading file '{$_FILES[$file_key]['name']}': Error code " . $_FILES[$file_key]['error'];
        }
        return null;
    }

    // Main Image
    $main_image_path_raw = upload_image('main-image-upload', PROPERTY_IMG_UPLOAD_DIR, $errors);
    if ($main_image_path_raw) $main_image_path = str_replace('../', '', $main_image_path_raw); // Store path relative to public_html root

    // Gallery Images
    if (isset($_FILES['gallery-image-upload'])) {
        $gallery_files = $_FILES['gallery-image-upload'];
        if (is_array($gallery_files['name'])) { // Multiple files
            for ($i = 0; $i < count($gallery_files['name']); $i++) {
                if ($gallery_files['error'][$i] === UPLOAD_ERR_OK) {
                    $single_gallery_file = [
                        'name' => $gallery_files['name'][$i],
                        'type' => $gallery_files['type'][$i],
                        'tmp_name' => $gallery_files['tmp_name'][$i],
                        'error' => $gallery_files['error'][$i],
                        'size' => $gallery_files['size'][$i]
                    ];
                    // Need to create a temporary simulated $_FILES entry for upload_image function
                    $temp_key = 'gallery_temp_file';
                    $_FILES[$temp_key] = $single_gallery_file;
                    $gallery_path_raw = upload_image($temp_key, PROPERTY_IMG_UPLOAD_DIR, $errors);
                    if ($gallery_path_raw) $gallery_image_paths[] = str_replace('../', '', $gallery_path_raw);
                    unset($_FILES[$temp_key]); // Clean up
                } elseif ($gallery_files['error'][$i] !== UPLOAD_ERR_NO_FILE) {
                     $errors[] = "Error uploading gallery file '{$gallery_files['name'][$i]}': Error code " . $gallery_files['error'][$i];
                }
            }
        } elseif ($gallery_files['error'] === UPLOAD_ERR_OK) { // Single gallery image (just in case form is not setup for array)
             $gallery_path_raw = upload_image('gallery-image-upload', PROPERTY_IMG_UPLOAD_DIR, $errors);
             if ($gallery_path_raw) $gallery_image_paths[] = str_replace('../', '', $gallery_path_raw);
        }
    }
    
    // Contact Image
    $contact_image_path_raw = upload_image('contact-image-upload', CONTACT_AVATAR_UPLOAD_DIR, $errors);
    if ($contact_image_path_raw) $contact_image_path = str_replace('../', '', $contact_image_path_raw); // Store path relative to public_html root. Assumed field `contact_image_path` in properties.


    // If validation or upload errors, redirect back
    if (!empty($errors)) {
        throw new Exception(implode("<br>", $errors));
    }

    // 6. Database Insertion
    // Insert into `properties` table
    // Added assumed fields: property_type, short_description, meta_description, landmark, distance,
    // contact_name, contact_phone, contact_email, contact_image_path,
    // has_special_offer, special_offer_text, property_category, property_rating, property_reviewcount
    $sql_insert_property = "INSERT INTO properties (
            owner_id, name, address, latitude, longitude, description, status,
            property_type, short_description, meta_description, landmark, distance,
            contact_name, contact_phone, contact_email, contact_image_path,
            has_special_offer, special_offer_text,
            property_category, property_rating, property_reviewcount
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    // Types: i, s, s, d, d, s, s,   s, s, s, s, s,   s, s, s, s,   i, s,   s, i, i
    // Total 21 fields

    $stmt_insert_property = $conn->prepare($sql_insert_property);
    if (!$stmt_insert_property) throw new Exception("Prepare failed (properties): " . $conn->error);

    $stmt_insert_property->bind_param(
        "issddssssssssssssisii",
        $owner_id,                // i
        $property_name,           // s
        $address,                 // s
        $map_latitude,            // d
        $map_longitude,           // d
        $db_description,          // s (long description)
        $final_db_status,         // s
        $property_type,           // s
        $short_description,       // s
        $meta_description,        // s
        $landmark,                // s
        $distance,                // s
        $contact_name,            // s
        $contact_phone,           // s
        $contact_email,           // s
        $contact_image_path,      // s
        $has_special_offer,       // i (boolean)
        $special_offer_text,      // s
        $property_category,       // s
        $property_rating,         // i
        $property_reviewcount     // i
    );

    if (!$stmt_insert_property->execute()) throw new Exception("Execute failed (properties): " . $stmt_insert_property->error);
    $property_id = $conn->insert_id;
    $stmt_insert_property->close();

    // Insert into `property_images`
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

    // **Rooms & Pricing** (e.g., `room_type_name[]`, `room_type_price[]`, `room_type_capacity[]`, `room_type_description[]`)
    if (isset($_POST['room_type_name']) && is_array($_POST['room_type_name'])) {
        $room_names = $_POST['room_type_name'];
        $room_prices = $_POST['room_type_price'] ?? [];
        $room_capacities = $_POST['room_type_capacity'] ?? []; // Assuming 'beds' meant capacity
        $room_descriptions = $_POST['room_type_description'] ?? [];

        $stmt_insert_room = $conn->prepare("INSERT INTO room_types (property_id, name, price_per_night, capacity, description) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt_insert_room) throw new Exception("Prepare failed (room_types): " . $conn->error);

        for ($i = 0; $i < count($room_names); $i++) {
            $r_name = trim($room_names[$i]);
            $r_price = trim($room_prices[$i] ?? '0');
            $r_capacity = trim($room_capacities[$i] ?? '1');
            $r_desc = trim($room_descriptions[$i] ?? '');

            if (empty($r_name) || !is_numeric($r_price) || !is_numeric($r_capacity)) {
                // Optionally add to $errors and throw, or just skip invalid room entries
                continue;
            }
            $stmt_insert_room->bind_param("isdis", $property_id, $r_name, $r_price, $r_capacity, $r_desc);
            if (!$stmt_insert_room->execute()) throw new Exception("Execute failed (room_type {$r_name}): " . $stmt_insert_room->error);
        }
        $stmt_insert_room->close();
    }

    // **Amenities** (e.g., `amenities[]` containing amenity IDs)
    if (isset($_POST['amenities']) && is_array($_POST['amenities'])) {
        $amenity_ids = $_POST['amenities'];
        $stmt_insert_amenity = $conn->prepare("INSERT INTO property_amenities (property_id, amenity_id) VALUES (?, ?)");
        if (!$stmt_insert_amenity) throw new Exception("Prepare failed (property_amenities): " . $conn->error);

        foreach ($amenity_ids as $amenity_id) {
            $aid = intval($amenity_id);
            if ($aid > 0) {
                $stmt_insert_amenity->bind_param("ii", $property_id, $aid);
                if (!$stmt_insert_amenity->execute()) {
                    // Ignore duplicate errors, otherwise throw
                    if ($conn->errno !== 1062) { // 1062 is error code for duplicate entry
                         throw new Exception("Execute failed (property_amenity ID {$aid}): " . $stmt_insert_amenity->error);
                    }
                }
            }
        }
        $stmt_insert_amenity->close();
    }

    // **Additional Services** (e.g., `service_name[]`, `service_price[]`, `service_description[]`)
    // Schema: `additional_services` (id, property_id, name, price, description)
    if (isset($_POST['service_name']) && is_array($_POST['service_name'])) {
        $service_names = $_POST['service_name'];
        $service_prices = $_POST['service_price'] ?? [];
        $service_descriptions = $_POST['service_description'] ?? [];

        $stmt_insert_service = $conn->prepare("INSERT INTO additional_services (property_id, name, price, description) VALUES (?, ?, ?, ?)");
        if (!$stmt_insert_service) throw new Exception("Prepare failed (additional_services): " . $conn->error);

        for ($i = 0; $i < count($service_names); $i++) {
            $s_name = trim($service_names[$i]);
            $s_price = trim($service_prices[$i] ?? '0');
            $s_desc = trim($service_descriptions[$i] ?? '');

            if (empty($s_name) || !is_numeric($s_price)) continue;

            $stmt_insert_service->bind_param("isds", $property_id, $s_name, $s_price, $s_desc);
            if (!$stmt_insert_service->execute()) throw new Exception("Execute failed (service {$s_name}): " . $stmt_insert_service->error);
        }
        $stmt_insert_service->close();
    }


    // **Nearby Places** (e.g., `nearby_place_name[]`, `nearby_place_type[]`, `nearby_place_distance_km[]`)
    // Schema: `nearby_places` (id, property_id, name, type, distance_km)
    if (isset($_POST['nearby_place_name']) && is_array($_POST['nearby_place_name'])) {
        $place_names = $_POST['nearby_place_name'];
        $place_types = $_POST['nearby_place_type'] ?? []; // Assuming 'type' is provided, not 'minutes' from task
        $place_distances = $_POST['nearby_place_distance_km'] ?? [];

        $stmt_insert_place = $conn->prepare("INSERT INTO nearby_places (property_id, name, type, distance_km) VALUES (?, ?, ?, ?)");
        if (!$stmt_insert_place) throw new Exception("Prepare failed (nearby_places): " . $conn->error);

        for ($i = 0; $i < count($place_names); $i++) {
            $p_name = trim($place_names[$i]);
            $p_type = trim($place_types[$i] ?? '');
            $p_distance = trim($place_distances[$i] ?? '0');

            if (empty($p_name) || !is_numeric($p_distance)) continue;

            $stmt_insert_place->bind_param("issd", $property_id, $p_name, $p_type, $p_distance);
            if (!$stmt_insert_place->execute()) throw new Exception("Execute failed (nearby_place {$p_name}): " . $stmt_insert_place->error);
        }
        $stmt_insert_place->close();
    }

    // **Special Offer** (has-special-offer, special-offer-text)
    // Not in current schema. Could be a boolean flag and a text field in `properties`.
    // $has_special_offer = isset($_POST['has-special-offer']);
    // $special_offer_text = trim($_POST['special-offer-text'] ?? '');
    // If $has_special_offer and $special_offer_text is not empty, this could be appended to description or stored in a new field.


    // If all successful
    $conn->commit();
    $_SESSION['success_message'] = "Property added successfully!";
    header("Location: properties.php"); // Assuming this is the listing page for properties
    exit();

} catch (Exception $e) {
    $conn->rollback();
    $_SESSION['error_message'] = "Failed to add property: " . $e->getMessage();
    // To repopulate form, would need to store $_POST data in session and handle in add-property.php
    // For now, just redirecting with error.
    header("Location: add-property.php");
    exit();
} finally {
    // Close connection if not done by PHP automatically
    // $conn->close();
}

?>
