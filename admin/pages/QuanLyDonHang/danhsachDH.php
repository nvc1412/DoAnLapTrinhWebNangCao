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
    $rowsPerPage = (isset($_GET['rowsPerPage'])) ? $_GET['rowsPerPage'] : 10;
    $perRow = $page*$rowsPerPage-$rowsPerPage;
    
    // Số trang muốn hiển thị
    $so_trang_hien_thi = 5;

    // Tính toán vị trí trang đầu tiên cần hiển thị
    $offset = max(1, $page - (int)($so_trang_hien_thi / 2));

    $loc = (isset($_GET['loc'])) ? $_GET['loc'] : 0;

    $search = (isset($_GET['search'])) ? $_GET['search'] : "";
?>
<div class="row">
    <div class="col-md-12">

        <div style="display: flex;justify-content: space-between; align-items: center;" class="page-header clearfix">
            <div>
                <h2 style="color: orange;">Danh sách đơn hàng</h2>
            </div>
            <div>

                <label for="rowsPerPage">Số hàng/trang:</label>
                <select style="border-color: gray; border-radius: 0.35rem;" id="rowsPerPage" name="rowsPerPage"
                    onchange="updateRowsPerPage()">

                    <option <?= ($rowsPerPage == 10) ? "selected" : "" ?> value="10">10</option>
                    <option <?= ($rowsPerPage == 20) ? "selected" : "" ?> value="20">20</option>
                    <option <?= ($rowsPerPage == 50) ? "selected" : "" ?> value="50">50</option>
                    <option <?= ($rowsPerPage == 100) ? "selected" : "" ?> value="100">100</option>

                </select>

                <script>
                function updateRowsPerPage() {
                    const select = document.getElementById("rowsPerPage");
                    location.href =
                        `quantri.php?page_layout=danhsachDH&rowsPerPage=${select.value}&loc=<?= $loc ?><?= ($search != "") ? "&search=".$search : ""?>`;
                }
                </script>

            </div>
            <div>
                <label for="loc">Lọc trạng thái đơn:</label>
                <select style="border-color: gray; border-radius: 0.35rem;" id="loc" name="loc" onchange="updateLoc()">
                    <option <?= ($loc == 0) ? "selected" : "" ?> value='0'>Tất cả</option>
                    <option <?= ($loc === "Chờ thanh toán") ? "selected" : "" ?> value='Chờ thanh toán'>Chờ thanh toán
                    </option>
                    <option <?= ($loc === "Chờ xử lý") ? "selected" : "" ?> value='Chờ xử lý'>Chờ xử lý</option>
                    <option <?= ($loc === "Đang vận chuyển") ? "selected" : "" ?> value='Đang vận chuyển'>Đang vận
                        chuyển
                    </option>
                    <option <?= ($loc === "Thành công") ? "selected" : "" ?> value='Thành công'>Thành công</option>
                    <option <?= ($loc === "Thất bại") ? "selected" : "" ?> value='Thất bại'>Thất bại</option>
                    <option <?= ($loc === "Hủy") ? "selected" : "" ?> value='Hủy'>Hủy</option>
                </select>

                <script>
                function updateLoc() {
                    const select = document.getElementById('loc');
                    location.href =
                        `quantri.php?page_layout=danhsachDH&rowsPerPage=<?= $rowsPerPage ?>&loc=${select.value}<?= ($search != "") ? "&search=".$search : ""?>`;
                }
                </script>

            </div>


            <div class="d-none d-sm-inline-block form-inline ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input required style="border-color: gray;" type="text" class="form-control bg-light small"
                        placeholder="Tìm kiếm" aria-label="Search" aria-describedby="basic-addon2" name="search"
                        id="search" value="<?= $search?>">

                    <div class="input-group-append">
                        <button onclick="updateSearch()" class="btn btn-primary" type="button">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>

                <script>
                function updateSearch() {
                    const search = document.getElementById('search');
                    if (search.value == "") {
                        location.href =
                            `quantri.php?page_layout=danhsachDH&rowsPerPage=<?= $rowsPerPage ?>&loc=<?= $loc ?>`;
                    } else {
                        location.href =
                            `quantri.php?page_layout=danhsachDH&rowsPerPage=<?= $rowsPerPage ?>&loc=<?= $loc ?>&search=${search.value}`;
                    }
                }
                </script>
            </div>
        </div>

        <?php

            // Cố gắng thực thi truy vấn
            // $sql = "SELECT donhang.id, taikhoan.username, taikhoan.phone, taikhoan.address,
            //                 donhang.note, donhang.total, donhang.status, donhang.created_at 
            //         FROM taikhoan
            //         JOIN donhang ON taikhoan.id = donhang.user_id 
            //         ORDER BY donhang.id DESC LIMIT $perRow, $rowsPerPage;";

            if($search != ""){

                $sql = "SELECT donhang.id, taikhoan.username, taikhoan.phone, taikhoan.address,
                            donhang.note, donhang.total, donhang.status, donhang.payment, donhang.created_at 
                    FROM taikhoan
                    JOIN donhang ON taikhoan.id = donhang.user_id  WHERE ". (($loc !== 0 && $loc !== '0') ? "donhang.status = '$loc' AND" : "") ." (donhang.id = '$search' || donhang.username LIKE '%$search%' || donhang.phone LIKE '%$search%' || donhang.address LIKE '%$search%' || donhang.total LIKE '%$search%') ORDER BY donhang.id DESC LIMIT $perRow, $rowsPerPage";
                
                $sql1 = "SELECT donhang.id, taikhoan.username, taikhoan.phone, taikhoan.address,
                            donhang.note, donhang.total, donhang.status, donhang.payment, donhang.created_at 
                    FROM taikhoan
                    JOIN donhang ON taikhoan.id = donhang.user_id  WHERE ". (($loc !== 0 && $loc !== '0') ? "donhang.status = '$loc' AND" : "") ." (donhang.id = '$search' || donhang.username LIKE '%$search%' || donhang.phone LIKE '%$search%' || donhang.address LIKE '%$search%' || donhang.total LIKE '%$search%')";
            
            }else{

                $sql = "SELECT donhang.id, taikhoan.username, taikhoan.phone, taikhoan.address,
                            donhang.note, donhang.total, donhang.status, donhang.payment, donhang.created_at 
                    FROM taikhoan
                    JOIN donhang ON taikhoan.id = donhang.user_id ". (($loc !== 0 && $loc !== '0') ? "WHERE donhang.status = '$loc'" : "") ." ORDER BY donhang.id DESC LIMIT $perRow, $rowsPerPage";

                $sql1 = "SELECT donhang.id, taikhoan.username, taikhoan.phone, taikhoan.address,
                            donhang.note, donhang.total, donhang.status, donhang.payment, donhang.created_at 
                    FROM taikhoan
                    JOIN donhang ON taikhoan.id = donhang.user_id ". (($loc !== 0 && $loc !== '0') ? "WHERE donhang.status = '$loc'" : "");
            }
            
            if($result = mysqli_query($conn, $sql)){

                //Phân trang
                $tongdonhang = mysqli_num_rows(mysqli_query($conn, $sql1));
                $tongsotrang = ceil($tongdonhang/$rowsPerPage);

                //Đổ dữ liệu sản phẩm
                if(mysqli_num_rows($result) > 0){ ?>
        <table class='table table-bordered table-striped'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên khách hàng</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Ghi chú</th>
                    <th>Tổng tiền</th>
                    <th width="14%">Trạng thái</th>
                    <th>Hình thức thanh toán</th>
                    <th>Thời gian tạo</th>
                    <th width="10%">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_array($result)){ ?>
                <tr>
                    <form action='quantri.php?page_layout=suaNhanhDH' method='post'>
                        <td><?= $row[0] ?><input required type='hidden' name='id' value='<?= $row[0] ?>'></td>
                        <td><?= $row[1] ?></td>
                        <td><?= $row[2] ?></td>
                        <td><?= $row[3] ?></td>
                        <td><input required type=' text' name='note' class='form-control' value='<?= $row[4] ?>'></td>

                        <td><?= number_format( $row[5]). " VNĐ" ?></td>

                        <td>
                            <select onchange="
                            switch(this.value){
                                case 'Chờ thanh toán': this.style.backgroundColor = 'orange'; break;
                                case 'Chờ xử lý': this.style.backgroundColor = 'blue'; break;
                                case 'Đang vận chuyển': this.style.backgroundColor = 'Cyan'; break;
                                case 'Thành công': this.style.backgroundColor = 'Lime'; break;
                                case 'Thất bại': this.style.backgroundColor = 'red'; break;
                                case 'Hủy': this.style.backgroundColor = 'Maroon'; break;
                            };" style="padding: 0; color: #fff; background-color: 
                            <?php 
                            switch($row['6']){
                                case 'Chờ thanh toán': echo 'orange'; break;
                                case 'Chờ xử lý': echo 'blue'; break;
                                case 'Đang vận chuyển': echo 'Cyan'; break;
                                case 'Thành công': echo 'Lime'; break;
                                case 'Thất bại': echo 'red'; break;
                                case 'Hủy': echo 'Maroon'; break;
                            };
                            ?>" class='form-control' name='status'>

                                <option style="background-color: orange;"
                                    <?= ($row['6'] === "Chờ thanh toán" ) ? 'selected' : '' ?> value="Chờ thanh toán">
                                    Chờ thanh toán
                                </option>

                                <option style="background-color: blue;"
                                    <?= ($row['6'] === "Chờ xử lý" ) ? 'selected' : '' ?> value="Chờ xử lý">Chờ xử lý
                                </option>

                                <option style="background-color: Cyan;"
                                    <?= ($row['6'] === "Đang vận chuyển" ) ? 'selected' : '' ?> value="Đang vận chuyển">
                                    Đang vận chuyển
                                </option>

                                <option style="background-color: Lime;"
                                    <?= ($row['6'] === "Thành công" ) ? 'selected' : '' ?> value="Thành công">Thành công
                                </option>

                                <option style="background-color: red;"
                                    <?= ($row['6'] === "Thất bại" ) ? 'selected' : '' ?> value="Thất bại">Thất bại
                                </option>

                                <option style="background-color: Maroon;"
                                    <?= ($row['6'] === "Hủy" ) ? 'selected' : '' ?> value="Hủy">Hủy
                                </option>

                            </select>
                        </td>

                        <td><?= $row[7] ?></td>
                        <td><?= date('d-m-Y H:i:s', strtotime($row[8])) ?></td>
                        <td>
                            <input title='Cập nhật' style='border: none;background: none;' type='submit' name='submit'
                                class='btn-sua material-icons' value='save'>
                            <a style='display: contents;' data-toggle='tooltip'
                                href='quantri.php?page_layout=suaDH&id=<?= $row[0] ?>'> <i title='Sửa chi tiết đơn hàng'
                                    class='btn-sua material-icons'>edit</i> </a>
                            <a style='display: contents;' data-toggle='tooltip'
                                href='quantri.php?page_layout=xoaDH&id=<?= $row[0] ?>'> <i title='Xóa đơn hàng'
                                    class='btn-xoa material-icons'>delete</i> </a>
                        </td>
                    </form>
                </tr>
                <?php } ?>

            </tbody>

        </table>
        <?php 
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


<ul class="pagination">
    <?php
    if($page<=$tongsotrang  && $page != 1){
        echo"<li><a href='quantri.php?page_layout=danhsachDH&rowsPerPage=".($rowsPerPage)."&loc=".($loc)."&page=".($page-1).(($search != "") ? "&search=".$search : "")."'>&laquo;</a></li>";
    }
                              
    for($i = $offset; $i <= min($offset + $so_trang_hien_thi - 1, $tongsotrang); $i++){ ?>
    <li><a <?= ($page==$i) ? "class='active'" : "" ?>
            href='quantri.php?page_layout=danhsachDH&rowsPerPage=<?= $rowsPerPage?>&loc=<?= $loc ?>&page=<?= $i?><?= ($search != "") ? "&search=".$search : ""?>'><?= $i?></a>
    </li>
    <?php }

    if($page>=1 && $page != $tongsotrang){
        echo"<li><a href='quantri.php?page_layout=danhsachDH&rowsPerPage=".($rowsPerPage)."&loc=".($loc)."&page=".($page+1).(($search != "") ? "&search=".$search : "")."'>&raquo;</a></li>";
    }

?>

</ul>

</div>