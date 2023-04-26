<?php

$RegexFomatPhone = "/^0[3|5|7|8|9]\d{8}$/";

// Xử lý dữ liệu biểu mẫu khi biểu mẫu được gửi
if(isset($_POST["submit"])){
    $_SESSION['error'] = "";
    $_SESSION['them_username'] = $_POST["username"];
    $_SESSION['them_password'] = $_POST["password"];
    $_SESSION['them_password_again'] = $_POST["password_again"];
    $_SESSION['them_email'] = $_POST["email"];
    $_SESSION['them_phone'] = $_POST["phone"];
    $_SESSION['them_address'] = $_POST["address"];
    $_SESSION['them_is_admin'] = $_POST["is_admin"];
    // Xác thực tên
    if(empty(trim($_POST["username"]))){
        $_SESSION['error'] .= "* Vui lòng điền tên!\n";
    } else{
        $username = trim($_POST["username"]);
        $sql = "SELECT * FROM taikhoan WHERE username = '$username'";
        if ($test = mysqli_query($conn, $sql)) {
            if(mysqli_num_rows($test) > 0){
                $_SESSION['error'] .= "* Tên tài khoản đã được sử dụng!\n";
            }
        } else {
            echo "ERROR: Không thể thực thi $sql. " . mysqli_error($conn);
        }
    }

    // Xác thực mật khẩu mới
    if(empty(trim($_POST["password"]))){
        $_SESSION['error'] .= "* Vui lòng điền mật khẩu mới!\n";
    } else{
        $password = trim($_POST["password"]);
    }

    // Xác thực lại mật khẩu mới
    if(empty(trim($_POST["password_again"]))){
        $_SESSION['error'] .= "* Nhập lại mật khẩu mới!\n";
    } else if(trim($_POST["password_again"]) != trim($_POST["password"])){
        $_SESSION['error'] .= "* Mật khẩu không trùng khớp!\n";
    }else{
        $password_again = trim($_POST["password_again"]);
    }
    
    // Xác thực email
    if(empty(trim($_POST["email"]))){
        $_SESSION['error'] .= "* Vui lòng điền email!\n";     
    } else{
        $email = trim($_POST["email"]);
        $sql = "SELECT * FROM taikhoan WHERE email = '$email'";
        if ($test = mysqli_query($conn, $sql)) {
            if(mysqli_num_rows($test) > 0){
                $_SESSION['error'] .= "* Email đã được sử dụng!\n";
            }
        } else {
            echo "ERROR: Không thể thực thi $sql. " . mysqli_error($conn);
        }
    }

    // Xác thực số điện thoại
    if(empty(trim($_POST["phone"]))){
        $_SESSION['error'] .= "* Vui lòng điền số điện thoại!\n";     
    }else if(!preg_match($RegexFomatPhone, trim($_POST["phone"]))){
        $_SESSION['error'] .= "* Số điện thoại không hợp lệ!";
    }else{
        $phone = trim($_POST["phone"]);
        $sql = "SELECT * FROM taikhoan WHERE phone = '$phone'";
        if ($test = mysqli_query($conn, $sql)) {
            if(mysqli_num_rows($test) > 0){
                $_SESSION['error'] .= "* Số điện thoại đã được sử dụng!\n";
            }
        } else {
            echo "ERROR: Không thể thực thi $sql. " . mysqli_error($conn);
        }
    }

    // Xác thực địa chỉ
    if(empty(trim($_POST["address"]))){
        $_SESSION['error'] .= "* Vui lòng điền address!\n";     
    } else{
        $address = trim($_POST["address"]);
    }
    
    // Xác thực quyền
    if(empty(trim($_POST["is_admin"]))){
        $_SESSION['error'] .= "* Vui lòng chọn Yes hoặc No!\n";     
    } else{
        if(trim($_POST["is_admin"])=="Yes"){
            $is_admin = 1;
        }else{
            $is_admin = 0;
        }
    }

    // Kiểm tra lỗi đầu vào trước khi chèn vào cơ sở dữ liệu
    if(empty($_SESSION['error'])){
        
        $password_new = md5($password_again);
        $sql = "INSERT INTO taikhoan (username, email, phone, password, address, is_admin) VALUES ('$username', '$email', '$phone', '$password_new', '$address', $is_admin)";

        echo $sql;
        die();
        if (mysqli_query($conn, $sql)) {
            unset($_SESSION['error']);
            unset($_SESSION['them_username']);
            unset($_SESSION['them_password']);
            unset($_SESSION['them_password_again']);
            unset($_SESSION['them_email']);
            unset($_SESSION['them_phone']);
            unset($_SESSION['them_address']);
            unset($_SESSION['them_is_admin']);
            $_SESSION['success'] = "Thêm thành công!";

            header("Location: quantri.php?page_layout=danhsachTK");
            exit();
        } else {
            echo "ERROR: Không thể thực thi $sql. " . mysqli_error($conn);
        }
        // Đóng kết nối
        mysqli_close($conn);
    }else{
        header("Location: quantri.php?page_layout=danhsachTK");
        exit();
    }
}else{
    header("Location: quantri.php?page_layout=danhsachTK");
    exit();
}
?>