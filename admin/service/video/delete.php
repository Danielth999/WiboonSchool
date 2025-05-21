<?php
header('Content-Type: application/json');
require_once('../connect.php');

// ตรวจสอบว่ามีการส่ง ID มาหรือไม่
if (!isset($_POST['id'])) {
    echo json_encode([
        'status' => false,
        'message' => 'ไม่พบข้อมูลที่ต้องการลบ'
    ]);
    exit;
}

try {
    // เตรียมข้อมูล
    $id = $_POST['id'];

    // ตรวจสอบว่ามีข้อมูลที่จะลบหรือไม่
    $checkStmt = $conn->prepare("SELECT id FROM social_links WHERE id = :id");
    $checkStmt->bindParam(':id', $id, PDO::PARAM_INT);
    $checkStmt->execute();

    if ($checkStmt->rowCount() === 0) {
        echo json_encode([
            'status' => false,
            'message' => 'ไม่พบข้อมูลที่ต้องการลบ'
        ]);
        exit;
    }

    // เตรียมคำสั่ง SQL
    $stmt = $conn->prepare("DELETE FROM social_links WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // ทำการลบข้อมูล
    $result = $stmt->execute();

    if ($result) {
        echo json_encode([
            'status' => true,
            'message' => 'ลบข้อมูลเรียบร้อยแล้ว'
        ]);
    } else {
        echo json_encode([
            'status' => false,
            'message' => 'เกิดข้อผิดพลาดในการลบข้อมูล'
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        'status' => false,
        'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()
    ]);
}