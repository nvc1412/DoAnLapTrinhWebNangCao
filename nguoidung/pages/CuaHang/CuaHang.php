<?php
    $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
    $rowsPerPage = 9;
    $perRow = $page*$rowsPerPage-$rowsPerPage;

    $sql = "SELECT id, name, image_url, price, discount FROM sanpham ORDER BY id DESC LIMIT $perRow, $rowsPerPage";

    if($result = mysqli_query($conn, $sql)){

        //Phân trang
        $tongsanpham = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM sanpham"));
        $tongsotrang = ceil($tongsanpham/$rowsPerPage);
?>



<section id="advertisement">
    <div class="container">
        <img src="./assets/images/home/advertisement.jpg" alt="" />
    </div>
</section>

<section>
    <div class="container">
        <div class="row">

            <?php include_once("Menu-Bar.php");?>

            <div class="col-sm-9 padding-right">




                <div class="features_items">
                    <!--features_items-->
                    <h2 class="title text-center">Tất cả sản phẩm</h2>

                    <?php
                        if(mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_array($result)){ 
                                $arr_danhgia = getCommentProduct($conn, $row['id']);
                                ?>
                    <div style="height: 500px;" class="col-sm-4">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">

                                    <a style="display: block;"
                                        href="index.php?page_layout=ChiTietSanPham&id=<?= $row['id']?>"><img
                                            src="./assets/images/sanpham/<?= (explode(",", $row['image_url']))[0] ?>"
                                            alt="" /></a>
                                    <p style="margin-top: 10px">Mã sản phẩm: <?= $row['id']?></p>

                                    <p
                                        style="height: 40px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2;">
                                        <?= $row['name'] ?></p>

                                    <?php 
                                    if($row['discount'] == 0){ ?>
                                    <a href="index.php?page_layout=ChiTietSanPham&id=<?= $row['id']?>">
                                        <h2 style="margin-top: 20px ; margin-bottom: 20px;">
                                            <?= number_format($row['price']). " VNĐ" ?>
                                        </h2>
                                    </a>
                                    <?php }else{ ?>

                                    <a href="index.php?page_layout=ChiTietSanPham&id=<?= $row['id']?>">
                                        <h2 style="margin-top: 10px; margin-bottom: 0px;">
                                            <?= number_format($row['discount']). " VNĐ" ?>
                                        </h2>
                                    </a>

                                    <p>Giá gốc: <del><?= number_format($row['price']). " VNĐ" ?></del></p>

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

                                    <a href="index.php?page_layout=ThemVaoGioHang&id=<?= $row['id']?>"
                                        class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào
                                        giỏ hàng</a>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <!--features_items-->

                <ul class="pagination">
                    <?php

                    if($page<=$tongsotrang  && $page != 1){
                        echo"<li><a href='index.php?page_layout=CuaHang&page=".($page-1)."'>&laquo;</a></li>";
                    }
                              
                    for($i=1; $i<=$tongsotrang; $i++){ ?>
                    <li <?= ($page==$i) ? "class='active'" : "" ?>><a
                            href='index.php?page_layout=CuaHang&page=<?= $i?>'><?= $i?></a></li>
                    <?php }

                    if($page>=1 && $page != $tongsotrang){
                        echo"<li><a href='index.php?page_layout=CuaHang&page=".($page+1)."'>&raquo;</a></li>";
                    }

                    ?>

                </ul>

                <?php
                    
                } else{
                    echo "<p class='lead'><em>Không tìm thấy bản ghi.</em></p>";
                }

    } else{
        echo "ERROR: Không thể thực thi $sql. " . mysqli_error($conn);
    }

    // Đóng kết nối
    mysqli_close($conn);
?>

            </div>
        </div>
    </div>
</section>