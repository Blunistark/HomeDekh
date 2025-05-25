<?php
require_once '../auth/session_check.php';
require_once '../config/db.php';
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit();
}
$action = $_POST['action'] ?? '';
if ($action === 'add') {
    // Add user
    $name = trim($_POST['first_name'] . ' ' . $_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $city = trim($_POST['city']);
    $state = trim($_POST['state']);
    $role = trim($_POST['role']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $status = 'active';
    $stmt = $conn->prepare("INSERT INTO users (name, email, phone, address, city, state, role, password, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param('sssssssss', $name, $email, $phone, $address, $city, $state, $role, $password, $status);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'User added successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add user: ' . $conn->error]);
    }
    $stmt->close();
    exit();
} elseif ($action === 'edit') {
    // Edit user
    $user_id = intval($_POST['id']);
    $name = trim($_POST['first_name'] . ' ' . $_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $city = trim($_POST['city']);
    $state = trim($_POST['state']);
    $role = trim($_POST['role']);
    $stmt = $conn->prepare("UPDATE users SET name=?, email=?, phone=?, address=?, city=?, state=?, role=? WHERE id=?");
    $stmt->bind_param('sssssssi', $name, $email, $phone, $address, $city, $state, $role, $user_id);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'User updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update user: ' . $conn->error]);
    }
    $stmt->close();
    exit();
} elseif ($action === 'deactivate' || $action === 'activate') {
    // Deactivate/activate user
    $user_id = intval($_POST['id']);
    $status = $action === 'deactivate' ? 'inactive' : 'active';
    $stmt = $conn->prepare("UPDATE users SET status=? WHERE id=?");
    $stmt->bind_param('si', $status, $user_id);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'User status updated.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update status: ' . $conn->error]);
    }
    $stmt->close();
    exit();
} elseif ($action === 'reset_password') {
    // Reset password
    $user_id = intval($_POST['id']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET password=? WHERE id=?");
    $stmt->bind_param('si', $password, $user_id);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Password reset successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to reset password: ' . $conn->error]);
    }
    $stmt->close();
    exit();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid action.']);
    exit();
} 