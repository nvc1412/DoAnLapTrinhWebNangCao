<?php

$product_id = $user_id = $rating = $comment = "";

if(!isset($_SESSION["logged"]) || $_SESSION["logged"] == 0){
    // echo "<script> location.href = 'index.php?page_layout=DangNhap'; </script>";
    header('Location: index.php?page_layout=DangNhap');
    exit();
}

if(isset($_SESSION['userid']) && isset($_POST['id_product']) && isset($_POST['comment']) ){

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
            if(isset($_POST['rate']) && $_POST['rate'] != 0){
                $product_id = $_POST['id_product'];
                $user_id = $_SESSION['userid'];
                $rating = $_POST['rate'];
                $comment = $_POST['comment'];
                $sql = "INSERT INTO danhgiasanpham(product_id, user_id, rating, comment) VALUES ($product_id, $user_id, $rating, '$comment')";
                if (mysqli_query($conn, $sql)) {
                    // echo "<script> location.href = 'index.php?page_layout=ChiTietSanPham&id=".$_POST['id_product']."'; </script>";
                    header('Location: index.php?page_layout=ChiTietSanPham&id='.$_POST["id_product"].'');
                    exit();
                } else {
                    echo "ERROR: Không thể thực thi $sql. " . mysqli_error($conn);
                }
                mysqli_close($conn);
            }else{
                // echo "<script> location.href = 'index.php?page_layout=ChiTietSanPham&id=".$_POST['id_product']."'; </script>";
                header('Location: index.php?page_layout=ChiTietSanPham&id='.$_POST["id_product"].'');
                exit();
            }
        }
    } else {
        header('Location: Error.php');
        exit();
    }




    

}else{
    // echo "<script> location.href = 'Error.php'; </script>";
    header('Location: Error.php');
    exit();
}


?>