<?php

// Xử lý dữ liệu biểu mẫu khi biểu mẫu được gửi
if(isset($_POST["submit"])){
    $_SESSION['error'] = "";
    $_SESSION['them_name'] = $_POST["name"];
    $_SESSION['them_description'] = $_POST["description"];

    $name = trim($_POST["name"]);
    $description = trim($_POST["description"]);

    // Xác thực 
    if(empty(trim($_POST["name"]))){
        $_SESSION['error'] .= "* Vui lòng điền tên danh mục!";
    } else{
        $name = trim($_POST["name"]);
        $sql = "SELECT * FROM danhmucsanpham WHERE name = '$name'";
        if ($test = mysqli_query($conn, $sql)) {
            if(mysqli_num_rows($test) > 0){
                $_SESSION['error'] .= "* Tên danh mục đã có!";
            }
        } else {
            echo "ERROR: Không thể thực thi $sql. " . mysqli_error($conn);
        }
    }


    // Xác thực 
    if(empty(trim($_POST["description"]))){
        $_SESSION['error'] .= "* Vui lòng điền mô tả!";     
    } else{
        $description = trim($_POST["description"]);
    }
    
    // Kiểm tra lỗi đầu vào trước khi chèn vào cơ sở dữ liệu
    if(empty($_SESSION['error'])){
        
        $sql = "INSERT INTO danhmucsanpham (name, description) VALUES ('$name', '$description')";

        if (mysqli_query($conn, $sql)) {
            unset($_SESSION['error']);
            unset($_SESSION['them_name']);
            unset($_SESSION['them_description']);
            $_SESSION['success'] = "Thêm thành công!";
            header("Location: quantri.php?page_layout=danhsachDM");
            exit();
        } else {
            echo "ERROR: Không thể thực thi $sql. " . mysqli_error($conn);
        }
        // Đóng kết nối
        mysqli_close($conn);
    }else{
        header("Location: quantri.php?page_layout=danhsachDM");
        exit();
    }
}else{
    header("Location: quantri.php?page_layout=danhsachDM");
    exit();
}
?>