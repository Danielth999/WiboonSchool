<?php
header('Content-Type: application/json');
require_once('../connect.php');

// ตรวจสอบว่ามีการส่งข้อมูล
if (!isset($_POST['id'])  || !isset($_POST['url'])) {
    echo json_encode([
        'status' => false,
        'message' => 'กรุณากรอกข้อมูลให้ครบถ้วน'
    ]);
    exit;
}

try {
    // เตรียมข้อมูล
    $id = $_POST['id'];

    $url = $_POST['url'];
    $status = isset($_POST['status']) ? $_POST['status'] : 1;

    // เตรียมคำสั่ง SQL
    $stmt = $conn->prepare("UPDATE social_links SET url = :url, status = :status WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    $stmt->bindParam(':url', $url, PDO::PARAM_STR);
    $stmt->bindParam(':status', $status, PDO::PARAM_INT);

    // ทำการอัพเดทข้อมูล
    $result = $stmt->execute();

    if ($result) {
        echo json_encode([
            'status' => true,
            'message' => 'อัพเดทข้อมูลเรียบร้อยแล้ว'
        ]);
    } else {
        echo json_encode([
            'status' => false,
            'message' => 'เกิดข้อผิดพลาดในการอัพเดทข้อมูล'
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        'status' => false,
        'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()
    ]);
}