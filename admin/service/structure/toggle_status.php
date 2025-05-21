<?php
session_start();
require_once('../connect.php');

// ตรวจสอบว่ามีการส่ง ID และ status มาหรือไม่
if (!isset($_POST['id']) || !isset($_POST['status'])) {
    echo json_encode(['status' => 'error', 'message' => 'ข้อมูลไม่ครบถ้วน']);
    exit();
}

// รับค่า ID และ status
$id = $_POST['id'];
$status = $_POST['status'];

// ตรวจสอบความถูกต้องของข้อมูล
if (!is_numeric($id)) {
    echo json_encode(['status' => 'error', 'message' => 'รหัสไม่ถูกต้อง']);
    exit();
}

// แปลงค่า status จาก boolean เป็น 0 หรือ 1
$status = ($status === 'true') ? 1 : 0;

try {
    // เตรียมคำสั่ง SQL สำหรับอัพเดทสถานะ
    $stmt = $conn->prepare("UPDATE school_structure SET status = :status WHERE id = :id");
    $stmt->bindParam(':status', $status, PDO::PARAM_INT);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // ทำการอัพเดท
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'อัพเดทสถานะเรียบร้อย']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ไม่สามารถอัพเดทสถานะได้']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()]);
}
