<?php
session_start();
include_once('../connect.php');
header('Content-Type: application/json');

if (!isset($_POST['id']) || !isset($_POST['status'])) {
    echo json_encode(['status' => 'error', 'message' => 'ข้อมูลไม่ครบถ้วน']);
    exit();
}

$id = $_POST['id'];
$status = $_POST['status'] == 1 ? 1 : 0;

$stmt = $conn->prepare("UPDATE documents SET status = :status WHERE id = :id");
$stmt->bindParam(':status', $status, PDO::PARAM_INT);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'อัปเดตสถานะเรียบร้อย']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'เกิดข้อผิดพลาด']);
}
?>