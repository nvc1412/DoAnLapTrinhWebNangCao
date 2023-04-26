<?php
 
// Xác định các biến và khởi tạo với các giá trị trống
$username = $phone = $address = $note = $status = "";
$total = 0;
$username_err = $phone_err = $address_err = $note_err = $status_err = $total_err = "";

// Xử lý dữ liệu biểu mẫu khi biểu mẫu được gửi
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Lấy dữ liệu đầu vào
    $id = $_POST["id"];
    
    // Xác thực ghi chú
    if(empty(trim($_POST["note"]))){
        $note = "";     
    } else{
        $note = trim($_POST["note"]);
    }
    
    // Xác thực trạng thái đơn hàng
    if(empty(trim($_POST["status"]))){
        $status_err = "* Vui lòng chọn trạng thái đơn hàng."; 
    } else{
        $status = trim($_POST["status"]);
    }
    
    // Kiểm tra lỗi đầu vào trước khi chèn vào cơ sở dữ liệu
    if(empty($note_err) && empty($status_err)){

        $sql = "UPDATE donhang SET note='$note', status='$status' WHERE id=$id";
        
        if (mysqli_query($conn, $sql)) {
            echo "<script> location.href = 'quantri.php?page_layout=danhsachDH'; </script>";
            exit();
        } else {
            echo "ERROR: Không thể thực thi $sql. " . mysqli_error($conn);
        }
        // Đóng kết nối
        mysqli_close($conn);
    }
    
} else{
    // Kiểm tra sự tồn tại của tham số id trước khi xử lý
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Lấy tham số URL
        $id =  trim($_GET["id"]);

        $arr_detailOrder = getAllDetailOrder($conn, $id);
        // echo"<pre>";
        // print_r($arr_detailOrder);
        // die();

        $sql = "SELECT donhang.id, taikhoan.username, taikhoan.phone, taikhoan.address, donhang.note, donhang.total, donhang.status
                FROM taikhoan
                JOIN donhang ON taikhoan.id = donhang.user_id WHERE donhang.id=$id;";

        if($result = mysqli_query($conn, $sql)){
            //Đổ dữ liệu tài khoản
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_array($result)){
                    $id = $row[0];
                    $username = $row[1];
                    $phone = $row[2];
                    $address = $row[3];
                    $note = $row[4];
                    $total = $row[5];
                    $status = $row[6];
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
        header("location: error.php");
        exit();
    }
}
?>




<!-- <div style="" class="wrapper"> -->
<!-- <div class="container-fluid"> -->
<div style="display: flex;">
    <form style="display: flex; flex: 1; flex-direction: column;" method="post">
        <div class="page-header" style="display: flex; align-items: baseline;">
            <h2 style="flex: 1;">Cập nhật đơn hàng</h2>
        </div>
        <br />
        <div style="display: flex;">
            <div style="flex: 0; margin-right: 20px">
                <div class="form-group" class="mb-3">
                    <lable>Tên khách hàng: </lable>
                    <input style="float: right;" type="text" name="username" value="<?= $username; ?>" disabled />
                </div>
                <div class="form-group" class="mb-3">
                    <lable>Số điện thoại: </lable>
                    <input style="float: right;" type="text" name="phone" value="<?= $phone; ?>" disabled />
                </div>
                <div class="form-group" class="mb-3">
                    <lable>Địa chỉ: </lable>
                    <input style="float: right;" type="text" name="address" value="<?= $address; ?>" disabled />
                </div>
                <div class="form-group" class="mb-3">
                    <lable>Tổng tiền: </lable>
                    <input style="float: right;" type="text" name="total" value="<?= number_format($total). " VNĐ"; ?>"
                        disabled />
                </div>
                <div class="form-group">
                    <label>Trạng thái đơn hàng:</label>
                    <select style="float: right;" name="status" id="status">
                        <?php foreach (['Chờ thanh toán','Chờ xử lý','Đang vận chuyển','Thành công','Thất bại','Hủy'] as $value) { ?>
                        <option <?php echo ($status==$value) ? "selected" : "" ?> value="<?= $value?>">
                            <?= $value?></option>;
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Ghi chú:</label>
                    <textarea id="note" name="note" rows="5" cols="35"><?= $note; ?></textarea>
                </div>
            </div>
        </div>
        <div>
            <input type="hidden" name="id" value="<?= $id; ?>" />
            <input name="submit" type="submit" class="btn btn-primary" value="Cập Nhật">
            <a href="quantri.php?page_layout=danhsachDH" class="btn btn-success">Cancel</a>
        </div>
    </form>

    <div style="display: flex; flex: 4; flex-direction: column;">
        <div style="display: flex;justify-content: space-evenly;align-items: baseline;">
            <h2>Chi tiết đơn hàng</h2>
            <!-- <a href="quantri.php?page_layout=themCTDH&id=<?= $id?>" class="btn btn-success pull-right mb-4">+
                        Thêm</a> -->
        </div>
        <br />
        <div style="flex: 1">
            <table class='table table-bordered table-striped'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Hành động</th>
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
                            <td>
                                <input style="width: 60px" type="number" name="quantity"
                                    value="<?= $arr_detailOrder[3][$key]?>" min=1>
                            </td>
                            <td><?= number_format($arr_detailOrder[4][$key]). " VNĐ" ?></td>
                            <td>
                                <input type="hidden" name="id_order" value="<?= $id; ?>" />
                                <input style="border: none;background: none;" class='btn-sua material-icons'
                                    name="submit" type="submit" value="save" />
                                <a style='display: contents;' data-toggle='tooltip'
                                    href='quantri.php?page_layout=xoaCTDH&id_detail=<?= $value?>&id_order=<?= $id?>'>
                                    <i title='Xóa sản phẩm khỏi đơn hàng' class='btn-xoa material-icons'>delete</i>
                                </a>
                            </td>
                        </tr>
                    </form>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
<!-- </div> -->