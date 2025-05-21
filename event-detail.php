<?php
include('includes/conn.php');
include('includes/date_helper.php');
// ตรวจสอบว่ามี id ที่ส่งมาหรือไม่
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: events.php");
    exit;
}
$id = (int)$_GET['id'];
$stmt = $conn->prepare("SELECT * FROM events WHERE id = :id LIMIT 1");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$event = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$event) {
    header("Location: events.php");
    exit;
}

// ดึงกิจกรรมที่เกี่ยวข้องมาแสดง
$stmt = $conn->prepare("SELECT id, title, image, created_at FROM events WHERE id != :id ORDER BY created_at DESC LIMIT 3");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$related_events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($event['title']) ?> - โรงเรียนวิบูลวิทยา</title>
    <!-- SEO Meta Tags -->
    <meta name="description"
        content="โรงเรียนวิบูลวิทยา จัดการศึกษามุ่งพัฒนาผู้เรียนสู่มาตรฐาน สร้างโอกาสทางการศึกษา มีคุณธรรม นำความรู้สู่สังคม">
    <meta name="keywords"
        content="โรงเรียนวิบูลวิทยา, โรงเรียน, ระยอง,วัดตาขัน,โรงเรียนระยอง,โรงเรียนการกุศล, การศึกษา, ข่าวสาร, กิจกรรม, วิชาการ">
    <meta name="author" content="โรงเรียนวิบูลวิทยา">
    <meta name="robots" content="index, follow">
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="โรงเรียนวิบูลวิทยา">
    <meta property="og:description"
        content="โรงเรียนวิบูลวิทยา จัดการศึกษามุ่งพัฒนาผู้เรียนสู่มาตรฐาน สร้างโอกาสทางการศึกษา มีคุณธรรม นำความรู้สู่สังคม">
    <meta property="og:image" content="http://wiboonwittayaschool.ac.th/images/logo_school.png">
    <meta property="og:url" content="http://wiboonwittayaschool.ac.th/">
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="โรงเรียนวิบูลวิทยา">
    <meta name="twitter:description"
        content="โรงเรียนวิบูลวิทยา โรงเรียนคุณภาพในจังหวัดสุรินทร์ มุ่งเน้นการเรียนรู้และพัฒนาศักยภาพของนักเรียน">
    <meta name="twitter:image" content="http://wiboonwittayaschool.ac.th/images/logo_school.png">
    <!-- Favicon -->
    <link rel="icon" href="images/logo_school.png" type="image/x-icon">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="assets/css/output.css">
    <!-- Aos Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- google analytics -->
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-C9VSSBF2SB"></script>
    <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-C9VSSBF2SB');
    </script>
</head>

<body>
    <?php include('components/topbar.php'); ?>
    <?php include('components/navbar.php'); ?>
    <div class="overflow-x-hidden">


        <!-- Breadcrumb -->
        <div
            class="bg-gradient-to-r from-yellow-400 via-amber-500 to-yellow-400 text-white py-4 shadow-md relative overflow-hidden">
            <div class="container mx-auto px-4">
                <div class="flex items-center text-white text-sm">
                    <a href="index.php" class="hover:text-blue-200">หน้าหลัก</a>
                    <span class="mx-2"><i class="fas fa-chevron-right text-xs"></i></span>
                    <a href="all-events.php" class="hover:text-blue-200">กิจกรรม</a>
                    <span class="mx-2"><i class="fas fa-chevron-right text-xs"></i></span>
                    <span class="truncate max-w-xs"><?= htmlspecialchars($event['title']) ?></span>
                </div>
            </div>
        </div>

        <main class="container mx-auto px-4 py-8">
            <div class="max-w-4xl mx-auto">
                <!-- Event Card -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8" data-aos="fade-up"
                    data-aos-duration="1000">
                    <?php if (!empty($event['image'])): ?>
                    <div class="relative w-full h-[450px] overflow-hidden">
                        <img src="images/events/<?= htmlspecialchars($event['image']) ?>"
                            alt="<?= htmlspecialchars($event['title']) ?>"
                            class="w-full h-full object-contain transition-transform duration-700 hover:scale-105">
                        <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/70 to-transparent p-6">
                            <div class="inline-block px-3 py-1  text-white text-sm font-medium rounded-full mb-2">

                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="p-6 md:p-8">
                        <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-4 text-gray-800">
                            <?= htmlspecialchars($event['title']) ?></h1>

                        <div class="flex flex-wrap items-center gap-4 text-gray-600 mb-6">
                            <?php if (!empty($event['location'])): ?>
                            <div class="flex items-center">
                                <i class="fas fa-map-marker-alt text-red-500 mr-2"></i>
                                <span><?= htmlspecialchars($event['location']) ?></span>
                            </div>
                            <?php endif; ?>

                            <div class="flex items-center">
                                <i class="far fa-clock text-blue-500 mr-2"></i>
                                <span><?= formatThaiDate($event['created_at'], true) ?></span>
                            </div>

                            <?php if (!empty($event['organizer'])): ?>
                            <div class="flex items-center">
                                <i class="fas fa-user-tie text-green-500 mr-2"></i>
                                <span><?= htmlspecialchars($event['organizer']) ?></span>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="prose max-w-none mb-8">
                            <div class="text-gray-700 leading-relaxed text-lg space-y-4">
                                <?= nl2br(htmlspecialchars($event['description'] ?? '')) ?>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-wrap  md:justify-between gap-4 mt-6">
                            <a href="./"
                                class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-full transition-colors duration-300 flex items-center">
                                <i class="fas fa-arrow-left mr-2"></i> กลับไปหน้ากิจกรรม
                            </a>

                            <?php if (!empty($event['link'])): ?>
                            <a href="<?= htmlspecialchars($event['link']) ?>"
                                class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-full transition-colors duration-300 flex items-center"
                                target="_blank">
                                <i class="fas fa-external-link-alt mr-2"></i> อ่านเพิ่มเติม
                            </a>
                            <?php endif; ?>


                        </div>
                    </div>
                </div>
        </main>

        <!-- contact-button -->
        <?php include 'components/btn-contact.php'; ?>
        <?php include('components/footer.php'); ?>
    </div>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
    // Initialize AOS
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            duration: 800,
            once: true,
        });
    });
    </script>
</body>

</html>