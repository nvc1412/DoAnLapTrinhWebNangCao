<?php
unset($_SESSION['logged']);
unset($_SESSION['userid']);
unset($_SESSION['username']);
unset($_SESSION['email']);
unset($_SESSION['phone']);
unset($_SESSION['address']);
if(isset($_COOKIE['username'])){
    unset($_COOKIE['username']);
    setcookie('username', null, -1, '/');
}
if(isset($_COOKIE['password'])){
    unset($_COOKIE['password']);
    setcookie('password', null, -1, '/');
}
header("Location: index.php");
exit();

?>