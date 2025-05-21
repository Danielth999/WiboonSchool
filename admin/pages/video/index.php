<?php
session_start(); // ประกาศ การใช้งาน session
require_once('../authen.php');
include_once('../../../includes/date_helper.php');

// ดึงข้อมูลจากตาราง social_links
$sql = "SELECT id, url, created_at, status FROM social_links ORDER BY created_at ASC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$response = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>จัดการวิดิโอ | โรงเรียนวิบูลวิทยา</title>
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
    <!-- Facebook SDK -->
    <div id="fb-root"></div>
    <script async defer src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.2"></script>

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
                                        <i class="fas fa-video"></i>
                                        จัดการวิดิโอ
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
                                                <th>วิดีโอ</th>
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
                                                    <div class="video-wrapper"
                                                        style="position:relative;width:200px;height:120px;">
                                                        <div class="fb-loading"
                                                            style="position:absolute;top:0;left:0;width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:rgba(255,255,255,0.7);z-index:2;">
                                                            <div class="spinner-border text-primary" role="status"
                                                                style="width:2rem;height:2rem;">
                                                                <span class="sr-only">Loading...</span>
                                                            </div>
                                                        </div>
                                                        <div class="fb-video" data-href="<?php echo $row['url']; ?>"
                                                            data-width="200" data-show-text="false"></div>
                                                    </div>
                                                </td>
                                                <td><?php echo formatThaiDate($row['created_at']) ?></td>
                                                <td>
                                                    <input class="toggle-event" data-id="<?php echo $row['id']; ?>"
                                                        type="checkbox" name="status"
                                                        <?php echo $row['status'] == '1' ? 'checked' : ''; ?>
                                                        data-toggle="toggle" data-on="เผยแพร่" data-off="ไม่เผยแพร่"
                                                        data-onstyle="success" data-style="ios">
                                                </td>
                                                <td>
                                                    <a href="form-edit.php?id=<?php echo $row['id']; ?>"
                                                        class="btn btn-warning text-white">
                                                        <i class="far fa-edit"></i> แก้ไข
                                                    </a>
                                                    <button type="button" class="btn btn-danger delete-btn"
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
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "language": {
                "lengthMenu": "แสดงข้อมูล _MENU_ แถว",
                "zeroRecords": "ไม่พบข้อมูลที่ต้องการ",
                "info": "แสดงหน้า _PAGE_ จาก _PAGES_",
                "infoEmpty": "ไม่พบข้อมูลที่ต้องการ",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "search": 'ค้นหา'
            },
            "fnDrawCallback": function() {
                $('.toggle-event').bootstrapToggle();

                // Parse Facebook embeds after table draw
                if (window.FB && window.FB.XFBML) {
                    window.FB.XFBML.parse();
                }
            }
        });

        // ลบข้อมูล
        // ลบข้อมูล
        $(document).on('click', '.delete-btn', function() {
            let id = $(this).data('id');
            Swal.fire({
                text: "คุณแน่ใจหรือไม่...ที่จะลบรายการนี้?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ใช่! ลบเลย',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    // แสดง loading
                    Swal.fire({
                        title: 'กำลังดำเนินการ...',
                        text: 'กรุณารอสักครู่',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        type: 'POST',
                        url: '../../service/video/delete.php',
                        data: {
                            id: id
                        },
                        dataType: 'json'
                    }).done(function(resp) {
                        if (resp.status) {
                            Swal.fire({
                                text: 'ลบข้อมูลเรียบร้อย',
                                icon: 'success',
                                confirmButtonText: 'ตกลง',
                            }).then((result) => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                text: resp.message ||
                                    'เกิดข้อผิดพลาดในการลบข้อมูล',
                                icon: 'error',
                                confirmButtonText: 'ตกลง',
                            });
                        }
                    }).fail(function(xhr, resp, text) {
                        console.error('AJAX Error:', xhr, resp, text);
                        Swal.fire({
                            text: 'เกิดข้อผิดพลาดในการเชื่อมต่อ โปรดลองใหม่',
                            icon: 'error',
                            confirmButtonText: 'ตกลง',
                        });
                    });
                }
            });
        });

        // Toggle สถานะ
        $(document).on('change', '.toggle-event', function() {
            let id = $(this).data('id');
            let status = $(this).prop('checked') ? 1 : 0;

            $.ajax({
                type: 'POST',
                url: '../../service/video/toggle_status.php',
                data: {
                    id: id,
                    status: status
                }
            }).done(function(resp) {
                if (resp.status) {
                    toastr.success('อัพเดทสถานะเรียบร้อย');
                } else {
                    toastr.error(resp.message);
                    // กรณีเกิดข้อผิดพลาด ให้กลับสถานะเดิม
                    $('.toggle-event[data-id="' + id + '"]').bootstrapToggle(status ? 'off' :
                        'on');
                }
            }).fail(function(xhr, resp, text) {
                toastr.error('เกิดข้อผิดพลาด โปรดลองใหม่');
                // กรณีเกิดข้อผิดพลาด ให้กลับสถานะเดิม
                $('.toggle-event[data-id="' + id + '"]').bootstrapToggle(status ? 'off' : 'on');
            });
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        // รอให้ Facebook SDK โหลดเสร็จ
        if (window.FB) {
            window.FB.Event.subscribe('xfbml.render', function() {
                document.querySelectorAll('.fb-loading').forEach(function(el) {
                    el.style.display = 'none';
                });
            });
        }
    });
    </script>
</body>

</html>