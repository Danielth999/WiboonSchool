<?php
session_start();
require_once '../connect.php';
header('Content-Type: application/json');

function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? sanitize($_POST['name']) : '';
    $position = isset($_POST['position']) ? sanitize($_POST['position']) : '';
    if (empty($name) || empty($position)) {
        echo json_encode(['status' => 'error', 'message' => 'กรุณากรอกข้อมูลให้ครบถ้วน']);
        exit();
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = $_FILES['image']['name'];
        $imageTmp = $_FILES['image']['tmp_name'];
        $imageSize = $_FILES['image']['size'];
        $imageExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        $targetDir = '../../../images/leaders/';
        if (!file_exists($targetDir)) {
            if (!mkdir($targetDir, 0755, true)) {
                echo json_encode(['status' => 'error', 'message' => 'ไม่สามารถสร้างโฟลเดอร์สำหรับเก็บรูปภาพได้']);
                exit();
            }
        }
        $newFilename = 'leader_' . uniqid() . '.' . $imageExtension;
        $targetFile = $targetDir . $newFilename;
        if (!in_array($imageExtension, $allowedExtensions)) {
            echo json_encode(['status' => 'error', 'message' => 'รองรับเฉพาะไฟล์ประเภท JPG, JPEG, PNG เท่านั้น']);
            exit();
        }
        if ($imageSize > 2097152) {
            echo json_encode(['status' => 'error', 'message' => 'ขนาดไฟล์เกิน 2MB กรุณาเลือกไฟล์ขนาดเล็กลง']);
            exit();
        }
        if (!move_uploaded_file($imageTmp, $targetFile)) {
            echo json_encode(['status' => 'error', 'message' => 'ไม่สามารถอัพโหลดไฟล์ได้ โปรดตรวจสอบสิทธิ์การเข้าถึง']);
            exit();
        }
        $imageUrl = $newFilename;
    } else {
        echo json_encode(['status' => 'error', 'message' => 'กรุณาเลือกรูปภาพ']);
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO school_leaders (name, position, image_url) VALUES (:name, :position, :image_url)");
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':position', $position, PDO::PARAM_STR);
    $stmt->bindParam(':image_url', $imageUrl, PDO::PARAM_STR);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'เพิ่มข้อมูลผู้นำโรงเรียนเรียบร้อยแล้ว']);
    } else {
        if (isset($targetFile) && file_exists($targetFile)) {
            unlink($targetFile);
        }
        echo json_encode(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'กรุณาส่งข้อมูลผ่านฟอร์มเท่านั้น']);
}
