<?php

function getValue($inputName, $method, $dataType, $defaultVal)
{
    $returnVal = $defaultVal;
    switch ($method) {
        case "POST":
            if (isset($_POST[$inputName])) {
                $returnVal = $_POST[$inputName];
            }
            break;
        default: // GET / khac
            if (isset($_GET[$inputName])) {
                $returnVal = $_GET[$inputName];
            }
            break;
    }

    switch ($dataType) {
        case "int":
            $returnVal = intval($returnVal);
            break;
        case "double":
            $returnVal = doubleval($returnVal);
            break;
        case "str":
            $returnVal = trim($returnVal);
            break;
        default:
            $returnVal = intval($returnVal);
            break;
    }
    return $returnVal;
}

function getNameCategory($conn, $id_category){
    if(!empty($id_category) && !empty($conn)){
        return (mysqli_fetch_array(mysqli_query($conn, "SELECT name FROM danhmucsanpham WHERE id=$id_category")))["name"];
    }else{
        return "";
    }
}

function getAllCategory($conn){
    $category = [[], []];
    if(!empty($conn)){
        $result = mysqli_query($conn, "SELECT * FROM danhmucsanpham");
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result)) {
                array_push($category[0], $row["id"]);
                array_push($category[1], $row["name"]);
            }
            return $category;
        } else {
            return $category;
        }
    }else{
        return $category;
    }
}



// ---------

function getNameBrand($conn, $id_brand){
    if(!empty($id_brand) && !empty($conn)){
        return (mysqli_fetch_array(mysqli_query($conn, "SELECT name FROM thuonghieu WHERE id=$id_brand")))["name"];
    }else{
        return "";
    }
}

function getAllBrand($conn){
    $brand = [[], []];
    if(!empty($conn)){
        $result = mysqli_query($conn, "SELECT * FROM thuonghieu");
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result)) {
                array_push($brand[0], $row["id"]);
                array_push($brand[1], $row["name"]);
            }
            return $brand;
        } else {
            return $brand;
        }
    }else{
        return $brand;
    }
}

// ------------


// Lấy tên ảnh slide/logo

function getImageSlideLogo($conn, $id){
    if(!empty($id) && !empty($conn)){
        return (mysqli_fetch_array(mysqli_query($conn, "SELECT url_image FROM slidelogo WHERE id=$id")))["url_image"];
    }else{
        return "";
    }
}


function getCountUrlSlideLogo($conn, $url_img){
    if(!empty($url_img) && !empty($conn)){
        return (mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) as sl FROM slidelogo WHERE url_image='$url_img' ")))["sl"];
    }else{
        return "";
    }
}


function getNameUser($conn, $id_user){
    $user = [];
    if(!empty($id_user) && !empty($conn)){
        $result = mysqli_query($conn, "SELECT * FROM taikhoan WHERE id=$id_user");
        while($row = mysqli_fetch_array($result)) {
            $user[] = $row["username"];
            $user[] = $row["phone"];
            $user[] = $row["address"];
        }
        return $user;
    }else{
        return $user;
    }
}

function getNameProduct($conn, $id_product){
    if(!empty($id_product) && !empty($conn)){
        return (mysqli_fetch_array(mysqli_query($conn, "SELECT name FROM sanpham WHERE id=$id_product")))["name"];
    }else{
        return "";
    }
}

function getImageProduct($conn, $id_product){
    if(!empty($id_product) && !empty($conn)){
        return (mysqli_fetch_array(mysqli_query($conn, "SELECT image_url FROM sanpham WHERE id=$id_product")))["image_url"];
    }else{
        return "";
    }
}

function getAllDetailOrder($conn, $id_order){
    $arr = [[], [], [], [], []];
    if(!empty($conn) && !empty($id_order)){
        $result = mysqli_query($conn, "SELECT chitietdonhang.id, sanpham.name, sanpham.image_url, chitietdonhang.quantity, chitietdonhang.price 
                                            FROM chitietdonhang JOIN sanpham ON chitietdonhang.product_id = sanpham.id 
                                                WHERE chitietdonhang.order_id = $id_order ORDER BY chitietdonhang.id DESC");
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result)) {
                array_push($arr[0], $row["id"]);
                array_push($arr[1], $row["name"]);
                array_push($arr[2], $row["image_url"]);
                array_push($arr[3], $row["quantity"]);
                array_push($arr[4], $row["price"]);
            }
            return $arr;
        } else {
            return $arr;
        }
    }else{
        return $arr;
    }
}



// lấy tổng bình luận, sản phẩm, đơn hàng, tài khoản

function getSumComment($conn){
    if(!empty($conn)){
        return (mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS sum_comment FROM danhgiasanpham")))["sum_comment"];
    }else{
        return "0";
    }
}

function getSumProduct($conn){
    if(!empty($conn)){
        return (mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS sum_product FROM sanpham")))["sum_product"];
    }else{
        return "0";
    }
}

function getSumBill($conn){
    if(!empty($conn)){
        return (mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS sum_bill FROM donhang")))["sum_bill"];
    }else{
        return "0";
    }
}

function getSumAccount($conn){
    if(!empty($conn)){
        return (mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS sum_account FROM taikhoan")))["sum_account"];
    }else{
        return "0";
    }
}

function getTop1Product($conn){
    if(!empty($conn)){
        return (mysqli_fetch_array(mysqli_query($conn, "SELECT sanpham.id, sanpham.name, sanpham.image_url, SUM(chitietdonhang.quantity) AS total_quantity FROM sanpham JOIN chitietdonhang ON sanpham.id = chitietdonhang.product_id GROUP BY sanpham.id ORDER BY total_quantity DESC LIMIT 1;")));
    }else{
        return [];
    }
}

// lấy doanh thu theo ngày, tháng, năm, tổng doanh thu

function getRevenueDay($conn){
    if(!empty($conn)){
        return (mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(total) AS revenue_day FROM donhang WHERE DATE(created_at) = CURDATE() AND status = 'Thành công' ")))["revenue_day"];
    }else{
        return "0";
    }
}

function getRevenueMonth($conn){
    if(!empty($conn)){
        return (mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(total) AS revenue_month FROM donhang WHERE MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE()) AND status = 'Thành công'")))["revenue_month"];
    }else{
        return "0";
    }
}

function getRevenueYear($conn){
    if(!empty($conn)){
        return (mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(total) AS revenue_year FROM donhang WHERE YEAR(created_at) = YEAR(CURDATE()) AND status = 'Thành công'")))["revenue_year"];
    }else{
        return "0";
    }
}

function getTotalRevenue($conn){
    if(!empty($conn)){
        return (mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(total) AS total_revenue FROM donhang WHERE status = 'Thành công'")))["total_revenue"];
    }else{
        return "0";
    }
}

function getRevenueOfMonthInYear($conn){
    $arr = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    if(!empty($conn)){
        $result = mysqli_query($conn, "SELECT MONTH(created_at) AS month, SUM(total) AS revenue FROM donhang WHERE YEAR(created_at) = YEAR(CURDATE()) AND status='Thành công' GROUP BY MONTH(created_at)");
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result)) {
                $arr[$row["month"]-1] = $row["revenue"];
            }
            return $arr;
        } else {
            return $arr;
        }
    }else{
        return $arr;
    }
}

// Đơn hàng

function getNewBill($conn){
    if(!empty($conn)){
        return (mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS new_bill FROM donhang WHERE status='Chờ thanh toán' OR status='Chờ xử lý'")))["new_bill"];
    }else{
        return "0";
    }
}

function getTransportBill($conn){
    if(!empty($conn)){
        return (mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS transport_bill FROM donhang WHERE status='Đang vận chuyển'")))["transport_bill"];
    }else{
        return "0";
    }
}

function getFailBill($conn){
    if(!empty($conn)){
        return (mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS fail_bill FROM donhang WHERE status='Thất bại'")))["fail_bill"];
    }else{
        return "0";
    }
}

function getStatusOfBill($conn){
    $arr = [0, 0, 0];
    if(!empty($conn)){
        $result = mysqli_query($conn, "SELECT status, COUNT(*) as count FROM donhang WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE()) AND status IN ('Đang vận chuyển', 'Thành công', 'Thất bại') GROUP BY status");
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result)) {
                if($row["status"] == "Đang vận chuyển"){
                    $arr[0] = $row["count"];
                }else if($row["status"] == "Thành công"){
                    $arr[1] = $row["count"];
                }else{
                    $arr[2] = $row["count"];
                }
                
            }
            return $arr;
        } else {
            return $arr;
        }
    }else{
        return $arr;
    }
}


function getLogoWeb($conn){
    $logo = "";
    if(!empty($conn)){
        $result = mysqli_query($conn, "SELECT url_image FROM slidelogo WHERE type='logo' AND status = 'Bật' ORDER BY position ASC LIMIT 1");
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result)) {
                $logo = $row["url_image"];
            }
            return $logo;
        } else {
            return $logo;
        }
    }else{
        return $logo;
    }
}


?>