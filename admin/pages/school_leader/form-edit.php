<?php
session_start();
require_once('../authen.php');

// ตรวจสอบว่ามีการส่ง ID มาหรือไม่
if (!isset($_GET['id'])) {
    echo '<script>window.location.href = "./index.php";</script>';
    exit;
}

// ดึงข้อมูลผู้นำโรงเรียนตาม ID
$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM school_leaders WHERE id = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$leader = $stmt->fetch(PDO::FETCH_ASSOC);

// ถ้าไม่พบข้อมูล ให้กลับไปหน้าหลัก
if (!$leader) {
    echo '<script>window.location.href = "./index.php";</script>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>แก้ไขข้อมูลผู้นำโรงเรียน | School Management</title>
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
                                        <i class="fas fa-user-edit"></i>
                                        แก้ไขข้อมูลผู้นำโรงเรียน
                                    </h4>
                                    <a href="./" class="btn btn-info mt-3">
                                        <i class="fas fa-list"></i>
                                        กลับหน้าหลัก
                                    </a>
                                </div>
                                <form id="formData" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="row justify-content-center">
                                            <div class="col-xl-6 px-1 px-md-5">
                                                <input type="hidden" name="id" value="<?php echo $leader['id']; ?>">
                                                <input type="hidden" name="old_image"
                                                    value="<?php echo $leader['image_url']; ?>">

                                                <div class="form-group">
                                                    <label for="name">ชื่อ</label>
                                                    <input type="text" class="form-control" name="name" id="name"
                                                        placeholder="ชื่อ" value="<?php echo $leader['name']; ?>"
                                                        required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="position">ตำแหน่ง</label>
                                                    <input type="text" class="form-control" name="position"
                                                        id="position" placeholder="ตำแหน่ง"
                                                        value="<?php echo $leader['position']; ?>" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="image">รูปภาพ (ไม่เกิน 2MB)</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="image"
                                                            name="image" accept="image/*">
                                                        <label class="custom-file-label"
                                                            for="image">เลือกไฟล์รูปภาพ</label>
                                                    </div>
                                                    <small class="form-text text-muted">รองรับไฟล์ภาพ JPG, JPEG, PNG
                                                        ขนาดไม่เกิน 2MB</small>
                                                </div>

                                                <?php if (!empty($leader['image_url'])): ?>
                                                <div class="form-group">
                                                    <label>รูปภาพปัจจุบัน</label>
                                                    <div>
                                                        <img src="../../../images/leaders/<?php echo $leader['image_url']; ?>"
                                                            alt="<?php echo $leader['name']; ?>" class="img-thumbnail"
                                                            width="150">
                                                    </div>
                                                    <small class="form-text text-muted">หากต้องการเปลี่ยนรูปภาพ
                                                        ให้อัพโหลดรูปภาพใหม่</small>
                                                </div>
                                                <?php endif; ?>

                                                <!-- แสดงตัวอย่างรูปภาพที่เลือก -->
                                                <div class="form-group" id="imagePreviewContainer"
                                                    style="display: none;">
                                                    <label>ตัวอย่างรูปภาพใหม่</label>
                                                    <div>
                                                        <img id="imagePreview" src="#" alt="ตัวอย่างรูปภาพ"
                                                            class="img-thumbnail" width="150">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="status">สถานะการเผยแพร่</label>
                                                    <select class="form-control" name="status" id="status">
                                                        <option value="0"
                                                            <?php if ($leader['status'] == 0) echo 'selected'; ?>>
                                                            สาธารณะ</option>
                                                        <option value="1"
                                                            <?php if ($leader['status'] == 1) echo 'selected'; ?>>
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
        // แสดงชื่อไฟล์ที่เลือกในช่อง input file
        $('.custom-file-input').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);

            // ตรวจสอบขนาดไฟล์
            if (this.files[0].size > 2097152) { // 2MB = 2097152 bytes
                Swal.fire({
                    title: "ขนาดไฟล์เกินกำหนด!",
                    text: "กรุณาเลือกไฟล์ขนาดไม่เกิน 2MB",
                    icon: "error",
                    confirmButtonText: "ตกลง"
                });
                $(this).val(''); // ล้างค่า input file
                $(this).next('.custom-file-label').html('เลือกไฟล์รูปภาพ');
                $('#imagePreviewContainer').hide();
                return;
            }

            // แสดงตัวอย่างรูปภาพ
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').attr('src', e.target.result);
                    $('#imagePreviewContainer').show();
                }
                reader.readAsDataURL(this.files[0]);
            }
        });

        // ส่งฟอร์มด้วย AJAX
        $('#formData').on('submit', function(e) {
            e.preventDefault();

            // ใช้ FormData เพื่อส่งไฟล์
            var formData = new FormData(this);

            // แสดง loading
            Swal.fire({
                title: 'กำลังบันทึกข้อมูล...',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                type: 'POST',
                url: '../../service/school_leader/update.php',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    try {
                        const res = JSON.parse(response);
                        if (res.status === 'success') {
                            Swal.fire({
                                title: "สำเร็จ!",
                                text: res.message,
                                icon: "success",
                                confirmButtonText: "ตกลง"
                            }).then((result) => {
                                location.href = './index.php?update=success';
                            });
                        } else {
                            Swal.fire({
                                title: "เกิดข้อผิดพลาด!",
                                text: res.message,
                                icon: "error",
                                confirmButtonText: "ตกลง"
                            });
                        }
                    } catch (e) {
                        Swal.fire({
                            title: "เกิดข้อผิดพลาด!",
                            text: "ไม่สามารถประมวลผลข้อมูลได้",
                            icon: "error",
                            confirmButtonText: "ตกลง"
                        });
                        console.error(e, response);
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: "เกิดข้อผิดพลาด!",
                        text: "ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้",
                        icon: "error",
                        confirmButtonText: "ตกลง"
                    });
                    console.error(xhr, status, error);
                }
            });
        });
    });
    </script>

</body>

</html>