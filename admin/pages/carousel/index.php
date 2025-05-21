<?php
session_start();
require_once('../authen.php');
include_once('../../../includes/date_helper.php');
$sql = "SELECT * FROM carousel ORDER BY upload_date DESC";;
$stmt = $conn->query($sql);
$response = $stmt->fetchAll(PDO::FETCH_ASSOC);
/** ตัวอย่างข้อมูลที่หน้านี้จะนำไปใช้งาน */

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>จัดการสไลด์โชว์ | โรงเรียนวิบูลวิทยา</title>
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/images/favicon.ico">
    <!-- stylesheet -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="../../plugins/bootstrap-toggle/bootstrap-toggle.min.css">
    <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <!-- Datatables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <script>
    // ป้องกันการกดปุ่มย้อนกลับบนเบราว์เซอร์
    window.history.pushState(null, null, window.location.href);
    window.onpopstate = function(event) {
        history.go(1);
    };
    </script>
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
                                        จัดการสไลด์โชว์
                                    </h4>
                                    <a href=" form-create.php" class="btn btn-primary mt-3">
                                        <i class="fas fa-plus"></i>
                                        เพิ่มสไลด์โชว์
                                    </a>
                                    <p class="text-secondary">
                                        <span class="text-danger">คำแนะนำสำหรับขนาดรูปภาพ :</span>

                                        - ขนาดที่แนะนำ: 1920 x 640 พิกเซล (อัตราส่วน 3:1)
                                        <br>
                                        - ความละเอียดขั้นต่ำ: 1280 x 427 พิกเซล หรือมากกว่า
                                        <br>
                                        - รูปแบบไฟล์: JPG PNG หรือ WebP (แนะนำ WebP เพื่อการโหลดในหน้าเว็บที่เร็วขึ้น)
                                        <br>
                                        - ขนาดไฟล์: ไม่เกิน 300KB เพื่อการโหลดที่เร็ว
                                        <br>
                                        <span class="text-danger"> หมายเหตุ:</span>
                                        ระบบจะปรับขนาดรูปภาพให้พอดีกับพื้นที่แสดงผลโดยอัตโนมัติ
                                        แต่การใช้รูปภาพที่มีอัตราส่วนใกล้เคียง 3:1 จะให้ผลลัพธ์ที่ดีที่สุด
                                        และเผยแพร่ได้ไม่เกิน 4 ภาพ
                                    </p>
                                </div>
                                <div class="card-body">
                                    <table id="logs" class="table table-hover" width="100%">
                                        <thead>
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>รูปภาพ</th>
                                                <th>วันที่สร้าง</th>
                                                <th>เผยแพร่</th>
                                                <th>จัดการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // fetch data from database

                                            $num = 0;
                                            foreach ($response as $row):
                                                $num++;
                                            ?>
                                            <tr>
                                                <td><?php echo $num; ?></td>
                                                <td>
                                                    <img src="../../../images/slide/<?php echo $row['image']; ?>"
                                                        alt="<?php echo $row['image']; ?>" class="img-thumbnail"
                                                        style="max-width: 150px; max-height: 100px;">
                                                    <button type="button"
                                                        class="btn btn-info btn-sm mt-2 view-image-btn"
                                                        data-toggle="modal" data-target="#imageModal"
                                                        data-img="../../../images/slide/<?php echo $row['image']; ?>"
                                                        data-title="<?php echo htmlspecialchars($row['image']); ?>">
                                                        <i class="fas fa-eye"></i> ดูรูปภาพ
                                                    </button>
                                                </td>
                                                <td><?php echo formatThaiDate($row['upload_date']) ?></td>

                                                <td>
                                                    <input class="toggle-event" data-id="<?php echo $row['id']; ?>"
                                                        type="checkbox" name="status"
                                                        <?php echo $row['status'] == 1 ? 'checked' : ''; ?>
                                                        data-toggle="toggle" data-on="สาธารณะ" data-off="ไม่สาธารณะ"
                                                        data-onstyle="success" data-offstyle="danger" data-style="ios">
                                                </td>
                                                <td>
                                                    <a href="form-edit.php?id=<?php echo $row['id']; ?>" type="button"
                                                        class="btn btn-warning text-white">
                                                        <i class="far fa-edit"></i> แก้ไข
                                                    </a>
                                                    <button type="button" class="btn btn-danger" id="delete"
                                                        data-id="<?php echo $row['id']; ?>">
                                                        <i class="far fa-trash-alt"></i> ลบ
                                                    </button>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once('../includes/footer.php') ?>
    </div>

    <!-- scripts -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="../../assets/js/adminlte.min.js"></script>
    <script src="../../plugins/bootstrap-toggle/bootstrap-toggle.min.js"></script>
    <script src="../../plugins/toastr/toastr.min.js"></script>

    <!-- datatables -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

    <script>
    // แสดงผลการทำงานสำเร็จด้วย sweet alert
    if (window.location.search.includes('?delete=success')) {
        Swal.fire("รายการของคุณถูกลบเรียบร้อย", "", "success");
        history.replaceState(null, null, window.location.pathname);
    }
    $(document).on('change', '.toggle-event', function() {
        let id = $(this).data('id');
        let status = $(this).prop('checked') ? 1 : 0;

        $.ajax({
            url: `../../service/carousel/update.php?id=${id}`, // หน้า PHP สำหรับอัพเดทสถานะ
            type: 'POST',
            data: {
                id: id,
                status: status
            },
            success: function(response) {
                toastr.success('อัพเดทสถานะเรียบร้อย');
            },
            error: function() {
                toastr.error('เกิดข้อผิดพลาดในการอัพเดทสถานะ');
            }
        });
    });

    $(document).on('click', '#delete', function() {
        let id = $(this).data('id');
        Swal.fire({
            text: "คุณแน่ใจหรือไม่...ที่จะลบรายการนี้?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ใช่! ลบเลย',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `../../service/carousel/delete.php`, // ส่งข้อมูลไปยังหน้า delete.php
                    type: 'POST',
                    data: {
                        id: id
                    }, // ส่ง id ของสไลด์โชว์ที่ต้องการลบ
                    success: function(response) {
                        let res = JSON.parse(response);
                        if (res.status === 'success') {
                            Swal.fire({
                                text: res.message,
                                icon: 'success',
                                confirmButtonText: 'ตกลง',
                            }).then(() => {
                                location
                                    .reload(); // รีเฟรชหน้าใหม่เพื่ออัพเดทข้อมูล
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
                            text: 'เกิดข้อผิดพลาดในการลบข้อมูล',
                            icon: 'error',
                            confirmButtonText: 'ตกลง',
                        });
                    }
                });
            }
        })
    });
    </script>

    <!-- Modal สำหรับดูรูปภาพ -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">ดูรูปภาพ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="carousel"
                        style="max-width:100%; max-height:70vh; border-radius:12px; box-shadow:0 4px 24px rgba(0,0,0,0.15);">
                </div>
            </div>
        </div>
    </div>
    <!-- scripts -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
    // Script สำหรับแสดงรูปใน Modal
    $(document).on('click', '.view-image-btn', function() {
        var imgSrc = $(this).data('img');
        var title = $(this).data('title');
        $('#modalImage').attr('src', imgSrc);
        $('#imageModalLabel').text(title);
    });
    </script>
</body>

</html>