<?php
session_start();
require_once('../connect.php'); // ใช้ไฟล์ authen.php ตามต้นฉบับ

// ตรวจสอบว่ามีการส่งข้อมูลมาหรือไม่
if (!isset($_POST['department']) || empty($_POST['department']) || !isset($_POST['status'])) {
    echo json_encode(['status' => 'error', 'message' => 'ข้อมูลไม่ครบ']);
    exit();
}

// รับข้อมูลจากฟอร์ม
$department = $_POST['department'];
$status = $_POST['status'];

// รับข้อมูล ID จาก URL
if (!isset($_GET['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'ไม่พบ ID ที่ต้องการอัพเดท']);
    exit();
}

$id = $_GET['id'];

// เตรียม SQL สำหรับอัพเดท
$sql = "UPDATE school_structure SET name = :department, status = :status, updated_at = NOW() WHERE id = :id";
$params = [
    ':department' => $department,
    ':status' => $status,
    ':id' => $id
];

// ตรวจสอบการอัพโหลดไฟล์ใหม่
if (isset($_FILES['file_upload']) && $_FILES['file_upload']['error'] == 0) {
    // กำหนดขนาดไฟล์สูงสุดที่อนุญาตให้อัพโหลด (2 MB)
    $max_file_size = 2 * 1024 * 1024; // 2 MB ในหน่วย bytes
    $file_size = $_FILES['file_upload']['size'];

    // ตรวจสอบขนาดไฟล์
    if ($file_size > $max_file_size) {
        echo json_encode(['status' => 'error', 'message' => 'ขนาดไฟล์ใหญ่เกินไป (ไม่เกิน 2 MB)']);
        exit();
    }

    // ตรวจสอบและลบไฟล์เก่าก่อนที่จะอัพโหลดไฟล์ใหม่
    $stmt = $conn->prepare("SELECT image FROM school_structure WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $upload_path = '../../../images/structure/';

    // ตรวจสอบว่าโฟลเดอร์มีอยู่หรือไม่
    if (!file_exists($upload_path)) {
        if (!mkdir($upload_path, 0777, true)) {
            echo json_encode(['status' => 'error', 'message' => 'ไม่สามารถสร้างโฟลเดอร์สำหรับเก็บรูปภาพได้']);
            exit();
        }
    }

    // ตรวจสอบสิทธิ์การเขียน
    if (!is_writable($upload_path)) {
        echo json_encode(['status' => 'error', 'message' => 'ไม่มีสิทธิ์เขียนไฟล์ในโฟลเดอร์รูปภาพ']);
        exit();
    }

    if ($row && !empty($row['image']) && file_exists($upload_path . $row['image'])) {
        // พยายามลบไฟล์เก่า แต่ไม่ต้องหยุดการทำงานถ้าลบไม่ได้
        @unlink($upload_path . $row['image']);
    }

    // อัพโหลดไฟล์ใหม่
    $allowed = ['jpg', 'jpeg', 'png', 'webp'];
    $file_name = $_FILES['file_upload']['name'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if (!in_array($file_ext, $allowed)) {
        echo json_encode(['status' => 'error', 'message' => 'ประเภทไฟล์ไม่ถูกต้อง (รองรับ jpg, jpeg, png, webp เท่านั้น)']);
        exit();
    }

    $new_file_name = 'structure_' . uniqid() . '.' . $file_ext;

    // บันทึกข้อมูลการอัพโหลดลงในไฟล์ log (ถ้าต้องการ)
    // $log_file = fopen($upload_path . "../upload_log.txt", "a");
    // fwrite($log_file, date('Y-m-d H:i:s') . " - Attempting to update ID: $id\n");
    // fwrite($log_file, "File size: " . $file_size . " bytes\n");
    // fwrite($log_file, "Destination: " . $upload_path . $new_file_name . "\n");

    if (move_uploaded_file($_FILES['file_upload']['tmp_name'], $upload_path . $new_file_name)) {
        // fwrite($log_file, "Upload successful\n");
        // เพิ่มชื่อไฟล์ในคำสั่ง SQL
        $sql = "UPDATE school_structure SET name = :department, image = :image, status = :status, updated_at = NOW() WHERE id = :id";
        $params[':image'] = $new_file_name;
    } else {
        $error_msg = error_get_last() ? error_get_last()['message'] : 'ไม่ทราบสาเหตุ';
        // fwrite($log_file, "Upload failed. Error: " . $error_msg . "\n");
        echo json_encode(['status' => 'error', 'message' => 'ไม่สามารถอัพโหลดไฟล์: ' . $error_msg]);
        exit();
    }
    // fclose($log_file);
}

try {
    $stmt = $conn->prepare($sql);
    if ($stmt->execute($params)) {
        echo json_encode(['status' => 'success', 'message' => 'อัพเดทข้อมูลเรียบร้อย']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ไม่สามารถอัพเดทข้อมูลได้']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()]);
}
