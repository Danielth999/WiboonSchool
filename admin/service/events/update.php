<?php
session_start();
require_once('../connect.php'); // Include database connection

header('Content-Type: application/json');

// Check if 'id' is provided
if (!isset($_GET['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'ไม่พบรหัสกิจกรรม']);
    exit();
}

try {
    // Get the event ID
    $eventId = $_GET['id'];

    // Validate form data
    if (empty($_POST['title'])) {
        echo json_encode(['status' => 'error', 'message' => 'กรุณากรอกหัวข้อกิจกรรม']);
        exit();
    }

    // Get form data
    $title = $_POST['title'];
    $description = $_POST['description']; // เพิ่มการรับข้อมูล description
    $link = $_POST['link'];
    $status = $_POST['status'];

    // Handle file upload if there's an image
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "../../../images/events/";

        // Create directory if it doesn't exist
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Generate unique filename
        $filename = uniqid() . '-' . $_FILES['image']['name'];
        $targetFile = $targetDir . $filename;

        // Check file type
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowTypes = ['jpg', 'jpeg', 'png', 'gif'];

        // Check file size (2MB max)
        if ($_FILES['image']['size'] > 2097152) {
            echo json_encode(['status' => 'error', 'message' => 'ขนาดไฟล์รูปภาพต้องไม่เกิน 2 MB']);
            exit();
        }

        if (!in_array($imageFileType, $allowTypes)) {
            echo json_encode(['status' => 'error', 'message' => 'อนุญาตเฉพาะไฟล์ JPG, JPEG, PNG & GIF เท่านั้น']);
            exit();
        }

        // Move the uploaded file
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            // Get current image to delete later
            $stmt = $conn->prepare("SELECT image FROM events WHERE id = :id");
            $stmt->bindParam(':id', $eventId);
            $stmt->execute();
            $oldImage = $stmt->fetchColumn();

            // Update with new image
            $stmt = $conn->prepare("UPDATE events SET title = :title, description = :description, link = :link, status = :status, image = :image WHERE id = :id");
            $stmt->bindParam(':image', $filename);

            // Delete old image if exists
            if ($oldImage && file_exists($targetDir . $oldImage)) {
                unlink($targetDir . $oldImage);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'การอัพโหลดรูปภาพล้มเหลว']);
            exit();
        }
    } else {
        // Update without changing image
        $stmt = $conn->prepare("UPDATE events SET title = :title, description = :description, link = :link, status = :status WHERE id = :id");
    }

    // Bind parameters and execute
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description); // เพิ่มการ bind parameter description
    $stmt->bindParam(':link', $link);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':id', $eventId);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'อัพเดทข้อมูลกิจกรรมเรียบร้อย']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ไม่สามารถอัพเดทข้อมูลกิจกรรม']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการอัพเดทข้อมูล: ' . $e->getMessage()]);
}