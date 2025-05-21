<?php
include('includes/conn.php');
include('includes/date_helper.php');

// กำหนดจำนวนรายการต่อหน้า
$itemsPerPage = 10;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($currentPage - 1) * $itemsPerPage;

// ดึงจำนวนรายการทั้งหมด
$countStmt = $conn->query("SELECT COUNT(*) FROM events WHERE status = 1");
$totalItems = $countStmt->fetchColumn();
$totalPages = ceil($totalItems / $itemsPerPage);

// ตรวจสอบหน้าปัจจุบัน
if ($currentPage < 1) {
    $currentPage = 1;
} elseif ($currentPage > $totalPages && $totalPages > 0) {
    $currentPage = $totalPages;
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>กิจกรรมย้อนหลังทั้งหมด - โรงเรียนวิบูลวิทยา</title>
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
    <?php include('components/topbar.php'); ?>
    <?php include('components/navbar.php'); ?>
    <div class="overflow-x-hidden">



        <?php include('components/banner.php'); ?>

        <!-- Page Header -->
        <header class="relative bg-yellow-50 pt-16 pb-32 mb-12">
            <div class="max-w-screen-xl mx-auto px-4">
                <nav aria-label="breadcrumb" class="flex justify-center mb-6">
                    <ol class="flex items-center space-x-2 text-gray-600">
                        <li class="flex items-center">
                            <a href="index.php" class="flex items-center hover:underline">
                                <i class="fas fa-home mr-1"></i> หน้าหลัก
                            </a>
                            <span class="mx-2 text-gray-400">/</span>
                        </li>
                        <li class="flex items-center">
                            <a href="news.php" class="flex items-center hover:underline">
                                <i class="fas fa-calendar-alt mr-1"></i> กิจกรรม
                            </a>
                            <span class="mx-2 text-gray-400">/</span>
                        </li>
                        <li class="flex items-center">
                            <span class="text-gray-800 font-semibold">
                                <i class="fas fa-history mr-1"></i> กิจกรรมย้อนหลังทั้งหมด
                            </span>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-3xl md:text-4xl font-bold text-center mb-4" data-aos="fade-up">กิจกรรมย้อนหลังทั้งหมด
                </h1>
                <p class="text-lg text-gray-600 text-center max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="100">
                    รวบรวมกิจกรรมและผลงานต่างๆ ของโรงเรียนวิบูลวิทยา
                </p>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto px-4 pb-5">
            <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8" data-aos="fade-up">
                <div class="  py-5 px-6 flex justify-between items-center">

                    <h2 class="text-xl md:text-2xl font-semibold flex items-center"><i
                            class="fa-solid fa-list mr-3"></i>รายการกิจกรรม</h2>
                    <span
                        class=" bg-opacity-20 py-1 px-4 rounded-full text-sm font-medium"><?= number_format($totalItems) ?>
                        รายการ</span>
                </div>
                <div class="p-6">
                    <?php
                    try {
                        $stmt = $conn->prepare("SELECT * FROM events WHERE status = 1 ORDER BY created_at DESC LIMIT :offset, :limit");
                        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
                        $stmt->bindParam(':limit', $itemsPerPage, PDO::PARAM_INT);
                        $stmt->execute();
                        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        if (!empty($results)) {
                    ?>
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-center">ลำดับ</th>
                                    <th class="px-4 py-2">ชื่อกิจกรรม</th>
                                    <th class="px-4 py-2 text-center">วันที่</th>
                                    <th class="px-4 py-2 text-center">รายละเอียด</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                        $startNumber = ($currentPage - 1) * $itemsPerPage + 1;
                                        foreach ($results as $index => $show) {
                                            $hasImage = !empty($show['image']);
                                            $hasDescription = !empty($show['title']);
                                        ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 text-center"><?= $startNumber + $index ?></td>
                                    <td class="px-4 py-2">
                                        <div class="flex items-center">
                                            <?php if ($hasImage): ?>
                                            <div class="w-20 h-16 overflow-hidden rounded-lg mr-4">
                                                <img src="images/events/<?= htmlspecialchars($show['image']) ?>"
                                                    alt="<?= htmlspecialchars($show['title']) ?>"
                                                    class="w-full h-full object-cover">
                                            </div>
                                            <?php endif; ?>
                                            <div>
                                                <?php if ($hasDescription): ?>
                                                <p class="text-sm text-gray-500">
                                                    <?= htmlspecialchars(substr($show['title'], 0, 100)) ?><?= strlen($show['title']) > 100 ? '...' : '' ?>
                                                </p>
                                                <?php endif; ?>
                                                <div class="text-sm text-gray-600">
                                                    <span class="inline-flex items-center gap-2">
                                                        <i class="fas fa-calendar-day"></i>
                                                        <?= formatThaiDate($show['created_at']) ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        <div class="rounded-lg py-2 px-4 text-center">
                                            <div class="text-lg font-bold">
                                                <?= date('d', strtotime($show['created_at'])) ?>
                                            </div>
                                            <div class="text-xs">
                                                <?= formatThaiDate($show['created_at']) ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        <a href="event-detail.php?id=<?= htmlspecialchars($show['id']) ?>"
                                            target="_blank"
                                            class="bg-danger text-white py-2 px-4 rounded-full inline-flex items-center gap-2">
                                            <i class="fas fa-external-link-alt"></i>
                                            <span>อ่านรายละเอียด</span>
                                        </a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <?php if ($totalPages > 1): ?>
                    <div class="mt-8">
                        <div
                            class="flex flex-col md:flex-row justify-between items-center px-4 py-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center text-sm text-gray-700 mb-4 md:mb-0">
                                <p>
                                    แสดง
                                    <span class="font-medium"><?= $startNumber ?></span>
                                    ถึง
                                    <span
                                        class="font-medium"><?= min($currentPage * $itemsPerPage, $totalItems) ?></span>
                                    จากทั้งหมด
                                    <span class="font-medium"><?= $totalItems ?></span>
                                    รายการ
                                </p>
                            </div>

                            <div class="inline-flex space-x-1">
                                <!-- First Page Button -->
                                <a href="?page=1"
                                    class="<?= ($currentPage <= 1) ? 'opacity-50 cursor-not-allowed' : '' ?> relative inline-flex items-center px-2 py-2 rounded-md bg-white text-sm font-medium text-gray-500 hover:bg-gray-100">
                                    <span class="sr-only">หน้าแรก</span>
                                    <i class="fas fa-angle-double-left"></i>
                                </a>

                                <!-- Previous Page Button -->
                                <a href="?page=<?= max(1, $currentPage - 1) ?>"
                                    class="<?= ($currentPage <= 1) ? 'opacity-50 cursor-not-allowed' : '' ?> relative inline-flex items-center px-4 py-2 rounded-md bg-white text-sm font-medium text-gray-700 hover:bg-gray-100">
                                    <span class="sr-only">ก่อนหน้า</span>
                                    <i class="fas fa-chevron-left mr-1"></i> ก่อนหน้า
                                </a>

                                <!-- Page Numbers -->
                                <div class="hidden md:inline-flex">
                                    <?php
                                                $startPage = max(1, $currentPage - 2);
                                                $endPage = min($totalPages, $currentPage + 2);

                                                if ($startPage > 1) {
                                                    echo '<a href="?page=1" class="relative inline-flex items-center px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md">1</a>';
                                                    if ($startPage > 2) {
                                                        echo '<span class="relative inline-flex items-center px-2 py-2 bg-white text-sm font-medium text-gray-700">...</span>';
                                                    }
                                                }

                                                for ($i = $startPage; $i <= $endPage; $i++) {
                                                    $activeClass = ($i == $currentPage) ? 'bg-danger text-white' : 'bg-white text-gray-700 hover:bg-gray-100';
                                                    echo '<a href="?page=' . $i . '" class="relative inline-flex items-center px-4 py-2 ' . $activeClass . ' text-sm font-medium rounded-md">' . $i . '</a>';
                                                }

                                                if ($endPage < $totalPages) {
                                                    if ($endPage < $totalPages - 1) {
                                                        echo '<span class="relative inline-flex items-center px-2 py-2 bg-white text-sm font-medium text-gray-700">...</span>';
                                                    }
                                                    echo '<a href="?page=' . $totalPages . '" class="relative inline-flex items-center px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md">' . $totalPages . '</a>';
                                                }
                                                ?>
                                </div>

                                <!-- Next Page Button -->
                                <a href="?page=<?= min($totalPages, $currentPage + 1) ?>"
                                    class="<?= ($currentPage >= $totalPages) ? 'opacity-50 cursor-not-allowed' : '' ?> relative inline-flex items-center px-4 py-2 rounded-md bg-white text-sm font-medium text-gray-700 hover:bg-gray-100">
                                    <span class="sr-only">ถัดไป</span>
                                    ถัดไป <i class="fas fa-chevron-right ml-1"></i>
                                </a>

                                <!-- Last Page Button -->
                                <a href="?page=<?= $totalPages ?>"
                                    class="<?= ($currentPage >= $totalPages) ? 'opacity-50 cursor-not-allowed' : '' ?> relative inline-flex items-center px-2 py-2 rounded-md bg-white text-sm font-medium text-gray-500 hover:bg-gray-100">
                                    <span class="sr-only">หน้าสุดท้าย</span>
                                    <i class="fas fa-angle-double-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php } else { ?>
            <div class="text-center py-8">
                <i class="fas fa-calendar-times text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-2xl text-gray-800">ไม่พบข้อมูลกิจกรรม</h3>
                <p class="text-gray-500">ขณะนี้ยังไม่มีข้อมูลกิจกรรมในระบบ</p>
            </div>
            <?php }
                    } catch (PDOException $e) { ?>
            <div class="text-center py-8 text-red-500">
                <i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($e->getMessage()) ?>
            </div>
            <?php } ?>
    </div>
    </div>
    </main>

    <?php include('components/btn-contact.php'); ?>
    <?php include('components/footer.php'); ?>



    </div>
    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="assets/js/aosInit.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</body>

</html>
