<?php

if(isset($_GET['vnp_TransactionStatus']) && isset($_GET['vnp_TxnRef']) && $_GET['vnp_TransactionStatus'] == 00){
    $id = $_GET['vnp_TxnRef'];
    $sql = "UPDATE donhang SET status = 'Chờ xử lý' WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        // echo "<script> location.href = 'index.php?page_layout=ThanhCong'; </script>";
        header('Location: index.php?page_layout=ThanhCong');
        exit();
    }else {
        echo "ERROR: Không thể thực thi $sql. " . mysqli_error($conn);
    }
    mysqli_close($conn);

}else{
    // echo "<script> location.href = 'index.php?page_layout=ThanhCong'; </script>";
    header('Location: index.php?page_layout=ThanhCong');
    exit();
}



?>