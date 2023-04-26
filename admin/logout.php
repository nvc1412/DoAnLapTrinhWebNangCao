<?php

if(isset($_SESSION['username'])){
    unset($_SESSION['username']);
}
if(isset($_COOKIE['username'])){
    unset($_COOKIE['username']);
    setcookie('username', null, -1, '/');
}
if(isset($_COOKIE['password'])){
    unset($_COOKIE['password']);
    setcookie('password', null, -1, '/');
}

header('Location: login.php');
exit();
?>