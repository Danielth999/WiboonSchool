<?php
session_start();
require_once('../connect.php');

header('Content-Type: application/json'); // เพิ่ม header สำหรับ json

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ตรวจสอบข้อมูลที่จำเป็น
    if (empty($_POST['document_name']) || empty($_POST['category_id']) || !isset($_POST['status'])) {
        echo json_encode(['status' => 'error', 'message' => 'กรุณากรอกข้อมูลให้ครบถ้วน']);
        exit();
    }

    $document_name = $_POST['document_name'];
    $category_id = $_POST['category_id'];
    $status = $_POST['status'];

    $file_path = '';

    // ตรวจสอบว่ามีการอัพโหลดไฟล์หรือไม่
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $file_name = $_FILES['file']['name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // ดึง category_code จากฐานข้อมูล
        $stmt = $conn->prepare("SELECT code FROM categories WHERE id = :category_id");
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->execute();
        $category = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($category) {
            $category_code = $category['code'];
        } else {
            echo json_encode(['status' => 'error', 'message' => 'ไม่พบหมวดหมู่']);
            exit();
        }

        $upload_path = '../../document/' . $category_code . '/';

        if (!file_exists($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        // ป้องกันชื่อไฟล์ซ้ำด้วยการเติม timestamp
        $new_file_name = time() . '_' . basename($file_name);

        if (file_exists($upload_path . $new_file_name)) {
            echo json_encode(['status' => 'error', 'message' => 'ไฟล์นี้มีอยู่แล้ว']);
            exit();
        }

        if (move_uploaded_file($_FILES['file']['tmp_name'], $upload_path . $new_file_name)) {
            // เก็บเฉพาะ path ที่ต้องการใช้ในระบบ เช่น 'document/xxx/filename'
            $file_path = $new_file_name;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'ไม่สามารถอัพโหลดไฟล์']);
            exit();
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'กรุณาอัพโหลดไฟล์']);
        exit();
    }

    // เตรียมคำสั่ง SQL สำหรับการบันทึกข้อมูล (ตรวจสอบชื่อ table ให้ตรงกับฐานข้อมูล)
    $stmt = $conn->prepare("INSERT INTO documents (title, category_id, filename, status) 
                            VALUES (:document_name, :category_id, :file_path, :status)");

    $stmt->bindParam(':document_name', $document_name);
    $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    $stmt->bindParam(':file_path', $file_path);
    $stmt->bindParam(':status', $status, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'เอกสารถูกเพิ่มเรียบร้อย']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ไม่สามารถเพิ่มเอกสารได้']);
    }
}
