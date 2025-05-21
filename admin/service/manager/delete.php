<?php
session_start();
require_once('../connect.php');

header('Content-Type: application/json');

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'super admin') {
    echo json_encode(['status' => 'error', 'message' => 'คุณไม่มีสิทธิ์ทำรายการนี้'], JSON_UNESCAPED_UNICODE);
    exit;
}

$id = $_POST['id'] ?? null;
if (!$id) {
    echo json_encode(['status' => 'error', 'message' => 'ไม่พบ ID ที่ต้องการลบ'], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $stmtCheck = $conn->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
    $stmtCheck->bindParam(':id', $id, PDO::PARAM_INT);
    $stmtCheck->execute();
    $user = $stmtCheck->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo json_encode(['status' => 'error', 'message' => 'ไม่พบข้อมูลผู้ใช้งาน'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $stmtDelete = $conn->prepare("DELETE FROM users WHERE id = :id");
    $stmtDelete->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmtDelete->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'ลบผู้ใช้งานเรียบร้อยแล้ว'], JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการลบข้อมูล'], JSON_UNESCAPED_UNICODE);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
}
