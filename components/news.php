<?php
// ดึงข้อมูลกิจกรรมล่าสุดจากฐานข้อมูล
$stmt = $conn->prepare("SELECT * FROM events WHERE status = 1 ORDER BY created_at DESC LIMIT 4");
$stmt->execute();
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- News & Events Section -->
<section class="py-16 bg-light">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl font-bold mb-4 text-danger">ข่าวสารประชาสัมพันธ์</h2>
            <p class="text-body max-w-2xl mx-auto">ติดตามข่าวสารและกิจกรรมล่าสุดของโรงเรียนวิบูลวิทยา</p>
        </div>

        <!-- Grid Container for Events -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php
            $i = 0;
            foreach ($events as $event) {
                $sdate = formatThaiDate($event['created_at']);
            ?>
            <div class="mb-8" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
                <div
                    class="bg-white rounded-lg overflow-hidden shadow-md transition-all duration-300 hover:shadow-xl hover:-translate-y-2 flex flex-col h-full">
                    <!-- Event image -->
                    <?php if ($event['image'] !== '') : ?>
                    <div class="w-full overflow-hidden h-[200px]">
                        <img src="images/events/<?= htmlspecialchars($event['image']) ?>"
                            alt="<?= htmlspecialchars($event['title']) ?>"
                            class="w-full h-full object-fill transition-transform duration-500 hover:scale-110">
                    </div>
                    <?php endif; ?>
                    <!-- Event content -->
                    <div class="p-5 flex-1">
                        <span class="text-sm mb-2 block">
                            <i class="far fa-calendar-alt mr-2"></i><?= $sdate ?>
                        </span>
                        <h3 class="text-xl font-semibold mb-2 truncate-3-lines"><?= htmlspecialchars($event['title']) ?>
                        </h3>
                        <p class="text-gray-600 mb-4">รายละเอียดกิจกรรมและข่าวสารที่น่าสนใจของโรงเรียน</p>
                        <a href="event-detail.php?id=<?= $event['id'] ?>"
                            class="bg-danger text-white py-2 px-4 rounded-full inline-flex items-center gap-2">
                            <i class="fas fa-external-link-alt"></i>
                            <span>อ่านรายละเอียด</span>
                        </a>
                    </div>
                </div>
            </div>
            <?php
                $i++;
            }
            ?>
        </div>
        <div class="text-center mt-10" data-aos="fade-up">
            <a href="./all-events.php"
                class="inline-block bg-danger text-white font-medium py-3 px-8 rounded-full transition-all duration-300 transform hover:-translate-y-1 hover:shadow-md">
                ข่าวสารประชาสัมพันธ์ทั้งหมด
            </a>
        </div>

    </div>
</section>

<style>
/* กำหนดการแสดงผลของ title ให้อยู่ใน 3 บรรทัด */
.truncate-3-lines {
    display: -webkit-box;
    line-clamp: 2;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* รูปภาพที่ใช้ object-cover เพื่อให้ขนาดไม่บิดเบี้ยว */
.event-image {
    width: 100%;
    height: 200px;
    /* กำหนดความสูงคงที่ */
    object-fit: cover;
    /* ให้รูปครอบพื้นที่ */
}
</style>