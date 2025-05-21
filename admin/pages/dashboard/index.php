<?php

/**
 * Dashboard Page
 * 
 * @link https://appzstory.dev
 * @author Yothin Sapsamran (Jame AppzStory Studio)
 */

session_start();
require_once('../authen.php');

// ดึงข้อมูลจำนวนและรายการล่าสุดจากแต่ละโมดูล
// 1. ผู้ดูแลระบบ
$manager_count = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();
$manager_latest = $conn->query("SELECT * FROM users ORDER BY id DESC LIMIT 3")->fetchAll(PDO::FETCH_ASSOC);

// 2. โครงสร้าง
$structure_count = $conn->query("SELECT COUNT(*) FROM school_structure")->fetchColumn();
$structure_latest = $conn->query("SELECT * FROM school_structure ORDER BY upload_date DESC LIMIT 3")->fetchAll(PDO::FETCH_ASSOC);

// 3. กิจกรรม
$event_count = $conn->query("SELECT COUNT(*) FROM events")->fetchColumn();
$event_latest = $conn->query("SELECT * FROM events ORDER BY created_at DESC LIMIT 3")->fetchAll(PDO::FETCH_ASSOC);

// 4. เอกสาร
$document_count = $conn->query("SELECT COUNT(*) FROM documents")->fetchColumn();
$document_latest = $conn->query("SELECT * FROM documents ORDER BY upload_date DESC LIMIT 3")->fetchAll(PDO::FETCH_ASSOC);

// 5. ประกาศ
$announce_count = $conn->query("SELECT COUNT(*) FROM school_info")->fetchColumn();
$announce_latest = $conn->query("SELECT * FROM school_info ORDER BY updated_at DESC LIMIT 3")->fetchAll(PDO::FETCH_ASSOC);

// 6. สไลด์โชว์
$carousel_count = $conn->query("SELECT COUNT(*) FROM carousel")->fetchColumn();
$carousel_latest = $conn->query("SELECT * FROM carousel ORDER BY upload_date DESC LIMIT 3")->fetchAll(PDO::FETCH_ASSOC);
// 7. สไลด์โชว์
$carousel_count = $conn->query("SELECT COUNT(*) FROM social_links")->fetchColumn();
$carousel_latest = $conn->query("SELECT * FROM social_links ORDER BY created_at DESC LIMIT 2")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard | โรงเรียนวิบูลวิทยา</title>
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/images/favicon.ico">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include_once('../includes/sidebar.php') ?>
        <div class="content-wrapper pt-3">
            <div class="content">
                <div class="container-fluid">
                    <div class="row flex-nowrap overflow-auto" style="gap: 16px;">
                        <!-- Card: ผู้ดูแลระบบ -->
                        <div class="col-12 col-md-2 flex-shrink-0" style="min-width:180px;">
                            <div class="small-box bg-info shadow">
                                <div class="inner text-center">
                                    <h3><?php echo $manager_count; ?></h3>
                                    <p>ผู้ดูแลระบบ</p>
                                </div>
                                <a href="../manager/" class="small-box-footer">ดูทั้งหมด <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- Card: โครงสร้าง -->
                        <div class="col-12 col-md-2 flex-shrink-0" style="min-width:180px;">
                            <div class="small-box bg-primary shadow">
                                <div class="inner text-center">
                                    <h3><?php echo $structure_count; ?></h3>
                                    <p>โครงสร้าง</p>
                                </div>
                                <a href="../structure/" class="small-box-footer">ดูทั้งหมด <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- Card: กิจกรรม -->
                        <div class="col-12 col-md-2 flex-shrink-0" style="min-width:180px;">
                            <div class="small-box bg-success shadow">
                                <div class="inner text-center">
                                    <h3><?php echo $event_count; ?></h3>
                                    <p>กิจกรรม</p>
                                </div>
                                <a href="../events/" class="small-box-footer">ดูทั้งหมด <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- Card: เอกสาร -->
                        <div class="col-12 col-md-2 flex-shrink-0" style="min-width:180px;">
                            <div class="small-box bg-warning shadow">
                                <div class="inner text-center">
                                    <h3><?php echo $document_count; ?></h3>
                                    <p>เอกสาร</p>
                                </div>
                                <a href="../document/" class="small-box-footer">ดูทั้งหมด <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- Card: ประกาศ -->
                        <div class="col-12 col-md-2 flex-shrink-0" style="min-width:180px;">
                            <div class="small-box bg-danger shadow">
                                <div class="inner text-center">
                                    <h3><?php echo $announce_count; ?></h3>
                                    <p>ประกาศ</p>
                                </div>
                                <a href="../announcement/" class="small-box-footer">ดูทั้งหมด <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- Card: สไลด์โชว์ -->
                        <div class="col-12 col-md-2 flex-shrink-0" style="min-width:180px;">
                            <div class="small-box bg-secondary shadow">
                                <div class="inner text-center">
                                    <h3><?php echo $carousel_count; ?></h3>
                                    <p>สไลด์โชว์</p>
                                </div>
                                <a href="../carousel/" class="small-box-footer">ดูทั้งหมด <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- Card: video -->
                        <div class="col-12 col-md-2 flex-shrink-0" style="min-width:180px;">
                            <div class="small-box bg-secondary shadow">
                                <div class="inner text-center">
                                    <h3><?php echo $carousel_count; ?></h3>
                                    <p>วิดิโอ</p>
                                </div>
                                <a href="../video/" class="small-box-footer">ดูทั้งหมด <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <!-- แสดงรายการล่าสุดของแต่ละโมดูล -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card shadow">
                                <div class="card-header bg-info text-white">ผู้ดูแลระบบล่าสุด</div>
                                <ul class="list-group list-group-flush">
                                    <?php foreach ($manager_latest as $item): ?>
                                    <li class="list-group-item"><?php echo $item['username']; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <div class="card shadow mt-3">
                                <div class="card-header bg-primary text-white">โครงสร้างล่าสุด</div>
                                <ul class="list-group list-group-flush">
                                    <?php foreach ($structure_latest as $item): ?>
                                    <li class="list-group-item"><?php echo $item['name']; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <div class="card shadow mt-3">
                                <div class="card-header bg-warning text-white">เอกสารล่าสุด</div>
                                <ul class="list-group list-group-flush">
                                    <?php foreach ($document_latest as $item): ?>
                                    <li class="list-group-item"><?php echo $item['title']; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card shadow">
                                <div class="card-header bg-success text-white">กิจกรรมล่าสุด</div>
                                <ul class="list-group list-group-flush">
                                    <?php foreach ($event_latest as $item): ?>
                                    <li class="list-group-item"><?php echo $item['title']; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <div class="card shadow mt-3">
                                <div class="card-header bg-danger text-white">ประกาศล่าสุด</div>
                                <ul class="list-group list-group-flush">
                                    <?php foreach ($announce_latest as $item): ?>
                                    <li class="list-group-item"><?php echo $item['value']; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <div class="card shadow mt-3">
                                <div class="card-header bg-secondary text-white">สไลด์โชว์ล่าสุด</div>
                                <ul class="list-group list-group-flush">
                                    <?php foreach ($carousel_latest as $item): ?>
                                    <li class="list-group-item d-flex align-items-center">
                                        <?php if (!empty($item['image'])): ?>
                                        <img src="../../../images/slide/<?php echo htmlspecialchars($item['image']); ?>"
                                            alt="carousel"
                                            style="width:60px; height:40px; object-fit:cover; border-radius:6px; margin-right:15px;">
                                        <?php endif; ?>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- สามารถเพิ่ม chart หรือกราฟสรุปได้ที่นี่ -->
                </div>
            </div>
        </div>
    </div>
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/adminlte.min.js"></script>
</body>

</html>