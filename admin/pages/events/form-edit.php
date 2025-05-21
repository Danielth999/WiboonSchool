<?php
session_start(); // Start session
require_once('../authen.php'); // Include authentication

// Check if 'id' is provided in the URL
if (!isset($_GET['id'])) {
    // If no ID, redirect back to events page
    header('Location: ./');
    exit();
}

// Get the event ID from the URL
$eventId = $_GET['id'];

// Prepare SQL query to fetch event data
$stmt = $conn->prepare("SELECT * FROM events WHERE id = :id");
$stmt->bindParam(':id', $eventId, PDO::PARAM_INT);
$stmt->execute();
$event = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$event) {
    // If no event found, redirect back to events page
    header('Location: events.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>จัดการกิจกรรม | โรงเรียนวิบูลวิทยา</title>
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
                                        <i class="fas fa-th-large"></i>
                                        แก้ไขกิจกรรม
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
                                                    <label for="title">หัวข้อกิจกรรม</label>
                                                    <input type="text" class="form-control" name="title" id="title"
                                                        value="<?= htmlspecialchars($event['title']) ?>"
                                                        placeholder="หัวข้อกิจกรรม">
                                                </div>
                                                <div class="form-group">
                                                    <label for="link">ลิงก์กิจกรรม</label>
                                                    <input type="text" class="form-control" name="link" id="link"
                                                        value="<?= htmlspecialchars($event['link']) ?>"
                                                        placeholder="ลิงก์กิจกรรม">
                                                </div>
                                                <div class="form-group">
                                                    <label for="status">สถานะ</label>
                                                    <select name="status" id="status" class="form-control">
                                                        <option value="1"
                                                            <?= $event['status'] == 1 ? 'selected' : '' ?>>เผยแพร่
                                                        </option>
                                                        <option value="0"
                                                            <?= $event['status'] == 0 ? 'selected' : '' ?>>ไม่เผยแพร่
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="description">คำอธิบายกิจกรรม</label>
                                                    <textarea class="form-control" name="description" id="description"
                                                        placeholder="คำอธิบายกิจกรรม"><?= htmlspecialchars($event['description']) ?></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="image">เลือกรูปกิจกรรม</label>
                                                    <input type="file" class="form-control" name="image" id="image">
                                                    <?php if (!empty($event['image'])): ?>
                                                        <img src="../../../images/events/<?= htmlspecialchars($event['image']) ?>"
                                                            alt="กิจกรรมรูป"
                                                            style="max-width: 100px; max-height: 70px; border-radius: 8px; object-fit: cover;">
                                                    <?php else: ?>
                                                        <div class="mt-2 text-muted">ไม่มีรูปภาพ</div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-block mx-auto w-50"
                                            name="submit">บันทึกข้อมูล</button>
                                    </div>
                                    </>

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
        $('#formData').on('submit', function(e) {
            e.preventDefault(); // Prevent form submission

            // ตรวจสอบขนาดไฟล์ก่อนส่ง (ฝั่ง client)
            var fileInput = document.getElementById('image');
            if (fileInput.files.length > 0) {
                var fileSize = fileInput.files[0].size;
                if (fileSize > 2 * 1024 * 1024) { // 2 MB
                    Swal.fire({
                        text: 'ขนาดไฟล์รูปภาพต้องไม่เกิน 2 MB',
                        icon: 'error',
                        confirmButtonText: 'ตกลง',
                    });
                    return;
                }
            }

            var formData = new FormData(this); // Create FormData object for handling files
            var eventId = <?= $eventId ?>; // Get eventId dynamically from PHP

            $.ajax({
                type: 'POST',
                url: '../../service/events/update.php?id=' + eventId, // Pass the event ID dynamically
                data: formData, // Send form data (including image)
                contentType: false, // Don't set contentType explicitly, let FormData handle it
                processData: false, // Don't process the data to query string, allow FormData to handle it
                success: function(response) {
                    let res = response;
                    // แปลง response เป็น object หากเป็น string
                    if (typeof res === 'string') {
                        try {
                            res = JSON.parse(res);
                        } catch (e) {
                            Swal.fire({
                                text: 'เกิดข้อผิดพลาดในการประมวลผลข้อมูล',
                                icon: 'error',
                                confirmButtonText: 'ตกลง',
                            });
                            return;
                        }
                    }
                    if (res.status === 'success') {
                        Swal.fire({
                            text: res.message,
                            icon: 'success',
                            confirmButtonText: 'ตกลง',
                        }).then(() => {
                            location.assign('./'); // Redirect back to the events list page
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
                        text: 'เกิดข้อผิดพลาดในการอัพเดทข้อมูล',
                        icon: 'error',
                        confirmButtonText: 'ตกลง',
                    });
                }
            });
        });
    </script>

</body>

</html>