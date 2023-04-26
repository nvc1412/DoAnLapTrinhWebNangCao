<?php

if(isset($_SESSION["logged"]) && $_SESSION["logged"] != 0){

    $id = $_SESSION['userid'];

    $sql = "SELECT * FROM taikhoan WHERE id=$id";
    
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) == 1) {
        $rows = mysqli_fetch_array($result);
        if($rows["status"] == 1){
            echo "Tài khoản này đang bị khóa!!";
            header('Location: index.php?page_layout=DangXuat');
            exit();
        }else{
            header('Location: index.php?page_layout=ThanhToan');
            exit();
        }
    } else {
        header('Location: Error.php');
        exit();
    }
    mysqli_close($conn);
}else{
    // echo "<script> location.href = 'index.php?page_layout=DangNhap'; </script>";
    header('Location: index.php?page_layout=DangNhap');
    exit();
}

?>