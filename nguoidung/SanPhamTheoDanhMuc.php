<div class="col-sm-12">
    <div class="recommended_items">
        <!-- recommended_items -->
        <h2 class="title text-center">Sản phẩm cùng danh mục</h2>

        <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">

            <div class="carousel-inner">


                <?php
            $so_luong_anh = count($arr_recommended[0]);
            $so_luong_div = ceil($so_luong_anh / 4);

            for ($i = 0; $i < $so_luong_div; $i++) {
                echo '<div class="item';
                if ($i == 0) {
                    echo ' active';
                }
                echo '">';

                $j = 0;
                while ($j < 4 && $so_luong_anh > 0) { 
                    $arr_danhgia = getCommentProduct($conn, $arr_recommended[0][$i * 4 + $j]);
                    ?>
                <div class="col-sm-3">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">

                                <a
                                    href="index.php?page_layout=ChiTietSanPham&id=<?= $arr_recommended[0][$i * 4 + $j] ?>"><img
                                        src="./assets/images/sanpham/<?= (explode(",", $arr_recommended[2][$i * 4 + $j]))[0] ?>"
                                        alt="" /></a>

                                <p style="margin-top: 10px">Mã sản phẩm: <?=  $arr_recommended[0][$i * 4 + $j] ?>
                                </p>

                                <p
                                    style="height: 40px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2;">
                                    <?= $arr_recommended[1][$i * 4 + $j] ?></p>


                                <?php 
                                    if($arr_recommended[4][$i * 4 + $j] == 0){ ?>
                                <a
                                    href="index.php?page_layout=ChiTietSanPham&id=<?= $arr_recommended[0][$i * 4 + $j] ?>">
                                    <h2 style="margin-top: 20px ; margin-bottom: 20px;">
                                        <?= number_format($arr_recommended[3][$i * 4 + $j]). " VNĐ" ?>
                                    </h2>
                                </a>
                                <?php }else{ ?>

                                <a
                                    href="index.php?page_layout=ChiTietSanPham&id=<?= $arr_recommended[0][$i * 4 + $j] ?>">
                                    <h2 style="margin-top: 10px; margin-bottom: 0px;">
                                        <?= number_format($arr_recommended[4][$i * 4 + $j]). " VNĐ" ?>
                                    </h2>
                                </a>

                                <p>Giá gốc:
                                    <del><?= number_format($arr_recommended[3][$i * 4 + $j]). " VNĐ" ?></del>
                                </p>

                                <?php } ?>


                                <p>
                                    <?php 
                                        $trungbinh_danhgia = 0;
                                        foreach ($arr_danhgia[0] as $key => $value_danhgia) {
                                            $trungbinh_danhgia += $arr_danhgia[2][$key];
                                        }
                                        $trungbinh_danhgia = ($trungbinh_danhgia==0) ? 0 : round($trungbinh_danhgia/count($arr_danhgia[0]));
                                        
                                        for($k = 1; $k <= 5; $k++) {
                                            if($k <= $trungbinh_danhgia){
                                                echo "<i style='color: #e3e317; margin: 0 2px;' class='fa fa-star'></i>";
                                            }else{
                                                echo "<i style='color: #e3e317; margin: 0 2px;' class='fa fa-star-o'></i>";
                                            }
                                        }
                                        ?>
                                    (<?= count($arr_danhgia[1]) ?>)</p>




                                <a href="index.php?page_layout=ThemVaoGioHang&id=<?= $arr_recommended[0][$i * 4 + $j] ?>"
                                    class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm
                                    vào giỏ hàng</a>

                            </div>

                        </div>
                    </div>
                </div>
                <?php
                $j++;
                $so_luong_anh--;
                }

                echo '</div>';
                }
                ?>














            </div>
            <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
                <i class="fa fa-angle-left"></i>
            </a>
            <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
                <i class="fa fa-angle-right"></i>
            </a>
        </div>
    </div>
    <!--/recommended_items -->
</div>