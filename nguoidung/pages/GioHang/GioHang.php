<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a style="position: relative;" href="#">Trang chủ</a></li>
                <li class="active">Giỏ hàng</li>
            </ol>
        </div>
        <div class="table-responsive cart_info">
            <?php if(isset($_SESSION['giohang'])){ 
                
                
                $arrID = [];
                foreach($_SESSION['giohang'] as $id=>$soluong){
                    $arrID[] = $id;
                }
                
                $strID = implode(',', $arrID);
                $sql = "SELECT * FROM sanpham WHERE id IN($strID) ORDER BY id DESC";
                $query = mysqli_query($conn, $sql);
            ?>



            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Hình ảnh</td>
                        <td>Tên sản phẩm</td>
                        <td class="price">Giá</td>
                        <td class="quantity">Số Lượng</td>
                        <td class="total">Thành Tiền</td>
                        <td></td>
                    </tr>
                </thead>

                <?php
                    $tongtien = 0;
                    while($row = mysqli_fetch_array($query)){

                        if($row['discount'] == 0){
                            $thanhtien = $row['price']*$_SESSION['giohang'][$row['id']];
                        }else{
                            $thanhtien = $row['discount']*$_SESSION['giohang'][$row['id']];
                        }

                        $tongtien+=$thanhtien;
                    
                ?>

                <tbody>
                    <tr>
                        <td class="image">
                            <a href="index.php?page_layout=ChiTietSanPham&id=<?= $row["id"] ?>"><img width="110px"
                                    height="110px"
                                    src="./assets/images/sanpham/<?= (explode(",", $row["image_url"]))[0]?>" alt=""></a>
                        </td>
                        <td>
                            <h4><a
                                    href="index.php?page_layout=ChiTietSanPham&id=<?= $row["id"] ?>"><?= $row["name"] ?></a>
                            </h4>
                            <p>Mã sản phẩm: <?= $row["id"] ?></p>
                        </td>
                        <td class="cart_price">
                            <?php
                                if($row['discount'] == 0){ ?>
                            <p><?= number_format($row["price"]). " VNĐ" ?></p>
                            <?php }else{ ?>
                            <p><?= number_format($row["discount"]). " VNĐ" ?></p>
                            <?php } ?>


                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                <a class="cart_quantity_up" href="index.php?page_layout=CongSP&id=<?= $row['id']?>"> +
                                </a>
                                <input class="cart_quantity_input" type="text" name="quantity"
                                    value="<?= $_SESSION['giohang'][$row['id']] ?>" autocomplete="off" size="2" min="1"
                                    inputmode="numeric">
                                <a class="cart_quantity_down" href="index.php?page_layout=TruSP&id=<?= $row['id']?>"> -
                                </a>
                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price"><?= number_format($thanhtien). " VNĐ" ?></p>
                        </td>
                        <td>
                            <a style="color: red;" class="cart_quantity_delete"
                                href="index.php?page_layout=XoaSP&id=<?= $row['id']?>"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

            <?php }else{ ?>

            <!-- Nếu không có sản phẩm -->
            <div class="panel-body">
                <div class="text-center">
                    <img src="./assets/images/home/giohangrong.png" alt="">
                    <h4 style="color:red">Không có sản phẩm trong giỏ hàng</h4>
                    <a href="index.php?page_layout=CuaHang" class="btn btn-warning">Mua sắm</a>
                </div>
            </div>

            <?php } ?>

        </div>
    </div>
</section>
<!--/#cart_items-->

<?php if(isset($_SESSION['giohang'])){ ?>
<section id="do_action">
    <div class="container">
        <div class="heading">
            <h3>Bạn có mã giảm giá?</h3>
            <p>Nhập mã giảm giá của bạn để áp dụng cho đơn hàng này.</p>
        </div>
        <div class="row">
            <div class="col-sm-5">
                <div class="chose_area">
                    <ul class="user_info">
                        <li class="single_field zip-field">
                            <label>Nhập mã tại đây:</label>
                            <input style="border: 1px solid#c5c532;" type="text">
                        </li>
                    </ul>
                    <a class="btn btn-default update" href="">Áp dụng</a>
                </div>
            </div>
            <div class="col-sm-7">
                <div class="total_area">
                    <ul>
                        <li>Tổng tiền hàng <span><?= number_format($tongtien). " VNĐ" ?></span></li>
                        <li>Mã giảm giá <span>0 VNĐ</span></li>
                        <li>Phí ship <span>0 VNĐ</span></li>
                        <li>Tổng tiền thanh toán <span><?= number_format($tongtien). " VNĐ" ?></span></li>
                    </ul>
                    <!-- <a class="btn btn-default update" href="">Cập nhật giỏ hàng</a> -->
                    <a class="btn btn-default update" href="index.php?page_layout=KiemTraDangNhap">Thanh toán</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/#do_action-->
<?php }?>