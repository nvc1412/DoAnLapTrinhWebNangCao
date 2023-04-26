<footer id="footer">
    <!--Footer-->
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-sm-2">
                    <div class="companyinfo">
                        <h2><span style="color: #200158;font-weight: bold;">HouseHaven</span></h2>
                        <p>Top những sản phẩm bán chạy</p>
                    </div>
                </div>
                <div class="col-sm-7">

                    <?php foreach ($hot_product[0] as $key => $value) { ?>
                    <?php if($key <= 3) { ?>
                    <div class="col-sm-3">
                        <div style="margin-top: 20px;" class="video-gallery text-center">
                            <a href="index.php?page_layout=ChiTietSanPham&id=<?= $value?>">
                                <div style="height: 100%;" class="iframe-img">
                                    <img src="./assets/images/sanpham/<?= (explode(",", $hot_product[2][$key]))[0]?>"
                                        alt="" />
                                </div>
                            </a>
                        </div>
                    </div>
                    <?php } } ?>

                </div>
                <div class="col-sm-3">
                    <div class="address">
                        <img src="./assets/images/home/map.png" alt="" />
                        <p>235 Hoàng Quốc Việt, Cổ Nhuế, Bắc Từ Liêm, Hà Nội</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-widget">
        <div class="container">
            <div class="row">
                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>Danh mục</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="#">Nồi cơm điện</a></li>
                            <li><a href="#">Bếp gas</a></li>
                            <li><a href="#">Bếp từ</a></li>
                            <li><a href="#">Xoong, nồi</a></li>
                            <li><a href="#">Chảo</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>Hỗ trợ</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="index.php?page_layout=HoTro">Hướng dẫn đặt hàng</a></li>
                            <li><a href="index.php?page_layout=HoTro">Chính sách bảo mật</a></li>
                            <li><a href="index.php?page_layout=HoTro">Chính sách vận chuyển</a></li>
                            <li><a href="index.php?page_layout=HoTro">Hình thức thanh toán</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-4 info-store">
                    <div class="single-widget">
                        <h2>Thông tin cửa hàng</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="index.php?page_layout=LienHe">Địa chỉ: 235 Hoàng Quốc Việt, Bắc Từ Liêm, Hà
                                    Nội</a></li>
                            <li><a href="tel:0365042941">Hotline: 0365042941</a></li>
                            <li><a href="mailto:nvc14122002@gmail.com">Email: nvc14122002@gmail.com</a></li>
                            <li><a target="_blank"
                                    href="https://www.facebook.com/profile.php?id=100087528094253">Facebook:
                                    facebook.com/HouseHaven</a></li>
                            <li><a href="#">Copyright</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3 col-sm-offset-1">
                    <div class="single-widget">
                        <h2>Đăng ký nhận tin</h2>
                        <form action="#" class="searchform">
                            <input type="text" placeholder="Email" />
                            <button type="submit" class="btn btn-default"><i
                                    class="fa fa-arrow-circle-o-right"></i></button>
                            <p>Đăng ký nhận tin để nhận những thông tin mới nhất về chúng tôi...</p>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <p class="pull-left">Copyright © 2023 HouseHaven Shop Inc. All rights reserved.</p>
                <p class="pull-right">Designed by <span><a target="_blank"
                            href="http://www.themeum.com">Themeum</a></span></p>
            </div>
        </div>
    </div>

</footer>
<!--/Footer-->



<script src="./assets/js/jquery.js"></script>
<script src="./assets/js/bootstrap.min.js"></script>
<script src="./assets/js/jquery.scrollUp.min.js"></script>
<script src="./assets/js/price-range.js"></script>
<script src="./assets/js/jquery.prettyPhoto.js"></script>
<script src="./assets/js/main.js"></script>
</body>

<!-- 
Messenger Plugin chat Code
<div id="fb-root"></div>

Your Plugin chat code
<div id="fb-customer-chat" class="fb-customerchat">
</div>

<script>
var chatbox = document.getElementById('fb-customer-chat');
chatbox.setAttribute("page_id", "104709355784320");
chatbox.setAttribute("attribution", "biz_inbox");
</script>

Your SDK code
<script>
window.fbAsyncInit = function() {
    FB.init({
        xfbml: true,
        version: 'v16.0'
    });
};

(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s);
    js.id = id;
    js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
 -->

</html>