<?php
session_start();
require_once('../connect.php');

// ตรวจสอบว่ามีข้อมูลที่จำเป็นหรือไม่
if (!isset($_POST['id']) || !isset($_POST['value'])) {
    echo json_encode(['status' => 'error', 'message' => 'ข้อมูลไม่ครบถ้วน']);
    exit;
}

$id = $_POST['id'];
$value = $_POST['value'];
$updated_at = date('Y-m-d H:i:s');

try {
    $sql = "UPDATE school_info SET value = :value, updated_at = :updated_at WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':value', $value, PDO::PARAM_STR);
    $stmt->bindParam(':updated_at', $updated_at, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'อัปเดตข้อมูลเรียบร้อย']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการอัปเดตข้อมูล']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()]);
}
