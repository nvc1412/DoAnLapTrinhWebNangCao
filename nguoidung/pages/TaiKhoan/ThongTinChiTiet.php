<?php


$user_id = "";
if(isset($_SESSION["logged"]) && $_SESSION["logged"] != 0){
    if(isset($_SESSION['userid'])){
        $user_id = $_SESSION['userid'];
    }else{
        header('Location: Error.php');
        exit();
    }
}else{
    header('Location: index.php?page_layout=DangNhap');
    exit();
}

// Kiểm tra sự tồn tại của tham số id trước khi xử lý
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Lấy tham số URL
    $id =  trim($_GET["id"]);

    $arr_detailOrder = [[], [], [], [], []];

    $sql = "SELECT chitietdonhang.id, sanpham.name, sanpham.image_url, chitietdonhang.quantity, chitietdonhang.price 
    FROM (chitietdonhang JOIN sanpham ON chitietdonhang.product_id = sanpham.id) JOIN donhang ON chitietdonhang.order_id = donhang.id 
        WHERE donhang.user_id = $user_id AND chitietdonhang.order_id = $id ORDER BY chitietdonhang.id DESC";

    if($result = mysqli_query($conn, $sql)){
        //Đổ dữ liệu tài khoản
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_array($result)){
                array_push($arr_detailOrder[0], $row["id"]);
                array_push($arr_detailOrder[1], $row["name"]);
                array_push($arr_detailOrder[2], $row["image_url"]);
                array_push($arr_detailOrder[3], $row["quantity"]);
                array_push($arr_detailOrder[4], $row["price"]);
            }
            // Giải phóng bộ nhớ
            mysqli_free_result($result);
        } else{
            echo "<p class='lead'><em>Không tìm thấy bản ghi.</em></p>";
        }
    } else{
        echo "ERROR: Không thể thực thi $sql. " . mysqli_error($conn);
    }

    // Đóng kết nối
    mysqli_close($conn);
}  else{
    // URL không chứa tham số id. Chuyển hướng đến trang error
    header("location: Error.php");
    exit();
}

?>


<section style="margin: 30px 0;" id="form">
    <!--form-->
    <div class="container">
        <div class="row">

            <div class="col-sm-12">
                <h2 class="">Chi tiết đơn hàng</h2>
                <div class="table-responsive cart_info">
                    <table class='table table-bordered table-striped'>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Hình ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($arr_detailOrder[0] as $key => $value) { ?>
                            <form action="quantri.php?page_layout=suaCTDH" method="post">
                                <tr>
                                    <td><?= $value?> <input type="hidden" name="id_detail" value="<?= $value?>"></td>
                                    <td><img class="mb-1"
                                            src="../nguoidung/assets/images/sanpham/<?= (explode(",", $arr_detailOrder[2][$key]))[0]?>"
                                            width="50" height="50">
                                    </td>
                                    <td><?= $arr_detailOrder[1][$key]?></td>
                                    <td><?= $arr_detailOrder[3][$key]?></td>
                                    <td><?= number_format($arr_detailOrder[4][$key]). " VNĐ" ?></td>
                                </tr>
                            </form>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>