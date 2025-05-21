<?php
require_once '../connect.php';
if(isset($_POST['id']) && isset($_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    try {
        $stmt = $conn->prepare("UPDATE school_leaders SET status = :status WHERE id = :id");
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        echo json_encode(['status'=>'success']);
    } catch(PDOException $e) {
        echo json_encode(['status'=>'error','message'=>$e->getMessage()]);
    }
} else {
    echo json_encode(['status'=>'error','message'=>'Invalid request']);
}