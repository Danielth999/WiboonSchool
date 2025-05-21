<?php
session_start();
require_once('../connect.php');

$id = $_GET['id']; // รับ id จาก URL

// รับข้อมูลจากฟอร์ม
$status = isset($_POST['status']) ? (int)$_POST['status'] : 0; // รับค่าของ status ด้วย

// ถ้ามีการอัปโหลดไฟล์ใหม่
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../../../images/slide/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = basename($_FILES['image']['name']);
    $uploadFile = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
        // ดึงชื่อไฟล์เก่าเพื่อลบทิ้ง
        $sql = "SELECT image FROM carousel WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $oldImage = $row['image'];

        // ลบไฟล์เก่า
        if (file_exists($uploadDir . $oldImage)) {
            unlink($uploadDir . $oldImage);
        }

        // อัปเดตข้อมูลรูปใหม่และสถานะเผยแพร่
        $sqlUpdate = "UPDATE carousel SET image = :image, status = :status WHERE id = :id";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bindParam(':image', $fileName);
        $stmtUpdate->bindParam(':status', $status, PDO::PARAM_INT);
        $stmtUpdate->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmtUpdate->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'อัปเดทรูปภาพและสถานะเรียบร้อย']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการอัปเดทข้อมูล']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการอัปโหลดไฟล์']);
    }
} else {
    // ไม่มีไฟล์ใหม่ => อัปเดตแค่สถานะเผยแพร่
    $sqlUpdate = "UPDATE carousel SET status = :status WHERE id = :id";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bindParam(':status', $status, PDO::PARAM_INT);
    $stmtUpdate->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmtUpdate->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'อัปเดตสถานะเผยแพร่เรียบร้อย']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการอัปเดตสถานะ']);
    }
}
