<?php
session_start();
require_once('../authen.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>เพิ่มสไลด์โชว์ | โรงเรียนวิบูลวิทยา</title>
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
                                        <i class="fas fa-images"></i>
                                        เพิ่มสไลด์โชว์
                                    </h4>
                                    <div class="alert alert-warning mt-3" role="alert">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        <strong>หมายเหตุ:</strong> ห้ามอัพโหลดไฟล์รูปภาพที่มีขนาดเกิน 2 MB
                                    </div>
                                    <a href="./" class="btn btn-info mt-3">
                                        <i class="fas fa-list"></i>
                                        กลับหน้าหลัก
                                    </a>
                                </div>
                                <!-- Form สำหรับการอัพโหลดรูปภาพ -->
                                <form id="formCreate" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="row justify-content-center">
                                            <div class="col-xl-6 px-1 px-md-5">

                                                <!-- ฟิลด์สำหรับอัพโหลดรูปภาพ -->
                                                <div class="form-group">
                                                    <label for="image">เลือกรูปภาพ</label>
                                                    <input type="file" class="form-control" name="image" id="image"
                                                        accept="image/*" required>
                                                </div>

                                                <!-- พรีวิวภาพ -->
                                                <div class="form-group">
                                                    <label for="preview">พรีวิวภาพ</label>
                                                    <img id="preview" src="#" alt="Image Preview"
                                                        style="max-width: 100%; display: none;" />
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit"
                                            class="btn btn-primary btn-block mx-auto w-50">อัพโหลดรูปภาพ</button>
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

    <script>
        // แสดงพรีวิวรูปภาพเมื่อเลือกไฟล์
        document.getElementById('image').addEventListener('change', function(event) {
            var file = event.target.files[0];
            if (file && file.size > 2 * 1024 * 1024) {
                Swal.fire({
                    text: 'ขนาดไฟล์เกิน 2 MB',
                    icon: 'error',
                    confirmButtonText: 'ตกลง',
                });
                event.target.value = '';
                document.getElementById('preview').style.display = 'none';
                return;
            }
            var reader = new FileReader();
            reader.onload = function() {
                var preview = document.getElementById('preview');
                preview.src = reader.result;
                preview.style.display = 'block';
            };
            if (file) reader.readAsDataURL(file);
        });

        // ใช้ AJAX ส่งข้อมูลแบบไม่โหลดหน้าใหม่
        $(function() {
            $('#formCreate').on('submit', function(e) {
                var file = document.getElementById('image').files[0];
                if (file && file.size > 2 * 1024 * 1024) {
                    Swal.fire({
                        text: 'ขนาดไฟล์เกิน 2 MB',
                        icon: 'error',
                        confirmButtonText: 'ตกลง',
                    });
                    e.preventDefault();
                    return false;
                }
                e.preventDefault();
                var formData = new FormData(this); // สร้าง FormData สำหรับส่งข้อมูลที่มีไฟล์

                $.ajax({
                    type: 'POST',
                    url: '../../service/carousel/create.php', // ไฟล์ที่ใช้ในการรับและจัดการข้อมูล
                    data: formData,
                    contentType: false, // ไม่ต้องกำหนด contentType
                    processData: false, // ไม่ต้องแปลงข้อมูลเป็น query string
                    success: function(response) {
                        // แสดงผลลัพธ์หลังจากที่อัพโหลดสำเร็จ
                        Swal.fire({
                            text: 'อัพโหลดรูปภาพเรียบร้อย',
                            icon: 'success',
                            confirmButtonText: 'ตกลง',
                        }).then((result) => {
                            location.assign('./'); // กลับไปที่หน้าหลัก
                        });
                    },
                    error: function() {
                        Swal.fire({
                            text: 'เกิดข้อผิดพลาดในการอัพโหลดรูปภาพ',
                            icon: 'error',
                            confirmButtonText: 'ตกลง',
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>