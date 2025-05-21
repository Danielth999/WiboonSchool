<?php
session_start(); // ประกาศ การใช้งาน session
require_once('../authen.php');
include_once('../../../includes/date_helper.php');

// ดึงข้อมูลประกาศจากฐานข้อมูล
$sql = "SELECT id, `key`, `value`, updated_at FROM school_info ORDER BY updated_at DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$response = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>เนื้อหา | โรงเรียนวิบูลวิทยา</title>
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
                                        <i class="fas fa-users"></i>
                                        จัดการเนื้อหา
                                    </h4>
                                    <!-- <a href="form-create.php" class="btn btn-primary mt-3">
                                        <i class="fas fa-plus"></i>
                                        เพิ่มข้อมูล
                                    </a> -->
                                </div>
                                <div class="card-body">
                                    <table id="logs" class="table table-hover" width="100%">
                                        <thead>
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>ประเภท</th>
                                                <th>เนื้อหา</th>
                                                <th>อัพเดทเมื่อ</th>
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
                                                <td><?php echo htmlspecialchars($row['key']); ?></td>
                                                <td><?php echo htmlspecialchars($row['value']); ?></td>
                                                <td><?php echo formatThaiDate($row['updated_at']) ?></td>
                                                <td>
                                                    <a href="form-edit.php?id=<?php echo $row['id']; ?>"
                                                        class="btn btn-warning text-white">
                                                        <i class="far fa-edit"></i> แก้ไข
                                                    </a>
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
                                `../../service/blankpage/delete.php?id=${id}`;
                        }
                    })
                }).on('change', '.toggle-event', function() {
                    toastr.success('อัพเดทข้อมูลเสร็จเรียบร้อย')
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