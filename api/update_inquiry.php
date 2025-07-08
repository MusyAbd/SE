<?php
// FILE: api/update_inquiry.php (FINAL)

require '../config/koneksi.php';
require '../auth_check.php';

header('Content-Type: application/json');
$input = json_decode(file_get_contents('php://input'), true);

if (empty($input['id'])) {
    echo json_encode(['success' => false, 'message' => 'Inquiry ID is required.']);
    exit;
}

$id = $input['id'];
$name = $input['name'] ?? '';
$code = $input['code'] ?? '';
$stock = $input['stock'] ?? '';
$unit = $input['unit'] ?? '';
$price = $input['price'] ?? '';
$mail = $input['mail'] ?? '';
$createdAt = $input['createdAt'] ?? '';
$expectedAt = $input['expectedAt'] ?? '';
$notes = $input['notes'] ?? '';
$updatedAt = date('d M Y h:i A');

$sql = "UPDATE sales_inquiries SET name=?, code=?, stock=?, unit=?, price=?, mail=?, createdAt=?, expectedAt=?, updatedAt=?, notes=? WHERE id=?";
$stmt = mysqli_prepare($koneksi, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "sssssssssss", $name, $code, $stock, $unit, $price, $mail, $createdAt, $expectedAt, $updatedAt, $notes, $id);
    if (mysqli_stmt_execute($stmt)) {
        // Cek affected_rows di sini berbeda, karena 0 berarti "tidak ada perubahan" bukan "gagal"
        mysqli_commit($koneksi); // Perubahan disimpan permanen
        echo json_encode(['success' => true, 'message' => 'Sales Inquiry updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database execution failed.']);
    }
    mysqli_stmt_close($stmt);
} else {
    echo json_encode(['success' => false, 'message' => 'Database statement preparation failed.']);
}
mysqli_close($koneksi);
?>