<?php

// Xử lý dữ liệu biểu mẫu khi biểu mẫu được gửi
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Lấy dữ liệu đầu vào
    $id = $_POST["id"];

    $_SESSION['error'] = "";

    // Xác thực ghi chú
    if(empty(trim($_POST["note"]))){
        $_SESSION['error'] .= "* Vui lòng điền ghi chú!\n";     
    } else{
        $note = trim($_POST["note"]);
    }

    // Xác thực trạng thái
    if(empty(trim($_POST["status"]))){
        $_SESSION['error'] .= "* Vui lòng chọn trạng thái đơn hàng!\n";     
    } else{
        $status = trim($_POST["status"]);
    }
    
    // Kiểm tra lỗi đầu vào trước khi chèn vào cơ sở dữ liệu
    if(empty($_SESSION['error'])){

        $sql = "UPDATE donhang SET note='$note', status='$status' WHERE id=$id";
        
        if (mysqli_query($conn, $sql)) {
            unset($_SESSION['error']);
            $_SESSION['success'] = "Cập nhật thành công!";
            header("Location: quantri.php?page_layout=danhsachDH");
            exit();
        } else {
            echo "ERROR: Không thể thực thi $sql. " . mysqli_error($conn);
        }
        // Đóng kết nối
        mysqli_close($conn);
    }else{
        header("Location: quantri.php?page_layout=danhsachDH");
        exit();
    }
    
}else{
    header("Location: quantri.php?page_layout=danhsachDH");
    exit();
}