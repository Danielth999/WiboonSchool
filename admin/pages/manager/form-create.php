<?php
session_start();
require_once('../authen.php');
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'super admin') {
    header('Location: ./');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>จัดการผู้ดูแลระบบ | โรงเรียนวิบูลวิทยา</title>
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/images/favicon.ico">
    <!-- stylesheet -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include_once('../includes/sidebar.php') ?>
        <div class="content-wrapper pt-3">
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow">
                                <div class="card-header border-0 pt-4">
                                    <h4>
                                        <i class="fas fa-user-cog"></i>
                                        เพิ่มข้อมูลผู้ดูแล
                                    </h4>
                                    <a href="./" class="btn btn-info my-3 ">
                                        <i class="fas fa-list"></i>
                                        กลับหน้าหลัก
                                    </a>
                                </div>
                                <form id="formCreate" action="../../service/manager/create.php" method="POST">
                                    <div class=" card-body">
                                        <div class="row">
                                            <div class="col-md-6 px-1 px-md-5">
                                                <div class="form-group">
                                                    <label for="username">ชื่อผู้ใช้งาน</label>
                                                    <input type="text" class="form-control" name="username"
                                                        id="username" placeholder="ชื่อผู้ใช้งาน" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="password">รหัสผ่าน</label>
                                                    <input type="password" class="form-control" name="password"
                                                        id="password" placeholder="รหัสผ่าน" required>
                                                </div>

                                            </div>
                                            <div class="col-md-6 px-1 px-md-5">

                                                <div class="form-group">
                                                    <label for="permission">สิทธิ์การใช้งาน</label>
                                                    <select class="form-control" name="role" id="permission" required>
                                                        <option value disabled selected>กำหนดสิทธิ์</option>
                                                        <option value="superadmin">Super Admin</option>
                                                        <option value="admin">Admin</option>
                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-block mx-auto w-50"
                                            name="submit">บันทึกข้อมูล</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once('../includes/footer.php') ?>
    </div>
    <!-- SCRIPTS -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="../../assets/js/adminlte.min.js"></script>
</body>
<script>
    $('#formCreate').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json', // ระบุว่าต้องการรับข้อมูลกลับเป็น JSON
            success: function(response) {
                // ไม่ต้องใช้ JSON.parse เพราะระบุ dataType: 'json' แล้ว
                if (response.status === 'success') {
                    Swal.fire({
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'ตกลง',
                    }).then((result) => {
                        location.assign('./');
                    });
                } else {
                    Swal.fire({
                        text: response.message,
                        icon: 'error',
                        confirmButtonText: 'ตกลง',
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    text: 'เกิดข้อผิดพลาดในการส่งข้อมูล: ' + error,
                    icon: 'error',
                    confirmButtonText: 'ตกลง',
                });
            }
        });
    });
</script>


</html>