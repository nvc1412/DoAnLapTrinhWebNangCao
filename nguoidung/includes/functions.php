<?php

// Xử lý thanh toán MOMO
function execPostRequest($url, $data)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data))
    );
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    //execute post
    $result = curl_exec($ch);
    //close connection
    curl_close($ch);
    return $result;
}



function getAllProduct($conn){
    $arr = [[], [], [], []];
    if(!empty($conn)){
        $result = mysqli_query($conn, "SELECT id, name, image_url, price FROM sanpham LIMIT 6");
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result)) {
                array_push($arr[0], $row["id"]);
                array_push($arr[1], $row["name"]);
                array_push($arr[2], $row["image_url"]);
                array_push($arr[3], $row["price"]);
            }
            return $arr;
        } else {
            return $arr;
        }
    }else{
        return $arr;
    }
}



function getAllProductRecommended($conn){
    $arr = [[], [], [], [], []];
    if(!empty($conn)){
        $result = mysqli_query($conn, "SELECT id, name, image_url, price, discount FROM sanpham  ORDER BY id ASC LIMIT 8");
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result)) {
                array_push($arr[0], $row["id"]);
                array_push($arr[1], $row["name"]);
                array_push($arr[2], $row["image_url"]);
                array_push($arr[3], $row["price"]);
                array_push($arr[4], $row["discount"]);
            }
            return $arr;
        } else {
            return $arr;
        }
    }else{
        return $arr;
    }
}

function getProductRecommendedCategory($conn, $category_name){
    $arr = [[], [], [], [], []];
    if(!empty($conn) && !empty($category_name)){
        $result = mysqli_query($conn, "SELECT sanpham.id, sanpham.name, sanpham.image_url, sanpham.price, sanpham.discount 
                                        FROM sanpham JOIN danhmucsanpham ON sanpham.category_id = danhmucsanpham.id 
                                        WHERE danhmucsanpham.name = '$category_name' ORDER BY sanpham.id ASC LIMIT 8");
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result)) {
                array_push($arr[0], $row["id"]);
                array_push($arr[1], $row["name"]);
                array_push($arr[2], $row["image_url"]);
                array_push($arr[3], $row["price"]);
                array_push($arr[4], $row["discount"]);
            }
            return $arr;
        } else {
            return $arr;
        }
    }else{
        return $arr;
    }
}



function getAllSlide($conn){
    $slide = [[], []];
    if(!empty($conn)){
        $result = mysqli_query($conn, "SELECT position, url_image FROM slidelogo WHERE type='slide' AND status = 'Bật' ORDER BY position ASC");
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result)) {
                array_push($slide[0], $row["position"]);
                array_push($slide[1], $row["url_image"]);
            }
            return $slide;
        } else {
            return $slide;
        }
    }else{
        return $slide;
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


function getLogoShop($conn){
    $logo = "";
    if(!empty($conn)){
        $result = mysqli_query($conn, "SELECT url_image FROM slidelogo WHERE type='logo' AND status = 'Bật' ORDER BY position ASC LIMIT 2");
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

function getQuantityProductOfBrand($conn, $id_brand){
    if(!empty($id_brand) && !empty($conn)){
        return (mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) AS quantity_product FROM sanpham WHERE brand_id=$id_brand")))["quantity_product"];
    }else{
        return "0";
    }
}


// Sản phẩm bán chạy
function getAllProductHot($conn){
    $arr = [[], [], [], [], [], []];
    if(!empty($conn)){
        $result = mysqli_query($conn, "SELECT sanpham.id, sanpham.name, sanpham.image_url, SUM(chitietdonhang.quantity) AS total_quantity, sanpham.price, sanpham.discount
                                        FROM sanpham JOIN chitietdonhang ON sanpham.id = chitietdonhang.product_id 
                                        GROUP BY sanpham.id
                                        ORDER BY total_quantity DESC 
                                        LIMIT 8");
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result)) {
                array_push($arr[0], $row["id"]);
                array_push($arr[1], $row["name"]);
                array_push($arr[2], $row["image_url"]);
                array_push($arr[3], $row["total_quantity"]);
                array_push($arr[4], $row["price"]);
                array_push($arr[5], $row["discount"]);
            }
            return $arr;
        } else {
            return $arr;
        }
    }else{
        return $arr;
    }
}

// Sản phẩm mới
function getAllProductNew($conn){
    $arr = [[], [], [], [], []];
    if(!empty($conn)){
        $result = mysqli_query($conn, "SELECT id, name, image_url, price, discount FROM sanpham ORDER BY created_at DESC LIMIT 8");
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result)) {
                array_push($arr[0], $row["id"]);
                array_push($arr[1], $row["name"]);
                array_push($arr[2], $row["image_url"]);
                array_push($arr[3], $row["price"]);
                array_push($arr[4], $row["discount"]);
            }
            return $arr;
        } else {
            return $arr;
        }
    }else{
        return $arr;
    }
}



// Chi tiết sản phẩm
function getDetailProduct($conn, $id_product){
    $arr = [];
    if(!empty($conn) && !empty($id_product)){
        $result = mysqli_query($conn, "SELECT sanpham.id, sanpham.name, sanpham.image_url, danhmucsanpham.name as name_danhmuc, 
                                                thuonghieu.name as name_thuonghieu, sanpham.price , sanpham.description, sanpham.quantity, sanpham.discount
                                        FROM (sanpham JOIN danhmucsanpham ON sanpham.category_id = danhmucsanpham.id) 
                                            JOIN thuonghieu ON sanpham.brand_id = thuonghieu.id
                                        WHERE sanpham.id = $id_product");
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result)) {
                array_push($arr, $row["id"]);
                array_push($arr, $row["name"]);
                array_push($arr, $row["image_url"]);
                array_push($arr, $row["name_danhmuc"]);
                array_push($arr, $row["name_thuonghieu"]);
                array_push($arr, $row["price"]);
                array_push($arr, $row["description"]);
                array_push($arr, $row["quantity"]);
                array_push($arr, $row["discount"]);
            }
            return $arr;
        } else {
            return $arr;
        }
    }else{
        return $arr;
    }
}

// Đánh giá sản phẩm
function getCommentProduct($conn, $id_product){
    $arr = [[], [], [], [], []];
    if(!empty($conn) && !empty($id_product)){
        $result = mysqli_query($conn, "SELECT danhgiasanpham.id, taikhoan.username, danhgiasanpham.rating, danhgiasanpham.comment, danhgiasanpham.created_at
        FROM danhgiasanpham JOIN taikhoan ON danhgiasanpham.user_id = taikhoan.id
        WHERE danhgiasanpham.product_id = $id_product ORDER BY created_at DESC");
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result)) {
                array_push($arr[0], $row["id"]);
                array_push($arr[1], $row["username"]);
                array_push($arr[2], $row["rating"]);
                array_push($arr[3], $row["comment"]);
                array_push($arr[4], $row["created_at"]);
            }
            return $arr;
        } else {
            return $arr;
        }
    }else{
        return $arr;
    }
}



// kiểm tra đăng ký tài khoản
function checkUsername($conn, $username){
    if(!empty($username) && !empty($conn)){
        return (mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) as soluong FROM taikhoan WHERE username = '$username'")))["soluong"];
    }else{
        return "0";
    }
}

function checkEmail($conn, $email){
    if(!empty($email) && !empty($conn)){
        return (mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) as soluong FROM taikhoan WHERE email = '$email'")))["soluong"];
    }else{
        return "0";
    }
}

function checkPhone($conn, $phone){
    if(!empty($phone) && !empty($conn)){
        return (mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(*) as soluong FROM taikhoan WHERE phone = '$phone'")))["soluong"];
    }else{
        return "0";
    }
}



// lấy giá sản phẩm
function getPriceProduct($conn, $product_id){
    if(!empty($product_id) && !empty($conn)){
        return (mysqli_fetch_array(mysqli_query($conn, "SELECT price FROM sanpham WHERE id = $product_id")))["price"];
    }else{
        return "0";
    }
}

// lấy giảm giá sản phẩm
function getDiscountProduct($conn, $product_id){
    if(!empty($product_id) && !empty($conn)){
        return (mysqli_fetch_array(mysqli_query($conn, "SELECT discount FROM sanpham WHERE id = $product_id")))["discount"];
    }else{
        return "0";
    }
}

// lấy id cuối cùng trong bảng đơn hàng
function getLastIdProduct($conn){
    if(!empty($conn)){
        return (mysqli_fetch_array(mysqli_query($conn, "SELECT MAX(id) as last_id FROM donhang")))["last_id"];
    }else{
        return "0";
    }
}


// lấy giá cao nhất và nhỏ nhất
function getMinMaxPrice($conn){
    $arr = [];
    if(!empty($conn)){
        $result = mysqli_query($conn, "SELECT MIN(price) AS min, MAX(price) AS max FROM sanpham");
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_array($result)) {
                array_push($arr, $row["min"]);
                array_push($arr, $row["max"]);
            }
            return $arr;
        } else {
            return $arr;
        }
    }else{
        return $arr;
    }
}


?>