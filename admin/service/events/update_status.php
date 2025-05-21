<?php
session_start();
require_once('../connect.php');

// Check if 'id' and 'status' are provided
if (isset($_POST['id']) && isset($_POST['status'])) {
    $eventId = $_POST['id'];
    $status = $_POST['status'];

    // Prepare SQL to update the status
    $stmt = $conn->prepare("UPDATE events SET status = :status WHERE id = :id");
    $stmt->bindParam(':status', $status, PDO::PARAM_INT);
    $stmt->bindParam(':id', $eventId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'สถานะอัพเดทเรียบร้อย']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ไม่สามารถอัพเดทสถานะได้']);
    }
}