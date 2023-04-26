<?php

// Quy trình xóa bản ghi sau khi đã xác nhận
if(isset($_POST["id_detail"]) && !empty($_POST["id_detail"]) && isset($_POST["id_order"]) && !empty($_POST["id_order"])){
    
    // Lấy dữ liệu đầu vào
    $id_detail = $_POST["id_detail"];
    $id_order = $_POST["id_order"];
    
    // Chuẩn bị câu lệnh delete
    $sql = "DELETE FROM chitietdonhang WHERE id = $id_detail AND order_id=$id_order ";
    
    if (mysqli_query($conn, $sql)) {
        // echo "<script> location.href = 'quantri.php?page_layout=suaDH&id=$id_order'; </script>";
        header("Location: quantri.php?page_layout=suaDH&id=$id_order");
        exit();
    } else {
        echo "Có lỗi xảy ra! ". mysqli_error($conn);
    }
    // Đóng kết nối
    mysqli_close($conn);
} else{
    // Kiểm tra sự tồn tại của tham số id
    if(isset($_GET["id_detail"]) && isset($_GET["id_order"]) && !empty(trim($_GET["id_detail"])) && !empty(trim($_GET["id_order"]))){
        $id_detail =  trim($_GET["id_detail"]);
        $id_order = trim($_GET["id_order"]);
    }else{
        // URL không chứa tham số id. Chuyển hướng đén trang error
        header("Location: error.php");
        exit();
    }
}
?>

<div class="row">
    <div style="width: 500px; margin: 0 auto;" class="wrapper">
        <div class="col-md-12">
            <div style="color: red;" class="page-header">
                <h1>Xóa sản phẩm này khỏi đơn hàng</h1>
            </div>
            <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                <div class="alert alert-danger">
                    <p>Bạn có chắc muốn xóa ?</p><br>
                    <p>
                        <input type="submit" value="Yes" class="btn btn-danger">
                        <a href="quantri.php?page_layout=suaDH&id=<?= $id_order?>" class="btn btn-success">No</a>
                    </p>
                </div>
                <input type="hidden" name="id_detail" value="<?php echo $id_detail; ?>" />
                <input type="hidden" name="id_order" value="<?php echo $id_order; ?>" />
            </form>
        </div>
    </div>
</div>
</div>