<?php
 
$target_dir = "../nguoidung/assets/images/slide/"; // khi dùng "../" là trở ra đường dẫn đầu tiên (localhost://)

// Xử lý dữ liệu biểu mẫu khi biểu mẫu được gửi
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Lấy dữ liệu đầu vào
    $id = $_POST["id"];


    $_SESSION['error'] = "";

    // Xác thực tên
    if(empty(trim($_POST["name"]))){
        $_SESSION['error'] .= "* Vui lòng điền tên ảnh!";     
    } else{
        $name = trim($_POST["name"]);
    }

    // Xác thực ảnh
    if(empty(trim($_FILES["image_url"]["name"]))){
        $image_url = $_POST["image_url"];
        $target_file = $target_dir . basename($image_url);
    } else{
        $image_url = trim($_FILES["image_url"]["name"]);

        $target_file = $target_dir . basename($image_url);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Kiểm tra ảnh thật hay giả
        $check = getimagesize($_FILES["image_url"]["tmp_name"]);
        if($check == false) {
            $_SESSION['error'] .= "* File không phải một ảnh!";
        }

        // kiểm tra cỡ file
        if ($_FILES["image_url"]["size"] > 600000) {
            $_SESSION['error'] .= "* File quá lớn, vui lòng chọn file có kích cỡ bé hơn!";
        }

        // kiểm tra định dạng file
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            $_SESSION['error'] .= "* Chỉ cho phép các tệp có định dạng là JPG, JPEG, PNG và GIF!";
        }

        // // kiểm tra file đã tồn tại
        // if (file_exists($target_file)) {
        //     $_SESSION['error'] .= "* File đã tồn tại.";
        // }
    }

    // Xác thực kiểu
    if(empty(trim($_POST["type"]))){
        $_SESSION['error'] .= "* Vui lòng chọn kiểu!";     
    } else{
        $type = trim($_POST["type"]);
    }

    // Xác thực vị trí
    if(empty(trim($_POST["position"])) && trim($_POST["position"]) != 0 ){
        $_SESSION['error'] .= "* Vui lòng chọn vị trí.";   
    } elseif(!ctype_digit(trim($_POST["position"]))){
        $_SESSION['error'] .= "* Vui lòng điền vị trí phải là số.";
    } else{
        $position = trim($_POST["position"]);
    }

    // Xác thực trạng thái
    if(empty(trim($_POST["status"]))){
        $_SESSION['error'] .= "* Vui lòng chọn trạng thái!";     
    } else{
        $status = trim($_POST["status"]);
    }

    // Xác thực mô tả
    if(empty(trim($_POST["description"]))){
        $_SESSION['error'] .= "* Vui lòng điền mô tả.";     
    } else{
        $description = trim($_POST["description"]);
    }
    
    
    // Kiểm tra lỗi đầu vào trước khi chèn vào cơ sở dữ liệu
    if(empty($_SESSION['error'])){
        
        // Chuẩn bị câu lệnh Update
        $sql = "UPDATE slidelogo SET name='$name', type='$type', description='$description', url_image='$image_url', status='$status', position=$position WHERE id= $id";

        if (mysqli_query($conn, $sql)) {
            // Update thành công. Chuyển hướng đến trang đích
            unset($_SESSION['error']);
            $_SESSION['success'] = "Cập nhật thành công!";
            move_uploaded_file($_FILES["image_url"]["tmp_name"], $target_file);
            header("Location: quantri.php?page_layout=danhsachSLLG");
            exit();
        } else {
            echo "ERROR: Không thể thực thi $sql. " . mysqli_error($conn);
        }
        // Đóng kết nối
        mysqli_close($conn);
    }else{
        header("Location: quantri.php?page_layout=danhsachSLLG");
        exit();
    }
}else{
    header("Location: quantri.php?page_layout=danhsachSLLG");
    exit();
}