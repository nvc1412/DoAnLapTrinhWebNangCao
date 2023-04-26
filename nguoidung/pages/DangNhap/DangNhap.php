<?php
$_SESSION["logged"] = 0;
$username = "";
$password = "";
$errorMsg1 = "";

$username_signup = $email = $phone = $password_signup = $password_again = $password_new = "";
$errorMsg2 = "";

$dangkythanhcong = "";

$RegexFomatPhone = "/^0[3|5|7|8|9]\d{8}$/";


if(isset($_COOKIE['username']) && isset($_COOKIE['password'])){
    $username = $_COOKIE['username'];
    $password = $_COOKIE['password'];
    $sql = "SELECT * FROM taikhoan WHERE (username='$username' OR email='$username') AND password='$password'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) == 1){
        $rows = mysqli_fetch_array($result);
        if($rows["status"] == 1){
            $errorMsg1 = "Tài khoản này đang bị khóa!!";
            $password = $_POST['password'];
        }else{
            $_SESSION['userid'] = $rows["id"];
            $_SESSION['username'] = $rows["username"];
            $_SESSION['email'] = $rows["email"];
            $_SESSION['phone'] = $rows["phone"];
            $_SESSION['address'] = $rows["address"];
            $_SESSION["logged"] = 1;

            setcookie("username", $username, time() + (5 * 60), '/', '', 0, 0);
            setcookie("password", $password, time() + (5 * 60), '/', '', 0, 0);

            header("Location: index.php");
            exit();
        }
    } else {
        $errorMsg1 = "Tên đăng nhập hoặc mật khẩu không đúng!";
        $password = $_POST['password'];
    }
    mysqli_close($conn);
}


if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM taikhoan WHERE (username='$username' OR email='$username') AND password='$password'";
    
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) == 1) {
        $rows = mysqli_fetch_array($result);
        if($rows["status"] == 1){
            $errorMsg1 = "Tài khoản này đang bị khóa!!";
            $password = $_POST['password'];
        }else{
            $_SESSION['userid'] = $rows["id"];
            $_SESSION['username'] = $rows["username"];
            $_SESSION['email'] = $rows["email"];
            $_SESSION['phone'] = $rows["phone"];
            $_SESSION['address'] = $rows["address"];
            $_SESSION["logged"] = 1;

            if(isset($_POST['remember'])){
                
                setcookie("username", $username, time() + (5 * 60), '/', '', 0, 0);
                setcookie("password", $password, time() + (5 * 60), '/', '', 0, 0);
            }

            header("Location: index.php");
            exit();
        }
    } else {
        $errorMsg1 = "Tên đăng nhập hoặc mật khẩu không đúng!";
        $password = $_POST['password'];
    }
    mysqli_close($conn);
}

if (isset($_POST['submit-signup'])) {
    $username_signup = trim($_POST["username_signup"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $password_signup = trim($_POST["password_signup"]);
    $password_again = trim($_POST["password_again"]);
    if(checkUsername($conn, $username_signup) > 0){
        $errorMsg2 = "Username đã được đăng ký!";
    }else if(checkEmail($conn, $email) > 0){
        $errorMsg2 = "Email đã được đăng ký!";
    }else if(!preg_match($RegexFomatPhone, $phone)){
        $errorMsg2 = "Số điện thoại không hợp lệ!";
    }else if(checkPhone($conn, $phone) > 0){
        $errorMsg2 = "Số điện thoại đã được đăng ký!";
    }else if($password_signup != $password_again){
        $errorMsg2 = "Mật khẩu xác nhận không khớp!";
    }else{
        // Kiểm tra lỗi đầu vào trước khi chèn vào cơ sở dữ liệu
        if(empty($errorMsg2)){
            $password_new = md5($password_again);
            $sql = "INSERT INTO taikhoan (username, email, phone, password) VALUES ('$username_signup', '$email', '$phone', '$password_new')";
            if (mysqli_query($conn, $sql)) {
                $dangkythanhcong = "Đăng ký thành công!";
                $username_signup = "";
                $email = "";
                $phone = "";
                $password_signup = "";
                $password_again = "";
            } else {
                echo "ERROR: Không thể thực thi $sql. " . mysqli_error($conn);
            }
            // Đóng kết nối
            mysqli_close($conn);
        }
    }    
}


?>


<section style="margin: 30px 0;" id="form">
    <!--form-->
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-1">
                <div class="login-form">
                    <!--login form-->
                    <h2>Đăng nhập vào tài khoản của bạn</h2>
                    <h5><?= (isset($errorMsg1)) ? $errorMsg1 : "" ?></h5>
                    <form action="" method="post">
                        <input name="username" value="<?= (isset($username)) ? $username : "" ?>" type="text"
                            placeholder="Email hoặc Username" required />
                        <div class="input-password">
                            <input name="password" value="<?= (isset($password)) ? $password : "" ?>" id="pass-login"
                                type="password" placeholder="Mật khẩu" required />
                            <i onclick="showPass('pass-login','icon-pass-login')" id="icon-pass-login"
                                class="fa fa-eye-slash"></i>
                        </div>
                        <span>
                            <input type="checkbox" class="checkbox" name="remember" id="remember">
                            <label style="font-weight: normal;" class="custom-control-label" for="remember">Nhớ mật
                                khẩu</label>
                            <!-- Nhớ mật khẩu -->
                        </span>
                        <button name="submit" type="submit" class="btn btn-default">Đăng nhập</button>
                    </form>
                </div>
                <!--/login form-->
            </div>
            <div class="col-sm-1">
                <h2 class="or">Hoặc</h2>
            </div>
            <div class="col-sm-4">
                <div class="signup-form">
                    <!--sign up form-->
                    <h2>Tạo tài khoản mới</h2>
                    <h5><?= (isset($errorMsg2)) ? $errorMsg2 : "" ?></h5>
                    <h4><?= (isset($dangkythanhcong)) ? $dangkythanhcong : "" ?></h4>
                    <form action="" method="post">
                        <input name="username_signup" value="<?= (isset($username_signup)) ? $username_signup : "" ?>"
                            type="text" placeholder="Username" required />
                        <input name="email" value="<?= (isset($email)) ? $email : "" ?>" type="email"
                            placeholder="Email" required />
                        <input name="phone" value="<?= (isset($phone)) ? $phone : "" ?>" type="tel"
                            placeholder="Số điện thoại" required />
                        <div class="input-password">
                            <input name="password_signup"
                                value="<?= (isset($password_signup)) ? $password_signup : "" ?>" id="pass-signup"
                                type="password" placeholder="Mật khẩu" required />
                            <i onclick="showPass('pass-signup','icon-pass-signup')" id="icon-pass-signup"
                                class="fa fa-eye-slash"></i>
                        </div>
                        <div class="input-password">
                            <input name="password_again" value="<?= (isset($password_again)) ? $password_again : "" ?>"
                                id="pass-signup-again" type="password" placeholder="Nhập lại mật khẩu" required />
                            <i onclick="showPass('pass-signup-again','icon-pass-signup-again')"
                                id="icon-pass-signup-again" class="fa fa-eye-slash"></i>
                        </div>
                        <button name="submit-signup" type="submit" class="btn btn-default">Đăng ký</button>
                    </form>
                </div>
                <!--/sign up form-->
            </div>
        </div>
    </div>
</section>
<!--/form-->