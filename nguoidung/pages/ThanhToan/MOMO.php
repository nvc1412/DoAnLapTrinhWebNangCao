<?php


if(isset($_GET['message']) && $_GET['message'] == "Successful."){
    $id = $_SESSION['order_id'];
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