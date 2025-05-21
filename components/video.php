<?php
require_once('includes/conn.php');
// ดึงข้อมูลจากฐานข้อมูล
$sql = "SELECT id, url, created_at, status FROM social_links WHERE status = 1 ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$response = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <!-- Section Header -->
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-4xl font-bold text-danger mb-3">สื่อและกิจกรรม</h2>
            <div class="w-24 h-1 bg-danger mx-auto mb-4"></div>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">ติดตามข่าวสารและกิจกรรมต่างๆ ของโรงเรียน</p>
        </div>

        <!-- Videos Column (เต็มความกว้าง) -->
        <div data-aos="fade-right" class="space-y-6 max-w-3xl mx-auto">
            <?php
            foreach ($response as $video) {
                echo '<div class="bg-white rounded-xl overflow-hidden shadow-lg transition-transform duration-300 hover:shadow-xl hover:-translate-y-1 ">';
                echo '<div class="fb-video" data-href="' . htmlspecialchars($video['url']) . '" data-width="" data-show-text="false"></div>';
                echo '</div>';
            }
            ?>
        </div>

    </div>
</section>