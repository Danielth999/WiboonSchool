<?php
session_start();
require_once('../authen.php');
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'super admin') {
    header('Location: ./');
    exit;
}

$id = $_GET['id'] ?? null;
if ($id == null) {
    header('Location: ./');
    exit;
}

// ดึงข้อมูลผู้ใช้งานจากฐานข้อมูลตาม id
$stmt = $conn->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo '<script>alert("ไม่พบข้อมูลผู้ใช้งานที่ต้องการแก้ไข");window.location.href="./";</script>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>แก้ไขข้อมูลผู้ดูแลระบบ | โรงเรียนวิบูลวิทยา</title>
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/images/favicon.ico">
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
                                    <h4>
                                        <i class="fas fa-user-cog"></i> แก้ไขข้อมูลผู้ดูแล
                                    </h4>
                                    <a href="./" class="btn btn-info my-3">
                                        <i class="fas fa-list"></i> กลับหน้าหลัก
                                    </a>
                                </div>
                                <form id="formData">
                                    <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 px-1 px-md-5">
                                                <div class="form-group">
                                                    <label>ชื่อผู้ใช้งาน</label>
                                                    <input type="text" class="form-control" name="username"
                                                        value="<?= htmlspecialchars($user['username']) ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>รหัสผ่านใหม่ (หากต้องการเปลี่ยน)</label>
                                                    <input type="password" class="form-control" name="new_password"
                                                        placeholder="********">
                                                </div>
                                            </div>
                                            <div class="col-md-6 px-1 px-md-5">
                                                <div class="form-group">
                                                    <label>สิทธิ์การใช้งาน</label>
                                                    <select class="form-control" name="role" required>
                                                        <option value disabled>กำหนดสิทธิ์</option>
                                                        <option value="super admin"
                                                            <?= $user['role'] == 'super admin' ? 'selected' : '' ?>>
                                                            Super Admin</option>
                                                        <option value="admin"
                                                            <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin
                                                        </option>
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

    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="../../assets/js/adminlte.min.js"></script>

    <script>
        $(function() {
            $('#formData').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: '../../service/manager/update.php',
                    data: $('#formData').serialize(),
                    dataType: 'json'
                }).done(function(res) {
                    if (res.status === 'success') {
                        Swal.fire({
                            title: 'สำเร็จ!',
                            text: res.message,
                            icon: 'success',
                            confirmButtonText: 'ตกลง'
                        }).then(() => {
                            location.assign('./');
                        });
                    } else {
                        Swal.fire({
                            title: 'ผิดพลาด!',
                            text: res.message,
                            icon: 'error',
                            confirmButtonText: 'ตกลง'
                        });
                    }
                }).fail(function() {
                    Swal.fire({
                        title: 'เกิดข้อผิดพลาด!',
                        text: 'ไม่สามารถส่งข้อมูลไปยังเซิร์ฟเวอร์ได้',
                        icon: 'error',
                        confirmButtonText: 'ตกลง'
                    });
                });
            });
        });
    </script>


</body>

</html>