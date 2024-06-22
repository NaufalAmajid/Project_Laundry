<?php
session_start();
if (isset($_SESSION['is_login'])) {
    header('Location: dashboard.php');
    exit;
}
require_once 'config/connection.php';
require_once 'classes/DB.php';
require_once 'classes/Pengaturan.php';

$set = new Pengaturan();
$set = $set->getPengaturan();
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="assets/images/logo-web.jpg" type="image/jpg" />
    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/bootstrap-extended.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href="assets/css/icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <!-- loader-->
    <link href="assets/css/pace.min.css" rel="stylesheet" />

    <!--plugins-->
    <link rel="stylesheet" href="assets/plugins/notifications/css/lobibox.min.css" />

    <title><?= ucwords($set['nama_usaha']) ?></title>
    <style>
        .logo-text {
            font-family: 'Impact';
            margin-left: -10px;
            margin-bottom: 0;
            letter-spacing: 1px;
            color: #3461ff;
        }
    </style>
</head>

<body class="bg-surface">

    <!--start wrapper-->
    <div class="wrapper">

        <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-white rounded-0 border-bottom">
                <div class="container">
                    <a class="navbar-brand" href="javascript:;"><img src="assets/images/laundry-logo.png" width="30" alt="" /></a>
                    <span class="logo-text fs-5"><?= strtoupper($set['nama_usaha']) ?></span>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                        <div class="d-flex ms-3 gap-3">
                            <a href="index.php" class="btn btn-secondary btn-sm px-4 radius-30">Login</a>
                            <a href="order-status.php" class="btn btn-light btn-sm px-4 radius-30">Status Laundry</a>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <!--start content-->
        <main class="authentication-content">
            <div class="container">
                <div class="mt-4">
                    <div class="card rounded-0 overflow-hidden shadow-none border mb-5 mb-lg-0">
                        <div class="row g-0">
                            <div class="col-12 order-1 col-xl-8 d-flex align-items-center justify-content-center border-end">
                                <img src="assets/images/login-laund.png" class="img-fluid" alt="">
                            </div>
                            <div class="col-12 col-xl-4 order-xl-2">
                                <div class="card-body p-4 p-sm-5">
                                    <h5 class="card-title">Login</h5>
                                    <p class="card-text mb-4">Silahkan login disebelah sini!</p>
                                    <form class="form-body" id="form-login">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label for="username" class="form-label">Username</label>
                                                <div class="ms-auto position-relative">
                                                    <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-envelope-fill"></i></div>
                                                    <input type="text" required class="form-control radius-30 ps-5" id="username" name="username" placeholder="Masukkan Username ..." autofocus autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <label for="inputChoosePassword" class="form-label">Password</label>
                                                <div class="ms-auto position-relative">
                                                    <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-lock-fill"></i></div>
                                                    <input type="password" required class="form-control radius-30 ps-5" id="inputChoosePassword" name="password" placeholder="Masukkan Password ...">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-primary radius-30">Login</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="col-12">
                                        <div class="login-separater text-center"> <span>Status Laundry</span>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="col-12 text-center">
                                        <p class="mb-0">Hanya Ingin Melihat Status Laundry Anda? <a href="order-status.php">Klik Disini!</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!--end page main-->

        <footer class="bg-white border-top p-3 text-center fixed-bottom">
            <p class="mb-0">Copyright &copy; <?= date('Y') ?>. All right reserved.</p>
        </footer>

    </div>
    <!--end wrapper-->


    <!-- Bootstrap bundle JS -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <!--plugins-->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/pace.min.js"></script>

    <!--notification js -->
    <script src="assets/plugins/notifications/js/lobibox.min.js"></script>
    <script src="assets/plugins/notifications/js/notifications.min.js"></script>
    <script src="assets/plugins/notifications/js/notification-custom-script.js"></script>
    <script src="assets/js/sweetalert2@11.js"></script>

    <script>
        $(document).ready(function() {
            $('#form-login').submit(function(e) {
                e.preventDefault();
                let data = $(this).serialize();
                data = data + '&action=login';
                $.ajax({
                    type: 'POST',
                    url: 'classes/Authentication.php',
                    data: data,
                    success: function(response) {
                        let res = JSON.parse(response);
                        Swal.fire({
                            icon: res.status,
                            title: res.msg,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function(e) {
                            if (e.dismiss === Swal.DismissReason.timer) {
                                if (res.status == 'success') {
                                    window.location.href = 'dashboard.php';
                                } else {
                                    location.reload();
                                }
                            }
                        });
                    }
                });
            });
        });
    </script>

</body>

</html>