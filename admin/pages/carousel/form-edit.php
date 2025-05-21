<?php
session_start();
require_once('../authen.php');

// ตรวจสอบว่าได้รับ ID จาก URL หรือไม่
$id = $_GET['id']; // รับ ID จาก URL
$sql = "SELECT * FROM carousel WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// หากไม่พบข้อมูลในฐานข้อมูล
if (!$row) {
    echo 'ไม่พบข้อมูลที่ต้องการแก้ไข';
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>อัพเดทรูปภาพ | โรงเรียนวิบูลวิทยา</title>
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
                                        อัพเดทรูปภาพสไลด์โชว์
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
                                <form id="formData" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="row justify-content-center">
                                            <div class="col-xl-6 px-1 px-md-5">

                                                <!-- ฟิลด์สำหรับอัพโหลดรูปภาพ -->
                                                <div class="form-group">
                                                    <label for="image">เลือกรูปภาพ</label>
                                                    <input type="file" class="form-control" name="image" id="image"
                                                        accept="image/*" required>
                                                </div>

                                                <!-- พรีวิวรูปภาพ -->
                                                <div class="form-group">
                                                    <label for="preview">พรีวิวภาพ</label>
                                                    <img id="preview"
                                                        src="../../../images/slide/<?php echo $row['image']; ?>"
                                                        alt="Image Preview" style="max-width: 100%; display: block;" />
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit"
                                            class="btn btn-primary btn-block mx-auto w-50">อัพเดทรูปภาพ</button>
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
                document.getElementById('preview').src = '';
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

        // เมื่อฟอร์มถูกส่ง
        $('#formData').on('submit', function(e) {
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
                url: '../../service/carousel/update.php?id=<?php echo $id; ?>', // ส่งข้อมูลไปยังหน้า update_image.php
                data: formData,
                contentType: false, // ไม่ต้องกำหนด contentType
                processData: false, // ไม่ต้องแปลงข้อมูลเป็น query string
                success: function(response) {
                    let res = JSON.parse(response);
                    if (res.status === 'success') {
                        Swal.fire({
                            text: res.message,
                            icon: 'success',
                            confirmButtonText: 'ตกลง',
                        }).then(() => {
                            location.assign('./'); // เปลี่ยนเส้นทางกลับไปที่หน้าหลัก
                        });
                    } else {
                        Swal.fire({
                            text: res.message,
                            icon: 'error',
                            confirmButtonText: 'ตกลง',
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        text: 'เกิดข้อผิดพลาดในการอัพเดทรูปภาพ',
                        icon: 'error',
                        confirmButtonText: 'ตกลง',
                    });
                }
            });
        });
    </script>

</body>

</html>