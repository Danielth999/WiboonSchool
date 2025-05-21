<!-- Personnel Section -->
<section class="py-20">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12 relative" data-aos="fade-up">
            <h2 class="text-4xl font-bold text-danger mb-4">ผู้บริหารโรงเรียน</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">ทีมผู้บริหารที่มีวิสัยทัศน์และความมุ่งมั่นในการพัฒนาโรงเรียน</p>
            <div class="absolute left-1/2 transform -translate-x-1/2 mt-4 w-20 h-1 bg-red-600"></div>
        </div>
        <?php
        require_once __DIR__ . '/../includes/conn.php';
        $sql = "SELECT * FROM school_leaders WHERE status=0 ORDER BY created_at ASC, id ASC";
        $result = $conn->query($sql);
        ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php if ($result && $result->rowCount() > 0): ?>
            <?php foreach ($result as $row): ?>
            <div data-aos="fade-up">
                <div
                    class="bg-white rounded-lg shadow-md overflow-hidden text-center transition-all duration-300 hover:shadow-xl hover:-translate-y-2">
                    <div
                        class="w-[150px] h-[150px] mx-auto mt-8 mb-4 rounded-full overflow-hidden border-5 border-gray-100">
                        <img src="images/leaders/<?= htmlspecialchars($row['image_url']) ?>"
                            alt="<?= htmlspecialchars($row['position']) ?>" class="w-full h-full ">
                    </div>
                    <div class="px-5 pb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-1"><?= htmlspecialchars($row['name']) ?></h3>
                        <span class="text-danger text-sm block"><?= htmlspecialchars($row['position']) ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <div class="col-span-4 text-center text-gray-500">ไม่พบข้อมูลผู้บริหาร</div>
            <?php endif; ?>
        </div>

        <div class="text-center mt-10" data-aos="fade-up">
            <a href="./structure.php"
                class="inline-block bg-danger text-white font-medium py-3 px-8 rounded-full transition-all duration-300 transform hover:-translate-y-1 hover:shadow-md">
                ดูโครงสร้างบริหารทั้งหมด
            </a>
        </div>
    </div>
</section>