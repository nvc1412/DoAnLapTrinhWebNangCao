<?php

// Kiểm tra sự tồn tại của tham số id
if(isset($_POST["id_order"]) && !empty($_POST["id_order"]) && isset($_POST["id_detail"]) && !empty($_POST["id_detail"]) && isset($_POST["quantity"]) && !empty($_POST["quantity"]) ){
    $id_detail =  trim($_POST["id_detail"]);
    $id_order = trim($_POST["id_order"]);
    $quantity = trim($_POST["quantity"]);

    $sql = "UPDATE chitietdonhang SET quantity=$quantity WHERE id=$id_detail AND order_id=$id_order";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script> location.href = 'quantri.php?page_layout=suaDH&id=$id_order'; </script>";
        exit();
    } else {
        echo "ERROR: Không thể thực thi $sql. " . mysqli_error($conn);
    }
    // Đóng kết nối
    mysqli_close($conn);

}else{
    // URL không chứa tham số id. Chuyển hướng đén trang error
    echo "<script> location.href = 'quantri.php?page_layout=Loi' </script>";
    exit();
}