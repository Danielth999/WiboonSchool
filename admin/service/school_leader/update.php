<?php
session_start();
require_once '../connect.php';

// ตรวจสอบว่ามีการส่งข้อมูลมาหรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับค่าจากฟอร์ม
    $id = $_POST['id'];
    $name = $_POST['name'];
    $position = $_POST['position'];
    $old_image = $_POST['old_image'];
    $status = $_POST['status'];

    // ตรวจสอบว่ามีการอัพโหลดไฟล์ใหม่หรือไม่
    $image_url = $old_image; // ใช้รูปเดิมเป็นค่าเริ่มต้น
    $image_updated = false;

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // ตรวจสอบขนาดไฟล์ (ไม่เกิน 2MB)
        if ($_FILES['image']['size'] > 2097152) {
            echo json_encode(['status' => 'error', 'message' => 'ขนาดไฟล์เกินกำหนด (ไม่เกิน 2MB)']);
            exit();
        }

        // ตรวจสอบประเภทไฟล์
        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png'];
        $file_type = $_FILES['image']['type'];

        if (!in_array($file_type, $allowed_types)) {
            echo json_encode(['status' => 'error', 'message' => 'รองรับเฉพาะไฟล์ JPG, JPEG, PNG เท่านั้น']);
            exit();
        }

        // สร้างชื่อไฟล์ใหม่เพื่อป้องกันชื่อซ้ำ
        $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $new_filename = 'leader_' . uniqid() . '.' . $file_extension;

        // กำหนดตำแหน่งที่จะบันทึกไฟล์
        $upload_path = '../../../images/leaders/';

        // ตรวจสอบว่าโฟลเดอร์มีอยู่หรือไม่ ถ้าไม่มีให้สร้างใหม่
        if (!file_exists($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        $upload_file = $upload_path . $new_filename;

        // อัพโหลดไฟล์
        if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_file)) {
            // กำหนดชื่อไฟล์ใหม่ (ไม่รวม path)
            $image_url = $new_filename;
            $image_updated = true;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'ไม่สามารถอัพโหลดไฟล์ได้']);
            exit();
        }
    }

    try {
        // เตรียมคำสั่ง SQL สำหรับอัพเดทข้อมูล
        $stmt = $conn->prepare("UPDATE school_leaders 
                               SET name = :name, 
                                   position = :position, 
                                   image_url = :image_url, 
                                   status = :status 
                               WHERE id = :id");

        // กำหนดค่าพารามิเตอร์
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':position', $position, PDO::PARAM_STR);
        $stmt->bindParam(':image_url', $image_url, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);

        // ประมวลผลคำสั่ง SQL
        $stmt->execute();

        // ถ้ามีการอัพเดทรูปภาพ ให้ลบรูปเก่า
        if ($image_updated && !empty($old_image)) {
            $old_image_path = $upload_path . $old_image;
            if (file_exists($old_image_path)) {
                unlink($old_image_path);
            }
        }

        // ส่งค่ากลับเป็น JSON
        echo json_encode(['status' => 'success', 'message' => 'อัพเดทข้อมูลผู้นำโรงเรียนเรียบร้อยแล้ว']);
        exit();
    } catch (PDOException $e) {
        // ถ้ามีการอัพโหลดไฟล์ใหม่และเกิดข้อผิดพลาด ให้ลบไฟล์ที่อัพโหลดไปแล้ว
        if ($image_updated) {
            $upload_file = '../../../' . ltrim($image_url, '/');
            if (file_exists($upload_file)) {
                unlink($upload_file);
            }
        }

        echo json_encode(['status' => 'error', 'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()]);
        exit();
    }
} else {
    // ถ้าไม่ใช่การส่งข้อมูลแบบ POST ให้กลับไปยังหน้าหลัก
    header('Location: ../../pages/school_leader/');
    exit();
}