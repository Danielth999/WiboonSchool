<?php
$host = "localhost";
$dbname = "wiboon";
$user = "root"; // ใส่ระหัสผ่านเป็น root for dev
$pwd = "";

date_default_timezone_set("Asia/Bangkok");

try {
    // connect to the database
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pwd);
    // set the PDO error mode to exception
    // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "เชื่อมต่อฐานข้อมูลสำเร็จ";
} catch (PDOException $e) {
    die("การเชื่อมต่อล้มเหลว: " . $e->getMessage());
}