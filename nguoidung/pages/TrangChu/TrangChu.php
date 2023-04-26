<section>
    <div class="container">
        <div class="row">

            <div class="col-sm-12">
                <div class="features_items">
                    <!--features_items-->
                    <h2 class="title text-center">Sản Phẩm bán chạy</h2>
                    <?php foreach ($hot_product[0] as $key => $value) { 
                    $arr_danhgia = getCommentProduct($conn, $value);
                    ?>

                    <div class="col-sm-3">
                        <div class="product-hover product-image-wrapper">
                            <div style="" class="single-products">
                                <div class="productinfo text-center">
                                    <a style="display: block;"
                                        href="index.php?page_layout=ChiTietSanPham&id=<?= $value ?>"><img
                                            src="./assets/images/sanpham/<?= (explode(",", $hot_product[2][$key]))[0] ?>"
                                            alt="" /></a>
                                    <p style="margin-top: 10px">Mã sản phẩm: <?= $value ?></p>

                                    <p
                                        style="height: 40px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2;">
                                        <?= $hot_product[1][$key] ?></p>

                                    <?php 
                                    if($hot_product[5][$key] == 0){ ?>
                                    <a href="index.php?page_layout=ChiTietSanPham&id=<?= $value ?>">
                                        <h2 style="margin-top: 20px ; margin-bottom: 20px;">
                                            <?= number_format($hot_product[4][$key]). " VNĐ" ?>
                                        </h2>
                                    </a>
                                    <?php }else{ ?>

                                    <a href="index.php?page_layout=ChiTietSanPham&id=<?= $value ?>">
                                        <h2 style="margin-top: 10px; margin-bottom: 0px;">
                                            <?= number_format($hot_product[5][$key]). " VNĐ" ?>
                                        </h2>
                                    </a>

                                    <p>Giá gốc: <del><?= number_format($hot_product[4][$key]). " VNĐ" ?></del></p>

                                    <?php } ?>

                                    <p>
                                        <?php 
                                        $trungbinh_danhgia = 0;
                                        foreach ($arr_danhgia[0] as $key => $value_danhgia) {
                                            $trungbinh_danhgia += $arr_danhgia[2][$key];
                                        }
                                        $trungbinh_danhgia = ($trungbinh_danhgia==0) ? 0 : round($trungbinh_danhgia/count($arr_danhgia[0]));
                                        
                                        for($i = 1; $i <= 5; $i++) {
                                            if($i <= $trungbinh_danhgia){
                                                echo "<i style='color: #e3e317; margin: 0 2px;' class='fa fa-star'></i>";
                                            }else{
                                                echo "<i style='color: #e3e317; margin: 0 2px;' class='fa fa-star-o'></i>";
                                            }
                                        }
                                        ?>
                                        (<?= count($arr_danhgia[1]) ?>)</p>

                                    <a href="index.php?page_layout=ThemVaoGioHang&id=<?= $value ?>"
                                        class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào
                                        giỏ hàng</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                </div>
                <!--features_items-->


                <!-- Start Banner Area -->
                <div class="banner section">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="single-banner"
                                    style="background-image:url('assets/images/home/banner-3-bg.jpg')">
                                    <div class="content">
                                        <h2>Bếp âm BlueStone</h2>
                                        <p style="text-shadow: 1px 1px #fff;">Sản phẩm luôn hot nhất cửa hàng <br>trong
                                            những năm qua </p>
                                        <div class="button">
                                            <a href="index.php?page_layout=ChiTietSanPham&id=3" class="btn">Xem chi
                                                tiết</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="single-banner custom-responsive-margin"
                                    style="background-image:url('assets/images/home/banner-4-bg.jpg')">
                                    <div class="content">
                                        <h2>Sản phẩm chất lượng</h2>
                                        <p style="text-shadow: 1px 1px #fff;">Những sản phẩm luôn nằm trong<br> top cao
                                            của thị trường</p>
                                        <div class="button">
                                            <a href="index.php?page_layout=CuaHang" class="btn">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Banner Area -->


                <div class="features_items">
                    <!--New_items-->
                    <h2 class="title text-center">Sản Phẩm Mới Nhất</h2>
                    <?php foreach ($new_product[0] as $key => $value) { 
                    $arr_danhgia = getCommentProduct($conn, $value);
                    ?>

                    <div style="height: 500px;" class="col-sm-3">
                        <div class="product-hover product-image-wrapper">
                            <div style="" class="single-products">
                                <div class="productinfo text-center">
                                    <a style="display: block;"
                                        href="index.php?page_layout=ChiTietSanPham&id=<?= $value ?>"><img
                                            src="./assets/images/sanpham/<?= (explode(",", $new_product[2][$key]))[0] ?>"
                                            alt="" /></a>
                                    <p style="margin-top: 10px">Mã sản phẩm: <?= $value ?></p>

                                    <p
                                        style="height: 40px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2;">
                                        <?= $new_product[1][$key] ?></p>

                                    <?php 
                                    if($new_product[4][$key] == 0){ ?>
                                    <a href="index.php?page_layout=ChiTietSanPham&id=<?= $value ?>">
                                        <h2 style="margin-top: 20px; margin-bottom: 20px;">
                                            <?= number_format($new_product[3][$key]). " VNĐ" ?>
                                        </h2>
                                    </a>
                                    <?php }else{ ?>

                                    <a href="index.php?page_layout=ChiTietSanPham&id=<?= $value ?>">
                                        <h2 style="margin-top: 10px; margin-bottom: 0px;">
                                            <?= number_format($new_product[4][$key]). " VNĐ" ?>
                                        </h2>
                                    </a>

                                    <p>Giá gốc: <del><?= number_format($new_product[3][$key]). " VNĐ" ?></del></p>

                                    <?php } ?>

                                    <p>
                                        <?php 
                                        $trungbinh_danhgia = 0;
                                        foreach ($arr_danhgia[0] as $key => $value_danhgia) {
                                            $trungbinh_danhgia += $arr_danhgia[2][$key];
                                        }
                                        $trungbinh_danhgia = ($trungbinh_danhgia==0) ? 0 : round($trungbinh_danhgia/count($arr_danhgia[0]));
                                        
                                        for($i = 1; $i <= 5; $i++) {
                                            if($i <= $trungbinh_danhgia){
                                                echo "<i style='color: #e3e317; margin: 0 2px;' class='fa fa-star'></i>";
                                            }else{
                                                echo "<i style='color: #e3e317; margin: 0 2px;' class='fa fa-star-o'></i>";
                                            }
                                        }
                                        ?>
                                        (<?= count($arr_danhgia[1]) ?>)</p>

                                    <a href="index.php?page_layout=ThemVaoGioHang&id=<?= $value ?>"
                                        class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào
                                        giỏ hàng</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                </div>
                <!--New_items-->
            </div>
        </div>
    </div>
</section>

<!-- Start Shipping Info -->
<section class="shipping-info">
    <div class="container">
        <ul style="padding: 0;">
            <!-- Free Shipping -->
            <li>
                <div class="media-icon">
                    <i class="fa fa-truck"></i>
                </div>
                <div class="media-body">
                    <h5>Miễn phí vận chuyển</h5>
                    <span>Cho đơn hàng trên 500k.</span>
                </div>
            </li>
            <!-- Money Return -->
            <li>
                <div class="media-icon">
                    <i class="fa fa-comments-o"></i>
                </div>
                <div class="media-body">
                    <h5>Hỗ trợ 24/7</h5>
                    <span>Chat hoặc gọi trực tiếp.</span>
                </div>
            </li>
            <!-- Support 24/7 -->
            <li>
                <div class="media-icon">
                    <i class="fa fa-credit-card"></i>
                </div>
                <div class="media-body">
                    <h5>Thanh toán online</h5>
                    <span>Bảo mật an toàn.</span>
                </div>
            </li>
            <!-- Safe Payment -->
            <li>
                <div class="media-icon">
                    <i class="fa fa-refresh"></i>
                </div>
                <div class="media-body">
                    <h5>Đổi trả dễ dàng</h5>
                    <span>Thoải mái mua sắm.</span>
                </div>
            </li>
        </ul>
    </div>
</section>
<!-- End Shipping Info -->