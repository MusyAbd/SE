<?php
// FILE: api/revert_inquiry_status.php (FINAL)

require '../config/koneksi.php';
require '../auth_check.php';

header('Content-Type: application/json');
$input = json_decode(file_get_contents('php://input'), true);

if (empty($input['id'])) {
    echo json_encode(['success' => false, 'message' => 'Inquiry ID is required.']);
    exit;
}

$id = $input['id'];
$updatedAt = date('d M Y h:i A');

$sql = "UPDATE sales_inquiries SET status = 'active', updatedAt = ? WHERE id = ? AND status = 'accepted'";
$stmt = mysqli_prepare($koneksi, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ss", $updatedAt, $id);
    
    if (mysqli_stmt_execute($stmt)) {
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            mysqli_commit($koneksi); // Perubahan disimpan permanen
            echo json_encode(['success' => true, 'message' => 'Inquiry status has been reverted to active.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Inquiry not found or its status was already active.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Database execution failed.']);
    }
    mysqli_stmt_close($stmt);
} else {
    echo json_encode(['success' => false, 'message' => 'Database statement preparation failed.']);
}
mysqli_close($koneksi);
?>