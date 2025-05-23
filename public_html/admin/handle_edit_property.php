<?php
// 1. Include session_check.php and db.php
require_once '../auth/session_check.php'; // Ensures only admin (owner) can access
require_once '../config/db.php';

// Define upload constants (consistent with add property script)
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5 MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/gif', 'image/webp']);
define('PROPERTY_IMG_UPLOAD_DIR', '../uploads/property_images/');
define('CONTACT_AVATAR_UPLOAD_DIR', '../uploads/contact_avatars/');

// Helper function to delete a file if it exists
function delete_file_if_exists($filepath_relative_to_root) {
    if (!empty($filepath_relative_to_root)) {
        $full_path = __DIR__ . '/../' . $filepath_relative_to_root; // Assuming this script is in public_html/admin/
        if (file_exists($full_path)) {
            unlink($full_path);
        }
    }
}

// Helper function for image upload (same as in add_property)
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
        // Ensure upload directory exists (it should from add_property, but good practice)
        if (!is_dir($upload_dir) && !mkdir($upload_dir, 0777, true) && !is_dir($upload_dir)) {
            $errors_array[] = "Upload directory '{$upload_dir}' does not exist and could not be created.";
            return null;
        }
        $filename = uniqid('', true) . '_' . basename($file['name']);
        $destination = $upload_dir . $filename;
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return $destination; // Return path relative to script execution context (e.g., ../uploads/...)
        } else {
            $errors_array[] = "Failed to move uploaded file '{$file['name']}'. Check permissions for {$upload_dir}.";
            return null;
        }
    } elseif (isset($_FILES[$file_key]) && $_FILES[$file_key]['error'] !== UPLOAD_ERR_NO_FILE) {
        $errors_array[] = "Error uploading file '{$_FILES[$file_key]['name']}': Error code " . $_FILES[$file_key]['error'];
    }
    return null;
}


// 3. Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $_SESSION['error_message'] = "Invalid request method.";
    header("Location: properties.php"); // Redirect to property list
    exit();
}

// 4. Retrieve property_id and validate
$property_id = filter_input(INPUT_POST, 'property_id', FILTER_VALIDATE_INT);
if (!$property_id || $property_id <= 0) {
    $_SESSION['error_message'] = "Invalid Property ID.";
    header("Location: properties.php");
    exit();
}

$redirect_on_error_url = "edit-property.php?id={$property_id}";

$conn->begin_transaction();

try {
    // 5. Retrieve and Validate Data (Similar to handle_add_property.php)
    $errors = [];

    // Basic Info
    $property_name = trim($_POST['property-name'] ?? '');
    $property_type = trim($_POST['property-type'] ?? '');
    $property_category = trim($_POST['property-category'] ?? '');
    $property_rating = !empty(trim($_POST['property-rating'] ?? '')) ? (int)trim($_POST['property-rating']) : null;
    $property_reviewcount = !empty(trim($_POST['property-reviewcount'] ?? '')) ? (int)trim($_POST['property-reviewcount']) : null;

    if (empty($property_name)) $errors[] = "Property name is required.";
    if (empty($property_type)) $errors[] = "Property type is required.";
    if (empty($property_category)) $errors[] = "Property category is required.";

    // Description
    $short_description = trim($_POST['short-description'] ?? '');
    $long_description = trim($_POST['long-description'] ?? '');
    $meta_description = trim($_POST['meta-description'] ?? '');
    $db_description = !empty($long_description) ? $long_description : (!empty($short_description) ? $short_description : null);

    // Location
    $address = trim($_POST['address'] ?? '');
    $landmark = trim($_POST['landmark'] ?? '');
    $distance = trim($_POST['distance'] ?? '');
    $map_latitude = !empty(trim($_POST['map_latitude'] ?? '')) ? trim($_POST['map_latitude']) : null;
    $map_longitude = !empty(trim($_POST['map_longitude'] ?? '')) ? trim($_POST['map_longitude']) : null;
    if (empty($address)) $errors[] = "Address is required.";
    if ($map_latitude !== null && (!is_numeric($map_latitude) || $map_latitude < -90 || $map_latitude > 90)) $errors[] = "Invalid latitude.";
    if ($map_longitude !== null && (!is_numeric($map_longitude) || $map_longitude < -180 || $map_longitude > 180)) $errors[] = "Invalid longitude.";
    
    // Property Status
    $property_status_input = trim($_POST['property-status'] ?? 'draft');
    $status_map = ['draft' => 'unavailable', 'pending' => 'unavailable', 'active' => 'available', 'inactive' => 'unavailable']; // Added inactive
    $final_db_status = $status_map[strtolower($property_status_input)] ?? 'unavailable';

    // Contact Info
    $contact_name = trim($_POST['contact-name'] ?? '');
    $contact_phone = trim($_POST['contact-phone'] ?? '');
    $contact_email = trim($_POST['contact-email'] ?? '');

    // Special Offer
    $has_special_offer = isset($_POST['has-special-offer']);
    $special_offer_text = trim($_POST['special-offer-text'] ?? '');
    if ($has_special_offer && empty($special_offer_text)) $errors[] = "Special offer text is required if offer is enabled.";
    if (!$has_special_offer) $special_offer_text = null;

    $owner_id = $_SESSION['user_id']; // For verification or logging, not usually changed during edit by admin

    // Fetch existing property data to get old image paths for deletion
    $stmt_old_data = $conn->prepare("SELECT contact_image_path FROM properties WHERE id = ?");
    if (!$stmt_old_data) throw new Exception("Prepare failed (fetch old data): " . $conn->error);
    $stmt_old_data->bind_param("i", $property_id);
    if (!$stmt_old_data->execute()) throw new Exception("Execute failed (fetch old data): " . $stmt_old_data->error);
    $old_property_data_result = $stmt_old_data->get_result();
    $old_property_data = $old_property_data_result->fetch_assoc();
    $stmt_old_data->close();
    if (!$old_property_data) throw new Exception("Property not found for fetching old data.");


    // 6. Handle Image Uploads
    $new_main_image_db_path = null;
    $new_contact_image_db_path = null; // This will be used to update properties.contact_image_path
    $old_main_image_to_delete = null;
    $old_contact_image_to_delete = $old_property_data['contact_image_path'] ?? null;

    // Main Image Upload
    if (isset($_FILES['main-image-upload']) && $_FILES['main-image-upload']['error'] === UPLOAD_ERR_OK) {
        // Fetch old main image path from property_images
        $stmt_old_main_img = $conn->prepare("SELECT image_path FROM property_images WHERE property_id = ? AND is_thumbnail = TRUE");
        if (!$stmt_old_main_img) throw new Exception("Prepare failed (old main img): " . $conn->error);
        $stmt_old_main_img->bind_param("i", $property_id);
        if (!$stmt_old_main_img->execute()) throw new Exception("Execute failed (old main img): " . $stmt_old_main_img->error);
        $old_main_img_result = $stmt_old_main_img->get_result();
        if ($old_main_img_row = $old_main_img_result->fetch_assoc()) {
            $old_main_image_to_delete = $old_main_img_row['image_path'];
        }
        $stmt_old_main_img->close();

        $uploaded_main_path_raw = upload_image('main-image-upload', PROPERTY_IMG_UPLOAD_DIR, $errors);
        if ($uploaded_main_path_raw) $new_main_image_db_path = str_replace('../', '', $uploaded_main_path_raw);
    }

    // Contact Image Upload
    if (isset($_FILES['contact-image-upload']) && $_FILES['contact-image-upload']['error'] === UPLOAD_ERR_OK) {
        // $old_contact_image_to_delete is already fetched
        $uploaded_contact_path_raw = upload_image('contact-image-upload', CONTACT_AVATAR_UPLOAD_DIR, $errors);
        if ($uploaded_contact_path_raw) $new_contact_image_db_path = str_replace('../', '', $uploaded_contact_path_raw);
    } else {
        // If not a new upload, keep the existing one (if any)
        $new_contact_image_db_path = $old_contact_image_to_delete;
    }


    // Gallery Images (Simplified: delete all existing, upload new ones)
    $new_gallery_image_db_paths = [];
    if (isset($_FILES['gallery-image-upload'])) {
        $gallery_files = $_FILES['gallery-image-upload'];
        if (is_array($gallery_files['name'])) {
            for ($i = 0; $i < count($gallery_files['name']); $i++) {
                if ($gallery_files['error'][$i] === UPLOAD_ERR_OK) {
                    $single_gallery_file = ['name' => $gallery_files['name'][$i], 'type' => $gallery_files['type'][$i], 'tmp_name' => $gallery_files['tmp_name'][$i], 'error' => $gallery_files['error'][$i], 'size' => $gallery_files['size'][$i]];
                    $_FILES['gallery_temp_file'] = $single_gallery_file; // Simulate for upload_image function
                    $gallery_path_raw = upload_image('gallery_temp_file', PROPERTY_IMG_UPLOAD_DIR, $errors);
                    if ($gallery_path_raw) $new_gallery_image_db_paths[] = str_replace('../', '', $gallery_path_raw);
                    unset($_FILES['gallery_temp_file']);
                } elseif ($gallery_files['error'][$i] !== UPLOAD_ERR_NO_FILE) {
                    $errors[] = "Error uploading gallery file '{$gallery_files['name'][$i]}': Error code " . $gallery_files['error'][$i];
                }
            }
        } elseif ($gallery_files['error'] === UPLOAD_ERR_OK) { // Single gallery image
             $gallery_path_raw = upload_image('gallery-image-upload', PROPERTY_IMG_UPLOAD_DIR, $errors);
             if ($gallery_path_raw) $new_gallery_image_db_paths[] = str_replace('../', '', $gallery_path_raw);
        }
    }


    if (!empty($errors)) {
        // If image upload caused errors, delete any successfully uploaded new files for this request
        if($new_main_image_db_path) delete_file_if_exists($new_main_image_db_path);
        if($new_contact_image_db_path && $new_contact_image_db_path !== $old_contact_image_to_delete) delete_file_if_exists($new_contact_image_db_path);
        foreach($new_gallery_image_db_paths as $p) delete_file_if_exists($p);
        throw new Exception(implode("<br>", $errors));
    }

    // 7. Database Update
    // Update `properties` table
    $sql_update_property = "UPDATE properties SET 
        name = ?, address = ?, latitude = ?, longitude = ?, description = ?, status = ?,
        property_type = ?, short_description = ?, meta_description = ?, landmark = ?, distance = ?,
        contact_name = ?, contact_phone = ?, contact_email = ?, contact_image_path = ?,
        has_special_offer = ?, special_offer_text = ?,
        property_category = ?, property_rating = ?, property_reviewcount = ?
        WHERE id = ?";
    // Types: s, s, d, d, s, s,   s, s, s, s, s,   s, s, s, s,   i, s,   s, i, i,  i (for id)
    // Total 21 fields to update + id for where clause
    $stmt_update_property = $conn->prepare($sql_update_property);
    if (!$stmt_update_property) throw new Exception("Prepare failed (update properties): " . $conn->error);
    
    $stmt_update_property->bind_param(
        "ssddsssssssssssisiiii", // 20 types for fields + 1 for id
        $property_name, $address, $map_latitude, $map_longitude, $db_description, $final_db_status,
        $property_type, $short_description, $meta_description, $landmark, $distance,
        $contact_name, $contact_phone, $contact_email, $new_contact_image_db_path, // Use new or existing path
        $has_special_offer, $special_offer_text,
        $property_category, $property_rating, $property_reviewcount,
        $property_id
    );
    if (!$stmt_update_property->execute()) throw new Exception("Execute failed (update properties): " . $stmt_update_property->error);
    $stmt_update_property->close();

    // Delete old contact image file if a new one was uploaded and different
    if ($new_contact_image_db_path !== $old_contact_image_to_delete && $old_contact_image_to_delete) {
        delete_file_if_exists($old_contact_image_to_delete);
    }

    // Handle Main Image in property_images
    if ($new_main_image_db_path) {
        // Delete old main image record from DB (is_thumbnail = TRUE) and file
        $stmt_delete_old_main = $conn->prepare("DELETE FROM property_images WHERE property_id = ? AND is_thumbnail = TRUE");
        if (!$stmt_delete_old_main) throw new Exception("Prepare failed (delete old main img DB): " . $conn->error);
        $stmt_delete_old_main->bind_param("i", $property_id);
        $stmt_delete_old_main->execute();
        $stmt_delete_old_main->close();
        if ($old_main_image_to_delete) {
            delete_file_if_exists($old_main_image_to_delete);
        }
        // Insert new main image record
        $stmt_insert_main = $conn->prepare("INSERT INTO property_images (property_id, image_path, is_thumbnail) VALUES (?, ?, TRUE)");
        if (!$stmt_insert_main) throw new Exception("Prepare failed (insert new main img): " . $conn->error);
        $stmt_insert_main->bind_param("is", $property_id, $new_main_image_db_path);
        if (!$stmt_insert_main->execute()) throw new Exception("Execute failed (insert new main img): " . $stmt_insert_main->error);
        $stmt_insert_main->close();
    }

    // Handle Gallery Images (Simplified: delete all non-thumbnail, then re-insert)
    // Fetch paths of old gallery images for deletion from server
    $stmt_old_gallery = $conn->prepare("SELECT image_path FROM property_images WHERE property_id = ? AND is_thumbnail = FALSE");
    if (!$stmt_old_gallery) throw new Exception("Prepare failed (fetch old gallery): " . $conn->error);
    $stmt_old_gallery->bind_param("i", $property_id);
    if (!$stmt_old_gallery->execute()) throw new Exception("Execute failed (fetch old gallery): " . $stmt_old_gallery->error);
    $old_gallery_result = $stmt_old_gallery->get_result();
    $old_gallery_paths_to_delete = [];
    while ($row = $old_gallery_result->fetch_assoc()) {
        $old_gallery_paths_to_delete[] = $row['image_path'];
    }
    $stmt_old_gallery->close();

    // Delete old gallery images from DB
    $stmt_delete_gallery_db = $conn->prepare("DELETE FROM property_images WHERE property_id = ? AND is_thumbnail = FALSE");
    if (!$stmt_delete_gallery_db) throw new Exception("Prepare failed (delete gallery DB): " . $conn->error);
    $stmt_delete_gallery_db->bind_param("i", $property_id);
    $stmt_delete_gallery_db->execute();
    $stmt_delete_gallery_db->close();

    // Delete old gallery image files from server
    foreach ($old_gallery_paths_to_delete as $old_gallery_path) {
        delete_file_if_exists($old_gallery_path);
    }

    // Insert new gallery images
    if (!empty($new_gallery_image_db_paths)) {
        $stmt_insert_gallery = $conn->prepare("INSERT INTO property_images (property_id, image_path, is_thumbnail) VALUES (?, ?, FALSE)");
        if (!$stmt_insert_gallery) throw new Exception("Prepare failed (insert gallery): " . $conn->error);
        foreach ($new_gallery_image_db_paths as $gallery_path) {
            $stmt_insert_gallery->bind_param("is", $property_id, $gallery_path);
            if (!$stmt_insert_gallery->execute()) throw new Exception("Execute failed (insert gallery img {$gallery_path}): " . $stmt_insert_gallery->error);
        }
        $stmt_insert_gallery->close();
    }

    // Helper lambda for deleting and re-inserting related data
    $delete_and_reinsert = function($table_name, $insert_sql, $bind_types, $data_arrays, $fk_id) use ($conn) {
        // Delete existing
        $stmt_delete = $conn->prepare("DELETE FROM {$table_name} WHERE property_id = ?");
        if (!$stmt_delete) throw new Exception("Prepare failed (delete {$table_name}): " . $conn->error);
        $stmt_delete->bind_param("i", $fk_id);
        if (!$stmt_delete->execute()) throw new Exception("Execute failed (delete {$table_name}): " . $stmt_delete->error);
        $stmt_delete->close();

        // Re-insert if data provided
        if (!empty($data_arrays) && !empty(reset($data_arrays))) { // Check if first array in data_arrays is not empty
             $stmt_insert = $conn->prepare($insert_sql);
             if (!$stmt_insert) throw new Exception("Prepare failed (insert {$table_name}): " . $conn->error);
            
            $num_items = count(reset($data_arrays)); // Number of items to insert (e.g., number of room names)
            for ($i = 0; $i < $num_items; $i++) {
                $params_to_bind = [$fk_id];
                foreach ($data_arrays as $key => $field_array) {
                    $params_to_bind[] = trim($field_array[$i] ?? '');
                }
                // Ensure all required params are present for bind_param call
                $actual_bind_types = "i" . $bind_types; // Add "i" for property_id
                if (count($params_to_bind) == strlen($actual_bind_types)) {
                    $stmt_insert->bind_param($actual_bind_types, ...$params_to_bind);
                    if (!$stmt_insert->execute()) throw new Exception("Execute failed (insert item {$i} into {$table_name}): " . $stmt_insert->error);
                } else {
                    // Skip if data is inconsistent for this item
                    // error_log("Skipping item {$i} for {$table_name} due to param count mismatch.");
                }
            }
            $stmt_insert->close();
        }
    };
    
    // Rooms & Pricing
    if (isset($_POST['room_type_name'])) { // Check if room data is submitted
        $room_data = [
            'names' => $_POST['room_type_name'],
            'prices' => $_POST['room_type_price'] ?? [],
            'capacities' => $_POST['room_type_capacity'] ?? [],
            'descriptions' => $_POST['room_type_description'] ?? []
        ];
        $delete_and_reinsert(
            'room_types',
            "INSERT INTO room_types (property_id, name, price_per_night, capacity, description) VALUES (?, ?, ?, ?, ?)",
            "sdis", // types for name, price, capacity, description
            $room_data,
            $property_id
        );
    }

    // Amenities
    if (isset($_POST['amenities']) && is_array($_POST['amenities'])) {
        $amenity_ids = array_map('intval', $_POST['amenities']);
        // Delete existing
        $stmt_delete_amenities = $conn->prepare("DELETE FROM property_amenities WHERE property_id = ?");
        if (!$stmt_delete_amenities) throw new Exception("Prepare failed (delete amenities): " . $conn->error);
        $stmt_delete_amenities->bind_param("i", $property_id);
        $stmt_delete_amenities->execute();
        $stmt_delete_amenities->close();
        // Re-insert
        if (!empty($amenity_ids)) {
            $stmt_insert_amenity = $conn->prepare("INSERT INTO property_amenities (property_id, amenity_id) VALUES (?, ?)");
            if (!$stmt_insert_amenity) throw new Exception("Prepare failed (insert amenity): " . $conn->error);
            foreach ($amenity_ids as $amenity_id) {
                if ($amenity_id > 0) {
                    $stmt_insert_amenity->bind_param("ii", $property_id, $amenity_id);
                    if (!$stmt_insert_amenity->execute() && $conn->errno !== 1062) { // Ignore duplicate entry error
                        throw new Exception("Execute failed (insert amenity ID {$amenity_id}): " . $stmt_insert_amenity->error);
                    }
                }
            }
            $stmt_insert_amenity->close();
        }
    }


    // Additional Services
    if (isset($_POST['service_name'])) {
        $service_data = [
            'names' => $_POST['service_name'],
            'prices' => $_POST['service_price'] ?? [],
            'descriptions' => $_POST['service_description'] ?? []
        ];
        $delete_and_reinsert(
            'additional_services',
            "INSERT INTO additional_services (property_id, name, price, description) VALUES (?, ?, ?, ?)",
            "sds", // types for name, price, description
            $service_data,
            $property_id
        );
    }

    // Nearby Places
    if (isset($_POST['nearby_place_name'])) {
        $nearby_data = [
            'names' => $_POST['nearby_place_name'],
            'types' => $_POST['nearby_place_type'] ?? [],
            'distances' => $_POST['nearby_place_distance_km'] ?? []
        ];
        $delete_and_reinsert(
            'nearby_places',
            "INSERT INTO nearby_places (property_id, name, type, distance_km) VALUES (?, ?, ?, ?)",
            "ssd", // types for name, type, distance
            $nearby_data,
            $property_id
        );
    }

    // If all successful
    $conn->commit();
    $_SESSION['success_message'] = "Property updated successfully!";
    header("Location: properties.php");
    exit();

} catch (Exception $e) {
    $conn->rollback();
    // Delete any newly uploaded files if an error occurred during DB operations
    if (!empty($new_main_image_db_path) && file_exists(PROPERTY_IMG_UPLOAD_DIR . basename($new_main_image_db_path))) {
        delete_file_if_exists($new_main_image_db_path);
    }
    if (!empty($new_contact_image_db_path) && $new_contact_image_db_path !== ($old_contact_image_to_delete ?? null) && file_exists(CONTACT_AVATAR_UPLOAD_DIR . basename($new_contact_image_db_path))) {
         delete_file_if_exists($new_contact_image_db_path);
    }
    foreach ($new_gallery_image_db_paths as $p) {
        if (file_exists(PROPERTY_IMG_UPLOAD_DIR . basename($p))) delete_file_if_exists($p);
    }

    $_SESSION['error_message'] = "Failed to update property: " . $e->getMessage();
    header("Location: " . $redirect_on_error_url);
    exit();
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?>
