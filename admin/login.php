<?php
session_start();
if (isset($_SESSION['user']['role'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>Admin - โรงเรียนวิบูลวิทยา</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Custom Style -->
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
    body {
        background: linear-gradient(135deg, #f8fafc 0%, #e0e7ef 100%);
        font-family: 'Kanit', sans-serif;
    }

    .login-card {
        border-radius: 1.5rem;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
        background: #fff;
    }

    .login-title {
        color: #d7263d;
        font-weight: bold;
        letter-spacing: 1px;
    }

    .show-password-btn {
        background: none;
        border: none;
        outline: none;
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #888;
        cursor: pointer;
    }

    .login-bg {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    </style>
</head>

<body>
    <div class="login-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="login-card p-4 p-md-5">
                        <div class="text-center mb-4">
                            <img src="../images/logo_school.png" alt="logo" style="width:60px;">
                            <h2 class="login-title mt-2 mb-1">โรงเรียนวิบูลวิทยา</h2>
                            <div class="text-secondary mb-2">เข้าสู่ระบบหลังบ้าน</div>
                        </div>
                        <form id="formLogin" method="POST" action="service/auth/login.php" autocomplete="off">
                            <div class="form-group position-relative">
                                <label for="username">ชื่อผู้ใช้งาน</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="username" id="username"
                                        placeholder="ชื่อผู้ใช้งาน" required autofocus>
                                </div>
                            </div>
                            <div class="form-group position-relative">
                                <label for="password">รหัสผ่าน</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input type="password" class="form-control" name="password" id="password"
                                        placeholder="รหัสผ่าน" required>
                                    <button type="button" class="show-password-btn" tabindex="-1"
                                        onclick="togglePassword()">
                                        <i class="fa fa-eye" id="togglePasswordIcon"></i>
                                    </button>
                                </div>
                            </div>
                            <button type="submit"
                                class="btn btn-danger btn-block mt-3 font-weight-bold">เข้าสู่ระบบ</button>
                        </form>
                    </div>
                    <div class="text-center text-muted mt-4" style="font-size:0.95rem;">
                        &copy; <?= date('Y') ?> โรงเรียนวิบูลวิทยา
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const icon = document.getElementById('togglePasswordIcon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
    </script>
</body>

</html>