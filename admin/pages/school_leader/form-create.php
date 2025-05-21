<?php
session_start();
require_once('../authen.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>เพิ่มข้อมูลผู้นำโรงเรียน | School Management</title>
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
                                        <i class="fas fa-user-plus"></i>
                                        เพิ่มข้อมูลผู้นำโรงเรียน
                                    </h4>
                                    <a href="./" class="btn btn-info mt-3">
                                        <i class="fas fa-list"></i>
                                        กลับหน้าหลัก
                                    </a>
                                </div>
                                <form id="formData">
                                    <div class="card-body">
                                        <div class="row justify-content-center">
                                            <div class="col-xl-6 px-1 px-md-5">

                                                <div class="form-group">
                                                    <label for="name">ชื่อ <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="name" id="name"
                                                        placeholder="ชื่อ" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="position">ตำแหน่ง <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="position"
                                                        id="position" placeholder="ตำแหน่ง" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="image">รูปภาพ <span class="text-danger">*</span>
                                                        (ไม่เกิน 2MB)</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="image"
                                                            name="image" accept="image/jpeg, image/png, image/jpg"
                                                            required>
                                                        <label class="custom-file-label"
                                                            for="image">เลือกไฟล์รูปภาพ</label>
                                                    </div>
                                                    <small class="form-text text-muted">รองรับไฟล์ภาพ JPG, JPEG, PNG
                                                        ขนาดไม่เกิน 2MB</small>
                                                </div>

                                                <!-- แสดงตัวอย่างรูปภาพที่เลือก -->
                                                <div class="form-group" id="imagePreviewContainer"
                                                    style="display: none;">
                                                    <label>ตัวอย่างรูปภาพ</label>
                                                    <div>
                                                        <img id="imagePreview" src="#" alt="ตัวอย่างรูปภาพ"
                                                            class="img-thumbnail" width="150">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-block mx-auto w-50"
                                            id="btnSubmit">
                                            <i class="fas fa-save mr-2"></i>บันทึกข้อมูล
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
    <!-- SCRIPTS -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="../../assets/js/adminlte.min.js"></script>

    <script>
    // ฟังก์ชั่นสำหรับแสดงตัวอย่างรูปภาพที่เลือก
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').attr('src', e.target.result);
                $('#imagePreviewContainer').show();
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // ฟังก์ชั่นตรวจสอบประเภทไฟล์
    function validateFileType(fileInput) {
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        const file = fileInput.files[0];

        if (!file) {
            return false;
        }

        if (!allowedTypes.includes(file.type)) {
            return false;
        }

        return true;
    }

    // ฟังก์ชั่นตรวจสอบขนาดไฟล์
    function validateFileSize(fileInput) {
        const maxSize = 2 * 1024 * 1024; // 2MB
        const file = fileInput.files[0];

        if (!file) {
            return false;
        }

        if (file.size > maxSize) {
            return false;
        }

        return true;
    }

    $(function() {
        // แสดงชื่อไฟล์ที่เลือกในช่อง input file
        $('.custom-file-input').on('change', function() {
            const fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);

            // ตรวจสอบประเภทไฟล์
            if (!validateFileType(this)) {
                Swal.fire({
                    title: "ประเภทไฟล์ไม่ถูกต้อง!",
                    text: "รองรับเฉพาะไฟล์ JPG, JPEG, PNG เท่านั้น",
                    icon: "error",
                    confirmButtonText: "ตกลง"
                });
                $(this).val('');
                $(this).next('.custom-file-label').html('เลือกไฟล์รูปภาพ');
                $('#imagePreviewContainer').hide();
                return;
            }

            // ตรวจสอบขนาดไฟล์
            if (!validateFileSize(this)) {
                Swal.fire({
                    title: "ขนาดไฟล์เกินกำหนด!",
                    text: "กรุณาเลือกไฟล์ขนาดไม่เกิน 2MB",
                    icon: "error",
                    confirmButtonText: "ตกลง"
                });
                $(this).val('');
                $(this).next('.custom-file-label').html('เลือกไฟล์รูปภาพ');
                $('#imagePreviewContainer').hide();
                return;
            }

            // แสดงตัวอย่างรูปภาพ
            previewImage(this);
        });

        // ส่งฟอร์มด้วย AJAX
        $('#formData').on('submit', function(e) {
            e.preventDefault();

            // ตรวจสอบข้อมูลก่อนส่ง
            if ($('#name').val().trim() === '') {
                Swal.fire({
                    title: "กรุณากรอกชื่อ!",
                    icon: "warning",
                    confirmButtonText: "ตกลง"
                });
                $('#name').focus();
                return;
            }

            if ($('#position').val().trim() === '') {
                Swal.fire({
                    title: "กรุณากรอกตำแหน่ง!",
                    icon: "warning",
                    confirmButtonText: "ตกลง"
                });
                $('#position').focus();
                return;
            }

            // ตรวจสอบว่ามีการเลือกไฟล์หรือไม่
            if ($('#image').val() === '') {
                Swal.fire({
                    title: "กรุณาเลือกรูปภาพ!",
                    icon: "warning",
                    confirmButtonText: "ตกลง"
                });
                return;
            }

            // ปิดปุ่มป้องกันการกด submit ซ้ำ
            $('#btnSubmit').prop('disabled', true).html(
                '<i class="fas fa-spinner fa-spin mr-2"></i>กำลังบันทึกข้อมูล...');

            // เตรียมข้อมูลสำหรับส่ง
            var formData = new FormData(this);

            // ส่งข้อมูลไปยัง server
            $.ajax({
                type: 'POST',
                url: '../../service/school_leader/create.php',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            title: "สำเร็จ!",
                            text: response.message,
                            icon: "success",
                            confirmButtonText: "ตกลง"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'index.php?msg=success';
                            }
                        });
                    } else {
                        Swal.fire({
                            title: "เกิดข้อผิดพลาด!",
                            text: response.message,
                            icon: "error",
                            confirmButtonText: "ตกลง"
                        });
                        // เปิดปุ่มกลับมาใช้งานได้
                        $('#btnSubmit').prop('disabled', false).html(
                            '<i class="fas fa-save mr-2"></i>บันทึกข้อมูล');
                    }
                },
                error: function(xhr, status, error) {
                    // พยายามแปลง response เป็น JSON
                    let errorMessage = 'เกิดข้อผิดพลาดในการเชื่อมต่อกับเซิร์ฟเวอร์';

                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.message) {
                            errorMessage = response.message;
                        }
                    } catch (e) {
                        if (xhr.responseText) {
                            errorMessage = xhr.responseText;
                        }
                    }

                    Swal.fire({
                        title: "เกิดข้อผิดพลาด!",
                        html: `${errorMessage}`,
                        icon: "error",
                        confirmButtonText: "ตกลง"
                    });

                    // เปิดปุ่มกลับมาใช้งานได้
                    $('#btnSubmit').prop('disabled', false).html(
                        '<i class="fas fa-save mr-2"></i>บันทึกข้อมูล');
                }
            });
        });
    });
    </script>
</body>

</html>