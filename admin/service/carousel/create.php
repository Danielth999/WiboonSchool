<?php
session_start();
require_once('../connect.php');

if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../../../images/slide/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // สร้างชื่อไฟล์ใหม่ป้องกันซ้ำ เช่น 1715058000_banner.jpg
    $originalName = basename($_FILES['image']['name']);
    $ext = pathinfo($originalName, PATHINFO_EXTENSION);
    $newFileName = time() . '_' . uniqid() . '.' . $ext;
    $uploadFile = $uploadDir . $newFileName;

    $fileType = mime_content_type($_FILES['image']['tmp_name']);
    if (strpos($fileType, 'image') !== false) {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $imagePath = $newFileName;
            $uploadDate = date('Y-m-d H:i:s');

            $sql = "INSERT INTO carousel (image) VALUES (:image)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':image', $imagePath);

            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'อัพโหลดรูปภาพและบันทึกข้อมูลสำเร็จ']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูลลงฐานข้อมูล']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการอัพโหลดไฟล์']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ไฟล์ที่อัพโหลดไม่ใช่รูปภาพ']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการอัพโหลด']);
}
