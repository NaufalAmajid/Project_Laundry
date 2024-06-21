<?php
session_start();
if (!isset($_SESSION['is_login'])) {
    header('Location: ../admin/');
    exit;
}

date_default_timezone_set('Asia/Jakarta');

require_once 'config/connection.php';
require_once 'config/functions.php';
require_once 'classes/DB.php';
require_once 'classes/Menu.php';
require_once 'classes/Pengaturan.php';

$func = new Functions();
$set = new Pengaturan();
$set = $set->getPengaturan();
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
    <!--plugins-->
    <link href="assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
    <link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/plugins/notifications/css/lobibox.min.css" />
    <link href="assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
    <link href="assets/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/bootstrap-extended.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href="assets/css/icons.css" rel="stylesheet">
    <link href="assets/css/fonts-google.css" rel="stylesheet">
    <!-- <link href="assets/css/bootstrap-icons.css" rel="stylesheet"> -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css"> -->

    <!-- loader-->
    <link href="assets/css/pace.min.css" rel="stylesheet" />

    <!-- javascript -->
    <script src="assets/js/jquery.min.js"></script>

    <title>Laundry</title>
    <style>
        /* Mengatur gaya untuk elemen Select2 container dengan kelas custom-border */
        .select2-container--default.custom-border-bottom .select2-selection--single {
            border: none;
            border-bottom: 1px solid #000;
            padding-left: 0;
            padding-right: 0;
        }

        .select2-container--default.custom-border-bottom .select2-selection--single:focus,
        .select2-container--default.custom-border-bottom .select2-selection--single:active {
            border-bottom: 2px solid #000;
            outline: none;
        }

        .select2-container--default.custom-border-bottom .select2-selection--single .select2-selection__arrow {
            height: 100%;
            border: none;
        }

        .select2-container--default.custom-border-bottom .select2-selection--single .select2-selection__rendered {
            padding-left: 0;
            padding-right: 0;
        }

        /* Akhit custom-border */

        .input-border-bottom-center {
            border: none;
            border-bottom: 1px solid #000;
            padding-left: 0;
            padding-right: 0;
            text-align: center;
        }
    </style>
</head>

<body>


    <!--start wrapper-->
    <div class="wrapper">
        <!--start top header-->
        <header class="top-header">
            <nav class="navbar navbar-expand gap-3">
                <div class="mobile-toggle-icon fs-3 d-flex d-lg-none">
                    <i class="bi bi-list"></i>
                </div>
                <div class="top-navbar-right ms-auto">
                    <ul class="navbar-nav align-items-center gap-1">
                        <li class="nav-item dropdown dropdown-large">
                            <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
                                <div class="notifications">
                                    <span class="notify-badge">8</span>
                                    <i class="bx bx-bell fs-4"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end p-0">
                                <div class="p-2 border-bottom m-2">
                                    <h5 class="h5 mb-0">Notifications</h5>
                                </div>
                                <div class="header-notifications-list p-2">
                                    <a class="dropdown-item" href="#">
                                        <div class="d-flex align-items-center">
                                            <div class="notification-box bg-light-primary text-primary"><i class="bx bx-cart-alt fs-4"></i></div>
                                            <div class="ms-3 flex-grow-1">
                                                <h6 class="mb-0 dropdown-msg-user">New Orders <span class="msg-time float-end text-secondary">1 m</span></h6>
                                                <small class="mb-0 dropdown-msg-text text-secondary d-flex align-items-center">You have recived new orders</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="dropdown dropdown-user-setting">
                    <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
                        <div class="user-setting d-flex align-items-center gap-3">
                            <?php if ($_SESSION['role_id'] == 1) : ?>
                                <img src="assets/images/avatars/avatar-pemilik.png" class="user-img" alt="">
                            <?php else : ?>
                                <img src="assets/images/avatars/avatar-pelanggan.png" class="user-img" alt="">
                            <?php endif; ?>
                            <div class="d-none d-sm-block">
                                <p class="user-name mb-0"><?= ucwords($_SESSION['nama']) ?></p>
                                <small class="mb-0 dropdown-user-designation"><?= ucwords($_SESSION['nama_role']) ?></small>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="?page=profile">
                                <div class="d-flex align-items-center">
                                    <div class=""><i class="bi bi-person-fill"></i></div>
                                    <div class="ms-3"><span>Profile</span></div>
                                </div>
                            </a>
                        </li>
                        <?php if ($_SESSION['role_id'] == 1) : ?>
                            <li>
                                <a class="dropdown-item" href="?page=pengaturan">
                                    <div class="d-flex align-items-center">
                                        <div class=""><i class="bi bi-gear-fill"></i></div>
                                        <div class="ms-3"><span>Pengaturan</span></div>
                                    </div>
                                </a>
                            </li>
                        <?php endif; ?>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="Logout()">
                                <div class="d-flex align-items-center">
                                    <div class=""><i class="bi bi-lock-fill"></i></div>
                                    <div class="ms-3"><span>Logout</span></div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!--end top header-->

        <!--start sidebar -->
        <aside class="sidebar-wrapper" data-simplebar="true">
            <div class="sidebar-header">
                <div>
                    <img src="assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
                </div>
                <div>
                    <h4 class="logo-text fs-6"><?= ucwords($set['nama_usaha']) ?></h4>
                </div>
                <div class="toggle-icon ms-auto"><i class="bx bx-menu-alt-right"></i>
                </div>
            </div>
            <!--navigation-->
            <ul class="metismenu" id="menu">
                <li class="menu-label">Menu</li>
                <?php
                $menu = new Menu();
                $menus = $menu->read($_SESSION['role_id']);
                ?>
                <li class="<?= isset($_GET['mydashboard']) ? 'mm-active' : '' ?>">
                    <a href="?mydashboard" id="btn-mydashboard">
                        <div class="parent-icon"><i class="bx bx-home fs-4"></i>
                        </div>
                        <div class="menu-title">Dashboard</div>
                    </a>
                </li>
                <?php foreach ($menus as $men) : ?>
                    <?php if (isset($men['submenu'])) : ?>
                        <li class="<?= isset($_GET['sub']) && $_GET['page'] == $men['nama_menu'] ? 'mm-active' : '' ?>">
                            <a href="javascript:;" class="has-arrow">
                                <div class="parent-icon"><i class="<?= $men['icon'] ?>"></i>
                                </div>
                                <div class="menu-title"><?= ucwords($men['nama_menu']) ?></div>
                            </a>
                            <ul>
                                <?php foreach ($men['submenu'] as $submenu) : ?>
                                    <li class="<?= isset($_GET['sub']) && $_GET['sub'] == $submenu['direktori'] && $_GET['page'] == $men['nama_menu'] ? 'mm-active' : '' ?>"> <a href="?page=<?= $men['nama_menu'] ?>&sub=<?= $submenu['direktori'] ?>"><i class="bx bx-radio-circle fs-4"></i><?= ucwords($submenu['nama_submenu']) ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php else : ?>
                        <li class="<?= isset($_GET['page']) && $_GET['page'] == $men['nama_menu'] ? 'mm-active' : '' ?>">
                            <a href="?page=<?= $men['direktori'] ?>">
                                <div class="parent-icon"><i class="<?= $men['icon'] ?>"></i>
                                </div>
                                <div class="menu-title"><?= ucwords($men['nama_menu']) ?></div>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
                <li class="menu-label">Autentikasi</li>
                <li>
                    <a href="javascript:void(0)" onclick="Logout()">
                        <div class="parent-icon"><i class="bx bx-log-out fs-4"></i>
                        </div>
                        <div class="menu-title">Keluar</div>
                    </a>
                </li>
            </ul>
            <!--end navigation-->
        </aside>
        <!--end sidebar -->

        <!--start content-->
        <main class="page-content">
            <?php
            $page = isset($_GET['page']) ? $_GET['page'] : '';
            $sub = isset($_GET['sub']) ? $_GET['sub'] : '';
            if ($page == '') {
                include 'menus/main.php';
            } else if (isset($_GET['mydashboard'])) {
                include 'menus/main.php';
            } else {
                if ($sub == '') {
                    include 'menus/' . $page . '.php';
                } else {
                    include 'menus/' . $page . '/' . $sub . '.php';
                }
            }
            ?>
            <div class="modal fade" id="my-modal-centered"></div>
        </main>
        <!--end page main-->

        <!--start overlay-->
        <div class="overlay nav-toggle-icon"></div>
        <!--end overlay-->

        <!--start footer-->
        <footer class="footer">
            <div class="footer-text">
                Copyright &copy; <?= date('Y') ?>. All right reserved.
            </div>
        </footer>
        <!--end footer-->


        <!--Start Back To Top Button-->
        <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
        <!--End Back To Top Button-->
    </div>
    <!--end wrapper-->

    <!-- Bootstrap bundle JS -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <!--plugins-->
    <script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <script src="assets/js/sweetalert2@11.js"></script>
    <script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
    <script src="assets/plugins/notifications/js/lobibox.min.js"></script>
    <script src="assets/plugins/notifications/js/notifications.min.js"></script>
    <script src="assets/plugins/select2/js/select2.min.js"></script>
    <!-- example from plugin -->
    <!-- <script src="assets/plugins/notifications/js/notification-custom-script.js"></script>
    <script src="assets/js/table-datatable.js"></script>
    <script src="assets/js/form-select2.js"></script> -->
    <!--app-->
    <script src="assets/js/app.js"></script>
    <script src="assets/js/custom_function.js"></script>
    <script>
        $(document).ready(function() {
            if (window.location.href.indexOf('page') == -1 && window.location.href.indexOf('mydashboard') == -1) {
                window.location.href = 'dashboard.php?mydashboard';
            }
            $('.select2.custom-border-bottom').next('.select2-container').addClass('custom-border-bottom');
        });

        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });

        function Logout() {
            Swal.fire({
                title: "Apakah anda yakin?",
                text: "Anda akan keluar dari aplikasi!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: 'classes/Authentication.php',
                        data: {
                            action: 'logout'
                        },
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
                                        location.reload();
                                    }
                                }
                            });
                        }
                    })
                }
            });
        }
    </script>
</body>

</html>