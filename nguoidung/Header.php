<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
$category = getAllCategory($conn);
$brand = getAllBrand($conn);
$hot_product = getAllProductHot($conn);
$new_product = getAllProductNew($conn);
$all_product = getAllProduct($conn);
$recommended_product = getAllProductRecommended($conn);
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>HouseHaven Shop</title>
    <link rel="icon" href="./assets/images/slide/<?= getLogoWeb($conn) ?>" type="image/x-icon">
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="./assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="./assets/css/prettyPhoto.css" rel="stylesheet">
    <link href="./assets/css/price-range.css" rel="stylesheet">
    <link href="./assets/css/animate.css" rel="stylesheet">
    <link href="./assets/css/main.css" rel="stylesheet">
    <link href="./assets/css/responsive.css" rel="stylesheet">
    <link href="./assets/css/style.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="./assets/js/html5shiv.js"></script>
    <script src="./assets/js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="./assets/images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
        href="./assets/images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
        href="./assets/images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72"
        href="./assets/images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="./assets/images/ico/apple-touch-icon-57-precomposed.png">
</head>
<!--/head-->

<body>
    <header id="header">
        <!--header-->
        <div class="header_top">
            <!--header_top-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="contactinfo">
                            <ul class="nav nav-pills">
                                <li><a href="tel:+84 365 042 941"><i class="fa fa-phone"></i> +84 365 042 941</a></li>
                                <li><a href="mailto:nvc14122002@gmail.com"><i class="fa fa-envelope"></i>
                                        nvc14122002@gmail.com</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="social-icons pull-right">
                            <ul class="nav navbar-nav">
                                <li><a target="_blank" href="https://www.facebook.com/profile.php?id=100087528094253"><i
                                            class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                                <li><a target="_blank"
                                        href="https://www.youtube.com/channel/UCu_KokLnFiSEMNJntWUu7jg"><i
                                            class="fa fa-youtube"></i></a></li>
                                <li><a target="_blank" href="https://github.com/nvc1412"><i
                                            class="fa fa-github"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/header_top-->

        <div class="header-middle">
            <!--header-middle-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="logo pull-left">
                            <a href="index.php?page_layout=TrangChu"><img
                                    src="./assets/images/slide/<?= getLogoShop($conn) ?>" alt="" /></a>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="shop-menu pull-right">
                            <ul class="nav navbar-nav">
                                <!-- <li><a href="ThanhToan.php"><i class="fa fa-crosshairs"></i> Checkout</a></li> -->
                                <li><a href="index.php?page_layout=GioHang"
                                        <?= (isset($_GET["page_layout"]) && ($_GET["page_layout"] == "GioHang" || $_GET["page_layout"] == "ThanhToan" || $_GET["page_layout"] == "ThanhCong")) ? 'class="active"' : '' ?>><i
                                            class="fa fa-shopping-cart"></i> Giỏ hàng
                                        <?php echo (isset($_SESSION['giohang']) && $_SESSION['giohang'] != 0) ? "<sup
                                            style='color: white; background: #34d016; padding: 4px 8px; border-radius: 50%; text-align: center;margin-right: 10px;'>".count($_SESSION['giohang'])."</sup>" : "" ?></a>
                                </li>
                                <?php if(!isset($_SESSION["logged"]) || $_SESSION["logged"] == 0 ){?>
                                <li><a href="index.php?page_layout=DangNhap"
                                        <?= (isset($_GET["page_layout"]) && $_GET["page_layout"] == "DangNhap") ? 'class="active"' : '' ?>><i
                                            class="fa fa-lock"></i> Đăng nhập/ Đăng ký</a>
                                </li>
                                <?php } else{?>
                                <li>
                                    <a href="#"
                                        <?= (isset($_GET["page_layout"]) && ($_GET["page_layout"] == "ThongTin" || $_GET["page_layout"] == "ThongTinChiTiet")) ? 'class="active"' : '' ?>><i
                                            class="fa fa-user"></i><?= (isset($_SESSION['username'])) ? $_SESSION['username'] : "chưa đăng nhập"?></a>
                                    <ul class="sub-menu-user">
                                        <li><a href="index.php?page_layout=ThongTin">Thông tin</a></li>
                                        <li><a href="index.php?page_layout=DangXuat">Đăng xuất</a></li>
                                    </ul>
                                </li>
                                <?php }?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/header-middle-->

        <div class="header-bottom">
            <!--header-bottom-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-9">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse"
                                data-target=".navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div class="mainmenu pull-left">
                            <ul class="nav navbar-nav collapse navbar-collapse">
                                <li><a href="index.php?page_layout=TrangChu"
                                        <?= (!isset($_GET["page_layout"]) || $_GET["page_layout"] == "TrangChu" || $_GET["page_layout"] == "TimKiem" ) ? 'class="active"' : '' ?>>Trang
                                        chủ</a></li>
                                <li><a href="index.php?page_layout=GioiThieu"
                                        <?= (isset($_GET["page_layout"]) && $_GET["page_layout"] == "GioiThieu") ? 'class="active"' : '' ?>>Giới
                                        thiệu</a></li>
                                <li><a href="index.php?page_layout=CuaHang"
                                        <?= (isset($_GET["page_layout"]) && ($_GET["page_layout"] == "CuaHang" || $_GET["page_layout"] == "ChiTietSanPham")) ? 'class="active"' : '' ?>>Cửa
                                        hàng</a>
                                </li>
                                <li class="dropdown"><a href="#"
                                        <?= (isset($_GET["page_layout"]) && ($_GET["page_layout"] == "TimKiemTheoDanhMuc" || $_GET["page_layout"] == "TimKiemTheoThuongHieu" || $_GET["page_layout"] == "LocGia")) ? 'class="active"' : '' ?>>Danh
                                        mục<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        <?php foreach ($category[0] as $key => $value) { 
                                                echo '<li><a href="index.php?page_layout=TimKiemTheoDanhMuc&search='.$value.'&name='.$category[1][$key].'">'.$category[1][$key].'</a></li>';
                                        } ?>
                                    </ul>
                                </li>
                                <li><a href="index.php?page_layout=HoTro"
                                        <?= (isset($_GET["page_layout"]) && $_GET["page_layout"] == "HoTro") ? 'class="active"' : '' ?>>Hỗ
                                        trợ</a></li>
                                <li><a href="index.php?page_layout=LienHe"
                                        <?= (isset($_GET["page_layout"]) && ($_GET["page_layout"] == "LienHe" || $_GET["page_layout"] == "GuiMail")) ? 'class="active"' : '' ?>>Liên
                                        hệ</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="search_box pull-right">
                            <form action="index.php?page_layout=TimKiem" method="post">
                                <input required name="search" type="text" placeholder="Tìm kiếm" />
                                <button class="btn-search" type=" submit"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/header-bottom-->
    </header>
    <!--/header-->