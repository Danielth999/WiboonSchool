<?php
session_start();
require_once('../authen.php');

// ตรวจสอบว่ามีการส่ง ID มาหรือไม่
if (!isset($_GET['id'])) {
    header('Location: ./');
    exit;
}

// ดึงข้อมูลวิดีโอตาม ID
$stmt = $conn->prepare("SELECT * FROM social_links WHERE id = :id");
$stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
$stmt->execute();
$video = $stmt->fetch(PDO::FETCH_ASSOC);

// ถ้าไม่พบข้อมูล ให้กลับไปหน้าหลัก
if (!$video) {
    header('Location: ./');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>แก้ไขวิดีโอ | โรงเรียนวิบูลวิทยา</title>
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
                                        <i class="fas fa-edit"></i>
                                        แก้ไขวิดีโอ
                                    </h4>
                                    <a href="./" class="btn btn-info mt-3">
                                        <i class="fas fa-list"></i>
                                        กลับหน้าหลัก
                                    </a>
                                </div>
                                <form id="formUpdate">
                                    <div class="card-body">
                                        <div class="row justify-content-center">
                                            <div class="col-xl-6 px-1 px-md-5">
                                                <input type="hidden" name="id" value="<?php echo $video['id']; ?>">
                                                <div class="form-group">
                                                    <label for="url">URL วิดีโอ</label>
                                                    <input type="text" class="form-control" name="url" id="url"
                                                        value="<?php echo htmlspecialchars($video['url']); ?>" required>
                                                    <small class="form-text text-muted">สำหรับ YouTube สามารถใส่ URL
                                                        ปกติได้เลย ระบบจะแปลงเป็น Embed ให้อัตโนมัติ</small>
                                                </div>
                                                <div class="form-group">
                                                    <label for="status">สถานะ</label>
                                                    <select class="form-control" name="status" id="status" required>
                                                        <option value="1"
                                                            <?php echo $video['status'] == '1' ? 'selected' : ''; ?>>
                                                            เผยแพร่</option>
                                                        <option value="0"
                                                            <?php echo $video['status'] == '0' ? 'selected' : ''; ?>>
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
        $('#formUpdate').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '../../service/video/update.php',
                data: $('#formUpdate').serialize()
            }).done(function(resp) {
                if (resp.status) {
                    Swal.fire({
                        text: 'อัพเดทข้อมูลเรียบร้อย',
                        icon: 'success',
                        confirmButtonText: 'ตกลง',
                    }).then((result) => {
                        location.assign('./');
                    });
                } else {
                    Swal.fire({
                        text: resp.message,
                        icon: 'error',
                        confirmButtonText: 'ตกลง',
                    });
                }
            }).fail(function(xhr, resp, text) {
                Swal.fire({
                    text: 'เกิดข้อผิดพลาด โปรดลองใหม่',
                    icon: 'error',
                    confirmButtonText: 'ตกลง',
                });
            });
        });
    });
    </script>

</body>

</html>