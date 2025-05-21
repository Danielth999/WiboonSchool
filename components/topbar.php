<?php


// เตรียม array สำหรับเก็บข้อมูล
$school_info = [
    'motto' => '',
    'address' => '',
    'phone' => '',
    'email' => ''
];

// ดึงข้อมูลทั้งหมดจาก school_info
$stmt = $conn->prepare("SELECT `key`, `value` FROM school_info WHERE `key` IN ('motto','address','phone','email')");
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $school_info[$row['key']] = $row['value'];
}
?>
<!-- Top Bar -->
<div class="bg-danger text-white text-sm py-2" id="topbar">
    <div class="container mx-auto flex flex-col md:flex-row items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="mailto:<?php echo htmlspecialchars($school_info['email']); ?>"
                class="hover:text-secondary flex items-center space-x-1">
                <i class="fas fa-envelope"></i><span><?php echo htmlspecialchars($school_info['email']); ?></span>
            </a>
            <a href="tel:<?php echo htmlspecialchars($school_info['phone']); ?>"
                class="hover:text-secondary flex items-center space-x-1">
                <i class="fas fa-phone-alt"></i><span><?php echo htmlspecialchars($school_info['phone']); ?></span>
            </a>
        </div>
        <div class="mt-2 md:mt-0">
            <a href="admin/login.php" target="_blank"
                class="hover:text-secondary flex items-center space-x-1 justify-end">
                <i class="fas fa-user-tie"></i><span>ระบบสำหรับผู้ดูแล</span>
            </a>
        </div>
    </div>
</div>