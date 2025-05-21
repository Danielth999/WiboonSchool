<?php
session_start();
require_once('../authen.php');

// ดึงข้อมูลหมวดหมู่จากฐานข้อมูล
$stmt = $conn->query("SELECT * FROM categories ");
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>เพิ่มเอกสาร | โรงเรียนวิบูลวิทยา</title>
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
                                        <i class="fas fa-users"></i>
                                        เพิ่มข้อมูลเอกสาร
                                    </h4>
                                    <a href="./" class="btn btn-info mt-3">
                                        <i class="fas fa-list"></i>
                                        กลับหน้าหลัก
                                    </a>
                                </div>
                                <form id="formCreate" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="row justify-content-center">
                                            <div class="col-xl-6 px-1 px-md-5">

                                                <div class="form-group">
                                                    <label for="document_name">ชื่อเอกสาร</label>
                                                    <input type="text" class="form-control" name="document_name"
                                                        id="document_name" placeholder="ชื่อเอกสาร" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="file">อัพโหลดไฟล์</label>
                                                    <input type="file" class="form-control" name="file" id="file"
                                                        required>
                                                    <br>
                                                </div>

                                                <div class="form-group">
                                                    <label for="category_id">หมวดหมู่</label>
                                                    <select class="form-control" name="category_id" id="category_id"
                                                        required>
                                                        <option value="">เลือกประเภทเอกสาร</option>
                                                        <?php foreach ($result as $row) : ?>
                                                            <option value="<?= $row['id'] ?>">
                                                                <?= htmlspecialchars($row['name']) ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
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
                                    <div class="card-footer">
                                        <button type="submit"
                                            class="btn btn-primary btn-block mx-auto w-50">บันทึกข้อมูล</button>
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
        $(function() {
            // เมื่อฟอร์มถูกส่ง
            $('#formCreate').on('submit', function(e) {
                e.preventDefault(); // ป้องกันการ submit แบบปกติ

                var formData = new FormData(this); // สร้าง FormData object

                $.ajax({
                    type: 'POST',
                    url: '../../service/document/create.php', // ส่งคำขอไปที่ไฟล์ create.php
                    data: formData,
                    contentType: false, // ไม่ตั้ง content type เพราะ FormData จะจัดการให้เอง
                    processData: false, // ไม่ประมวลผลข้อมูล
                    cache: false, // ป้องกันการแคชข้อมูล
                    dataType: 'json', // รอรับข้อมูล JSON
                    success: function(response) {
                        // เมื่อได้รับคำตอบจากเซิร์ฟเวอร์
                        if (response.status === 'success') {
                            Swal.fire({
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'ตกลง',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.assign('./'); // รีเฟรชหน้า
                                }
                            });
                        } else {
                            Swal.fire("ไม่สามารถบันทึกได้", response.message, "error");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                        Swal.fire("เกิดข้อผิดพลาด!", "ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้",
                            "error");
                    }
                });
            });
        });
    </script>
</body>

</html>