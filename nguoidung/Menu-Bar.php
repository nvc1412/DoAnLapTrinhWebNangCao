<div class="col-sm-3">
    <div class="left-sidebar">
        <h2>Danh Mục</h2>
        <div class="panel-group category-products" id="accordian">
            <!--category-productsr-->

            <?php foreach ($category[0] as $key => $value) { ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title"><a
                            href="index.php?page_layout=TimKiemTheoDanhMuc&search=<?= $value?>&name=<?= $category[1][$key]?>"><?= $category[1][$key]?></a>
                    </h4>
                </div>
            </div>
            <?php } ?>

        </div>
        <!--/category-products-->

        <div class="brands_products">
            <!--brands_products-->
            <h2>Thương hiệu</h2>

            <div class="brands-name">
                <?php foreach ($brand[0] as $key => $value) { ?>
                <ul class="nav nav-pills nav-stacked">
                    <li><a
                            href="index.php?page_layout=TimKiemTheoThuongHieu&search=<?= $value?>&name=<?= $brand[1][$key]?>">
                            <span
                                class="pull-right">(<?= getQuantityProductOfBrand($conn, $value)?>)</span><?= $brand[1][$key]?></a>
                    </li>
                </ul>
                <?php } ?>
            </div>


        </div>
        <!--/brands_products-->

        <?php 
        $min_max_price = getMinMaxPrice($conn);
        ?>
        <div class="price-range">
            <!--price-range-->
            <h2>Giá</h2>
            <form action="index.php?page_layout=LocGia" method="post">
                <div class="well text-center">
                    <input name="price" type="text" class="span2" data-slider-min="<?= $min_max_price[0]?>"
                        data-slider-max="<?= $min_max_price[1]?>" data-slider-step="100000"
                        data-slider-value="[<?= (isset($min)) ? $min : $min_max_price[0]?>,<?= (isset($max)) ? $max : $min_max_price[1]?>]"
                        id="sl2"><br />
                    <b class="pull-left"><?= number_format($min_max_price[0]). " VNĐ" ?></b> <b
                        class="pull-right"><?= number_format($min_max_price[1]). " VNĐ" ?></b>
                </div>
                <input name="submit" type="submit" class="btn btn-primary " value="Lọc giá" />
            </form>
        </div>
        <!--/price-range-->

        <div class="shipping text-center">
            <!--shipping-->
            <img src="./assets/images/home/shipping.jpg" alt="" />
        </div>
        <!--/shipping-->

    </div>
</div>