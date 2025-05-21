<?php
session_start();
require_once('../connect.php'); // Authentication

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize input data
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $link = htmlspecialchars($_POST['link']);
    $status = $_POST['status'];

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = $_FILES['image']['name'];
        $imageTmp = $_FILES['image']['tmp_name'];
        $imageSize = $_FILES['image']['size'];
        $imageExtension = pathinfo($imageName, PATHINFO_EXTENSION);
        $targetDir = "../../../images/events/";
        $targetFile = $targetDir . basename($imageName);

        // Check if the file is an image
        if (in_array(strtolower($imageExtension), ['jpg', 'jpeg', 'png', 'gif'])) {
            // Check file size (2MB max)
            if ($imageSize <= 2097152) { // 2MB = 2*1024*1024 = 2097152 bytes
                if (move_uploaded_file($imageTmp, $targetFile)) {
                    // Save event data to the database
                    $stmt = $conn->prepare("INSERT INTO events (title, description, link, image, status) VALUES (:title, :description, :link, :image, :status)");
                    $stmt->bindParam(':title', $title);
                    $stmt->bindParam(':description', $description);
                    $stmt->bindParam(':link', $link);
                    $stmt->bindParam(':image', $imageName);
                    $stmt->bindParam(':status', $status);
                    if ($stmt->execute()) {
                        echo json_encode(['status' => 'success', 'message' => 'เพิ่มกิจกรรมเรียบร้อย']);
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'ไม่สามารถบันทึกข้อมูลกิจกรรม']);
                    }
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'ไม่สามารถอัพโหลดรูปภาพได้']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'ขนาดไฟล์รูปภาพต้องไม่เกิน 2 MB']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'โปรดเลือกไฟล์รูปภาพที่ถูกต้อง']);
        }
    } else {
        // Handle case when no image is uploaded
        $stmt = $conn->prepare("INSERT INTO events (title, description, link, status) VALUES (:title, :description, :link, :status)");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':link', $link);
        $stmt->bindParam(':status', $status);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'เพิ่มกิจกรรมเรียบร้อย']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'ไม่สามารถบันทึกข้อมูลกิจกรรม']);
        }
    }
}