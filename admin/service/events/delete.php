<?php
session_start();
require_once('../connect.php'); // Authentication

// Check if 'id' is provided in the POST request
if (isset($_POST['id'])) {
    $eventId = $_POST['id'];

    // Fetch the image path associated with the event from the database
    $stmt = $conn->prepare("SELECT image FROM events WHERE id = :id");
    $stmt->bindParam(':id', $eventId, PDO::PARAM_INT);
    $stmt->execute();
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($event) {
        // Get the image path
        $imagePath = '../../../images/events/' . $event['image'];

        // Check if the image exists in the server and delete it
        if (file_exists($imagePath)) {
            // Delete the image from the server
            unlink($imagePath);
        }
    }

    // Prepare SQL to delete the event
    $stmt = $conn->prepare("DELETE FROM events WHERE id = :id");
    $stmt->bindParam(':id', $eventId, PDO::PARAM_INT);

    // Execute the query and check if the event is deleted
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'กิจกรรมถูกลบเรียบร้อย']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ไม่สามารถลบกิจกรรมได้']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'ไม่พบ ID ที่ต้องการลบ']);
}
