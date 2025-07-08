<?php
// FILE: api/update_product.php (FINAL)

require '../config/koneksi.php';
require '../auth_check.php';

header('Content-Type: application/json');
$input = json_decode(file_get_contents('php://input'), true);

if (empty($input['id'])) {
    echo json_encode(['success' => false, 'message' => 'Product ID is required.']);
    exit;
}

$id = $input['id'];
$name = $input['name'] ?? '';
$stock = $input['stock'] ?? 0;
$unit = $input['unit'] ?? '';
$date = $input['date'] ?? ''; 

$sql = "UPDATE products SET name = ?, stock = ?, unit = ?, date_added = ? WHERE id = ?";
$stmt = mysqli_prepare($koneksi, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "sisss", $name, $stock, $unit, $date, $id);
    
    if (mysqli_stmt_execute($stmt)) {
        mysqli_commit($koneksi); // Perubahan disimpan permanen
        echo json_encode(['success' => true, 'message' => 'Product updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database execution failed.']);
    }
    mysqli_stmt_close($stmt);
} else {
    echo json_encode(['success' => false, 'message' => 'Database statement preparation failed.']);
}
mysqli_close($koneksi);
?>