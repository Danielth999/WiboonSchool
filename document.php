<?php
/* Database Connection */
include 'includes/conn.php';
/* Helper Functions */
include 'includes/date_helper.php';
include 'includes/get_file_icon.php';

// Get Type
$course = isset($_GET['course']) ? $_GET['course'] : '';

// Pagination settings
$records_per_page = 10; // จำนวนรายการต่อหน้า
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // หน้าปัจจุบัน (default = 1)
$offset = ($page - 1) * $records_per_page; // คำนวณ offset

// Count total records
$count_stmt = $conn->prepare("SELECT COUNT(*) FROM documents d 
                             JOIN categories c ON d.category_id = c.id
                             WHERE c.code = :course AND d.status = 1");
$count_stmt->bindParam(':course', $course, PDO::PARAM_STR);
$count_stmt->execute();
$total_records = $count_stmt->fetchColumn();
$total_pages = ceil($total_records / $records_per_page);

// Get Structure with pagination
$stmt = $conn->prepare("SELECT d.*, c.name as category_name FROM documents d 
                       JOIN categories c ON d.category_id = c.id  
                       WHERE c.code = :course 
                       AND d.status = 1
                       ORDER BY d.id ASC
                       LIMIT :offset, :records_per_page");
$stmt->bindParam(':course', $course, PDO::PARAM_STR);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->bindParam(':records_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();

// ดึงข้อมูลเพื่อนำชื่อหลักสูตรมาแสดง
$category_stmt = $conn->prepare("SELECT name FROM categories WHERE code = :course LIMIT 1");
$category_stmt->bindParam(':course', $course, PDO::PARAM_STR);
$category_stmt->execute();
$category = $category_stmt->fetch(PDO::FETCH_ASSOC);
$courseName = $category ? $category['name'] : '';

// ดึงข้อมูลเอกสารทั้งหมด
$documents = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>โครงสร้าง<?= $courseName ?> - โรงเรียนวิบูลวิทยา</title>
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
    <?php include 'components/topbar.php'; ?>
    <?php include 'components/navbar.php'; ?>
    <div class="overflow-x-hidden">

        <!-- Header Components -->

        <?php include 'components/banner.php'; ?>

        <!-- Page Header -->
        <header class="relative bg-gradient-to-b from-yellow-50 to-gray-50 pt-16 pb-32 mb-12">
            <div class="container mx-auto px-4">
                <nav aria-label="breadcrumb" class="flex justify-center mb-6">
                    <ol class="flex items-center   space-x-2 text-gray-600">
                        <li class="flex items-center">
                            <a href="index.php" class="flex items-center hover:underline">
                                <i class="fas fa-home mr-1"></i> หน้าหลัก
                            </a>
                            <span class="mx-2 text-gray-400">/</span>
                        </li>
                        <li class="flex items-center">
                            <a href="#" class="flex items-center hover:underline">
                                <i class="fas fa-layer-group mr-1"></i> กลุ่มสาระการเรียนรู้
                            </a>
                            <span class="mx-2 text-gray-400">/</span>
                        </li>
                        <?php if (!empty($courseName)): ?>
                        <li class="flex items-center">
                            <a href="document.php?course=<?= htmlspecialchars($course) ?>"
                                class="flex items-center hover:underline">
                                <i class="fas fa-book mr-1"></i> <?= htmlspecialchars($courseName) ?>
                            </a>
                            <span class="mx-2 text-gray-400">/</span>
                        </li>
                        <?php endif; ?>
                        <li class="flex items-center">
                            <span class="text-gray-800 font-semibold">
                                <i class="fas fa-file-alt mr-1"></i> เอกสารประกอบหลักสูตร
                            </span>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-3xl md:text-4xl font-bold text-center mb-4" data-aos="fade-up">เอกสารประกอบหลักสูตร</h1>
                <?php if (!empty($courseName)): ?>
                <p class="text-lg text-gray-600 text-center max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="100">
                    <?= htmlspecialchars($courseName) ?>
                </p>
                <?php else: ?>
                <p class="text-lg text-gray-600 text-center max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="100">
                    รวบรวมเอกสารสำคัญที่เกี่ยวข้องกับหลักสูตรการเรียนการสอน
                </p>
                <?php endif; ?>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto px-4 pb-12">
            <!-- Document Card -->
            <div class="bg-white rounded-xl shadow-xl overflow-hidden mb-8" data-aos="fade-up">
                <div class="p-6 flex flex-wrap justify-between items-center">
                    <h2 class="text-xl md:text-2xl font-semibold flex items-center mb-2 md:mb-0">
                        <i class="fas fa-file-alt mr-3 text-danger"></i> รายการเอกสาร
                    </h2>

                    <div class="flex items-center space-x-3">
                        <?php if (!empty($courseName)): ?>
                        <span class="bg-yellow-100 text-yellow-800 px-4 py-1 rounded-full text-sm font-medium">
                            <?= htmlspecialchars($courseName) ?>
                        </span>
                        <?php endif; ?>

                        <?php if ($total_records > 0): ?>
                        <span class="bg-red-100 text-red-800  px-3 py-1 rounded-full text-sm font-medium">
                            ทั้งหมด <?= number_format($total_records) ?> รายการ
                        </span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="p-6">
                    <?php
                    try {
                        if (count($documents) > 0) {
                    ?>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-16">
                                        ลำดับ
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        ชื่อเอกสาร
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-32 hidden md:table-cell">
                                        ประเภท
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-28">
                                        ดาวน์โหลด
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php
                                        // ตำแหน่งเริ่มต้นของการนับลำดับในหน้าปัจจุบัน
                                        $start_number = ($page - 1) * $records_per_page + 1;

                                        foreach ($documents as $index => $doc) {
                                            $fileExt = pathinfo($doc['filename'], PATHINFO_EXTENSION);
                                            $fileIcon = getFileIcon($fileExt);
                                            $fileColor = getFileColor($fileExt);
                                            $current_number = $start_number + $index;
                                        ?>
                                <tr class="hover:bg-yellow-50 transition">
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-900">
                                        <?= $current_number; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div
                                                class="flex-shrink-0 h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center text-lg <?= $fileColor ?> mr-4">
                                                <i class="<?= $fileIcon ?>"></i>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    <?= htmlspecialchars($doc['title']); ?>
                                                </div>
                                                <?php if (!empty($doc['description'])): ?>
                                                <div class="text-xs text-gray-500 mt-1">
                                                    <?= htmlspecialchars($doc['description']); ?>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500 hidden md:table-cell">
                                        <span
                                            class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            <?= strtoupper($fileExt); ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <a target="_blank"
                                            class="inline-flex items-center justify-center px-3 py-1.5 rounded-full text-xs font-medium bg-danger text-white hover:bg-red-600 transition transform hover:-translate-y-0.5 shadow hover:shadow-md"
                                            href="./admin/document/<?= htmlspecialchars($course); ?>/<?= htmlspecialchars($doc['filename']); ?>"
                                            title="เปิดเอกสาร">
                                            <i class="fas fa-eye mr-1"></i>
                                            <span>เปิด</span>
                                        </a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <?php if ($total_pages > 1): ?>
                    <div class="mt-8">
                        <div
                            class="flex flex-col md:flex-row justify-between items-center px-4 py-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center text-sm text-gray-700 mb-4 md:mb-0">
                                <p>
                                    แสดง
                                    <span class="font-medium"><?= $start_number ?></span>
                                    ถึง
                                    <span
                                        class="font-medium"><?= min($page * $records_per_page, $total_records) ?></span>
                                    จากทั้งหมด
                                    <span class="font-medium"><?= $total_records ?></span>
                                    รายการ
                                </p>
                            </div>

                            <div class="inline-flex space-x-1">
                                <!-- First Page Button -->
                                <a href="?course=<?= htmlspecialchars($course) ?>&page=1"
                                    class="<?= ($page <= 1) ? 'opacity-50 cursor-not-allowed' : '' ?> relative inline-flex items-center px-2 py-2 rounded-md bg-white text-sm font-medium text-gray-500 hover:bg-gray-100"
                                    <?= ($page <= 1) ? 'aria-disabled="true"' : '' ?>>
                                    <span class="sr-only">หน้าแรก</span>
                                    <i class="fas fa-angle-double-left"></i>
                                </a>

                                <!-- Previous Button -->
                                <a href="?course=<?= htmlspecialchars($course) ?>&page=<?= ($page > 1) ? $page - 1 : 1 ?>"
                                    class="<?= ($page <= 1) ? 'opacity-50 cursor-not-allowed' : '' ?> relative inline-flex items-center px-4 py-2 rounded-md bg-white text-sm font-medium text-gray-700 hover:bg-gray-100"
                                    <?= ($page <= 1) ? 'aria-disabled="true"' : '' ?>>
                                    <span class="sr-only">ก่อนหน้า</span>
                                    <i class="fas fa-chevron-left mr-1"></i> ก่อนหน้า
                                </a>

                                <!-- Page Numbers - Desktop -->
                                <div class="hidden md:inline-flex">
                                    <?php
                                                $start_page = max(1, $page - 2);
                                                $end_page = min($total_pages, $page + 2);

                                                // Always show first page
                                                if ($start_page > 1) {
                                                    echo '<a href="?course=' . htmlspecialchars($course) . '&page=1" class="relative inline-flex items-center px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md">1</a>';
                                                    if ($start_page > 2) {
                                                        echo '<span class="relative inline-flex items-center px-2 py-2 bg-white text-sm font-medium text-gray-700">...</span>';
                                                    }
                                                }

                                                // Page numbers
                                                for ($i = $start_page; $i <= $end_page; $i++) {
                                                    $active_class = ($i == $page) ? 'bg-danger text-white' : 'bg-white text-gray-700 hover:bg-gray-100';
                                                    echo '<a href="?course=' . htmlspecialchars($course) . '&page=' . $i . '" class="relative inline-flex items-center px-4 py-2 ' . $active_class . ' text-sm font-medium rounded-md">' . $i . '</a>';
                                                }

                                                // Always show last page
                                                if ($end_page < $total_pages) {
                                                    if ($end_page < $total_pages - 1) {
                                                        echo '<span class="relative inline-flex items-center px-2 py-2 bg-white text-sm font-medium text-gray-700">...</span>';
                                                    }
                                                    echo '<a href="?course=' . htmlspecialchars($course) . '&page=' . $total_pages . '" class="relative inline-flex items-center px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md">' . $total_pages . '</a>';
                                                }
                                                ?>
                                </div>

                                <!-- Next Button -->
                                <a href="?course=<?= htmlspecialchars($course) ?>&page=<?= ($page < $total_pages) ? $page + 1 : $total_pages ?>"
                                    class="<?= ($page >= $total_pages) ? 'opacity-50 cursor-not-allowed' : '' ?> relative inline-flex items-center px-4 py-2 rounded-md bg-white text-sm font-medium text-gray-700 hover:bg-gray-100"
                                    <?= ($page >= $total_pages) ? 'aria-disabled="true"' : '' ?>>
                                    <span class="sr-only">ถัดไป</span>
                                    ถัดไป <i class="fas fa-chevron-right ml-1"></i>
                                </a>

                                <!-- Last Page Button -->
                                <a href="?course=<?= htmlspecialchars($course) ?>&page=<?= $total_pages ?>"
                                    class="<?= ($page >= $total_pages) ? 'opacity-50 cursor-not-allowed' : '' ?> relative inline-flex items-center px-2 py-2 rounded-md bg-white text-sm font-medium text-gray-500 hover:bg-gray-100"
                                    <?= ($page >= $total_pages) ? 'aria-disabled="true"' : '' ?>>
                                    <span class="sr-only">หน้าสุดท้าย</span>
                                    <i class="fas fa-angle-double-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php } else { ?>
                    <div class="text-center py-12" data-aos="fade-up">
                        <div class="mx-auto h-16 w-16 text-gray-300 mb-4">
                            <i class="fas fa-folder-open text-5xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-1">ไม่พบเอกสาร</h3>
                        <p class="text-gray-500 max-w-md mx-auto">ขณะนี้ยังไม่มีเอกสารประกอบหลักสูตรในหมวดหมู่นี้</p>
                    </div>
                    <?php }
                    } catch (PDOException $e) { ?>
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-red-400"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">เกิดข้อผิดพลาดในการดึงข้อมูล:</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <?= htmlspecialchars($e->getMessage()) ?>
                                </div>
                            </div>
                        </div>
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