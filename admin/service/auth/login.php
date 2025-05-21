<?php
session_start(); // เริ่ม session

// ตรวจสอบว่าได้ส่งข้อมูลผ่าน POST มาหรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../connect.php'; // รวมไฟล์การเชื่อมต่อฐานข้อมูล

    $username = $_POST['username'] ?? null;
    $password = $_POST['password'] ?? null;

    if ($username && $password) {
        // ค้นหาผู้ใช้จากฐานข้อมูลตาม username
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // เปรียบเทียบรหัสผ่านที่กรอกกับรหัสผ่านในฐานข้อมูล
        if ($user && $password == $user['password']) {

            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role'],
                'login_time' => date('Y-m-d H:i:s')
            ];


            if (isset($_SESSION['user'])) {
                // เปลี่ยนเส้นทางไปยังหน้า dashboard
                header('Location: ../../pages/dashboard/');
                exit;
            } else {
                echo '<script> alert("ไม่สามารถเริ่ม session ได้ กรุณาลองใหม่อีกครั้ง"); </script>';
                header('Refresh:0; url=../../index.php');
                exit;
            }
        } else {
            // ถ้ารหัสผ่านไม่ถูกต้อง
            echo '<script> alert("ชื่อผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง"); </script>';
            header('Refresh:0; url=../../index.php');
            exit;
        }
    } else {
        // ถ้าไม่ได้กรอกข้อมูล
        echo '<script> alert("กรุณากรอกข้อมูลให้ครบถ้วน"); </script>';
        header('Refresh:0; url=../../index.php');
        exit;
    }
}