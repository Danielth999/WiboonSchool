<?php
/* Database Connection */
include 'includes/conn.php';

/* Helper Functions */
include 'includes/date_helper.php';
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>โครงสร้างบริหาร - โรงเรียนวิบูลวิทยา</title>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
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
    <?php include 'components/topbar.php'; ?>
    <?php include 'components/navbar.php'; ?>
    <div class="overflow-x-hidden">


        <!-- Header Components -->

        <?php include 'components/banner.php'; ?>

        <!-- Page Header -->
        <header class="relative bg-gradient-to-b from-yellow-50 to-gray-50 pt-16 pb-32 mb-12">
            <div class="container mx-auto px-4">
                <nav class="flex justify-center mb-6" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2 text-gray-600">
                        <li class="flex items-center">
                            <a href="index.php" class="flex items-center hover:underline">
                                <i class="fas fa-home mr-1"></i> หน้าหลัก
                            </a>
                            <span class="mx-2 text-gray-400">/</span>
                        </li>
                        <li class="flex items-center">
                            <a href="#" class="flex items-center hover:underline">
                                <i class="fas fa-school mr-1"></i> ข้อมูลสถานศึกษา
                            </a>
                            <span class="mx-2 text-gray-400">/</span>
                        </li>
                        <li class="flex items-center">
                            <span class="text-gray-800 font-semibold">
                                <i class="fas fa-sitemap mr-1"></i> โครงสร้างบริหาร
                            </span>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-3xl    md:text-4xl font-bold text-center  mb-4 ">
                    โครงสร้างบริหาร
                </h1>
                <p class="text-lg text-gray-600 text-center max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="100">
                    แผนผังการบริหารงานและการแบ่งส่วนงานภายในโรงเรียน เพื่อการบริหารจัดการที่มีประสิทธิภาพ
                </p>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-16 bg-white"></div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto px-4 pb-12">
            <!-- Structure Card -->
            <div class="bg-white rounded-xl shadow-xl overflow-hidden mb-8" data-aos="fade-up">
                <div class="p-6">
                    <?php
                    $stmt = $conn->query("SELECT * FROM school_structure WHERE type = 'structure' AND status = 1 ORDER BY id ASC LIMIT 1");
                    $st = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($st) {
                        $imageUrl = "./images/structure/" . $st['image'];
                        $lastUpdated = isset($st['upload_date']) ? $st['updated_at'] : date('Y-m-d');
                    ?>
                    <div class="relative rounded-lg overflow-hidden shadow-md" data-aos="zoom-in" data-aos-delay="200">
                        <img src="<?= $imageUrl ?>" class="w-full transition-transform duration-500" id="structureImage"
                            alt="โครงสร้างบริหารโรงเรียน">
                        <div class="absolute bottom-4 right-4 flex space-x-2">
                            <button onclick="zoomIn()"
                                class="w-10 h-10 bg-white bg-opacity-80 rounded-full flex items-center justify-center text-yellow-500 hover:bg-yellow-500 hover:text-white transition">
                                <i class="fas fa-search-plus"></i>
                            </button>
                            <button onclick="zoomOut()"
                                class="w-10 h-10 bg-white bg-opacity-80 rounded-full flex items-center justify-center text-yellow-500 hover:bg-yellow-500 hover:text-white transition">
                                <i class="fas fa-search-minus"></i>
                            </button>
                            <button onclick="resetZoom()"
                                class="w-10 h-10 bg-white bg-opacity-80 rounded-full flex items-center justify-center text-yellow-500 hover:bg-yellow-500 hover:text-white transition">
                                <i class="fas fa-redo"></i>
                            </button>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-6 mt-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="flex flex-col md:flex-row">
                            <div class="w-full md:w-2/3">
                                <h3 class="text-xl font-semibold text-gray-800 mb-4">รายละเอียดโครงสร้างบริหาร</h3>

                                <div class="flex items-start">
                                    <div
                                        class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-500 mr-4 flex-shrink-0">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800">ปรับปรุงล่าสุด</h4>
                                        <p class="text-gray-600"><?= formatThaiDate($lastUpdated) ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full md:w-1/3 mt-6 md:mt-0 md:text-right">
                                <a href="<?= $imageUrl ?>" download
                                    class="inline-flex items-center px-6 py-3 bg-danger text-white rounded-full hover:from-red-500 hover:to-yellow-400 transition-all hover:-translate-y-1 shadow-lg hover:shadow-xl">
                                    <i class="fas fa-download mr-2"></i> ดาวน์โหลดแผนผัง
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php } else { ?>
                    <div class="bg-blue-100 text-blue-800 p-4 rounded-lg flex items-center">
                        <i class="fas fa-info-circle mr-3"></i> ขณะนี้ยังไม่มีข้อมูลโครงสร้างบริหาร
                        กรุณาติดต่อผู้ดูแลระบบ
                    </div>
                    <?php } ?>
                </div>
            </div>
        </main>

        <!-- contact-button -->
        <?php include 'components/btn-contact.php'; ?>

        <!-- Footer Components -->
        <?php include 'components/footer.php'; ?>
    </div>
    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="assets/js/aosInit.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
    function zoomIn() {
        const img = document.getElementById('structureImage');
        let currentScale = img.style.transform ? parseFloat(img.style.transform.match(/scale\(([^)]+)\)/)[1]) : 1;
        img.style.transform = `scale(${currentScale + 0.1})`;
    }

    function zoomOut() {
        const img = document.getElementById('structureImage');
        let currentScale = img.style.transform ? parseFloat(img.style.transform.match(/scale\(([^)]+)\)/)[1]) : 1;
        if (currentScale > 0.5) {
            img.style.transform = `scale(${currentScale - 0.1})`;
        }
    }

    function resetZoom() {
        document.getElementById('structureImage').style.transform = 'scale(1)';
    }
    </script>
</body>

</html>