<?php
session_start();
if(isset($_SESSION["logged"]) && $_SESSION["logged"] == 1){
    require_once("./includes/config.php");
    require_once("./includes/functions.php");
    require_once("PHPExcel.php");
    ob_start();
    include_once 'header.php';
    
    if(isset($_GET["page_layout"])){
        switch ($_GET["page_layout"]) {

            //---------------Báo cáo thống kê--------------

            case 'BaoCaoThongKe':
                include_once './pages/BaoCaoThongKe/BaoCaoThongKe.php';
                break;

            //---------------Quản lí danh mục sản phẩm--------------

            case 'danhsachDM':
                include_once './pages/QuanLyDanhMuc/danhsachDM.php';
                break;

            case 'themDM':
                include_once './pages/QuanLyDanhMuc/themDM.php';
                break;

            case 'suaDM':
                include_once './pages/QuanLyDanhMuc/suaDM.php';
                break;

            case 'xoaDM':
                include_once './pages/QuanLyDanhMuc/xoaDM.php';
                break;


            //---------------Quản lí thương hiệu--------------

            case 'danhsachTH':
                include_once './pages/QuanLyThuongHieu/danhsachTH.php';
                break;

            case 'themTH':
                include_once './pages/QuanLyThuongHieu/themTH.php';
                break;

            case 'suaTH':
                include_once './pages/QuanLyThuongHieu/suaTH.php';
                break;

            case 'xoaTH':
                include_once './pages/QuanLyThuongHieu/xoaTH.php';
                break;


            //---------------Quản lí sản phẩm--------------

            case 'danhsachSP':
                include_once './pages/QuanLySanPham/danhsachSP.php';
                break;

            case 'themSP':
                include_once './pages/QuanLySanPham/themSP.php';
                break;

            case 'suaSP':
                include_once './pages/QuanLySanPham/suaSP.php';
                break;

            case 'suaNhanhSP':
                include_once './pages/QuanLySanPham/suaNhanhSP.php';
                break;    

            case 'xoaSP':
                include_once './pages/QuanLySanPham/xoaSP.php';
                break;



            //---------------Quản lí đơn hàng--------------

            case 'danhsachDH':
                include_once './pages/QuanLyDonHang/danhsachDH.php';
                break;

            case 'suaDH':
                include_once './pages/QuanLyDonHang/suaDH.php';
                break;

            case 'xoaDH':
                include_once './pages/QuanLyDonHang/xoaDH.php';
                break;

            case 'suaCTDH':
                include_once './pages/QuanLyDonHang/suaCTDH.php';
                break;

            case 'suaNhanhDH':
                include_once './pages/QuanLyDonHang/suaNhanhDH.php';
                break;

            case 'xoaCTDH':
                include_once './pages/QuanLyDonHang/xoaCTDH.php';
                break;

            //---------------Quản lí bình luận--------------

            case 'danhsachBL':
                include_once './pages/QuanLyBinhLuan/danhsachBL.php';
                break;

            case 'xoaBL':
                include_once './pages/QuanLyBinhLuan/xoaBL.php';
                break;


            //---------------Quản lí slide logo--------------

            case 'danhsachSLLG':
                include_once './pages/QuanLySlideLogo/danhsachSLLG.php';
                break;

            case 'themSLLG':
                include_once './pages/QuanLySlideLogo/themSLLG.php';
                break;

            case 'suaSLLG':
                include_once './pages/QuanLySlideLogo/suaSLLG.php';
                break;

            case 'xoaSLLG':
                include_once './pages/QuanLySlideLogo/xoaSLLG.php';
                break;
                

            //---------------Quản lí tài khoản--------------

            case 'danhsachTK':
                include_once './pages/QuanLyTaiKhoan/danhsachTK.php';
                break;
                
            case 'themTK':
                include_once './pages/QuanLyTaiKhoan/themTK.php';
                break;

            case 'suaTK':
                include_once './pages/QuanLyTaiKhoan/suaTK.php';
                break;

            case 'xoaTK':
                include_once './pages/QuanLyTaiKhoan/xoaTK.php';
                break;


            //---------------Lỗi--------------

            case 'Loi':
                include_once 'error.php';
                break;

        }
    }else {
        include_once './pages/BaoCaoThongKe/BaoCaoThongKe.php';
    }
        
    
    include_once 'footer.php';
    ob_end_flush();
}else{
    header("Location: login.php");
}
?>