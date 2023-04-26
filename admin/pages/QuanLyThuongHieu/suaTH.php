<?php
 
// Xử lý dữ liệu biểu mẫu khi biểu mẫu được gửi
if(isset($_POST["submit"])){
    
    $id = $_POST["id"];
    $_SESSION['error'] = "";

    // Xác thực tên thương hiệu
    if(empty(trim($_POST["name"]))){
        $_SESSION['error'] .= "* Vui lòng điền tên thương hiệu!";
    } else if($_POST["name"] != $_POST["name_test"]){
        $name = trim($_POST["name"]);
        $sql = "SELECT * FROM thuonghieu WHERE name = '$name'";
        if ($test = mysqli_query($conn, $sql)) {
            if(mysqli_num_rows($test) > 0){
                $_SESSION['error'] .= "* Tên thương hiệu đã có!";
            }else{
                $name = trim($_POST["name"]);
            }
        } else {
            echo "ERROR: Không thể thực thi $sql. " . mysqli_error($conn);
        }
    }else{
        $name = trim($_POST["name"]);
    }

    // Xác thực mô tả
    if(empty(trim($_POST["description"]))){
        $_SESSION['error'] .= "* Vui lòng điền mô tả thương hiệu!";     
    } else{
        $description = trim($_POST["description"]);
    }
    
    // Kiểm tra lỗi đầu vào trước khi chèn vào cơ sở dữ liệu
    if(empty($_SESSION['error'])){

        $sql = "UPDATE thuonghieu SET name='$name', description='$description' WHERE id=$id";

        if (mysqli_query($conn, $sql)) {
            unset($_SESSION['error']);
            $_SESSION['success'] = "Cập nhật thành công!";
            header("Location: quantri.php?page_layout=danhsachTH");
            exit();
        } else {
            echo "ERROR: Không thể thực thi $sql. " . mysqli_error($conn);
        }
        // Đóng kết nối
        mysqli_close($conn);
    }else{
        header("Location: quantri.php?page_layout=danhsachTH");
        exit();
    }
    
}else{
    header("Location: quantri.php?page_layout=danhsachTH");
    exit();
}

?>