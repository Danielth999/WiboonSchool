<?php
function isActive($data)
{
    $array = explode('/', $_SERVER['REQUEST_URI']);
    $key = array_search("pages", $array);
    $name = $array[$key + 1];
    return $name === $data ? 'active' : '';
}
?>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars fa-2x"></i></a>
        </li>
    </ul>
    <!-- mobile -->
    <ul class="navbar-nav ml-auto ">
        <li class="nav-item d-md-none d-block">
            <a href="../dashboard/">
                <img src="../../assets/images/AdminLogo.png" alt="Admin Logo" width="50px"
                    class="img-circle elevation-3">
                <span class="font-weight-light pl-1">Wiboonwittaya Admin</span>
            </a>
        </li>
        <li class="nav-item d-md-block d-none">
            <a class="nav-link">เข้าสู่ระบบครั้งล่าสุด: <?php echo $_SESSION['user']['login_time'] ?> </a>
        </li>
    </ul>
</nav>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="../dashboard/" class="brand-link">
        <img src="../../assets/images/AdminLogo.png" alt="Admin Logo" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">Wiboonwittaya Admin</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="../../assets/images/avatar5.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="../manager/" class="d-block">
                    <?php echo $_SESSION['user']['username'] ?> </a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="../dashboard/" class="nav-link <?php echo isActive('dashboard') ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>หน้าหลัก</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../analytics/" class="nav-link ">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>สถิติการเข้าถึงเว็บไซต์</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../manager/" class="nav-link <?php echo isActive('manager') ?>">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p>ผู้ดูแลระบบ</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../school_leader/" class="nav-link <?php echo isActive('school_leader') ?>">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p>ผู้บริหารโรงเรียน</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../carousel/" class="nav-link <?php echo isActive('carousel') ?>">
                        <i class="nav-icon fas fa-images"></i>
                        <p>สไลด์โชว์</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../events/" class="nav-link <?php echo isActive('events') ?>">
                        <i class="fas fa-calendar-alt nav-icon"></i>
                        <p>กิจกรรม</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../structure/" class="nav-link <?php echo isActive('structure') ?>">
                        <i class="nav-icon fas fa-sitemap mr-1"></i>
                        <p>โครงสร้างบริหาร</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../document/" class="nav-link <?php echo isActive('document') ?>">
                        <i class="nav-icon fas fa-print"></i>
                        <p>เอกสารประกอบ</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="../announcement/" class="nav-link <?php echo isActive('announcement') ?>">
                        <i class="nav-icon fas fa-bullhorn"></i>
                        <p>เนื้อหา</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../video/" class="nav-link <?php echo isActive('video') ?>">
                        <i class="nav-icon fas fa-video"></i>
                        <p>วิดิโอ</p>
                    </a>
                </li>

                <li class="nav-header">บัญชีของเรา</li>
                <li class="nav-item">
                    <a href="../logout.php" id="logout" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>ออกจากระบบ</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>