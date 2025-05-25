<?php
require_once '../auth/session_check.php';
require_once '../config/db.php';
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit();
}
$property_id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$action = isset($_POST['action']) ? $_POST['action'] : '';
$feedback = isset($_POST['feedback']) ? trim($_POST['feedback']) : '';
if (!$property_id || !$action) {
    echo json_encode(['success' => false, 'message' => 'Missing property ID or action.']);
    exit();
}
try {
    if ($action === 'approve') {
        $stmt = $conn->prepare("UPDATE properties SET status = 'available' WHERE id = ?");
        $stmt->bind_param('i', $property_id);
        $stmt->execute();
        $stmt->close();
        echo json_encode(['success' => true, 'message' => 'Property approved.']);
        exit();
    } elseif ($action === 'reject') {
        $stmt = $conn->prepare("UPDATE properties SET status = 'unavailable' WHERE id = ?");
        $stmt->bind_param('i', $property_id);
        $stmt->execute();
        $stmt->close();
        // Store feedback
        if ($feedback) {
            $stmt_fb = $conn->prepare("INSERT INTO property_feedback (property_id, action, feedback) VALUES (?, 'reject', ?)");
            $stmt_fb->bind_param('is', $property_id, $feedback);
            $stmt_fb->execute();
            $stmt_fb->close();
        }
        echo json_encode(['success' => true, 'message' => 'Property rejected.']);
        exit();
    } elseif ($action === 'request-changes') {
        $stmt = $conn->prepare("UPDATE properties SET status = 'unavailable' WHERE id = ?");
        $stmt->bind_param('i', $property_id);
        $stmt->execute();
        $stmt->close();
        // Store feedback
        if ($feedback) {
            $stmt_fb = $conn->prepare("INSERT INTO property_feedback (property_id, action, feedback) VALUES (?, 'request-changes', ?)");
            $stmt_fb->bind_param('is', $property_id, $feedback);
            $stmt_fb->execute();
            $stmt_fb->close();
        }
        echo json_encode(['success' => true, 'message' => 'Requested changes for property.']);
        exit();
    } else {
        echo json_encode(['success' => false, 'message' => 'Unknown action.']);
        exit();
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    exit();
} 