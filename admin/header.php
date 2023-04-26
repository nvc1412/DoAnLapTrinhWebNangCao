<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Trang Quản Lý</title>

    <link rel="icon" href="../nguoidung/assets/images/slide/<?= getLogoWeb($conn) ?>" type="image/x-icon">

    <!-- Custom fonts for this template-->
    <link href="./assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">


    <!-- Custom styles for this template-->
    <link href="./assets/css/sb-admin-2.min.css" rel="stylesheet">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>


    <script type="text/javascript" src="./ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="./ckeditor/ckfinder/ckfinder.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

    <!-- <link href="./assets/css/style.css" rel="stylesheet"> -->
    <!-- <script src="./assets/js/script.js"></script> -->


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul style="background-image: linear-gradient(180deg,#3a3b45 10%,#043a27 100%);"
            class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="quantri.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-home"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Trang Chủ</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->

            <li
                class="nav-item <?= (!isset($_GET["page_layout"]) || ($_GET["page_layout"] == "BaoCaoThongKe")) ? 'active' : '' ?>">
                <a class="nav-link" href="quantri.php?page_layout=BaoCaoThongKe">
                    <i class="fas fa-fw fa-chart-bar"></i>
                    <span>Báo Cáo Thống kê</span>
                </a>
            </li>

            <li
                class="nav-item <?= (isset($_GET["page_layout"]) && ($_GET["page_layout"] == "danhsachDM" || $_GET["page_layout"] == "xoaDM")) ? 'active' : '' ?>">
                <a class="nav-link" href="quantri.php?page_layout=danhsachDM">
                    <i class="fas fa-fw fa-th-list"></i>
                    <span>Quản lý danh mục</span>
                </a>
            </li>

            <li
                class="nav-item <?= (isset($_GET["page_layout"]) && ($_GET["page_layout"] == "danhsachTH" || $_GET["page_layout"] == "xoaTH")) ? 'active' : '' ?>">
                <a class="nav-link" href="quantri.php?page_layout=danhsachTH">
                    <i class="fas fa-fw fa-tags"></i>
                    <span>Quản lý thương hiệu</span>
                </a>
            </li>

            <li
                class="nav-item <?= (isset($_GET["page_layout"]) && ($_GET["page_layout"] == "danhsachSP" || $_GET["page_layout"] == "themSP" || $_GET["page_layout"] == "xoaSP" || $_GET["page_layout"] == "suaSP")) ? 'active' : '' ?>">
                <a class="nav-link" href="quantri.php?page_layout=danhsachSP">
                    <i class="fa-solid fa-fw fa-kitchen-set"></i>
                    <span>Quản lý sản phẩm</span>
                </a>
            </li>

            <li
                class="nav-item <?= (isset($_GET["page_layout"]) && ($_GET["page_layout"] == "danhsachDH" || $_GET["page_layout"] == "xoaDH" || $_GET["page_layout"] == "suaDH")) ? 'active' : '' ?>">
                <a class="nav-link" href="quantri.php?page_layout=danhsachDH">
                    <i class="fas fa-fw fa-credit-card"></i>
                    <span>Quản lý đơn hàng</span>
                </a>
            </li>

            <li
                class="nav-item <?= (isset($_GET["page_layout"]) && ($_GET["page_layout"] == "danhsachBL" || $_GET["page_layout"] == "xoaBL")) ? 'active' : '' ?>">
                <a class="nav-link" href="quantri.php?page_layout=danhsachBL">
                    <i class="fas fa-fw fa-comment-alt"></i>
                    <span>Quản lý bình luận</span>
                </a>
            </li>

            <li
                class="nav-item <?= (isset($_GET["page_layout"]) && ($_GET["page_layout"] == "danhsachSLLG" || $_GET["page_layout"] == "xoaSLLG")) ? 'active' : '' ?>">
                <a class="nav-link" href="quantri.php?page_layout=danhsachSLLG">
                    <i class="fas fa-fw fa-images"></i>
                    <span>Quản lý slide/logo</span>
                </a>
            </li>

            <li
                class="nav-item <?= (isset($_GET["page_layout"]) && ($_GET["page_layout"] == "danhsachTK" || $_GET["page_layout"] == "xoaTK")) ? 'active' : '' ?>">
                <a class="nav-link" href="quantri.php?page_layout=danhsachTK">
                    <i class="fas fa-fw fa-user-cog"></i>
                    <span>Quản lý tài khoản</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-fw fa-sign-out-alt"></i>
                    <span>Đăng Xuất</span></a>
            </li>

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Tìm kiếm"
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $_SESSION["username"] ?></span>
                                <img class="img-profile rounded-circle" src="./assets/img/icon_admin.png">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Đăng Xuất
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">