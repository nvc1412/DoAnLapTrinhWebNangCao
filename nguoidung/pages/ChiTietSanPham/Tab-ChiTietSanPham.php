<div class="category-tab shop-details-tab">
    <!--category-tab-->
    <div class="col-sm-12">
        <ul class="nav nav-tabs">
            <li><a href="#details" data-toggle="tab">Mô tả</a></li>
            <li class="active"><a href="#reviews" data-toggle="tab">Đánh giá (<?= count($arr_comment[1]) ?>)</a></li>
        </ul>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade" id="details">
            <p><?= $arr_product[6]?></p>
        </div>

        <div class="tab-pane fade active in" id="reviews">
            <div class="col-sm-12">

                <?php if(count($arr_comment[1])==0){echo"<p style='color: #fa2727'>Chưa có bình luận nào!</p>";}?>

                <?php foreach ($arr_comment[0] as $key => $value) { ?>
                <div style="margin-bottom: 10px; padding: 10px; border: 1px solid #caa51f;">
                    <ul>
                        <li><a href="#"><i class="fa fa-user"></i><?= $arr_comment[1][$key] ?></a></li>
                        <li><a href="#"><i
                                    class="fa fa-clock-o"></i><?= date('H:i:s A', strtotime($arr_comment[4][$key])) ?></a>
                        </li>
                        <li><a href="#"><i
                                    class="fa fa-calendar-o"></i><?= strtoupper(date('d M Y', strtotime($arr_comment[4][$key]))) ?></a>
                        </li>
                        <br />
                        <li>
                            <?php
                            for($i = 1; $i <= 5; $i++) {
                                if($i <= $arr_comment[2][$key]){
                                    echo "<i style='color: #e3e317; margin: 0 2px;' class='fa fa-star'></i>";
                                }else{
                                    echo "<i style='color: #e3e317; margin: 0 2px;' class='fa fa-star-o'></i>";
                                }
                            }
                            ?>
                        </li>
                    </ul>
                    <p><?= $arr_comment[3][$key] ?></p>
                </div>
                <?php } ?>

                <p><b>Viết đánh giá của bạn</b></p>

                <form action="index.php?page_layout=DanhGia" method="post">
                    <span>
                        <input disabled type="text"
                            value="<?= (isset($_SESSION['username']) ? $_SESSION['username'] : "") ?>"
                            placeholder="Tên" />
                        <input disabled type="email"
                            value="<?= (isset($_SESSION['email']) ? $_SESSION['email'] : "") ?>" placeholder="Email" />
                    </span>
                    <textarea required name="comment" placeholder="Nội dung..."></textarea>
                    <b>Rating: </b>
                    <?php 
                    for($i = 1; $i <= 5; $i++){
                        echo "<i id='star' style='color: #e3e317; margin: 0 2px;' class='fa fa-star-o'></i>";
                    }
                    ?>

                    <input name="rate" id="rate" type="hidden" value="" />
                    <input name="id_product" type="hidden" value="<?= $arr_product[0]?>" />

                    <input id="submit-comment" type="hidden" class="btn btn-default pull-right" value="Gửi đánh giá" />
                </form>
            </div>
        </div>
    </div>
</div>