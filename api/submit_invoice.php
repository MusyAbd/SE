<?php
// FILE: api/submit_invoice.php (FINAL)

require '../config/koneksi.php';
require '../auth_check.php';

header('Content-Type: application/json');
$input = json_decode(file_get_contents('php://input'), true);

$division = $input['division'] ?? null;
$email = $input['email'] ?? null;
$period = $input['period'] ?? null;
$fileName = $input['fileName'] ?? 'No file uploaded';

if (!$division || !$email || !$period) {
    echo json_encode(['success' => false, 'message' => 'Please fill all required fields.']);
    exit;
}

$sql = "INSERT INTO invoices (division, email, period, file_name) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($koneksi, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ssss", $division, $email, $period, $fileName);
    
    if (mysqli_stmt_execute($stmt)) {
        mysqli_commit($koneksi); // Perubahan disimpan permanen
        echo json_encode(['success' => true, 'message' => 'Invoice submitted successfully and saved to database.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database execution failed.']);
    }
    mysqli_stmt_close($stmt);
} else {
    echo json_encode(['success' => false, 'message' => 'Database statement preparation failed.']);
}
mysqli_close($koneksi);
?>