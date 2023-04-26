<?php
if(isset($_SESSION["logged"]) && $_SESSION["logged"] != 0){
    
    $id = $_SESSION['userid'];

    $sql = "SELECT * FROM taikhoan WHERE id=$id";
    
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) == 1) {
        $rows = mysqli_fetch_array($result);
        if($rows["status"] == 1){
            echo "Tài khoản này đang bị khóa!!";
            header('Location: index.php?page_layout=DangXuat');
            exit();
        }else{
            if(isset($_GET["status"]) && $_GET["status"] == "thanhcong"){
                echo '<div style="text-align: center">
                <h1 style="color: #26bd0f;">Cảm ơn bạn đã liên hệ với chúng tôi!</h1>
                <h3>Tin nhắn đã được gửi đi! </h3>
                <h4>Chúng tôi sẽ phản hồi trong thời gian sớm nhất!</h4>
                <h4>Mọi hỗ trợ xin vui lòng liên hệ:</h4>
                <h4>Hotline:<a href="tel:+84 365 042 941"> +84 365 042 941</a></h4>
                <h4>Email: <a href="mailto:nvc14122002@gmail.com"> nvc14122002@gmail.com</a></h4>
            </div>';
            }else if(isset($_POST["message"])){
                $mail = new Mailer();
                $mail->lienhemail($_SESSION["email"], $_SESSION["username"], $_POST["message"]);
            }else{
                // echo "<script> location.href = 'index.php?page_layout=LienHe'; </script>";
                header('Location: index.php?page_layout=LienHe');
                exit();
            }
        }
    } else {
        header('Location: Error.php');
        exit();
    }

    
}else{
    // echo "<script> location.href = 'index.php?page_layout=DangNhap'; </script>";
    header('Location: index.php?page_layout=DangNhap');
    exit();
}
?>