<?php
session_start();
require_once '../connect.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    try {
        $stmt = $conn->prepare("SELECT image_url FROM school_leaders WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $leader = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($leader) {
            $stmt = $conn->prepare("DELETE FROM school_leaders WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                if (!empty($leader['image_url'])) {
                    $image_path = '../../../images/leaders/' . $leader['image_url'];
                    if (file_exists($image_path)) {
                        @unlink($image_path);
                    }
                }
                echo json_encode(['status' => 'success', 'message' => 'ลบข้อมูลเรียบร้อย']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'ไม่สามารถลบข้อมูลได้']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'ไม่พบข้อมูลที่ต้องการลบ']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'ไม่พบ ID ที่ต้องการลบ']);
}