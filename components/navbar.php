<?php
// ฟังก์ชันสำหรับตรวจสอบว่าหน้าปัจจุบันตรงกับลิงก์หรือไม่
function isActive($page)
{
    $currentPage = basename($_SERVER['PHP_SELF']);
    return $page === $currentPage;
}

// ฟังก์ชันสำหรับตรวจสอบว่าหน้าปัจจุบันอยู่ในกลุ่มเมนูหรือไม่
function isActiveGroup($pages)
{
    $currentPage = basename($_SERVER['PHP_SELF']);
    return in_array($currentPage, $pages);
}

// กำหนดกลุ่มเมนูต่างๆ
$schoolInfoPages = ['school-info.php', 'structure.php'];
$personnelPages = ['manager.php', 'academic.php', 'personal.php', 'budget.php', 'technical.php', 'personel.php'];

// ตรวจสอบว่าอยู่ในหน้าเอกสารหรือไม่
$isDocumentPage = basename($_SERVER['PHP_SELF']) === 'document.php' && isset($_GET['course']);

// ตรวจสอบว่าอยู่ในหน้าบุคลากรหรือไม่
$isPersonnelPage = basename($_SERVER['PHP_SELF']) === 'personel.php' && isset($_GET['type']);
?>

<!-- Header -->
<header class="sticky top-0 z-40 bg-white shadow-md">
    <nav class="relative">
        <div class="container mx-auto px-4 py-2">
            <div class="flex items-center justify-between">
                <!-- Logo and Brand -->
                <a href="index.php" class="flex items-center gap-2">
                    <img src="images/logo_school.png" alt="โรงเรียนวิบูลวิทยา" class="h-[60px] w-auto">
                    <span class="text-xl text-gray-600 font-medium">โรงเรียนวิบูลวิทยา</span>
                </a>

                <!-- Mobile Toggle Button -->
                <button type="button" id="mobile-menu-toggle" class="lg:hidden focus:outline-none"
                    aria-label="Toggle navigation">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <!-- Desktop Navigation Menu -->
                <div class="hidden lg:block">
                    <ul class="flex space-x-1">
                        <li>
                            <a href="index.php"
                                class="block py-3 px-5 font-medium transition-colors duration-300 <?= isActive('index.php') ? 'text-danger' : 'text-gray-800 hover:text-danger' ?>">หน้าหลัก</a>
                        </li>

                        <!-- Dropdown: ข้อมูลสถานศึกษา -->
                        <li class="relative desktop-dropdown">
                            <button
                                class="flex items-center py-3 px-5 font-medium transition-colors duration-300 focus:outline-none <?= isActiveGroup($schoolInfoPages) ? 'text-danger' : 'text-gray-800 hover:text-danger' ?>">
                                ข้อมูลสถานศึกษา
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 ml-1 transition-transform duration-200" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <ul
                                class="absolute left-0 pt-2 w-48 bg-white rounded-md shadow-lg opacity-0 invisible transition-all duration-300 transform origin-top scale-95 z-10">
                                <li><a href="school-info.php"
                                        class="block px-6 py-3 text-sm transition-colors duration-300 <?= isActive('school-info.php') ? 'bg-gray-50 text-danger' : 'text-gray-800 hover:bg-gray-50 hover:text-danger' ?>">ประวัติโรงเรียน</a>
                                </li>
                                <li><a href="structure.php"
                                        class="block px-6 py-3 text-sm transition-colors duration-300 <?= isActive('structure.php') ? 'bg-gray-50 text-danger' : 'text-gray-800 hover:bg-gray-50 hover:text-danger' ?>">โครงสร้างบริหาร</a>
                                </li>
                            </ul>
                        </li>

                        <!-- Dropdown: บุคลากร -->
                        <li class="relative desktop-dropdown">
                            <button
                                class="flex items-center py-3 px-5 font-medium transition-colors duration-300 focus:outline-none <?= isActiveGroup($personnelPages) || $isPersonnelPage ? 'text-danger' : 'text-gray-800 hover:text-danger' ?>">
                                บุคลากร
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 ml-1 transition-transform duration-200" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <?php
                            $sql = "SELECT * FROM school_structure WHERE type != 'structure' && status = 1";
                            $result = $conn->query($sql);
                            $personel = $result->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <ul
                                class="absolute left-0 pt-2 w-48 bg-white rounded-md shadow-lg opacity-0 invisible transition-all duration-300 transform origin-top scale-95 z-10">
                                <?php foreach ($personel as $p) : ?>
                                <li>
                                    <a href="personel.php?type=<?= $p['type'] ?>"
                                        class="block px-6 py-3 text-sm transition-colors duration-300 <?= isActive('personel.php') && isset($_GET['type']) && $_GET['type'] === $p['type'] ? 'bg-gray-50 text-danger' : 'text-gray-800 hover:bg-gray-50 hover:text-danger' ?>">
                                        <?= $p['name'] ?>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>

                        <!-- Dropdown: กลุ่มสาระการเรียนรู้ -->
                        <li class="relative desktop-dropdown">
                            <button
                                class="flex items-center py-3 px-5 font-medium transition-colors duration-300 focus:outline-none <?= $isDocumentPage || basename($_SERVER['PHP_SELF']) === 'document.php' ? 'text-danger' : 'text-gray-800 hover:text-danger' ?>">
                                กลุ่มสาระการเรียนรู้
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 ml-1 transition-transform duration-200" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <ul
                                class="absolute left-0 pt-2 w-48 bg-white rounded-md shadow-lg opacity-0 invisible transition-all duration-300 transform origin-top scale-95 z-10">
                                <?php
                                // Query all learning subject categories
                                $categoryQuery = $conn->query("SELECT * FROM categories");
                                $learningSubjects = $categoryQuery->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($learningSubjects as $subject) :
                                    $isCurrentSubject = $isDocumentPage && isset($_GET['course']) && $_GET['course'] === $subject['code'];
                                ?>
                                <li>
                                    <a href="document.php?course=<?= $subject['code']; ?>"
                                        class="block px-6 py-3 text-sm transition-colors duration-300 <?= $isCurrentSubject ? 'bg-gray-50 text-danger' : 'text-gray-800 hover:bg-gray-50 hover:text-danger' ?>">
                                        <?= $subject['name']; ?>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>

                        <li>
                            <a href="all-events.php"
                                class="block py-3 px-5 font-medium transition-colors duration-300 <?= isActive('all-events.php') ? 'text-danger' : 'text-gray-800 hover:text-danger' ?>">กิจกรรม</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>

<!-- Mobile Menu - Full Screen Overlay -->
<div class="lg:hidden fixed inset-0 bg-white z-50 opacity-0 pointer-events-none transition-opacity duration-300 ease-in-out"
    id="mobile-menu">
    <div class="flex flex-col h-full">
        <!-- Mobile Menu Header -->
        <div class="flex items-center justify-between p-4 border-b">
            <a href="index.php" class="flex items-center gap-2">
                <img src="images/logo_school.png" alt="โรงเรียนวิบูลวิทยา" class="h-[50px] w-auto">
                <span class="text-xl text-gray-600 font-medium">โรงเรียนวิบูลวิทยา</span>
            </a>
            <button id="mobile-menu-close" class="p-2 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Mobile Menu Content -->
        <div class="flex-1 overflow-y-auto py-4">
            <ul class="space-y-2 px-4">
                <li>
                    <a href="index.php"
                        class="flex items-center py-3 px-4 rounded-lg font-medium transition-colors duration-300 <?= isActive('index.php') ? 'bg-gray-100 text-danger' : 'text-gray-800 hover:bg-gray-100 hover:text-danger' ?>">
                        หน้าหลัก
                    </a>
                </li>

                <!-- Mobile Dropdown: ข้อมูลสถานศึกษา -->
                <li class="mobile-dropdown">
                    <button
                        class="flex items-center justify-between w-full py-3 px-4 rounded-lg font-medium focus:outline-none transition-colors duration-300 <?= isActiveGroup($schoolInfoPages) ? 'bg-gray-100 text-danger' : 'text-gray-800 hover:bg-gray-100 hover:text-danger' ?>">
                        <span>ข้อมูลสถานศึกษา</span>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 transition-transform duration-200 <?= isActiveGroup($schoolInfoPages) ? 'rotate-180' : '' ?>"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="overflow-hidden transition-all duration-300 max-h-0"
                        aria-expanded="<?= isActiveGroup($schoolInfoPages) ? 'true' : 'false' ?>">
                        <ul class="mt-2 pl-4 space-y-1">
                            <li>
                                <a href="school-info.php"
                                    class="flex items-center py-2 px-4 rounded-lg text-sm transition-colors duration-300 <?= isActive('school-info.php') ? 'bg-gray-100 text-danger' : 'text-gray-700 hover:bg-gray-100 hover:text-danger' ?>">
                                    ประวัติโรงเรียน
                                </a>
                            </li>
                            <li>
                                <a href="structure.php"
                                    class="flex items-center py-2 px-4 rounded-lg text-sm transition-colors duration-300 <?= isActive('structure.php') ? 'bg-gray-100 text-danger' : 'text-gray-700 hover:bg-gray-100 hover:text-danger' ?>">
                                    โครงสร้างบริหาร
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Mobile Dropdown: บุคลากร -->
                <li class="mobile-dropdown">
                    <button
                        class="flex items-center justify-between w-full py-3 px-4 rounded-lg font-medium focus:outline-none transition-colors duration-300 <?= isActiveGroup($personnelPages) || $isPersonnelPage ? 'bg-gray-100 text-danger' : 'text-gray-800 hover:bg-gray-100 hover:text-danger' ?>">
                        <span>บุคลากร</span>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 transition-transform duration-200 <?= isActiveGroup($personnelPages) || $isPersonnelPage ? 'rotate-180' : '' ?>"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="overflow-hidden transition-all duration-300 max-h-0"
                        aria-expanded="<?= isActiveGroup($personnelPages) || $isPersonnelPage ? 'true' : 'false' ?>">
                        <ul class="mt-2 pl-4 space-y-1">
                            <?php foreach ($personel as $p) : ?>
                            <li>
                                <a href="personel.php?type=<?= $p['type'] ?>"
                                    class="flex items-center py-2 px-4 rounded-lg text-sm transition-colors duration-300 <?= isActive('personel.php') && isset($_GET['type']) && $_GET['type'] === $p['type'] ? 'bg-gray-100 text-danger' : 'text-gray-700 hover:bg-gray-100 hover:text-danger' ?>">
                                    <?= $p['name'] ?>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </li>

                <!-- Mobile Dropdown: กลุ่มสาระการเรียนรู้ -->
                <li class="mobile-dropdown">
                    <button
                        class="flex items-center justify-between w-full py-3 px-4 rounded-lg font-medium focus:outline-none transition-colors duration-300 <?= $isDocumentPage || basename($_SERVER['PHP_SELF']) === 'document.php' ? 'bg-gray-100 text-danger' : 'text-gray-800 hover:bg-gray-100 hover:text-danger' ?>">
                        <span>กลุ่มสาระการเรียนรู้</span>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 transition-transform duration-200 <?= $isDocumentPage || basename($_SERVER['PHP_SELF']) === 'document.php' ? 'rotate-180' : '' ?>"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="overflow-hidden transition-all duration-300 max-h-0"
                        aria-expanded="<?= $isDocumentPage || basename($_SERVER['PHP_SELF']) === 'document.php' ? 'true' : 'false' ?>">
                        <ul class="mt-2 pl-4 space-y-1">
                            <?php
                            // Query all learning subject categories
                            $categoryQuery = $conn->query("SELECT * FROM categories");
                            $learningSubjects = $categoryQuery->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($learningSubjects as $subject) :
                                $isCurrentSubject = $isDocumentPage && isset($_GET['course']) && $_GET['course'] === $subject['code'];
                            ?>
                            <li>
                                <a href="document.php?course=<?= $subject['code']; ?>"
                                    class="flex items-center py-2 px-4 rounded-lg text-sm transition-colors duration-300 <?= $isCurrentSubject ? 'bg-gray-100 text-danger' : 'text-gray-700 hover:bg-gray-100 hover:text-danger' ?>">
                                    <?= $subject['name']; ?>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="all-events.php"
                        class="flex items-center py-3 px-4 rounded-lg font-medium transition-colors duration-300 <?= isActive('all-events.php') ? 'bg-gray-100 text-danger' : 'text-gray-800 hover:bg-gray-100 hover:text-danger' ?>">
                        กิจกรรม
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- JavaScript for Menu Toggle -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle main mobile menu
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenuClose = document.getElementById('mobile-menu-close');
    const mobileMenu = document.getElementById('mobile-menu');
    let mobileMenuOpen = false;

    function openMobileMenu() {
        mobileMenu.classList.add('opacity-100');
        mobileMenu.classList.remove('opacity-0', 'pointer-events-none');
        document.body.style.overflow = 'hidden';
        mobileMenuOpen = true;
    }

    function closeMobileMenu() {
        mobileMenu.classList.remove('opacity-100');
        mobileMenu.classList.add('opacity-0', 'pointer-events-none');
        document.body.style.overflow = '';
        mobileMenuOpen = false;
    }

    mobileMenuToggle.addEventListener('click', openMobileMenu);
    mobileMenuClose.addEventListener('click', closeMobileMenu);

    // Toggle mobile dropdowns
    const mobileDropdowns = document.querySelectorAll('.mobile-dropdown');

    mobileDropdowns.forEach(dropdown => {
        const dropdownButton = dropdown.querySelector('button');
        const dropdownContent = dropdown.querySelector('div');
        const icon = dropdownButton.querySelector('svg');

        // Set initial state for active dropdowns
        if (dropdownContent.getAttribute('aria-expanded') === 'true') {
            const dropdownItems = dropdownContent.querySelector('ul');
            dropdownContent.style.maxHeight = dropdownItems.scrollHeight + 'px';
        }

        dropdownButton.addEventListener('click', function() {
            const expanded = dropdownContent.getAttribute('aria-expanded') === 'true';

            // Toggle current dropdown
            if (expanded) {
                dropdownContent.style.maxHeight = '0px';
                dropdownContent.setAttribute('aria-expanded', 'false');
                icon.classList.remove('rotate-180');
            } else {
                const dropdownItems = dropdownContent.querySelector('ul');
                dropdownContent.style.maxHeight = dropdownItems.scrollHeight + 'px';
                dropdownContent.setAttribute('aria-expanded', 'true');
                icon.classList.add('rotate-180');
            }
        });
    });

    // Toggle desktop dropdowns
    const desktopDropdowns = document.querySelectorAll('.desktop-dropdown');

    // Function to close all desktop dropdowns
    function closeAllDesktopDropdowns() {
        desktopDropdowns.forEach(dropdown => {
            const dropdownButton = dropdown.querySelector('button');
            const dropdownContent = dropdown.querySelector('ul');
            const icon = dropdownButton.querySelector('svg');

            dropdownContent.classList.remove('opacity-100', 'visible', 'scale-100');
            dropdownContent.classList.add('opacity-0', 'invisible', 'scale-95');
            icon.classList.remove('rotate-180');
            dropdownButton.setAttribute('aria-expanded', 'false');
        });
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.desktop-dropdown')) {
            closeAllDesktopDropdowns();
        }
    });

    desktopDropdowns.forEach(dropdown => {
        const dropdownButton = dropdown.querySelector('button');
        const dropdownContent = dropdown.querySelector('ul');
        const icon = dropdownButton.querySelector('svg');

        // Set initial ARIA state
        dropdownButton.setAttribute('aria-expanded', 'false');
        dropdownButton.setAttribute('aria-haspopup', 'true');

        dropdownButton.addEventListener('click', function(event) {
            event.stopPropagation();

            const isExpanded = dropdownButton.getAttribute('aria-expanded') === 'true';

            // Close all other dropdowns first
            closeAllDesktopDropdowns();

            // If this dropdown wasn't expanded, open it
            if (!isExpanded) {
                dropdownContent.classList.remove('opacity-0', 'invisible', 'scale-95');
                dropdownContent.classList.add('opacity-100', 'visible', 'scale-100');
                icon.classList.add('rotate-180');
                dropdownButton.setAttribute('aria-expanded', 'true');
            }
        });

        // Handle keyboard navigation
        dropdownButton.addEventListener('keydown', function(event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                dropdownButton.click();
            } else if (event.key === 'Escape') {
                closeAllDesktopDropdowns();
            }
        });
    });

    // Close mobile menu when clicking on links
    const mobileMenuLinks = mobileMenu.querySelectorAll('a');
    mobileMenuLinks.forEach(link => {
        link.addEventListener('click', closeMobileMenu);
    });

    // Close mobile menu when window is resized to desktop size
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 1024 && mobileMenuOpen) {
            closeMobileMenu();
        }
    });
});
</script>