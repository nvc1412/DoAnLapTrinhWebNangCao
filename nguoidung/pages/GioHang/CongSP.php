<?php
$id =  trim($_GET["id"]);

if(isset($_SESSION['giohang'][$id])){
    $_SESSION['giohang'][$id] = $_SESSION['giohang'][$id] + 1;
}

// echo "<script> location.href = 'index.php?page_layout=GioHang'; </script>";
header('Location: index.php?page_layout=GioHang');
exit();

?>