<?php
session_start();
require_once('../authen.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>สถิติผู้เข้าชมเว็บไซต์ | Analytics</title>
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
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card shadow mt-5">
                                <div class="card-body text-center">
                                    <h3 class="mb-3"><i class="fas fa-exclamation-triangle text-warning"></i>
                                        การเข้าถึงสถิติผู้เข้าชมเว็บไซต์</h3>
                                    <p>การดูสถิติผู้เข้าชมเว็บไซต์นี้ต้องเข้าสู่ระบบ <b>Google Analytics</b>
                                        ด้วยบัญชีที่ได้รับอนุญาต (เช่น email
                                        โรงเรียน)<br>ไม่ใช่ระบบของเว็บไซต์นี้<br>หากต้องการสิทธิ์เข้าถึง
                                        กรุณาขออนุมัติจากผู้ดูแลระบบ Analytics ก่อนใช้งาน</p>
                                    <a href="https://analytics.google.com/analytics/web/#/p489407437/reports/intelligenthome?params=_u..nav%3Dmaui"
                                        class="btn btn-primary mr-2" target="_blank">เข้าสู่ระบบ Google Analytics</a>

                                </div>
                                <img src="../../../images/analytics/ex.png" alt="ตัวอย่างหน้าสถิติ"
                                    class="img-fluid p-3">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once('../includes/footer.php') ?>
    </div>
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/adminlte.min.js"></script>
</body>

</html>