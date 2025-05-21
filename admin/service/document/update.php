<?php
session_start();
include_once('../connect.php');

header('Content-Type: application/json');

// ตรวจสอบว่ามี id ที่ต้องการแก้ไขหรือไม่
if (!isset($_POST['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'ไม่พบรหัสเอกสาร']);
    exit();
}

$id = $_POST['id'];
$title = isset($_POST['document_name']) ? trim($_POST['document_name']) : '';
$category_id = isset($_POST['category_id']) ? $_POST['category_id'] : '';
$status = isset($_POST['status']) ? $_POST['status'] : 0;

// ตรวจสอบข้อมูลที่จำเป็น
if ($title === '' || $category_id === '') {
    echo json_encode(['status' => 'error', 'message' => 'กรุณากรอกข้อมูลให้ครบถ้วน']);
    exit();
}

// ดึงข้อมูลเดิมเพื่อดูชื่อไฟล์เก่า
$stmt = $conn->prepare("SELECT filename FROM documents WHERE id = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$oldData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$oldData) {
    echo json_encode(['status' => 'error', 'message' => 'ไม่พบข้อมูลเอกสาร']);
    exit();
}

$filename = $oldData['filename'];

// ดึง code ของหมวดหม่ (วิชา) จาก categories
$stmtCat = $conn->prepare("SELECT code FROM categories WHERE id = :category_id");
$stmtCat->bindParam(':category_id', $category_id, PDO::PARAM_INT);
$stmtCat->execute();
$catData = $stmtCat->fetch(PDO::FETCH_ASSOC);

if (!$catData) {
    echo json_encode(['status' => 'error', 'message' => 'ไม่พบหมวดหม่']);
    exit();
}

$category_code = $catData['code'];

// ตรวจสอบว่ามีการอัปโหลดไฟล์ใหม่หรือไม่
if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../../document/' . $category_code . '/';
    $fileTmp = $_FILES['file']['tmp_name'];
    $fileName = basename($_FILES['file']['name']);
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowed = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'jpg', 'jpeg', 'png'];

    if (!in_array($fileExt, $allowed)) {
        echo json_encode(['status' => 'error', 'message' => 'ประเภทไฟล์ไม่ถูกต้อง']);
        exit();
    }

    // ตรวจสอบชื่อไฟล์ซ้ำ
    if (file_exists($uploadDir . $fileName)) {
        echo json_encode(['status' => 'error', 'message' => 'มีไฟล์ชื่อเดียวกันอยู่แล้วในหมวดหมู่นี้ กรุณาเปลี่ยนชื่อไฟล์']);
        exit();
    }

    // สร้างโฟลเดอร์ถ้ายังไม่มี
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (move_uploaded_file($fileTmp, $uploadDir . $fileName)) {
        $filename = $fileName; // ใช้ชื่อไฟล์เดิม
        // ลบไฟล์เก่า (ถ้ามี)
        if (!empty($oldData['filename']) && file_exists($uploadDir . $oldData['filename'])) {
            @unlink($uploadDir . $oldData['filename']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'อัปโหลดไฟล์ไม่สำเร็จ']);
        exit();
    }
}

// อัปเดตข้อมูลในฐานข้อมูล
$stmt = $conn->prepare("UPDATE documents SET title = :title, filename = :filename, category_id = :category_id, status = :status WHERE id = :id");
$stmt->bindParam(':title', $title, PDO::PARAM_STR);
$stmt->bindParam(':filename', $filename, PDO::PARAM_STR);
$stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
$stmt->bindParam(':status', $status, PDO::PARAM_INT);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'อัปเดตข้อมูลเรียบร้อย']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการอัปเดตข้อมูล']);
}
?>