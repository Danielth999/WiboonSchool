<?php
session_start(); // ประกาศ การใช้งาน session
require_once('../authen.php');
include_once('../../../includes/date_helper.php');

// ดึงข้อมูลกิจกรรมทั้งหมด - นำมาจากไฟล์ที่สอง
$stmt = $conn->prepare("SELECT d.id AS doc_id, c.id AS cat_id, d.*, c.* FROM documents d JOIN categories c ON d.category_id = c.id ORDER BY upload_date DESC");
$stmt->execute();
$response = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>จัดการเอกสาร | โรงเรียนวิบูลวิทยา</title>
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
                                        <i class="fas fa-print"></i>
                                        จัดการเอกสาร
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
                                                <th>ชื่อเอกสาร</th>
                                                <th>ชื่อไฟล์</th>
                                                <th>หมวดหมู่</th>
                                                <th>แสดง</th>
                                                <th>วันที่สร้าง</th>
                                                <th>เผยแพร่</th>
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
                                                <td><?php echo $row['title']; ?></td>
                                                <td><?php echo $row['filename']; ?></td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td>
                                                    <a href="../../document/<?php echo $row['code']; ?>/<?= $row['filename'] ?>"
                                                        target="_blank" rel="noopener noreferrer">
                                                        เปิด</a>
                                                </td>
                                                <td><?php echo formatThaiDate($row['upload_date']) ?></td>
                                                <td>
                                                    <input class="toggle-event" data-id="<?= $row['doc_id'] ?>"
                                                        type="checkbox" name="status"
                                                        <?php echo $row['status'] == 1 ? 'checked' : ''; ?>
                                                        data-toggle="toggle" data-on="เผยแพร่" data-off="ไม่เผยแพร่"
                                                        data-onstyle="success" data-style="ios">
                                                </td>
                                                <td>
                                                    <a href="form-edit.php?id=<?php echo $row['doc_id']; ?>"
                                                        type="button" class="btn btn-warning text-white">
                                                        <i class="far fa-edit"></i> แก้ไข
                                                    </a>
                                                    <button type="button" class="btn btn-danger" id="delete"
                                                        data-id="<?php echo $row['doc_id']; ?>">
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
    $(function() {
        $('#logs').DataTable({
            initComplete: function() {
                $(document).on('click', '#delete', function() {
                    let id = $(this).data('id')
                    Swal.fire({
                        text: "คุณแน่ใจหรือไม่...ที่จะลบรายการนี้?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'ใช่! ลบเลย',
                        cancelButtonText: 'ยกเลิก'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href =
                                `../../service/document/delete.php?id=${id}`;
                        }
                    })
                }).on('change', '.toggle-event', function() {
                    let id = $(this).data('id');
                    let status = $(this).prop('checked') ? 1 : 0;
                    $.ajax({
                        url: '../../service/document/toggle_status.php',
                        method: 'POST',
                        data: {
                            id: id,
                            status: status
                        },
                        success: function(response) {
                            toastr.success('อัพเดทสถานะเสร็จเรียบร้อย');
                        },
                        error: function() {
                            toastr.error('เกิดข้อผิดพลาดในการอัพเดทสถานะ');
                        }
                    });
                })
            },
            fnDrawCallback: function() {
                $('.toggle-event').bootstrapToggle();
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
                "search": 'ค้นหา'
            }
        })
    })
    </script>
</body>

</html>