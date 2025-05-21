<?php
header('Content-Type: application/json');
require_once('../connect.php');

// ตรวจสอบว่ามีการส่งข้อมูลมาหรือไม่
if (!isset($_POST['url'])) {
    echo json_encode([
        'status' => false,
        'message' => 'กรุณากรอกข้อมูลให้ครบถ้วน'
    ]);
    exit;
}

try {
    // เตรียมข้อมูล
    $url = $_POST['url'];
    $status = isset($_POST['status']) ? $_POST['status'] : 1;

    // เตรียมคำสั่ง SQL
    $stmt = $conn->prepare("INSERT INTO social_links ( url, status) VALUES ( :url, :status)");
    $stmt->bindParam(':url', $url, PDO::PARAM_STR);
    $stmt->bindParam(':status', $status, PDO::PARAM_INT);

    // ทำการบันทึกข้อมูล
    $result = $stmt->execute();

    if ($result) {
        echo json_encode([
            'status' => true,
            'message' => 'เพิ่มข้อมูลเรียบร้อยแล้ว'
        ]);
    } else {
        echo json_encode([
            'status' => false,
            'message' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล'
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        'status' => false,
        'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()
    ]);
}