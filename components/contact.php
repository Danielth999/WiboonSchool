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
<!-- Contact Section -->
<section id="contact" class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-4xl font-bold text-danger mb-3">ติดต่อเรา</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">หากมีข้อสงสัยหรือต้องการข้อมูลเพิ่มเติม
                สามารถติดต่อเราได้ตามช่องทางด้านล่าง</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Contact Information Column - Left side -->
            <div data-aos="fade-right">
                <div class="space-y-6">
                    <div class="flex items-center">
                        <div class="bg-gray-100 p-4 rounded-full">
                            <i class="text-danger fas fa-map-marker-alt text-2xl text-gray-700"></i>
                        </div>
                        <div class="ml-4">
                            <h5 class="text-xl font-semibold text-gray-800">ที่อยู่</h5>
                            <p class="text-gray-600"><?php echo htmlspecialchars($school_info['address']); ?></p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="bg-gray-100 p-4 rounded-full">
                            <i class="text-danger fas fa-phone-alt text-2xl text-gray-700"></i>
                        </div>
                        <div class="ml-4">
                            <h5 class="text-xl font-semibold text-gray-800">โทรศัพท์</h5>
                            <p class="text-gray-600"><?php echo htmlspecialchars($school_info['phone']); ?></p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="bg-gray-100 p-4 rounded-full">
                            <i class="text-danger fas fa-envelope text-2xl text-gray-700"></i>
                        </div>
                        <div class="ml-4">
                            <h5 class="text-xl font-semibold text-gray-800">อีเมล</h5>
                            <p class="text-gray-600"><?php echo htmlspecialchars($school_info['email']); ?></p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="bg-gray-100 p-4 rounded-full">
                            <i class="text-danger fas fa-clock text-2xl text-gray-700"></i>
                        </div>
                        <div class="ml-4">
                            <h5 class="text-xl font-semibold text-gray-800">เวลาทำการ</h5>
                            <p class="text-gray-600">จันทร์ - ศุกร์: 07:30 - 16:30 น.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Google Map Column - Right side -->
            <div data-aos="fade-left">
                <div class="w-full aspect-[4/3] md:aspect-[16/9] rounded-xl overflow-hidden shadow-lg">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3891.8780894778674!2d101.29951597460023!3d12.721375220315918!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3102fd18d622bfb7%3A0x391c80c5c3e25768!2z4LmC4Lij4LiH4LmA4Lij4Li14Lii4LiZ4Lin4Li04Lia4Li54Lil4Lin4Li04LiX4Lii4Liy!5e0!3m2!1sth!2sth!4v1745461053016!5m2!1sth!2sth"
                        class="w-full h-full border-0" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>