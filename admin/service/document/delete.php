<?php
session_start();
include_once('../connect.php');

if (!isset($_GET['id'])) {
    header('Location: ../../pages/document/index.php?delete=error');
    exit();
}

$id = $_GET['id'];

// ดึงข้อมูลไฟล์และหมวดหมู่
$stmt = $conn->prepare("SELECT d.filename, c.code FROM documents d JOIN categories c ON d.category_id = c.id WHERE d.id = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    header('Location: ../../pages/document/index.php?delete=error');
    exit();
}

// ลบไฟล์จริง
$filePath = '../../document/' . $data['code'] . '/' . $data['filename'];
if (file_exists($filePath)) {
    @unlink($filePath);
}

// ลบข้อมูลในฐานข้อมูล
$stmt = $conn->prepare("DELETE FROM documents WHERE id = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);

if ($stmt->execute()) {
    header('Location: ../../pages/document/index.php?delete=success');
    exit();
} else {
    header('Location: ../../pages/document/index.php?delete=error');
    exit();
}
?>