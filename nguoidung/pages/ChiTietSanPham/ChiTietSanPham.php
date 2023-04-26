<?php
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    $arr_product = getDetailProduct($conn, $_GET["id"]);
    $arr_comment = getCommentProduct($conn, $arr_product[0]);
    $arr_img = explode(",", $arr_product[2]);

    $arr_recommended = getProductRecommendedCategory($conn, $arr_product[3]);
    
}else{
    // URL không chứa tham số id. Chuyển hướng đến trang error
    // echo "<script> location.href = 'Error.php'; </script>";
    header('Location: Error.php');
    exit();
}
?>
<section>
    <div class="container">
        <div class="row">

            <?php include_once("Menu-Bar.php");?>

            <div class="col-sm-9 padding-right">
                <div class="product-details">
                    <!--product-details-->
                    <div class="col-sm-5">
                        <div class="view-product">
                            <img src="./assets/images/sanpham/<?= $arr_img[0]?>" alt="" />
                        </div>

                        <div id="similar-product" class="carousel slide" data-ride="carousel">

                            <!-- Wrapper for slides -->
                            <div class="carousel-inner">

                                <?php
                                    $so_luong_anh = count($arr_img);
                                    $so_luong_div = ceil($so_luong_anh / 3);

                                    for ($i = 0; $i < $so_luong_div; $i++) {
                                        echo '<div class="item';
                                        if ($i == 0) {
                                            echo ' active';
                                        }
                                        echo '">';

                                        $j = 0;
                                        while ($j < 3 && $so_luong_anh > 0) {
                                            echo '<div style="display: contents;"><img width="85px" height="84px" src="./assets/images/sanpham/' . $arr_img[$i * 3 + $j] . '" alt=""></div>';
                                            $j++;
                                            $so_luong_anh--;
                                        }
                                        echo '</div>';
                                    }
                                ?>


                            </div>

                            <!-- Controls -->
                            <a class="left item-control" href="#similar-product" data-slide="prev">
                                <i class="fa fa-angle-left"></i>
                            </a>
                            <a class="right item-control" href="#similar-product" data-slide="next">
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </div>

                    </div>

                    <script>
                    const imgElements = document.querySelectorAll('.carousel-inner div img');
                    const viewProductImg = document.querySelector('.view-product img');
                    imgElements.forEach(img => {
                        img.addEventListener('click', () => {
                            viewProductImg.src = img.src;
                        });
                    });
                    </script>

                    <div class="col-sm-7">
                        <div class="product-information">
                            <!--/product-information-->
                            <img src="./assets/images/home/new.jpg" class="newarrival" alt="" />
                            <h2><?= $arr_product[1]?></h2>
                            <p>Mã sản phẩm: <?= $arr_product[0]?></p>

                            <?php 
                            $trungbinh_danhgia = 0;
                            foreach ($arr_comment[0] as $key => $value) {
                                $trungbinh_danhgia += $arr_comment[2][$key];
                            }
                            $trungbinh_danhgia = ($trungbinh_danhgia==0) ? 0 : round($trungbinh_danhgia/count($arr_comment[0]));
                            
                            for($i = 1; $i <= 5; $i++) {
                                if($i <= $trungbinh_danhgia){
                                    echo "<i style='color: #e3e317; margin: 0 2px;' class='fa fa-star'></i>";
                                }else{
                                    echo "<i style='color: #e3e317; margin: 0 2px;' class='fa fa-star-o'></i>";
                                }
                            }
                            ?>

                            <span style="width: 100%;">

                                <?php 
                                    if($arr_product[8] == 0){ ?>
                                <span><?= number_format($arr_product[5]). " VNĐ"?></span>
                                <?php }else{ ?>
                                <span><?= number_format($arr_product[8]). " VNĐ"?></span>
                                <?php } ?>

                                <label>Số lượng:</label>
                                <input id="quantity_order_detail" oninput="updateHref(<?= $arr_product[0]?>)"
                                    type="number" value="1" min="1" />
                            </span>

                            <?php 
                                    if($arr_product[8] != 0){ ?>
                            <p style="margin-bottom: 25px;">Giá gốc:
                                <del><?= number_format($arr_product[5]). " VNĐ" ?></del>
                            </p>

                            <?php }?>

                            <a id="buyLink" href="index.php?page_layout=ThemVaoGioHang&id=<?= $arr_product[0]?>&sl=1"
                                style="margin-left: 0;" type="button" class="btn btn-fefault cart">
                                <i class="fa fa-shopping-cart"></i>
                                Thêm vào giỏ hàng
                            </a>
                            <p><b>Tình trạng:</b> Còn hàng (<?= $arr_product[7]?>)</p>
                            <p><b>Danh mục:</b> <?= $arr_product[3]?></p>
                            <p><b>Thương hiệu:</b><img style="margin-left: 10px; margin-top: -3px;" width="80"
                                    height="30" src="./assets/images/logo/<?= $arr_product[4]?>.png" alt="" />
                            </p>
                        </div>
                        <!--/product-information-->
                    </div>
                </div>
                <!--/product-details-->



                <?php include_once("Tab-ChiTietSanPham.php");?>

            </div>
            <?php include_once("SanPhamTheoDanhMuc.php");?>

        </div>
    </div>
</section>