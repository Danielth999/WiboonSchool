<?php
session_start();
require_once('../authen.php');
include_once('../../../includes/date_helper.php');
// เชื่อมต่อฐานข้อมูลและดึงข้อมูลจากตาราง school_leader
$stmt = $conn->prepare("SELECT * FROM school_leaders ORDER BY id DESC");
$stmt->execute();
$school_leaders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>จัดการข้อมูลผู้นำโรงเรียน | School Management</title>
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
                                        <i class="fas fa-user-tie"></i>
                                        จัดการข้อมูลผู้นำโรงเรียน
                                    </h4>
                                    <a href="form-create.php" class="btn btn-primary mt-3">
                                        <i class="fas fa-plus"></i>
                                        เพิ่มข้อมูล
                                    </a>
                                </div>
                                <div class="card-body">
                                    <table id="logs" class="table table-hover" width="100%">
                                        <thead>
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>รูปภาพ</th>
                                                <th>ชื่อ</th>
                                                <th>ตำแหน่ง</th>
                                                <th>วันที่สร้าง</th>
                                                <th>เผยแพร่</th>
                                                <th>จัดการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $num = 0;
                                            foreach ($school_leaders as $row):
                                                $num++;
                                            ?>
                                            <tr>
                                                <td><?php echo $num; ?></td>
                                                <td>
                                                    <img src="../../../images/leaders/<?php echo $row['image_url']; ?>"
                                                        alt="<?php echo $row['name']; ?>" class="img-thumbnail"
                                                        width="50">
                                                </td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $row['position']; ?></td>
                                                <td><?php echo formatThaiDate($row['created_at']); ?></td>
                                                <td>
                                                    <input type="checkbox" class="toggle-publish"
                                                        data-id="<?php echo $row['id']; ?>"
                                                        <?php echo $row['status'] == 0 ? 'checked' : ''; ?>
                                                        data-toggle="toggle" data-on="เผยแพร่" data-off="ไม่เผยแพร่"
                                                        data-onstyle="success" data-offstyle="secondary">
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
    // แสดงข้อความแจ้งเตือนเมื่อมีการดำเนินการสำเร็จ
    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'success'): ?>
    Swal.fire({
        title: "สำเร็จ!",
        text: "เพิ่มข้อมูลผู้นำโรงเรียนเรียบร้อยแล้ว",
        icon: "success",
        confirmButtonText: "ตกลง"
    });
    <?php endif; ?>

    <?php if (isset($_GET['update']) && $_GET['update'] == 'success'): ?>
    Swal.fire({
        title: "สำเร็จ!",
        text: "อัพเดทข้อมูลผู้นำโรงเรียนเรียบร้อยแล้ว",
        icon: "success",
        confirmButtonText: "ตกลง"
    });
    <?php endif; ?>

    <?php if (isset($_GET['delete']) && $_GET['delete'] == 'success'): ?>
    Swal.fire({
        title: "สำเร็จ!",
        text: "ลบข้อมูลผู้นำโรงเรียนเรียบร้อยแล้ว",
        icon: "success",
        confirmButtonText: "ตกลง"
    });
    <?php endif; ?>

    // ลบ query string จาก URL หลังจากแสดง SweetAlert
    if (window.location.search) {
        history.replaceState(null, null, window.location.pathname);
    }

    $(function() {
        $('#logs').DataTable({
            initComplete: function() {
                // ลบโค้ด window.location.href ออก ไม่ต้องมีแล้ว
            },
            responsive: {
                details: {
                    renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                        tableClass: 'table'
                    })
                }
            },
            language: {
                "lengthMenu": "แสดงข้อมูล _MENU_ แถว",
                "zeroRecords": "ไม่พบข้อมูลที่ต้องการ",
                "info": "แสดงหน้า _PAGE_ จาก _PAGES_",
                "infoEmpty": "ไม่พบข้อมูลที่ต้องการ",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "search": 'ค้นหา',
                "paginate": {
                    "first": "หน้าแรก",
                    "last": "หน้าสุดท้าย",
                    "next": "ถัดไป",
                    "previous": "ก่อนหน้า"
                }
            }
        })
    })
    $(document).on('change', '.toggle-publish', function() {
        let id = $(this).data('id');
        let status = $(this).prop('checked') ? 0 : 1;
        let toggle = $(this);
        $.ajax({
            url: '../../service/school_leader/toggle_publish.php',
            method: 'POST',
            data: {
                id: id,
                status: status
            },
            success: function(res) {
                let data = JSON.parse(res);
                if (data.status === 'success') {
                    toastr.success('อัปเดตสถานะเรียบร้อยแล้ว');
                } else {
                    toastr.error(data.message || 'ไม่สามารถอัปเดตสถานะได้');
                    toggle.bootstrapToggle('toggle');
                }
            },
            error: function() {
                toastr.error('ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้');
                toggle.bootstrapToggle('toggle');
            }
        });
    });
    </script>
</body>

</html>

<script>
$(document).ready(function() {
    $(document).on('click', 'button#delete', function() {
        var id = $(this).data('id');
        Swal.fire({
            title: 'ยืนยันการลบข้อมูล?',
            text: 'คุณต้องการลบข้อมูลนี้หรือไม่?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ลบเลย!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../../service/school_leader/delete.php',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire('ลบสำเร็จ!', 'ข้อมูลถูกลบแล้ว', 'success')
                                .then(() => {
                                    location.reload();
                                });
                        } else {
                            Swal.fire('เกิดข้อผิดพลาด', response.message ||
                                'ไม่สามารถลบข้อมูลได้', 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('เกิดข้อผิดพลาด',
                            'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้', 'error');
                    }
                });
            }
        });
    });
});
</script>