<?php
require_once '../config/db.php';
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="users_export.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, ['ID', 'Name', 'Email', 'Phone', 'Address', 'City', 'State', 'Role', 'Status', 'Created At']);

$sql = "SELECT id, name, email, phone, address, city, state, role, status, created_at FROM users ORDER BY created_at DESC";
$result = $conn->query($sql);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }
}
fclose($output);
exit(); 