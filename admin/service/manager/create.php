<?php
session_start();
require_once('../connect.php');

header('Content-Type: application/json'); // ตั้ง header เป็น JSON

// ตรวจสอบสิทธิ์ผู้ใช้
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'super admin') {
    echo json_encode(['status' => 'error', 'message' => 'คุณไม่มีสิทธิ์ในการดำเนินการนี้']);
    exit;
}

try {
    // รับและตรวจสอบข้อมูล
    $required_fields = ['username', 'password', 'role'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            echo json_encode(['status' => 'error', 'message' => 'กรุณากรอกข้อมูลให้ครบถ้วน']);
            exit;
        }
    }

    $username = trim($_POST['username']);
    $password = $_POST['password']; // plain text
    $role = $_POST['role'];

    // ตรวจสอบ username ซ้ำ
    $checkSql = "SELECT id FROM users WHERE username = :username";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bindParam(':username', $username);
    $checkStmt->execute();

    if ($checkStmt->rowCount() > 0) {
        echo json_encode(['status' => 'error', 'message' => 'ชื่อผู้ใช้งานนี้มีอยู่ในระบบแล้ว']);
        exit;
    }

    // บันทึกข้อมูล
    $sql = "INSERT INTO users (username, password, role) 
            VALUES (:username, :password, :role)";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password); // plain text
    $stmt->bindParam(':role', $role);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'เพิ่มข้อมูลผู้ดูแลระบบเรียบร้อย']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()]);
}
