<?php
session_start();
require_once('../connect.php');

header('Content-Type: application/json');

// เช็กสิทธิ์
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'super admin') {
    echo json_encode(['status' => 'error', 'message' => 'คุณไม่มีสิทธิ์ทำรายการนี้']);
    exit;
}

try {
    $id = $_POST['id'] ?? null;
    $username = trim($_POST['username'] ?? '');
    $role = $_POST['role'] ?? '';
    $new_password = $_POST['new_password'] ?? '';

    // เช็กข้อมูลที่จำเป็น
    if (!$id || !$username || !$role) {
        echo json_encode(['status' => 'error', 'message' => 'กรุณากรอกข้อมูลให้ครบถ้วน']);
        exit;
    }

    // ดึงข้อมูลผู้ใช้เดิม
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo json_encode(['status' => 'error', 'message' => 'ไม่พบข้อมูลผู้ใช้งาน']);
        exit;
    }

    // เตรียมข้อมูลที่ต้องอัปเดต
    $fieldsToUpdate = [
        'username' => $username,
        'role' => $role
    ];

    $changeLog = [];

    if ($username !== $user['username']) {
        $changeLog[] = 'เปลี่ยนชื่อผู้ใช้งาน';
    }

    if ($role !== $user['role']) {
        $changeLog[] = 'เปลี่ยนสิทธิ์การใช้งาน';
    }

    // ถ้ามีการกรอก new_password
    if (!empty($new_password)) {
        $fieldsToUpdate['password'] = $new_password; // ใช้ plain text ตามที่คุณต้องการ
        $changeLog[] = 'เปลี่ยนรหัสผ่าน';
    }

    // สร้าง SQL UPDATE แบบไดนามิก
    $setClause = [];
    foreach ($fieldsToUpdate as $key => $value) {
        $setClause[] = "{$key} = :{$key}";
    }
    $sql = "UPDATE users SET " . implode(', ', $setClause) . " WHERE id = :id";

    $stmtUpdate = $conn->prepare($sql);

    // Bind parameters
    foreach ($fieldsToUpdate as $key => $value) {
        $stmtUpdate->bindValue(":{$key}", $value);
    }
    $stmtUpdate->bindValue(':id', $id, PDO::PARAM_INT);

    if ($stmtUpdate->execute()) {
        $message = "อัปเดตสำเร็จ: " . (count($changeLog) > 0 ? implode(', ', $changeLog) : 'ไม่มีการเปลี่ยนแปลง');
        echo json_encode(['status' => 'success', 'message' => $message]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการอัปเดตข้อมูล']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()]);
}
