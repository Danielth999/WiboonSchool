<?php
// เชื่อมต่อฐานข้อมูล
include 'includes/conn.php';
// ฟังก์ชันช่วยเหลือเกี่ยวกับวันที่
include 'includes/date_helper.php';
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>โรงเรียนวิบูลวิทยา</title>
    <!-- SEO Meta Tags -->
    <meta name="description"
        content="โรงเรียนวิบูลวิทยา จัดการศึกษามุ่งพัฒนาผู้เรียนสู่มาตรฐาน สร้างโอกาสทางการศึกษา มีคุณธรรม นำความรู้สู่สังคม">
    <meta name="keywords"
        content="โรงเรียนวิบูลวิทยา, โรงเรียน, ระยอง,วัดตาขัน,โรงเรียนระยอง,โรงเรียนการกุศล, การศึกษา, ข่าวสาร, กิจกรรม, วิชาการ">
    <meta name="author" content="โรงเรียนวิบูลวิทยา">
    <meta name="robots" content="index, follow">
    <meta property="og:type" content="website">
    <meta property="og:title" content="โรงเรียนวิบูลวิทยา">
    <meta property="og:description"
        content="โรงเรียนวิบูลวิทยา จัดการศึกษามุ่งพัฒนาผู้เรียนสู่มาตรฐาน สร้างโอกาสทางการศึกษา มีคุณธรรม นำความรู้สู่สังคม">
    <meta property="og:image" content="http://wiboonwittayaschool.ac.th/images/logo_school.png">
    <meta property="og:url" content="http://wiboonwittayaschool.ac.th/">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="โรงเรียนวิบูลวิทยา">
    <meta name="twitter:description"
        content="โรงเรียนวิบูลวิทยา โรงเรียนคุณภาพในจังหวัดสุรินทร์ มุ่งเน้นการเรียนรู้และพัฒนาศักยภาพของนักเรียน">
    <meta name="twitter:image" content="http://wiboonwittayaschool.ac.th/images/logo_school.png">
    <!-- Favicon -->
    <link rel="icon" href="images/logo_school.png" type="image/x-icon">
    <!-- CSS หลักของเว็บไซต์ -->
    <link rel="stylesheet" href="assets/css/output.css">
    <!-- CSS สำหรับ AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Font Awesome สำหรับไอคอน -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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

    <!-- ส่วน Topbar -->
    <?php include 'components/topbar.php'; ?>
    <!-- ส่วน Navbar -->
    <?php include 'components/navbar.php'; ?>
    <div class="overflow-x-hidden">
        <!-- Facebook SDK สำหรับ Social Plugins -->
        <div id="fb-root"></div>
        <script async defer src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.2"></script>

        <!-- Hero Carousel -->
        <?php include 'components/carousel.php'; ?>
        <!-- ข่าวประกาศ -->
        <?php include 'components/announcement.php'; ?>
        <!-- เกี่ยวกับโรงเรียน -->
        <?php include 'components/about.php'; ?>
        <!-- บุคลากร -->
        <?php include 'components/personel.php'; ?>
        <!-- ข่าวสารและกิจกรรม -->
        <?php include 'components/news.php'; ?>
        <!-- โปรโมท Afterklass -->
        <?php include 'components/afterklass-promo.php'; ?>
        <!-- ส่วนแสดงวิดิโอ และแสดงเพจ facebook ของโรงเรียน -->
        <?php include 'components/video.php'; ?>
        <!-- facebook page -->
        <?php include 'components/facebook_page.php'; ?>
        <!-- ติดต่อโรงเรียน -->
        <?php include 'components/contact.php'; ?>
        <!-- ปุ่มติดต่อด่วน -->
        <?php include 'components/btn-contact.php'; ?>
        <!-- ส่วน Footer -->
        <?php include 'components/footer.php'; ?>
    </div>

    <!-- Scripts ส่วนล่างของหน้า -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Slick Carousel JS -->
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <!-- AOS Animation JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- สคริปต์เพิ่มเติมสำหรับ AOS (ถ้ามี) -->
    <script src="assets/js/aosInit.js"></script>
</body>

</html>