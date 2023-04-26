<?php
if(isset($_GET["id"])){
    $id =  trim($_GET["id"]);

    if($id == 0){
        unset($_SESSION["giohang"]);
    }
    else{
        unset($_SESSION['giohang'][$id]);
        if($_SESSION["giohang"]==null){
            unset($_SESSION["giohang"]);
        }
    }
}

// echo "<script> location.href = 'index.php?page_layout=GioHang'; </script>";
header('Location: index.php?page_layout=GioHang');
exit();

?>