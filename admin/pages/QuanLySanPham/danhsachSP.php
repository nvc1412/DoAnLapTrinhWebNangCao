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
    
    $search = (isset($_GET['search'])) ? $_GET['search'] : "";
?>
<div class="row">
    <div class="col-md-12">

        <div style="display: flex;justify-content: space-between; align-items: center;" class="page-header clearfix">
            <div>
                <h2 style="color: orange;">Danh sách sản phẩm</h2>
            </div>
            <div>
                <a href="quantri.php?page_layout=themSP" class="btn btn-success pull-right ">+ Thêm sản phẩm</a>
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
                        `quantri.php?page_layout=danhsachSP&rowsPerPage=${select.value}<?= ($search != "") ? "&search=".$search : ""?>`;
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
                            `quantri.php?page_layout=danhsachSP&rowsPerPage=<?= $rowsPerPage ?>`;
                    } else {
                        location.href =
                            `quantri.php?page_layout=danhsachSP&rowsPerPage=<?= $rowsPerPage ?>&search=${search.value}`;
                    }
                }
                </script>
            </div>
        </div>


        <?php
                $category = getAllCategory($conn);
                $brand = getAllBrand($conn);

                // Cố gắng thực thi truy vấn
                // $sql = "SELECT * FROM sanpham ORDER BY id DESC LIMIT $perRow, $rowsPerPage";

                if($search != ""){
                    $sql = "SELECT * FROM sanpham WHERE (id = '$search' || name LIKE '%$search%' || price LIKE '%$search%') ORDER BY id DESC LIMIT $perRow, $rowsPerPage";
                    $sql1 = "SELECT * FROM sanpham WHERE (id = '$search' || name LIKE '%$search%' || price LIKE '%$search%')";
                   
                }else{
                    $sql = "SELECT * FROM sanpham ORDER BY id DESC LIMIT $perRow, $rowsPerPage";
                    $sql1 = "SELECT * FROM sanpham";
                }

                if($result = mysqli_query($conn, $sql)){

                    //Phân trang
                    $tongsanpham = mysqli_num_rows(mysqli_query($conn, $sql1));
                    $tongsotrang = ceil($tongsanpham/$rowsPerPage);

                    //Đổ dữ liệu sản phẩm
                    if(mysqli_num_rows($result) > 0){ ?>
        <table class='table table-bordered table-striped'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th width="11%">Hình ảnh</th>
                    <th width="11%">Tên sản phẩm</th>
                    <th width="14%">Danh mục</th>
                    <th width="12%">Thương hiệu</th>
                    <th width="11%">Giá (VNĐ)</th>
                    <th width="11%">Giảm giá</th>
                    <th width="9%">Số lượng</th>
                    <th>Mô tả</th>
                    <th width="10%">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_array($result)){ ?>
                <tr>
                    <form action='quantri.php?page_layout=suaNhanhSP' method='post'>
                        <td><?= $row['id'] ?><input required type='hidden' name='id' value='<?= $row['id'] ?>'></td>

                        <td style='display: flex;flex-wrap: wrap;justify-content: space-evenly;'>
                            <?php 
                            $row['image_url'] = explode(",", $row['image_url']);
                            foreach ($row['image_url'] as $value) {
                                echo '<img class="mb-1" src="../nguoidung/assets/images/sanpham/' . $value . '" width="35" height="35">';
                            } ?>
                        </td>

                        <td>
                            <input required type='text' name='name' class='form-control' value='<?= $row['name'] ?>'>
                        </td>

                        <td>
                            <select class='form-control' style="border-color: gray; border-radius: 0.35rem;"
                                name="category_id">
                                <?php foreach ($category[0] as $key => $value) { ?>
                                <option <?php echo ($row['category_id'] == $value) ? "selected" : "" ?>
                                    value="<?= $value?>">
                                    <?= $category[1][$key]?></option>;
                                <?php } ?>
                            </select>
                        </td>

                        <td>
                            <select class='form-control' style="border-color: gray; border-radius: 0.35rem;"
                                name="brand_id">
                                <?php foreach ($brand[0] as $key => $value) { ?>
                                <option <?php echo ($row['brand_id']==$value) ? "selected" : "" ?> value="<?= $value?>">
                                    <?= $brand[1][$key]?></option>;
                                <?php } ?>
                            </select>
                        </td>

                        <td>
                            <input required type='text' name='price' class='form-control' value='<?= $row['price'] ?>'>
                        </td>


                        <td>
                            <input required type='text' name='discount' class='form-control'
                                value='<?= $row['discount'] ?>'>
                        </td>

                        <td>
                            <input type="number" name="quantity" class='form-control' value="<?= $row['quantity'] ?>"
                                min=0>
                        </td>

                        <td>
                            <input required type='text' name='description' class='form-control'
                                value='<?= $row['description'] ?>'>
                        </td>

                        <td>
                            <input title='Cập nhật' style='border: none;background: none;' type='submit' name='submit'
                                class='btn-sua material-icons' value='save'>
                            <a style='display: contents;' data-toggle='tooltip'
                                href='quantri.php?page_layout=suaSP&id=<?= $row['id'] ?>'> <i
                                    title='Sửa chi tiết sản phẩm' class='btn-sua material-icons'>edit</i> </a>
                            <a style='display: contents;' data-toggle='tooltip'
                                href='quantri.php?page_layout=xoaSP&id=<?= $row['id'] ?>'> <i title='Xóa sản phẩm'
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
        echo"<li><a href='quantri.php?page_layout=danhsachSP&rowsPerPage=".($rowsPerPage)."&page=".($page-1).(($search != "") ? "&search=".$search : "")."'>&laquo;</a></li>";
    }
                              
    for($i = $offset; $i <= min($offset + $so_trang_hien_thi - 1, $tongsotrang); $i++){ ?>
    <li><a <?= ($page==$i) ? "class='active'" : "" ?>
            href='quantri.php?page_layout=danhsachSP&rowsPerPage=<?= $rowsPerPage?>&page=<?= $i?><?= ($search != "") ? "&search=".$search : ""?>'><?= $i?></a>
    </li>
    <?php }

    if($page>=1 && $page != $tongsotrang){
        echo"<li><a href='quantri.php?page_layout=danhsachSP&rowsPerPage=".($rowsPerPage)."&page=".($page+1).(($search != "") ? "&search=".$search : "")."'>&raquo;</a></li>";
    }

?>

</ul>

</div>