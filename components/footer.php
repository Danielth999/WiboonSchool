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
<footer class="bg-gray-800 text-white ">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 py-10">
            <!-- Footer Logo and Description -->
            <div class="footer-widget flex flex-col items-center md:items-start">
                <div class="footer-logo mb-6">
                    <img src="images/logo_school.png" alt="โรงเรียนวิบูลวิทยา" class="w-32">
                </div>
                <p class="footer-text text-center md:text-left text-gray-400 mb-6">
                    <?php echo htmlspecialchars($school_info['motto']); ?>
                </p>
                <div class="footer-social flex justify-center md:justify-start space-x-4">
                    <a href="https://www.facebook.com/wiboonwittayaschool" class="text-gray-400 hover:text-white"><i
                            class="fab fa-facebook-f"></i></a>
                    <a href="https://www.instagram.com/wiboonrayong?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="
                        class="text-gray-400 hover:text-white"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.tiktok.com/@wiboonrayong?is_from_webapp=1&sender_device=pc"
                        class="text-gray-400 hover:text-white"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>

            <!-- Related Links Section -->
            <div class="footer-widget">
                <h4 class="footer-title text-xl font-semibold text-white mb-4">ลิงก์ที่เกี่ยวข้อง</h4>
                <ul class="footer-links space-y-2 text-gray-400">
                    <li><a href="./school-info.php" class="flex items-center hover:text-white"><i
                                class="fas fa-angle-right mr-2"></i> ประวัติโรงเรียน</a></li>
                    <li><a href="./structure.php" class="flex items-center hover:text-white"><i
                                class="fas fa-angle-right mr-2"></i> โครงสร้างบริหาร</a></li>
                    <li><a href="./all-events.php" class="flex items-center hover:text-white"><i
                                class="fas fa-angle-right mr-2"></i> กิจกรรมทั้งหมด</a></li>
                </ul>
            </div>

            <!-- Contact Information Section -->
            <div class="footer-widget">
                <h4 class="footer-title text-xl font-semibold text-white mb-4">ติดต่อเรา</h4>
                <ul class="footer-contact space-y-4 text-gray-400">
                    <li class="flex items-center">
                        <i class="fas fa-map-marker-alt mr-3"></i>
                        <span><?php echo htmlspecialchars($school_info['address']); ?></span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-phone-alt mr-3"></i>
                        <span><?php echo htmlspecialchars($school_info['phone']); ?></span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-envelope mr-3"></i>
                        <span><?php echo htmlspecialchars($school_info['email']); ?></span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-clock mr-3"></i>
                        <span>จันทร์ - ศุกร์: 07:30 - 16:30 น.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Footer Bottom -->
    <div class="footer-bottom bg-gray-700 py-4">
        <div class="container mx-auto text-center">
            <p class="text-gray-300">&copy; <?= date('Y'); ?> โรงเรียนวิบูลวิทยา. สงวนลิขสิทธิ์.</p>
        </div>
    </div>
</footer>