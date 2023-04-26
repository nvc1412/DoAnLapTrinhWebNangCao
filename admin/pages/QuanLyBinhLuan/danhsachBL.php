<?php
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
                <h2 style="color: orange;">Danh sách bình luận</h2>
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
                        `quantri.php?page_layout=danhsachBL&rowsPerPage=${select.value}&loc=<?= $loc ?><?= ($search != "") ? "&search=".$search : ""?>`;
                }
                </script>

            </div>
            <div>
                <label for="loc">Lọc theo xếp hạng:</label>
                <select style="border-color: gray; border-radius: 0.35rem;" id="loc" name="loc" onchange="updateLoc()">
                    <option <?= ($loc == 0) ? "selected" : "" ?> value='0'>Tất cả</option>
                    <option <?= ($loc == 5) ? "selected" : "" ?> value='5'>5 sao</option>
                    <option <?= ($loc == 4) ? "selected" : "" ?> value='4'>4 sao</option>
                    <option <?= ($loc == 3) ? "selected" : "" ?> value='3'>3 sao</option>
                    <option <?= ($loc == 2) ? "selected" : "" ?> value='2'>2 sao</option>
                    <option <?= ($loc == 1) ? "selected" : "" ?> value='1'>1 sao</option>
                </select>

                <script>
                function updateLoc() {
                    const select = document.getElementById('loc');
                    location.href =
                        `quantri.php?page_layout=danhsachBL&rowsPerPage=<?= $rowsPerPage ?>&loc=${select.value}<?= ($search != "") ? "&search=".$search : ""?>`;
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
                            `quantri.php?page_layout=danhsachBL&rowsPerPage=<?= $rowsPerPage ?>&loc=<?= $loc ?>`;
                    } else {
                        location.href =
                            `quantri.php?page_layout=danhsachBL&rowsPerPage=<?= $rowsPerPage ?>&loc=<?= $loc ?>&search=${search.value}`;
                    }
                }
                </script>
            </div>
        </div>


        <?php
                // Cố gắng thực thi truy vấn
                // $sql = "SELECT * FROM danhgiasanpham ORDER BY id DESC LIMIT $perRow, $rowsPerPage";


                if($search != ""){
                    $sql = "SELECT danhgiasanpham.* FROM ((danhgiasanpham JOIN taikhoan ON danhgiasanpham.user_id = taikhoan.id) JOIN sanpham ON danhgiasanpham.product_id = sanpham.id ) WHERE ". (($loc != 0) ? "danhgiasanpham.rating = $loc AND" : "") ." (danhgiasanpham.id = '$search' || taikhoan.username LIKE '%$search%' || danhgiasanpham.product_id = '$search' || sanpham.name LIKE '%$search%') ORDER BY danhgiasanpham.id DESC LIMIT $perRow, $rowsPerPage";
                    $sql1 = "SELECT danhgiasanpham.* FROM ((danhgiasanpham JOIN taikhoan ON danhgiasanpham.user_id = taikhoan.id) JOIN sanpham ON danhgiasanpham.product_id = sanpham.id ) WHERE ". (($loc != 0) ? "danhgiasanpham.rating = $loc AND" : "") ." (danhgiasanpham.id = '$search' || taikhoan.username LIKE '%$search%' || danhgiasanpham.product_id = '$search' || sanpham.name LIKE '%$search%')";
                   
                }else{
                    $sql = "SELECT * FROM danhgiasanpham ". (($loc != 0) ? "WHERE rating = $loc" : "") ." ORDER BY id DESC LIMIT $perRow, $rowsPerPage";
                    $sql1 = "SELECT * FROM danhgiasanpham ". (($loc != 0) ? "WHERE rating = $loc" : "");
                }

                if($result = mysqli_query($conn, $sql)){

                    //Phân trang
                    $tongbinhluan = mysqli_num_rows(mysqli_query($conn, $sql1));
                    $tongsotrang = ceil($tongbinhluan/$rowsPerPage);

                    //Đổ dữ liệu tài khoản
                    if(mysqli_num_rows($result) > 0){
                        echo "<table class='table table-bordered table-striped'>";
                            echo "<thead>";
                                echo "<tr>";
                                    echo "<th>ID</th>";
                                    echo "<th>Tên tài khoản</th>";
                                    echo "<th>Mã sản phẩm</th>";
                                    echo "<th>Tên sản phẩm</th>";
                                    echo "<th>Hình ảnh</th>";
                                    echo "<th>Xếp hạng</th>";
                                    echo "<th>Nội dung bình luận</th>";
                                    echo "<th>Thời gian tạo</th>";
                                    echo "<th>Hành động</th>";
                                echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            while($row = mysqli_fetch_array($result)){
                                echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . getNameUser($conn, $row['user_id'])[0] . "</td>";
                                    echo "<td>" . $row['product_id'] . "</td>";
                                    echo "<td>" . getNameProduct($conn, $row['product_id']) . "</td>";
                                    
                                    echo "<td><img src='../nguoidung/assets/images/sanpham/" . explode(",", getImageProduct($conn, $row['product_id']))[0] . "' width='40' height='40'></td>";
                                    
                                    echo "<td>";
                                    for($i = 1; $i<=$row['rating']; $i++){
                                        echo "<i style='color: #e3e317;' class='fa-solid fa-star'></i>";
                                    }
                                    echo "</td>";
                                    echo "<td style='position: relative;'><p title_show='".$row['comment']."' class='ellipsis'>" . $row['comment'] . "</p></td>";
                                    echo "<td>" . date('d-m-Y H:i:s', strtotime($row['created_at'])). "</td>";
                                    echo "<td>";
                                        echo "<a style='display: contents;' data-toggle='tooltip' href='quantri.php?page_layout=xoaBL&id=". $row['id'] ."'> <i title='Xóa bình luận' class='btn-xoa material-icons'>delete</i> </a>";
                                    echo "</td>";
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

<ul class="pagination">
    <?php
    if($page<=$tongsotrang  && $page != 1){
        echo"<li><a href='quantri.php?page_layout=danhsachBL&rowsPerPage=".($rowsPerPage)."&loc=".($loc)."&page=".($page-1).(($search != "") ? "&search=".$search : "")."'>&laquo;</a></li>";
    }
                              
    for($i = $offset; $i <= min($offset + $so_trang_hien_thi - 1, $tongsotrang); $i++){ ?>
    <li><a <?= ($page==$i) ? "class='active'" : "" ?>
            href='quantri.php?page_layout=danhsachBL&rowsPerPage=<?= $rowsPerPage?>&loc=<?= $loc ?>&page=<?= $i?><?= ($search != "") ? "&search=".$search : ""?>'><?= $i?></a>
    </li>
    <?php }

    if($page>=1 && $page != $tongsotrang){
        echo"<li><a href='quantri.php?page_layout=danhsachBL&rowsPerPage=".($rowsPerPage)."&loc=".($loc)."&page=".($page+1).(($search != "") ? "&search=".$search : "")."'>&raquo;</a></li>";
    }

?>

</ul>

</div>