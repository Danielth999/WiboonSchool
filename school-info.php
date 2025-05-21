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
    <title>ประวัติสถานศึกษา - โรงเรียนวิบูลวิทยา</title>
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
        <!-- School Info Section -->
        <section id="school-info" class="py-12 bg-white">
            <div class="container mx-auto px-4">
                <div class="flex justify-center mb-12">
                    <div class="w-full lg:w-2/3 text-center">
                        <h2 class="text-3xl font-bold mb-4" data-aos="fade-up">ประวัติโรงเรียนวิบูลวิทยา</h2>
                        <p class="text-gray-600" data-aos="fade-up" data-aos-delay="100">เรียนรู้เกี่ยวกับประวัติ
                            สัญลักษณ์ และปรัชญาของโรงเรียนของเรา</p>
                    </div>
                </div>

                <div class="flex flex-wrap -mx-4">
                    <div class="w-full lg:w-1/2 px-4 mb-6" data-aos="fade-up">
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                            <div class="bg-yellow-500 text-white p-4 flex items-center">
                                <div
                                    class="w-10 h-10 rounded-full bg-white text-yellow-500 flex items-center justify-center mr-3">
                                    <i class="fas fa-landmark text-xl"></i>
                                </div>
                                <h3 class="text-xl font-bold">ตราโรงเรียน</h3>
                            </div>
                            <div class="p-6">
                                <p class="mb-6">เป็นรูปวงกลมเส้นผ่าศูนย์กลาง 5 เซนติเมตร ตรงกลางมีรูปหนังสือ และ
                                    ดวงเทียน
                                </p>
                                <div class="space-y-4">
                                    <div class="flex">
                                        <div
                                            class="w-10 h-10 rounded-full bg-yellow-100 text-yellow-500 flex items-center justify-center mr-3">
                                            <i class="fas fa-book"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-bold">หนังสือ</h4>
                                            <p class="text-gray-600">คือ สัญลักษณ์ของสรรพวิทยาการต่าง ๆ
                                                ก่อให้เกิดปัญญาความรู้</p>
                                        </div>
                                    </div>
                                    <div class="flex">
                                        <div
                                            class="w-10 h-10 rounded-full bg-yellow-100 text-yellow-500 flex items-center justify-center mr-3">
                                            <i class="fas fa-fire"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-bold">ดวงเทียน</h4>
                                            <p class="text-gray-600">สัญลักษณ์ของแสงสว่าง ฉะนั้น "หนังสือและดวงเทียน"
                                                จึงหมายถึง ปัญญาคือแสงสว่าง
                                                ความเจริญงอกงามแห่งชีวิต</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w-full lg:w-1/2 px-4 mb-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                            <div class="bg-red-500 text-white p-4 flex items-center">
                                <div
                                    class="w-10 h-10 rounded-full bg-white text-red-500 flex items-center justify-center mr-3">
                                    <i class="fas fa-star text-xl"></i>
                                </div>
                                <h3 class="text-xl font-bold">อัตลักษณ์โรงเรียน</h3>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-gray-50 p-4 rounded-lg text-center">
                                        <div
                                            class="w-12 h-12 rounded-full bg-yellow-100 text-yellow-500 flex items-center justify-center mx-auto mb-2">
                                            <i class="fas fa-font"></i>
                                        </div>
                                        <h4 class="font-bold mb-1">ชื่อย่อ</h4>
                                        <p class="text-gray-600">ว.บ.</p>
                                    </div>
                                    <div class="bg-gray-50 p-4 rounded-lg text-center">
                                        <div
                                            class="w-12 h-12 rounded-full bg-yellow-100 text-yellow-500 flex items-center justify-center mx-auto mb-2">
                                            <i class="fas fa-quote-right"></i>
                                        </div>
                                        <h4 class="font-bold mb-1">คติพจน์โรงเรียน</h4>
                                        <p class="text-gray-600">ปญฺญา โลกสฺมิ ปชฺโชโต<br>(ปัญญาเป็นแสงสว่างในโลก)</p>
                                    </div>
                                    <div class="bg-gray-50 p-4 rounded-lg text-center">
                                        <div
                                            class="w-12 h-12 rounded-full bg-yellow-100 text-yellow-500 flex items-center justify-center mx-auto mb-2">
                                            <i class="fas fa-palette"></i>
                                        </div>
                                        <h4 class="font-bold mb-1">สีประจำโรงเรียน</h4>
                                        <p class="text-gray-600 mb-2">เหลือง แดง</p>
                                        <div class="flex justify-center">
                                            <span class="w-6 h-6 bg-yellow-400 rounded-full mr-1"></span>
                                            <span class="w-6 h-6 bg-red-500 rounded-full"></span>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 p-4 rounded-lg text-center">
                                        <div
                                            class="w-12 h-12 rounded-full bg-yellow-100 text-yellow-500 flex items-center justify-center mx-auto mb-2">
                                            <i class="fas fa-pray"></i>
                                        </div>
                                        <h4 class="font-bold mb-1">พระพุทธรูปประจำโรงเรียน</h4>
                                        <p class="text-gray-600">พระพุทธปางลีลา</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <div class="w-full px-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                            <div class="bg-blue-500 text-white p-4 flex items-center">
                                <div
                                    class="w-10 h-10 rounded-full bg-white text-blue-500 flex items-center justify-center mr-3">
                                    <i class="fas fa-lightbulb text-xl"></i>
                                </div>
                                <h3 class="text-xl font-bold">ปรัชญาและวิสัยทัศน์</h3>
                            </div>
                            <div class="p-6">
                                <div class="flex flex-wrap -mx-4">
                                    <div class="w-full md:w-1/3 px-4 mb-6 md:mb-0">
                                        <div class="bg-gray-50 p-6 rounded-lg h-full text-center">
                                            <div
                                                class="w-16 h-16 rounded-full bg-blue-100 text-blue-500 flex items-center justify-center mx-auto mb-4">
                                                <i class="fas fa-eye text-2xl"></i>
                                            </div>
                                            <h4 class="font-bold mb-2">วิสัยทัศน์</h4>
                                            <p class="text-gray-600">จัดการศึกษามุ่งพัฒนาผู้เรียนสู่มาตรฐาน
                                                สร้างโอกาสทางการศึกษา มีคุณธรรม
                                                นำความรู้สู่สังคม</p>
                                        </div>
                                    </div>
                                    <div class="w-full md:w-1/3 px-4 mb-6 md:mb-0">
                                        <div class="bg-gray-50 p-6 rounded-lg h-full text-center">
                                            <div
                                                class="w-16 h-16 rounded-full bg-blue-100 text-blue-500 flex items-center justify-center mx-auto mb-4">
                                                <i class="fas fa-fingerprint text-2xl"></i>
                                            </div>
                                            <h4 class="font-bold mb-2">เอกลักษณ์</h4>
                                            <p class="text-gray-600">คุณธรรม นำความรู้ สู่สังคม</p>
                                        </div>
                                    </div>
                                    <div class="w-full md:w-1/3 px-4">
                                        <div class="bg-gray-50 p-6 rounded-lg h-full text-center">
                                            <div
                                                class="w-16 h-16 rounded-full bg-blue-100 text-blue-500 flex items-center justify-center mx-auto mb-4">
                                                <i class="fas fa-id-card text-2xl"></i>
                                            </div>
                                            <h4 class="font-bold mb-2">อัตลักษณ์</h4>
                                            <p class="text-gray-600">ยิ้มง่าย ไหว้สวย</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

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
</body>

</html>