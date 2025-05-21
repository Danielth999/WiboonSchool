<?php
header('Content-Type: application/json');
require_once('../connect.php');

// ตรวจสอบว่ามีการส่งข้อมูลมาหรือไม่
if (!isset($_POST['id']) || !isset($_POST['status'])) {
    echo json_encode([
        'status' => false,
        'message' => 'ข้อมูลไม่ครบถ้วน'
    ]);
    exit;
}

try {
    // เตรียมข้อมูล
    $id = $_POST['id'];
    $status = $_POST['status'];

    // เตรียมคำสั่ง SQL
    $stmt = $conn->prepare("UPDATE social_links SET status = :status WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':status', $status, PDO::PARAM_INT);

    // ทำการอัพเดทข้อมูล
    $result = $stmt->execute();

    if ($result) {
        echo json_encode([
            'status' => true,
            'message' => 'อัพเดทสถานะเรียบร้อยแล้ว'
        ]);
    } else {
        echo json_encode([
            'status' => false,
            'message' => 'เกิดข้อผิดพลาดในการอัพเดทสถานะ'
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        'status' => false,
        'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()
    ]);
}