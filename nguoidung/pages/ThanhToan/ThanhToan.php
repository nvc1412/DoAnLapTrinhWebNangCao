<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a style="position: relative;" href="#">Trang chủ</a></li>
                <li class="active">Thanh toán</li>
            </ol>
        </div>
        <!--/breadcrums-->

        <div class="review-payment">
            <h2>Xác nhận đơn hàng và thanh toán</h2>
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
                    </tr>
                </thead>



                <tbody>
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
                                <input class="cart_quantity_input" readonly type="text" name="quantity"
                                    value="<?= $_SESSION['giohang'][$row['id']] ?>" autocomplete="off" size="2">
                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price"><?= number_format($thanhtien). " VNĐ" ?></p>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="4">&nbsp;</td>
                        <td colspan="2">
                            <table class="table table-condensed total-result">
                                <tr>
                                    <td>Tổng tiền hàng</td>
                                    <td><?= number_format($tongtien). " VNĐ" ?></td>
                                </tr>
                                <tr>
                                    <td>Mã giảm giá</td>
                                    <td>0 VNĐ</td>
                                </tr>
                                <tr class="shipping-cost">
                                    <td>Phí ship</td>
                                    <td>0 VNĐ</td>
                                </tr>
                                <tr>
                                    <td>Tổng tiền thanh toán</td>
                                    <td><span><?= number_format($tongtien). " VNĐ" ?></span></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>

            </table>
            <?php } ?>
        </div>

        <div class="shopper-informations">
            <div class="row">
                <form action="index.php?page_layout=XuLyThanhToan" method="post">
                    <div class="col-sm-8 clearfix">
                        <div class="bill-to">
                            <p>Thông tin đơn hàng</p>
                            <div class="form-one">
                                <div>
                                    <input name="user_name"
                                        value="<?= (isset($_SESSION['username']) ? $_SESSION['username'] : "") ?>"
                                        required type="text" placeholder="* Tên người nhận">
                                    <input name="phone"
                                        value="<?= (isset($_SESSION['phone']) ? $_SESSION['phone'] : "") ?>" required
                                        type="text" placeholder="* Số điện thoại">
                                    <input name="email"
                                        value="<?= (isset($_SESSION['email']) ? $_SESSION['email'] : "") ?>" required
                                        type="email" placeholder="* Email">
                                    <input name="address"
                                        value="<?= (isset($_SESSION['address']) ? $_SESSION['address'] : "") ?>"
                                        required type="text" placeholder="* Địa chỉ (số nhà, ngõ, đường,...)">
                                </div>
                            </div>
                            <div class="form-two">
                                <div>
                                    <select name="payment" style="height: 40px;" required>
                                        <option value="">-- Hình thức thanh toán --</option>
                                        <option value="COD">Thanh toán khi nhận hàng (COD)</option>
                                        <option value="MOMO">Thanh toán online qua cổng MOMO</option>
                                        <option value="VNPAY">Thanh toán online qua cổng VNPAY</option>
                                    </select>
                                    <input name="total" type="hidden" value="<?= $tongtien?>" />
                                    <input name="redirect" type="hidden" value="" />
                                </div>
                                <div style="text-align: center;">
                                    <img src="./assets/images/logo/VNPAY.png" alt="">
                                    <img src="./assets/images/logo/MOMO.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="order-message">
                            <p>Ghi chú</p>
                            <textarea style="height: 191px;" name="note" placeholder="ghi chú đơn hàng" rows="16"
                                required></textarea>
                        </div>
                    </div>
                    <input value="Xác nhận" type="submit" style="margin: 0 0 30px 15px;" class="btn btn-primary">
                </form>
            </div>
        </div>

    </div>
</section>
<!--/#cart_items-->