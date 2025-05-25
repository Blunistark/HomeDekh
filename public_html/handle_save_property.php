<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once '../config/db.php'; // Adjust path if pgs.php is not in root of public_html

header('Content-Type: application/json');

// User Authentication
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.', 'action' => 'login_required']);
    exit;
}

$user_id = $_SESSION['user_id'];

// Input Processing
if (!isset($_POST['property_id']) || !isset($_POST['action'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid input. Missing property_id or action.']);
    exit;
}

$property_id = filter_var($_POST['property_id'], FILTER_VALIDATE_INT);
$action = trim($_POST['action']); // 'save' or 'unsave'

if (!$property_id) {
    echo json_encode(['success' => false, 'message' => 'Invalid property ID.']);
    exit;
}

if ($action !== 'save' && $action !== 'unsave') {
    echo json_encode(['success' => false, 'message' => 'Invalid action specified.']);
    exit;
}

// Database Operations
if ($action === 'save') {
    // Check if already saved to prevent duplicate entries and handle gracefully
    $check_sql = "SELECT id FROM saved_properties WHERE user_id = ? AND property_id = ?";
    $stmt_check = $conn->prepare($check_sql);
    if (!$stmt_check) {
        echo json_encode(['success' => false, 'message' => 'Error preparing check statement: ' . $conn->error]);
        exit;
    }
    $stmt_check->bind_param("ii", $user_id, $property_id);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        $stmt_check->close();
        echo json_encode(['success' => true, 'status' => 'saved', 'message' => 'Property already saved.']);
        exit;
    }
    $stmt_check->close();

    // Insert if not already saved
    $insert_sql = "INSERT INTO saved_properties (user_id, property_id) VALUES (?, ?)";
    $stmt_insert = $conn->prepare($insert_sql);
    if (!$stmt_insert) {
        echo json_encode(['success' => false, 'message' => 'Error preparing insert statement: ' . $conn->error]);
        exit;
    }
    $stmt_insert->bind_param("ii", $user_id, $property_id);

    if ($stmt_insert->execute()) {
        echo json_encode(['success' => true, 'status' => 'saved', 'message' => 'Property saved successfully.']);
    } else {
        // Check for duplicate entry error specifically (though the above check should prevent it)
        if ($conn->errno == 1062) { // Error code for duplicate entry
             echo json_encode(['success' => true, 'status' => 'saved', 'message' => 'Property was already saved (concurrent request).']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to save property: ' . $stmt_insert->error]);
        }
    }
    $stmt_insert->close();

} elseif ($action === 'unsave') {
    $delete_sql = "DELETE FROM saved_properties WHERE user_id = ? AND property_id = ?";
    $stmt_delete = $conn->prepare($delete_sql);
     if (!$stmt_delete) {
        echo json_encode(['success' => false, 'message' => 'Error preparing delete statement: ' . $conn->error]);
        exit;
    }
    $stmt_delete->bind_param("ii", $user_id, $property_id);

    if ($stmt_delete->execute()) {
        if ($stmt_delete->affected_rows > 0) {
            echo json_encode(['success' => true, 'status' => 'unsaved', 'message' => 'Property unsaved successfully.']);
        } else {
            echo json_encode(['success' => true, 'status' => 'unsaved', 'message' => 'Property was not saved or already unsaved.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to unsave property: ' . $stmt_delete->error]);
    }
    $stmt_delete->close();
}

$conn->close();
?>
