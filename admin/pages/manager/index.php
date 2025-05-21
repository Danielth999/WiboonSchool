<?php
    session_start();
    require_once('../authen.php');
    include_once('../../../includes/date_helper.php');
    $sql = "SELECT * FROM users ";
    $stmt = $conn->query($sql);
    $response = $stmt->fetchAll(PDO::FETCH_ASSOC);

    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>จัดการผู้ดูแลระบบ | โรงเรียนวิบูลวิทยา</title>
        <link rel="shortcut icon" type="image/x-icon" href="../../assets/images/favicon.ico">
        <!-- stylesheet -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
        <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
        <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
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
                                            <i class="fas fa-user-cog"></i>
                                            ผู้ดูแลระบบ
                                        </h4>
                                        <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'super admin'): ?>
                                            <a href="form-create.php" class="btn btn-primary mt-3">
                                                <i class="fas fa-plus"></i>
                                                เพิ่มข้อมูล
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                    <div class="card-body">
                                        <table id="logs" class="table table-hover " width="100%">
                                            <thead>
                                                <tr>
                                                    <th>ลำดับ</th>
                                                    <th>ชื่อผู้ใช้งาน</th>
                                                    <th>รหัสผ่าน</th>
                                                    <th>สิทธิ์เข้าใช้งาน</th>
                                                    <th>สร้างเมื่อ</th>
                                                    <th>การเปลี่ยนแปลง</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $num = 0;
                                                foreach ($response as $row) {
                                                    $num++;
                                                    echo "<tr>";
                                                    echo "<td>{$num}</td>";
                                                    echo "<td>{$row['username']}</td>";

                                                    if ($_SESSION['user']['role'] === 'super admin') {
                                                        echo "<td>
            <span class='password-mask' id='mask_{$row['id']}'>******</span>
            <span class='password-real d-none' id='real_{$row['id']}'>{$row['password']}</span>
            <button type='button' class='btn btn-sm btn-secondary ml-2 toggle-password' data-id='{$row['id']}'>
                แสดง
            </button>
        </td>";
                                                    } else {
                                                        echo "<td>******</td>";
                                                    }

                                                    if ($row['role'] === 'super admin') {
                                                        echo "<td><span class='badge badge-success'>{$row['role']}</span></td>";
                                                    } else if ($row['role'] === 'admin') {
                                                        echo "<td><span class='badge badge-secondary'>{$row['role']}</span></td>";
                                                    } else {
                                                        echo "<td><span class='badge badge-info'>{$row['role']}</span></td>";
                                                    }

                                                    echo "<td>" . (function_exists('formatThaiDate') ? formatThaiDate($row['created_at']) : $row['created_at']) . "</td>";

                                                    // 🔥 เงื่อนไขการแสดงปุ่ม: เฉพาะ super admin เท่านั้น
                                                    if ($_SESSION['user']['role'] === 'super admin') {
                                                        echo "<td>
            <a href='form-edit.php?id={$row['id']}' class='btn btn-warning text-white'>
                <i class='far fa-edit'></i> แก้ไข
            </a>
            <button type='button' class='btn btn-danger' id='delete' data-id='{$row['id']}'>
                <i class='far fa-trash-alt'></i> ลบ
            </button>
        </td>";
                                                    } else {
                                                        echo "<td>ไม่มีสิทธิ์</td>";
                                                    }

                                                    echo "</tr>";
                                                }
                                                ?>
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
            $(document).on('click', '.toggle-password', function() {
                var id = $(this).data('id');
                var mask = $('#mask_' + id);
                var real = $('#real_' + id);
                var button = $(this);

                if (mask.hasClass('d-none')) {
                    // ตอนนี้เห็นรหัสผ่านจริงอยู่ ➔ ปิด
                    mask.removeClass('d-none');
                    real.addClass('d-none');
                    button.text('แสดง');
                } else {
                    // ตอนนี้เห็น ****** ➔ เปิด
                    mask.addClass('d-none');
                    real.removeClass('d-none');
                    button.text('ซ่อน');
                }
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
                            type: 'POST',
                            url: `../../service/manager/delete.php`,
                            data: {
                                id: id
                            },
                            success: function(response) {
                                let res = response;
                                if (typeof res === "string") res = JSON.parse(
                                    res); // กันไว้ถ้า response เป็น string

                                if (res.status === 'success') {
                                    Swal.fire({
                                        text: res.message,
                                        icon: 'success',
                                        confirmButtonText: 'ตกลง',
                                    }).then(() => {
                                        location.reload(); // รีโหลดตารางหลังลบเสร็จ
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

    </body>

    </html>