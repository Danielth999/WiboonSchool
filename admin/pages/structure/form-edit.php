<?php
session_start();
require_once('../authen.php');

// Check if 'id' is provided in the URL
if (!isset($_GET['id'])) {
    // If no ID, redirect back to events page
    header('Location: ./');
    exit();
}

// Get the event ID from the URL
$structureId = $_GET['id'];

// Prepare SQL query to fetch struc$structure data
$stmt = $conn->prepare("SELECT * FROM school_structure WHERE id = :id");
$stmt->bindParam(':id', $structureId, PDO::PARAM_INT);
$stmt->execute();
$structure = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$structure) {
    // If no structure found, redirect back to structures page
    header('Location: ./');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>จัดการผู้ดูแล </title>
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
                                        เพิ่มข้อมูลลูกค้า
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

                                                <div class="form-group">
                                                    <label for="department">กลุ่มงาน</label>
                                                    <input type="text" class="form-control" name="department"
                                                        id="department" placeholder="กลุ่มงาน"
                                                        value="<?= htmlspecialchars($structure['name']) ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="file_upload">อัพโหลดไฟล์ภาพ</label>
                                                    <input type="file" class="form-control" name="file_upload"
                                                        id="file_upload" accept=".png,.jpg,.jpeg,.webp">
                                                    <small class="form-text text-muted">
                                                        เลือกไฟล์ภาพที่ต้องการอัพโหลด (jpg, jpeg, png, webp)<br>
                                                        <span style="color:red;">* ขนาดไฟล์ต้องไม่เกิน 2 MB</span>
                                                    </small>
                                                    <img src="../../../images/structure/<?= htmlspecialchars($structure['image']) ?>"
                                                        alt="" class="img-fluid mt-2" width="200px" height="200px">
                                                </div>

                                                <div class="form-group">
                                                    <label for="status">สถานะเผยแพร่</label>
                                                    <select class="form-control" name="status" id="status" required>
                                                        <option value="1"
                                                            <?= $structure['status'] == 1 ? 'selected' : '' ?>>เผยแพร่
                                                        </option>
                                                        <option value="0"
                                                            <?= $structure['status'] == 0 ? 'selected' : '' ?>>
                                                            ไม่เผยแพร่</option>
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

    <script>
        $(function() {
            $('#formData').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                var formData = new FormData(this); // Create a new FormData object
                var structureId = <?= $structureId ?>; // ใช้ตัวแปร structureId ที่ประกาศไว้แล้ว

                $.ajax({
                    type: 'POST',
                    url: '../../service/structure/update.php?id=' +
                        structureId, // แก้ไขให้ใช้ตัวแปรที่ถูกต้อง
                    data: formData,
                    contentType: false, // Don't set content type as FormData will handle it
                    processData: false, // Don't process the data
                    cache: false, // Don't cache the data
                    success: function(response) {
                        // แปลง response เป็น JSON object ถ้าได้รับเป็น string
                        if (typeof response === 'string') {
                            try {
                                response = JSON.parse(response);
                            } catch (e) {
                                console.error("Error parsing JSON:", e);
                                Swal.fire("เกิดข้อผิดพลาด!",
                                    "ไม่สามารถประมวลผลการตอบกลับจากเซิร์ฟเวอร์", "error");
                                return;
                            }
                        }

                        // Handle the server's response
                        if (response.status === 'success') {
                            Swal.fire({
                                text: response.message, // ใช้ข้อความจาก backend
                                icon: 'success',
                                confirmButtonText: 'ตกลง',
                            }).then((result) => {
                                // After confirming, redirect to the main page
                                if (result.isConfirmed) {
                                    location.assign('./'); // Redirect to the main page
                                }
                            });
                        } else {
                            Swal.fire("เกิดข้อผิดพลาด", response.message,
                                "error"); // ใช้ข้อความจาก backend
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

<script>
    document.getElementById('file_upload').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file && file.size > 2 * 1024 * 1024) {
            Swal.fire({
                text: 'ขนาดไฟล์ใหญ่เกินไป (ไม่เกิน 2 MB)',
                icon: 'error',
                confirmButtonText: 'ตกลง'
            });
            e.target.value = '';
        }
    });

    $(function() {
        $('#formData').on('submit', function(e) {
            // ตรวจสอบขนาดไฟล์ก่อน submit
            var fileInput = document.getElementById('file_upload');
            if (fileInput.files.length > 0 && fileInput.files[0].size > 2 * 1024 * 1024) {
                Swal.fire({
                    text: 'ขนาดไฟล์ใหญ่เกินไป (ไม่เกิน 2 MB)',
                    icon: 'error',
                    confirmButtonText: 'ตกลง'
                });
                e.preventDefault();
                return false;
            }
            e.preventDefault(); // Prevent the default form submission

            var formData = new FormData(this); // Create a new FormData object
            var structureId = <?= $structureId ?>; // ใช้ตัวแปร structureId ที่ประกาศไว้แล้ว

            $.ajax({
                type: 'POST',
                url: '../../service/structure/update.php?id=' +
                    structureId, // แก้ไขให้ใช้ตัวแปรที่ถูกต้อง
                data: formData,
                contentType: false, // Don't set content type as FormData will handle it
                processData: false, // Don't process the data
                cache: false, // Don't cache the data
                success: function(response) {
                    // แปลง response เป็น JSON object ถ้าได้รับเป็น string
                    if (typeof response === 'string') {
                        try {
                            response = JSON.parse(response);
                        } catch (e) {
                            console.error("Error parsing JSON:", e);
                            Swal.fire("เกิดข้อผิดพลาด!",
                                "ไม่สามารถประมวลผลการตอบกลับจากเซิร์ฟเวอร์", "error");
                            return;
                        }
                    }

                    // Handle the server's response
                    if (response.status === 'success') {
                        Swal.fire({
                            text: response.message, // ใช้ข้อความจาก backend
                            icon: 'success',
                            confirmButtonText: 'ตกลง',
                        }).then((result) => {
                            // After confirming, redirect to the main page
                            if (result.isConfirmed) {
                                location.assign('./'); // Redirect to the main page
                            }
                        });
                    } else {
                        Swal.fire("เกิดข้อผิดพลาด", response.message,
                            "error"); // ใช้ข้อความจาก backend
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