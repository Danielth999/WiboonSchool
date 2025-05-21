<?php
session_start();
require_once('../authen.php'); // Authentication
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>เพิ่มกิจกรรม | โรงเรียนวิบูลวิทยา</title>
    <link rel="shortcut icon" href="../../assets/images/favicon.ico" type="image/x-icon">
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
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow">
                                <div class="card-header border-0 pt-4">
                                    <h4><i class="fas fa-plus"></i> เพิ่มข้อมูลกิจกรรม</h4>
                                    <div class="alert alert-warning mt-3" role="alert">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        <strong>หมายเหตุ:</strong> ห้ามอัพโหลดไฟล์รูปภาพที่มีขนาดเกิน 2 MB
                                    </div>
                                    <a href="./" class="btn btn-info mt-3">
                                        <i class="fas fa-list"></i> กลับหน้าหลัก
                                    </a>
                                </div>

                                <form id="formCreate" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="row justify-content-center">
                                            <div class="col-xl-6 px-1 px-md-5">
                                                <div class="form-group">
                                                    <label for="title">หัวข้อกิจกรรม</label>
                                                    <textarea class="form-control" name="title" id="title"
                                                        placeholder="กรอกหัวข้อกิจกรรม" required rows="3"></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label for="description">รายละเอียดกิจกรรม</label>
                                                    <textarea class="form-control" name="description" id="description"
                                                        placeholder="กรอกรายละเอียดกิจกรรม" rows="4"
                                                        required></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label for="link">ลิงก์กิจกรรม (ถ้ามี)</label>
                                                    <textarea class="form-control" name="link" id="link"
                                                        placeholder="กรอก URL เช่น https://..." rows="2"></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label for="image">รูปภาพกิจกรรม</label>
                                                    <input type="file" class="form-control" name="image" id="image"
                                                        accept="image/*" required>
                                                    <br>
                                                    <img id="preview-image" src="#" alt="Preview"
                                                        style="display:none; max-width:300px; margin-top:10px; border-radius:8px;">
                                                </div>

                                                <div class="form-group">
                                                    <label for="status">สถานะเผยแพร่</label>
                                                    <select class="form-control" name="status" id="status" required>
                                                        <option value="1" selected>เผยแพร่</option>
                                                        <option value="0">ไม่เผยแพร่</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer text-center">
                                        <button type="submit" class="btn btn-primary w-50">
                                            <i class="fas fa-save"></i> บันทึกข้อมูล
                                        </button>
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

    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="../../assets/js/adminlte.min.js"></script>

    <script>
        $(function() {
            // แสดงตัวอย่างรูปภาพ
            $('#image').change(function() {
                const input = this;
                if (input.files && input.files[0]) {
                    // ตรวจสอบขนาดไฟล์ (ฝั่ง client)
                    if (input.files[0].size > 2 * 1024 * 1024) {
                        Swal.fire({
                            text: 'ขนาดไฟล์รูปภาพต้องไม่เกิน 2 MB',
                            icon: 'error',
                            confirmButtonText: 'ตกลง'
                        });
                        $(this).val(''); // ล้างค่า input
                        $('#preview-image').hide();
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#preview-image').attr('src', e.target.result).fadeIn();
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            });

            // ส่งฟอร์ม
            $('#formCreate').submit(function(e) {
                e.preventDefault();

                // ตรวจสอบขนาดไฟล์อีกครั้งก่อนส่ง (กัน user hack js)
                var fileInput = document.getElementById('image');
                if (fileInput.files.length > 0) {
                    var fileSize = fileInput.files[0].size;
                    if (fileSize > 2 * 1024 * 1024) {
                        Swal.fire({
                            text: 'ขนาดไฟล์รูปภาพต้องไม่เกิน 2 MB',
                            icon: 'error',
                            confirmButtonText: 'ตกลง'
                        });
                        return;
                    }
                }

                let formData = new FormData(this);

                $.ajax({
                    type: 'POST',
                    url: '../../service/events/create.php',
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(res) {
                        // แปลง response เป็น object หากเป็น string
                        if (typeof res === 'string') {
                            try {
                                res = JSON.parse(res);
                            } catch (e) {
                                Swal.fire({
                                    text: 'เกิดข้อผิดพลาดในการประมวลผลข้อมูล',
                                    icon: 'error',
                                    confirmButtonText: 'ตกลง'
                                });
                                return;
                            }
                        }
                        if (res.status === 'success') {
                            Swal.fire({
                                text: res.message,
                                icon: 'success',
                                confirmButtonText: 'ตกลง'
                            }).then(() => {
                                window.location.href = './';
                            });
                        } else {
                            Swal.fire({
                                text: res.message,
                                icon: 'error',
                                confirmButtonText: 'ตกลง'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            text: 'ไม่สามารถส่งข้อมูลได้: ' + error,
                            icon: 'error',
                            confirmButtonText: 'ตกลง'
                        });
                    }
                });
            });
        });
    </script>

</body>

</html>