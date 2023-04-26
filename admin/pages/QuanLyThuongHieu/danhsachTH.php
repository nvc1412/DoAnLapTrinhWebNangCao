<?php

    if (isset($_SESSION['error'])) {
        // Hiển thị thông tin lỗi lên trang web
        $lines = explode("* ", $_SESSION['error']);
        $error = "";
        foreach ($lines as $line) {
            if (!empty($line)) {
                $error .= "* " . trim($line) . "<br>";
            }
        }
        echo "<div class='alert alert-danger'>$error</div>";
        // Xóa thông tin lỗi ra khỏi biến session
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
        echo "<div style='text-align: center;' class='alert alert-success'><h4 class='alert-heading'>".$_SESSION['success']."</h4></div>";
        // Xóa thông tin lỗi ra khỏi biến session
        unset($_SESSION['success']);
    }

    $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
    $rowsPerPage = 10;
    $perRow = $page*$rowsPerPage-$rowsPerPage;
    
    // Số trang muốn hiển thị
    $so_trang_hien_thi = 5;

    // Tính toán vị trí trang đầu tiên cần hiển thị
    $offset = max(1, $page - (int)($so_trang_hien_thi / 2));
?>

<!-- <div class="wrapper">
    <div class="container-fluid"> -->
<div class="row">
    <div class="col-md-12">

        <div style=" color: green;" class="page-header clearfix">
            <h2>Thêm thương hiệu</h2>
        </div>

        <table class='table table-bordered table-striped'>
            <thead>
                <tr>
                    <th>Tên thương hiệu</th>
                    <th>Mô tả</th>
                    <th style="width: 10%;">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <form action="quantri.php?page_layout=themTH" method="post">
                        <td><input required type='text' name='name' class='form-control'
                                value='<?php if(isset($_SESSION['them_name'])){echo $_SESSION['them_name']; unset($_SESSION['them_name']);}else{echo "";}?>'>
                        </td>
                        <td><input required type='text' name='description' class='form-control'
                                value='<?php if(isset($_SESSION['them_description'])){echo $_SESSION['them_description']; unset($_SESSION['them_description']);}else{echo "";}?>'>
                        </td>
                        <td><input type='submit' name='submit' class='btn btn-success' value='Thêm'></td>
                    </form>
                </tr>
            </tbody>
        </table>

        <div style="color: orange;" class="page-header clearfix">
            <h2>Danh sách thương hiệu</h2>
        </div>

        <?php

                // Cố gắng thực thi truy vấn
                $sql = "SELECT * FROM thuonghieu ORDER BY id DESC LIMIT $perRow, $rowsPerPage";
                if($result = mysqli_query($conn, $sql)){

                    //Phân trang
                    $tongthuonghieu = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM thuonghieu"));
                    $tongsotrang = ceil($tongthuonghieu/$rowsPerPage);

                    // $listPage="";
                    // for($i=1; $i<=$tongsotrang; $i++){
                    //     if($page==$i){
                    //         $listPage.='<a class="active" href="quantri.php?page_layout=danhsachTH&page='.$i.'">'.$i.'</a>';
                    //     }else{
                    //         $listPage.='<a href="quantri.php?page_layout=danhsachTH&page='.$i.'">'.$i.'</a>';
                    //     }
                    // }

                    //Đổ dữ liệu tài khoản
                    if(mysqli_num_rows($result) > 0){
                        echo "<table class='table table-bordered table-striped'>";
                            echo "<thead>";
                                echo "<tr>";
                                    echo "<th>ID</th>";
                                    echo "<th>Tên thương hiệu</th>";
                                    echo "<th>Mô tả</th>";
                                    echo "<th>Thời gian tạo</th>";
                                    echo "<th>Hành động</th>";
                                echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            while($row = mysqli_fetch_array($result)){
                                echo "<tr>";
                                    echo "<form action='quantri.php?page_layout=suaTH' method='post'>";
                                    echo "<td>" . $row['id'] . "<input required type='hidden' name='id' value='".$row['id']."'></td>";
                                    echo "<td><input required type='text' name='name' class='form-control' value='".$row['name']."'><input required type='hidden' name='name_test' value='".$row['name']."'></td>";
                                    echo "<td><input required type='text' name='description' class='form-control' value='".$row['description']."'></td>";
                                    echo "<td>" . date('d-m-Y H:i:s', strtotime($row['created_at'])) . "</td>";
                                    echo "<td>";
                                        echo "<input title='Cập nhật' style='border: none;background: none;' type='submit' name='submit' class='btn-sua material-icons' value='save'>";
                                        // echo "<a style='display: contents;' data-toggle='tooltip' href='quantri.php?page_layout=suaTH&id=". $row['id'] ."'> <i title='Sửa danh mục' class='btn-sua material-icons'>edit</i> </a>";
                                        echo "<a style='display: contents;' data-toggle='tooltip' href='quantri.php?page_layout=xoaTH&id=". $row['id'] ."'> <i title='Xóa thương hiệu' class='btn-xoa material-icons'>delete</i> </a>";
                                    echo "</td>";
                                    echo "</form>";
                                echo "</tr>";
                            }
                            echo "</tbody>";                            
                        echo "</table>";
                        // Giải phóng bộ nhớ
                        mysqli_free_result($result);
                    } else{
                        echo "<p class='lead'><em>Không tìm thấy bản ghi.</em></p>";
                    }
                } else{
                    echo "ERROR: Không thể thực thi $sql. " . mysqli_error($conn);
                }

                // Đóng kết nối
                mysqli_close($conn);
                ?>
    </div>
</div>

<!-- <div class="pagination">
    <?php echo $listPage ?>
</div> -->

<ul class="pagination">
    <?php
    if($page<=$tongsotrang  && $page != 1){
        echo"<li><a href='quantri.php?page_layout=danhsachTH&page=".($page-1)."'>&laquo;</a></li>";
    }
                              
    for($i = $offset; $i <= min($offset + $so_trang_hien_thi - 1, $tongsotrang); $i++){ ?>
    <li><a <?= ($page==$i) ? "class='active'" : "" ?>
            href='quantri.php?page_layout=danhsachTH&page=<?= $i?>'><?= $i?></a></li>
    <?php }

    if($page>=1 && $page != $tongsotrang){
        echo"<li><a href='quantri.php?page_layout=danhsachTH&page=".($page+1)."'>&raquo;</a></li>";
    }

?>

</ul>
<!-- <?php echo $listPage ?> -->

</div>
<!-- </div> -->