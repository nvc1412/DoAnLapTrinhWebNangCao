<?php


$RegexFomatPhone = "/^0[3|5|7|8|9]\d{8}$/";

// Xử lý dữ liệu biểu mẫu khi biểu mẫu được gửi
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Lấy dữ liệu đầu vào
    $id = $_POST["id"];

    $_SESSION['error'] = "";

    // Xác thực tên
    if(empty(trim($_POST["username"]))){
        $_SESSION['error'] .= "* Vui lòng điền tên!\n";
    } else if($_POST["username"] != $_POST["username_test"]){
        $username = trim($_POST["username"]);
        $sql = "SELECT * FROM taikhoan WHERE username = '$username'";
        if ($test = mysqli_query($conn, $sql)) {
            if(mysqli_num_rows($test) > 0){
                $_SESSION['error'] .= "* Tên tài khoản đã được sử dụng!\n";
            }else{
                $username = trim($_POST["username"]);
            }
        } else {
            echo "ERROR: Không thể thực thi $sql. " . mysqli_error($conn);
        }
    }else{
        $username = trim($_POST["username"]);
    }

    // Xác thực email
    if(empty(trim($_POST["email"]))){
        $_SESSION['error'] .= "* Vui lòng điền email!\n";     
    } else if(trim($_POST["email"]) != $_POST["email_test"]){
        $email = trim($_POST["email"]);
        $sql = "SELECT * FROM taikhoan WHERE email = '$email'";
        if ($test = mysqli_query($conn, $sql)) {
            if(mysqli_num_rows($test) > 0){
                $_SESSION['error'] .= "* Email đã được sử dụng!\n";
            }else{
                $email = trim($_POST["email"]);
            }
        } else {
            echo "ERROR: Không thể thực thi $sql. " . mysqli_error($conn);
        }
    }else{
        $email = trim($_POST["email"]);
    }


    // Xác thực số điện thoại
    if(empty(trim($_POST["phone"]))){
        $_SESSION['error'] .= "* Vui lòng điền số điện thoại!\n";     
    }else if(!preg_match($RegexFomatPhone, trim($_POST["phone"]))){
        $_SESSION['error'] .= "* Số điện thoại không hợp lệ!";
    }else if(trim($_POST["phone"]) != $_POST["phone_test"]){
        $phone = trim($_POST["phone"]);
        $sql = "SELECT * FROM taikhoan WHERE phone = '$phone'";
        if ($test = mysqli_query($conn, $sql)) {
            if(mysqli_num_rows($test) > 0){
                $_SESSION['error'] .= "* Số điện thoại đã được sử dụng!\n";
            }else{
                $phone = trim($_POST["phone"]);
            }
        } else {
            echo "ERROR: Không thể thực thi $sql. " . mysqli_error($conn);
        }
    }else{
        $phone = trim($_POST["phone"]);
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

    // Xác thực trạng thái
    if(empty(trim($_POST["status"]))){
        $_SESSION['error'] .= "* Vui lòng chọn Khóa hoặc Tốt!\n";     
    } else{
        if(trim($_POST["status"])=="Yes"){
            $status = 1;
        }else{
            $status = 0;
        }
    }
    
    // Kiểm tra lỗi đầu vào trước khi chèn vào cơ sở dữ liệu
    if(empty($_SESSION['error'])){

        $sql = "UPDATE taikhoan SET username='$username', email='$email', phone='$phone', address='$address', is_admin=$is_admin, status=$status WHERE id=$id";
        
        if (mysqli_query($conn, $sql)) {
            unset($_SESSION['error']);
            $_SESSION['success'] = "Cập nhật thành công!";
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