<div id="contact-page" class="container">
    <div class="bg">
        <div class="row">
            <div class="col-sm-12">
                <h2 class="title text-center">Liên hệ với <strong>chúng tôi</strong></h2>
                <div id="googleMap" class="contact-map">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3617.652315543923!2d105.78418759368584!3d21.046382252561823!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135abb158a2305d%3A0x5c357d21c785ea3d!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyDEkGnhu4duIEzhu7Fj!5e0!3m2!1svi!2s!4v1678289609824!5m2!1svi!2s"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <div class="contact-form">
                    <h2 class="title text-center">Nội dung</h2>
                    <div class="status alert alert-success" style="display: none"></div>
                    <form action="index.php?page_layout=GuiMail" id="main-contact-form" class="contact-form row"
                        name="contact-form" method="post">
                        <div class="form-group col-md-6">
                            <input disabled type="text" name="username" class="form-control"
                                value="<?= (isset($_SESSION['username']) ? $_SESSION['username'] : "") ?>"
                                placeholder="Tên" />
                        </div>
                        <div class="form-group col-md-6">
                            <input disabled type="email" name="email" class="form-control"
                                value="<?= (isset($_SESSION['email']) ? $_SESSION['email'] : "") ?>"
                                placeholder="Email" />
                        </div>
                        <div class="form-group col-md-12">
                            <textarea required name="message" id="message" class="form-control" rows="8"
                                placeholder="Tin nhắn của bạn"></textarea>
                        </div>
                        <div class="form-group col-md-12">
                            <input type="submit" name="submit" class="btn btn-primary pull-right" value="Gửi">
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="contact-info">
                    <h2 class="title text-center">Địa chỉ nhận thư</h2>
                    <address>
                        <p>HouseHaven Shop Inc.</p>
                        <p>235 Hoàng Quốc Việt, Cổ Nhuế, Bắc Từ Liêm,</p>
                        <p>Hà Nội, Việt Nam</p>
                        <p>Hotline: +84 365 042 941</p>
                        <p>Email: nvc14122002@gmail.com</p>
                    </address>
                    <div class="social-networks">
                        <h2 class="title text-center">Mạng xã hội</h2>
                        <ul>
                            <li>
                                <a target="_blank" href="https://www.facebook.com/profile.php?id=100087528094253"><i
                                        class="fa fa-facebook"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                            </li>
                            <li>
                                <a target="_blank" href="https://www.youtube.com/channel/UCu_KokLnFiSEMNJntWUu7jg"><i
                                        class="fa fa-youtube"></i></a>
                            </li>
                            <li>
                                <a target="_blank" href="https://github.com/nvc1412"><i class="fa fa-github"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <?php include_once("SanPhamDeXuat.php");?>

        </div>
    </div>
</div>
<!--/#contact-page-->