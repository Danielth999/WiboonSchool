<?php
header('Content-Type: application/json');
require_once '../connect.php';

// ตรวจสอบว่ามีการส่งข้อมูลมาหรือไม่
if (!isset($_POST['department']) || empty($_POST['department'])) {
    echo json_encode(['status' => 'error', 'message' => 'กรุณากรอกข้อมูลกลุ่มงาน']);
    exit();
}

// เก็บค่าจากฟอร์ม
$department = $_POST['department'];
$status = $_POST['status'];

$image_name = ''; // เก็บเฉพาะชื่อไฟล์ ไม่ใช่ path เต็ม

// จัดการกับไฟล์ภาพ (ถ้ามี)
if (isset($_FILES['file_upload']) && $_FILES['file_upload']['error'] == 0) {
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $file_name = $_FILES['file_upload']['name'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $file_size = $_FILES['file_upload']['size'];

    // ตรวจสอบขนาดไฟล์ (ไม่เกิน 2MB)
    if ($file_size > 2 * 1024 * 1024) {
        echo json_encode(['status' => 'error', 'message' => 'ขนาดไฟล์ใหญ่เกินไป (ไม่เกิน 2 MB)']);
        exit();
    }

    // ตรวจสอบนามสกุลไฟล์
    if (!in_array($file_ext, $allowed)) {
        echo json_encode(['status' => 'error', 'message' => 'นามสกุลไฟล์ไม่ถูกต้อง อนุญาตเฉพาะ: ' . implode(', ', $allowed)]);
        exit();
    }

    // ตรวจสอบขนาดไฟล์ (ไม่เกิน 5MB)
    // if ($file_size > 5000000) {
    //     echo json_encode(['status' => 'error', 'message' => 'ขนาดไฟล์ต้องไม่เกิน 5MB']);
    //     exit();
    // }

    // สร้างชื่อไฟล์ใหม่เพื่อป้องกันการซ้ำ
    $new_file_name = 'structure_' . uniqid() . '.' . $file_ext;
    $upload_path = '../../../images/structure/';

    // สร้างโฟลเดอร์หากยังไม่มี
    if (!file_exists($upload_path)) {
        mkdir($upload_path, 0777, true);
    }

    // อัพโหลดไฟล์
    if (move_uploaded_file($_FILES['file_upload']['tmp_name'], $upload_path . $new_file_name)) {
        $image_name = $new_file_name; // เก็บเฉพาะชื่อไฟล์
    } else {
        echo json_encode(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการอัพโหลดไฟล์']);
        exit();
    }
}

try {
    // เตรียมคำสั่ง SQL สำหรับเพิ่มข้อมูล
    $stmt = $conn->prepare("INSERT INTO school_structure (name, image, status) 
                           VALUES (:department, :img, :status1)");

    // กำหนดค่าพารามิเตอร์
    $stmt->bindParam(':department', $department);
    $stmt->bindParam(':img', $image_name); // ใช้ชื่อไฟล์แทน path
    $stmt->bindParam(':status1', $status);

    // ประมวลผลคำสั่ง SQL
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'ข้อมูลถูกบันทึกเรียบร้อย']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ไม่สามารถบันทึกข้อมูลได้']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()]);
}
