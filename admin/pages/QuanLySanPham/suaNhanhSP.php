<?php

// Xử lý dữ liệu biểu mẫu khi biểu mẫu được gửi
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Lấy dữ liệu đầu vào
    $id = $_POST["id"];
    
    $_SESSION['error'] = "";

    // Xác thực danh mục
    if(empty(trim($_POST["category_id"]))){
        $_SESSION['error'] .= "* Vui lòng điền danh mục sản phẩm!";     
    } else{
        $category_id = trim($_POST["category_id"]);
    }

    // Xác thực thương hiệu
    if(empty(trim($_POST["brand_id"]))){
        $_SESSION['error'] .= "* Vui lòng điền thương hiệu sản phẩm!";     
    } else{
        $brand_id = trim($_POST["brand_id"]);
    }

    // Xác thực tên
    if(empty(trim($_POST["name"]))){
        $_SESSION['error'] .= "* Vui lòng điền tên sản phẩm!";     
    } else{
        $name = trim($_POST["name"]);
    }

    // Xác thực mô tả
    if(empty(trim($_POST["description"]))){
        $_SESSION['error'] .= "* Vui lòng điền mô tả!";     
    } else{
        $description = trim($_POST["description"]);
    }

    // Xác thực giá
    if(empty(trim($_POST["price"])) && trim($_POST["price"]) != 0 ){
        $_SESSION['error'] .= "* Vui lòng điền giá!";
        echo trim($_POST["price"]);     
    } elseif(!ctype_digit(trim($_POST["price"]))){
        $_SESSION['error'] .= "* Vui lòng điền giá phải là số!";
    } else{
        $price = trim($_POST["price"]);
    }

    // Xác thực giảm giá
    if(empty(trim($_POST["discount"])) && trim($_POST["discount"]) != 0 ){
        $_SESSION['error'] .= "* Vui lòng điền giảm giá!";
        echo trim($_POST["discount"]);     
    } elseif(!ctype_digit(trim($_POST["discount"]))){
        $_SESSION['error'] .= "* Vui lòng điền giảm giá phải là số!";
    } else{
        $discount = trim($_POST["discount"]);
    }
    
    // Xác thực số lượng
    if(empty(trim($_POST["quantity"])) && trim($_POST["quantity"]) != 0 ){
        $_SESSION['error'] .= "* Vui lòng điền số lượng!";
        echo trim($_POST["quantity"]);     
    } elseif(!ctype_digit(trim($_POST["quantity"]))){
        $_SESSION['error'] .= "* Vui lòng điền số phải là số!";
    } else{
        $quantity = trim($_POST["quantity"]);
    }
    
    
    // Kiểm tra lỗi đầu vào trước khi chèn vào cơ sở dữ liệu
    if(empty($_SESSION['error'])){

        // Chuẩn bị câu lệnh Update
        $sql = "UPDATE sanpham SET category_id= $category_id, brand_id = $brand_id, name='$name', description='$description', price= $price, discount= $discount, quantity=$quantity WHERE id= $id";

        if (mysqli_query($conn, $sql)) {
            // Update thành công. Chuyển hướng đến trang đích
            unset($_SESSION['error']);
            $_SESSION['success'] = "Cập nhật thành công!";
            header("Location: quantri.php?page_layout=danhsachSP");
            exit();
        } else {
            echo "ERROR: Không thể thực thi $sql. " . mysqli_error($conn);
        }
        // Đóng kết nối
        mysqli_close($conn);
    }else{
        header("Location: quantri.php?page_layout=danhsachSP");
        exit();
    }
}else{
    header("Location: quantri.php?page_layout=danhsachSP");
    exit();
}
?>