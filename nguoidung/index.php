<?php
session_start();
require_once("./includes/config.php");
require_once("./includes/config_vnpay.php");
require_once("./includes/config_momo.php");
require_once("./includes/functions.php");
require("./mail/sendmail.php");
ob_start();
include_once("Header.php");

if(isset($_GET["page_layout"])){
    switch ($_GET["page_layout"]) {
        
        case 'KiemTraDangNhap':
            include_once 'KiemTraDangNhap.php';
            break;

        case 'TrangChu':
            include_once './pages/TrangChu/Slider.php';
            include_once './pages/TrangChu/TrangChu.php';
            break;

        case 'GioiThieu':
            include_once './pages/GioiThieu/GioiThieu.php';
            break;

        case 'CuaHang':
            include_once './pages/CuaHang/CuaHang.php';
            break;

        case 'HoTro':
            include_once './pages/HoTro/HoTro.php';
            break;

        case 'LienHe':
            include_once './pages/LienHe/LienHe.php';
            break;
            
        case 'GioHang':
            include_once './pages/GioHang/GioHang.php';
            break;

        case 'DangNhap':
            include_once './pages/DangNhap/DangNhap.php';
            break;

        case 'DangXuat':
            include_once './pages/DangNhap/DangXuat.php';
            break;

        case 'ChiTietSanPham':
            include_once './pages/ChiTietSanPham/ChiTietSanPham.php';
            break;

        case 'DanhGia':
            include_once './pages/ChiTietSanPham/DanhGia.php';
            break;

        case 'ThanhToan':
            include_once './pages/ThanhToan/ThanhToan.php';
            break;

        case 'ThanhCong':
            include_once './pages/ThanhToan/ThanhCong.php';
            break;

        case 'VNPAY':
            include_once './pages/ThanhToan/VNPAY.php';
            break;

        case 'MOMO':
            include_once './pages/ThanhToan/MOMO.php';
            break;

        case 'XuLyThanhToan':
            include_once './pages/ThanhToan/XuLyThanhToan.php';
            break;

        case 'ThemVaoGioHang':
            include_once './pages/GioHang/ThemVaoGioHang.php';
            break;
    
        case 'CongSP':
            include_once './pages/GioHang/CongSP.php';
            break;

        case 'TruSP':
            include_once './pages/GioHang/TruSP.php';
            break;

        case 'XoaSP':
            include_once './pages/GioHang/XoaSP.php';
            break;

        case 'TimKiem':
            include_once './pages/TimKiem/TimKiem.php';
            break;

        case 'TimKiemTheoDanhMuc':
            include_once './pages/TimKiem/TimKiemTheoDanhMuc.php';
            break;

        case 'TimKiemTheoThuongHieu':
            include_once './pages/TimKiem/TimKiemTheoThuongHieu.php';
            break;

        case 'LocGia':
            include_once './pages/TimKiem/LocGia.php';
            break;

        case 'GuiMail':
            include_once './pages/LienHe/GuiMail.php';
            break;

        case 'ThongTin':
            include_once './pages/TaiKhoan/ThongTin.php';
            break;

        case 'ThongTinChiTiet':
            include_once './pages/TaiKhoan/ThongTinChiTiet.php';
            break;

    }
}else {
    include_once './pages/TrangChu/Slider.php';
    include_once './pages/TrangChu/TrangChu.php';
}

include_once("Footer.php");
ob_end_flush();
?>