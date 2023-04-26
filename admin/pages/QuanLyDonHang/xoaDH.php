<?php

// Quy trình xóa bản ghi sau khi đã xác nhận
if(isset($_POST["id"]) && !empty($_POST["id"])){
    
    // Lấy dữ liệu đầu vào
    $id = $_POST["id"];
    
    // Chuẩn bị câu lệnh delete
    $sql = "DELETE FROM donhang WHERE id = $id";
    
    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = "Xóa thành công!";
        header("Location: quantri.php?page_layout=danhsachDH");
        exit();
    } else {
        echo "Có lỗi xảy ra! ". mysqli_error($conn);
    }
    // Đóng kết nối
    mysqli_close($conn);
} else{
    // Kiểm tra sự tồn tại của tham số id
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        $id =  trim($_GET["id"]);
    }else{
        // URL không chứa tham số id. Chuyển hướng đén trang error
        header("location: error.php");
        exit();
    }
}
?>

<div class="row">
    <div style="width: 500px; margin: 0 auto;" class="wrapper">
        <div class="col-md-12">
            <div style="color: red;" class="page-header">
                <h1>Xóa đơn hàng</h1>
            </div>
            <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                <div class="alert alert-danger">
                    <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>" />
                    <p>Bạn có chắc muốn xóa đơn hàng này?</p><br>
                    <p>
                        <input type="submit" value="Yes" class="btn btn-danger">
                        <a href="quantri.php?page_layout=danhsachDH" class="btn btn-success">No</a>
                    </p>
                </div>
                <input type="hidden" name="id" value="<?php echo $id; ?>" />
            </form>
        </div>
    </div>
</div>
</div>