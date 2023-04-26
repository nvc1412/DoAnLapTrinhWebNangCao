<?php 
 
 if(isset($_SESSION['order_id']) && $_SESSION['username'] && $_SESSION['order_user_name'] && $_SESSION['order_phone'] && $_SESSION['order_email'] && $_SESSION['order_address'] && $_SESSION['order_payment'] && $_SESSION['order_total'] ){
 
?>
<div style="text-align: center">
    <h1 style="color: #26bd0f;">Đặt hàng thành công!</h1>
    <h3>Thông tin đơn hàng: </h3>
    <div>

        <p>Mã hóa đơn: <?= $_SESSION['order_id']?></p>
        <p>Tài khoản đặt hàng: <?= $_SESSION['username']?></p>
        <p>Tên khách hàng: <?= $_SESSION['order_user_name']?></p>
        <p>Số điện thoại: <?= $_SESSION['order_phone']?></p>
        <p>Email: <?= $_SESSION['order_email']?></p>
        <p>Địa chỉ: <?= $_SESSION['order_address']?></p>
        <p>Hình thức thanh toán: <?= $_SESSION['order_payment']?></p>
        <p>Tổng tiền thanh toán: <?= number_format($_SESSION['order_total']). " VNĐ"?></p>
        <p>Thời gian tạo: <?= date("d/m/Y H:i:s")?></p>

    </div>
    <h3>Cảm ơn quý khách hàng đã sử dụng dịch vụ của chúng tôi!<br>
        Đơn hàng sẽ được xác nhận và vận chuyển trong vòng 2-5 ngày
    </h3>
    <h4>Mọi hỗ trợ xin vui lòng liên hệ:</h4>
    <h4>Hotline:<a href="tel:+84 365 042 941"> +84 365 042 941</a></h4>
    <h4>Email: <a href="mailto:nvc14122002@gmail.com"> nvc14122002@gmail.com</a></h4>
</div>

<?php 

$noidung = "<div style='text-align: center'>
<h1 style='color: #26bd0f;'>Đặt hàng thành công!</h1>
<h3>Thông tin đơn hàng: </h3>
<div>
    <p>Mã hóa đơn: ".$_SESSION['order_id']."</p>
    <p>Tài khoản đặt hàng: ".$_SESSION['username']."</p>
    <p>Tên khách hàng: ".$_SESSION['order_user_name']."</p>
    <p>Số điện thoại: ". $_SESSION['order_phone']."</p>
    <p>Email: ".$_SESSION['order_email']."</p>
    <p>Địa chỉ: ".$_SESSION['order_address']."</p>
    <p>Hình thức thanh toán: ".$_SESSION['order_payment']."</p>
    <p>Tổng tiền thanh toán: ".number_format($_SESSION['order_total']). " VNĐ</p>
    <p>Thời gian tạo: ".date("d/m/Y H:i:s")."</p>
</div>
<h3>Cảm ơn quý khách hàng đã sử dụng dịch vụ của chúng tôi!<br>
    Đơn hàng sẽ được xác nhận và vận chuyển trong vòng 2-5 ngày
</h3>
<h4>Mọi hỗ trợ xin vui lòng liên hệ:</h4>
<h4>Hotline:<a href='tel:+84 365 042 941'> +84 365 042 941</a></h4>
<h4>Email: <a href='mailto:nvc14122002@gmail.com'> nvc14122002@gmail.com</a></h4>
</div>";

// $noidung="Dat hang thanh cong!";

$mail = new Mailer();
$mail->thanhtoanmail($_SESSION["order_email"], $_SESSION["order_user_name"], $noidung);

 unset($_SESSION["order_id"]);
 unset($_SESSION["order_user_name"]);
 unset($_SESSION["order_phone"]);
 unset($_SESSION["order_email"]);
 unset($_SESSION["order_address"]);
 unset($_SESSION["order_payment"]);
 unset($_SESSION["order_total"]);


}else{
    // echo "<script> location.href = 'index.php'; </script>";
    header('Location: index.php');
    exit();
}
?>