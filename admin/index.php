<?php
session_start();
if (isset($_SESSION['is_login'])) {
    header('Location: dashboard.php');
    exit;
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
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

    <title>Laundry</title>
</head>

<body>

    <!--start wrapper-->
    <div class="wrapper">

        <!--start content-->
        <main class="authentication-content">
            <div class="container-fluid">
                <div class="authentication-card">
                    <div class="card shadow rounded-0 overflow-hidden">
                        <div class="row g-0">
                            <div class="col-lg-6 bg-login d-flex align-items-center justify-content-center">
                                <img src="assets/images/login-img.png" class="img-fluid" alt="">
                            </div>
                            <div class="col-lg-6">
                                <div class="card-body p-4 p-sm-5">
                                    <h5 class="card-title">Login</h5>
                                    <p class="card-text mb-4">Silahkan login disebelah sini!</p>
                                    <form class="form-body" id="form-login">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label for="username" class="form-label">Username</label>
                                                <div class="ms-auto position-relative">
                                                    <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-envelope-fill"></i></div>
                                                    <input type="text" required class="form-control radius-30 ps-5" id="username" name="username" placeholder="Masukkan Username ..." autofocus>
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
                                                    <button type="submit" class="btn btn-primary radius-30">Sign In</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!--end page main-->

    </div>
    <!--end wrapper-->


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