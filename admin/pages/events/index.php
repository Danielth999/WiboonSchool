<?php
session_start();
require_once('../authen.php');
include_once('../../../includes/date_helper.php');
// ดึงข้อมูลกิจกรรมทั้งหมด - นำมาจากไฟล์ที่สอง
$stmt = $conn->prepare("SELECT * FROM events ORDER BY created_at DESC");
$stmt->execute();
$response = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <link rel="stylesheet" href="../../plugins/bootstrap-toggle/bootstrap-toggle.min.css">
    <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <!-- Datatables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <style>
        .event-desc-ellipsis {
            max-width: 220px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            /* เพิ่ม property มาตรฐาน */
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: normal;
        }
    </style>
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
                                        จัดการกิจกรรม
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
                                                <th>ภาพ</th>
                                                <th>หัวข้อ</th>
                                                <th>รายละเอียด</th>
                                                <th>ลิงก์</th>
                                                <th>วันที่สร้าง</th>
                                                <th>สถานะ</th>
                                                <th>จัดการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $num = 0;
                                            foreach ($response as $row):
                                                $num++;
                                            ?>
                                                <tr>
                                                    <td><?php echo $num; ?></td>
                                                    <td>
                                                        <?php if (!empty($row['image'])): ?>
                                                            <img src="../../../images/events/<?= htmlspecialchars($row['image']) ?>"
                                                                alt="รูปกิจกรรม"
                                                                style="max-width: 100px; max-height: 70px; border-radius: 8px; object-fit: cover;">
                                                        <?php else: ?>
                                                            <span class="badge badge-light text-muted">ไม่มีรูป</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-left"><?= htmlspecialchars($row['title']) ?></td>
                                                    <td class="text-left event-desc-ellipsis">
                                                        <?= nl2br(htmlspecialchars($row['description'])) ?></td>
                                                    <td>
                                                        <?php if (!empty($row['link'])): ?>
                                                            <a href="<?= htmlspecialchars($row['link']) ?>"
                                                                class="btn btn-sm btn-outline-primary" target="_blank">
                                                                ดูเพิ่มเติม
                                                            </a>
                                                        <?php else: ?>
                                                            <span class="badge badge-light text-muted">ไม่มีลิงก์</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?php echo formatThaiDate($row['created_at']) ?></td>
                                                    <td>
                                                        <input class="toggle-event" data-id="<?= $row['id'] ?>"
                                                            type="checkbox" <?= $row['status'] == '1' ? 'checked' : '' ?>
                                                            data-toggle="toggle" data-on="เผยแพร่" data-off="ไม่เผยแพร่"
                                                            data-onstyle="success" data-offstyle="danger" data-style="ios">
                                                    </td>
                                                    <td>
                                                        <a href="form-edit.php?id=<?php echo $row['id']; ?>"
                                                            class="btn btn-warning text-white mb-1">
                                                            <i class="far fa-edit"></i> แก้ไข
                                                        </a>
                                                        <button type="button" class="btn btn-danger delete-btn mt-1"
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
        $(function() {
            $('#logs').DataTable({
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
                    "search": 'ค้นหา'
                },
                fnDrawCallback: function() {
                    $('.toggle-event').bootstrapToggle();
                }
            });

            // จัดการการลบข้อมูล
            $(document).on('click', '.delete-btn', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: "ยืนยันการลบ",
                    text: "คุณต้องการลบข้อมูลนี้ใช่ไหม?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "ใช่, ลบเลย!",
                    cancelButtonText: "ยกเลิก"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: '../../service/events/delete.php',
                            data: {
                                id: id
                            },
                            success: function(response) {
                                let res;
                                try {
                                    res = typeof response === "string" ? JSON.parse(
                                        response) : response;
                                } catch (e) {
                                    console.error("Failed to parse JSON", e);
                                    return;
                                }

                                if (res.status === 'success') {
                                    Swal.fire({
                                        text: res.message,
                                        icon: 'success',
                                        confirmButtonText: 'ตกลง',
                                    }).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        text: res.message,
                                        icon: 'error',
                                        confirmButtonText: 'ตกลง'
                                    });
                                }
                            },
                            error: function() {
                                Swal.fire({
                                    text: 'เกิดข้อผิดพลาดในการส่งข้อมูล',
                                    icon: 'error',
                                    confirmButtonText: 'ตกลง'
                                });
                            }
                        });
                    }
                });
            });

            // จัดการการเปลี่ยนสถานะ
            $(document).on('change', '.toggle-event', function() {
                let id = $(this).data('id');
                let status = $(this).prop('checked') ? 1 : 0;
                $.post('../../service/events/update_status.php', {
                    id: id,
                    status: status
                }, function(response) {
                    let res = typeof response === "string" ? JSON.parse(response) : response;
                    if (res.status === 'success') {
                        toastr.success('อัพเดทสถานะเรียบร้อย');
                    } else {
                        toastr.error('อัพเดทสถานะไม่สำเร็จ');
                    }
                }).fail(function() {
                    toastr.error('เกิดข้อผิดพลาดในการอัพเดทสถานะ');
                });
            });
        });
    </script>

    <script>
        $(document).on('click', '.event-desc-ellipsis', function() {
            $(this).toggleClass('expanded');
            if ($(this).hasClass('expanded')) {
                $(this).css({
                    '-webkit-line-clamp': 'unset',
                    'overflow': 'visible'
                });
            } else {
                $(this).css({
                    '-webkit-line-clamp': '2',
                    'overflow': 'hidden'
                });
            }
        });
    </script>
</body>

</html>