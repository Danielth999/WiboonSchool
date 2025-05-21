<?php
session_start();
require_once('../connect.php');

// ตรวจสอบว่าได้รับค่า id จากการส่งผ่าน POST หรือไม่
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // ดึงข้อมูลไฟล์จากฐานข้อมูลก่อนที่จะลบ
    $sql = "SELECT image FROM carousel WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $imageFile = '../../../images/slide/' . $row['image']; // เส้นทางของไฟล์ที่ต้องลบ

        // ตรวจสอบว่าไฟล์มีอยู่หรือไม่ ก่อนทำการลบ
        if (file_exists($imageFile)) {
            unlink($imageFile); // ลบไฟล์
        }

        // ลบข้อมูลจากฐานข้อมูล
        $sqlDelete = "DELETE FROM carousel WHERE id = :id";
        $stmtDelete = $conn->prepare($sqlDelete);
        $stmtDelete->bindParam(':id', $id);
        if ($stmtDelete->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'ลบรายการและไฟล์เรียบร้อย']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการลบข้อมูลจากฐานข้อมูล']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ไม่พบข้อมูลที่ต้องการลบ']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'ไม่พบข้อมูลที่ต้องการลบ']);
}
