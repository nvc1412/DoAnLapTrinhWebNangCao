<?php
session_start();
require_once("./includes/config.php");
require_once("./includes/functions.php");
$logo = getLogoWeb($conn);
$_SESSION["logged"] = 0;
$username = "";
$password = "";
$errorMsg = "";

if(isset($_COOKIE['username']) && isset($_COOKIE['password'])){
    $username = $_COOKIE['username'];
    $password = $_COOKIE['password'];
    $sql = "SELECT * FROM taikhoan WHERE (username='$username' OR email='$username') AND password='$password'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) == 1){
        $rows = mysqli_fetch_array($result);
        if($rows["is_admin"]==1){
            $_SESSION['username'] = $rows["username"];
            $_SESSION["logged"] = 1;
            setcookie("username", $username, time() + (5 * 60), '/', '', 0, 0);
            setcookie("password", $password, time() + (5 * 60), '/', '', 0, 0);
            header('Location: quantri.php');
            exit();
        }else{
            $errorMsg = "Tài khoản không có quyền truy cập!";
        }
    } else {
        $errorMsg = "Tên đăng nhập hoặc mật khẩu không đúng!";
    }
    mysqli_close($conn);
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $action = $_POST['action'];

    $sql = "SELECT * FROM taikhoan WHERE (username='$username' OR email='$username') AND password='$password'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) == 1) {
        $rows = mysqli_fetch_array($result);
        if($rows["is_admin"]==1){
            $_SESSION['username'] = $rows["username"];
            $_SESSION["logged"] = 1;

            if(isset($_POST['remember'])){
                setcookie("username", $username, time() + (5 * 60), '/', '', 0, 0);
                setcookie("password", $password, time() + (5 * 60), '/', '', 0, 0);
            }
            
            header('Location: quantri.php');
            exit();
        }else{
            $errorMsg = "Tài khoản không có quyền truy cập!";
            $password = $_POST['password'];
        }
    } else {
        $errorMsg = "Tên đăng nhập hoặc mật khẩu không đúng!";
        $password = $_POST['password'];
    }
}

mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>HOUSEHAVEN ADMIN</title>

    <link rel="icon" href="../nguoidung/assets/images/slide/<?= $logo ?>" type="image/x-icon">

    <!-- Custom fonts for this template-->
    <link href="./assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="./assets/css/sb-admin-2.min.css" rel="stylesheet">
    <script src="./assets/js/showPassword.js" language="javascript"></script>

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">
                <?php if ($errorMsg != "") { ?>
                <div style="margin-top: 20px; margin-bottom: -20px;" class="alert alert-danger" id="login-err-msg">
                    <?= $errorMsg ?>
                </div>
                <?php } ?>
                <div class="card o-hidden border-0 shadow-lg my-5">

                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row pt-5 pb-5">
                            <div style="background-image: url('./assets/img/logo_login.png'); background-position: center; background-size: cover;"
                                class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 style="color: #fe6882;font-weight: bold;" class="h3 mb-4">HouseHaven Admin
                                        </h1>
                                    </div>
                                    <form action="" class="user" method="post">
                                        <div class="form-group">
                                            <input type="text" name="username" id="username"
                                                class="form-control form-control-user" required
                                                placeholder="Email hoặc username" value="<?= $username ?>">
                                        </div>
                                        <div style="display: flex; justify-content: flex-end; align-items: center;"
                                            class="form-group">
                                            <input type="password" name="password" id="password"
                                                class="form-control form-control-user" required placeholder="Password"
                                                value="<?= $password ?>">
                                            <i id="show" onclick="showPass('password', 'show')"
                                                style="position: absolute; margin-right: 20px; color: green;"
                                                class="fas fa-eye-slash"></i>
                                        </div>
                                        <div class="form-group">
                                            <div class="ml-2 custom-control custom-checkbox small">
                                                <input name="remember" type="checkbox" class="custom-control-input"
                                                    id="remember">
                                                <label class="custom-control-label" for="remember">Nhớ mật
                                                    khẩu</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" id="action" name="action" value="login" />
                                            <input type="submit" name="submit"
                                                class="btn btn-primary btn-user btn-block" value="Đăng Nhập">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="./assets/vendor/jquery/jquery.min.js"></script>
    <script src="./assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="./assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="./assets/js/sb-admin-2.min.js"></script>

</body>

</html>