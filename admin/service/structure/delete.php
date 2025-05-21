<?php
// ไฟล์ delete.php
header('Content-Type: application/json');
require_once '../connect.php';

// ตรวจสอบการเชื่อมต่อกับฐานข้อมูล
if (!isset($conn) || $conn === null) {
    echo json_encode(['status' => 'error', 'message' => 'ไม่สามารถเชื่อมต่อกับฐานข้อมูลได้']);
    exit();
}

// ตรวจสอบว่ามีการส่งค่า id มาหรือไม่
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'ไม่พบรหัสที่ต้องการลบ']);
    exit();
}

$id = $_GET['id'];

try {
    // ตรวจสอบว่าข้อมูลมีภาพหรือไม่ เพื่อลบไฟล์ภาพด้วย
    $stmt = $conn->prepare("SELECT image FROM school_structure WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // ถ้ามีการเก็บชื่อไฟล์ภาพ
    if ($row && !empty($row['image'])) {
        // กำหนด path ไปยังโฟลเดอร์ที่เก็บรูปภาพ
        $image_path = '../../../images/structure/' . $row['image'];
        // ลบไฟล์ภาพถ้ามีอยู่จริง
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }

    // ลบข้อมูลจากฐานข้อมูล
    $stmt = $conn->prepare("DELETE FROM school_structure WHERE id = :id");
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        // ส่งคำตอบกลับเป็น JSON
        echo json_encode(['status' => 'success', 'message' => 'ลบข้อมูลสำเร็จ']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ไม่สามารถลบข้อมูลได้']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()]);
}
