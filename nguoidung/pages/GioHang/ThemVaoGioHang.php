<?php 
$id =  trim($_GET["id"]);

if(isset($_SESSION['giohang'][$id])){
    if(isset($_GET["sl"])){
        $_SESSION['giohang'][$id] = $_SESSION['giohang'][$id] + $_GET["sl"];
    }else{
        $_SESSION['giohang'][$id] = $_SESSION['giohang'][$id] + 1;
    }
}else{
    if(isset($_GET["sl"])){
        $_SESSION['giohang'][$id] = $_GET["sl"];
    }else{
        $_SESSION['giohang'][$id] = 1;
    }
}


// echo "<script> location.href = 'index.php?page_layout=GioHang'; </script>";
header('location: index.php?page_layout=GioHang');
exit();
?>