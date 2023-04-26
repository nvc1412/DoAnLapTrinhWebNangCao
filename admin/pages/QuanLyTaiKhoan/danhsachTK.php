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

        <div style=" color: green;" class="page-header clearfix">
            <h2>Thêm tài khoản</h2>
        </div>

        <table class='table table-bordered table-striped'>
            <thead>
                <tr>
                    <th>Tên tài khoản</th>
                    <th>Mật khẩu</th>
                    <th>Nhập lại mật khẩu</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Quyền Admin</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <form action="quantri.php?page_layout=themTK" method="post">
                        <td><input required type='text' name='username' class='form-control'
                                value='<?php if(isset($_SESSION['them_username'])){echo $_SESSION['them_username']; unset($_SESSION['them_username']);}else{echo "";}?>'>
                        </td>
                        <td>
                            <div style="position: relative;">
                                <input required id="password" type="password" name="password" class="form-control"
                                    value='<?php if(isset($_SESSION['them_password'])){echo $_SESSION['them_password']; unset($_SESSION['them_password']);}else{echo "";}?>'>
                                <i id="show" onclick="showPass('password','show')"
                                    style="position: absolute; top: 12px; right: 10px; color: green;"
                                    class="fas fa-eye-slash"></i>
                            </div>
                        </td>
                        <td>
                            <div style="position: relative;">
                                <input required id="password_again" type="password" name="password_again"
                                    class="form-control"
                                    value='<?php if(isset($_SESSION['them_password_again'])){echo $_SESSION['them_password_again']; unset($_SESSION['them_password_again']);}else{echo "";}?>'>
                                <i id="show_again" onclick="showPass('password_again','show_again')"
                                    style="position: absolute; top: 12px; right: 10px; color: green;"
                                    class="fas fa-eye-slash"></i>
                            </div>
                        </td>
                        <td><input required type='email' name='email' class='form-control'
                                value='<?php if(isset($_SESSION['them_email'])){echo $_SESSION['them_email']; unset($_SESSION['them_email']);}else{echo "";}?>'>
                        </td>
                        <td><input required type='tel' name='phone' class='form-control'
                                value='<?php if(isset($_SESSION['them_phone'])){echo $_SESSION['them_phone']; unset($_SESSION['them_phone']);}else{echo "";}?>'>
                        </td>
                        <td><input required type='text' name='address' class='form-control'
                                value='<?php if(isset($_SESSION['them_address'])){echo $_SESSION['them_address']; unset($_SESSION['them_address']);}else{echo "";}?>'>
                        </td>

                        <td>
                            <select
                                onchange="if (this.value === 'Yes') {this.style.backgroundColor = 'red';} else {this.style.backgroundColor = 'green';}"
                                style="color: #fff; background-color: <?= (isset($_SESSION['them_is_admin']) && $_SESSION['them_is_admin'] == "Yes") ? 'red' : 'green' ?>"
                                class='form-control' name="is_admin">
                                <option style="background-color: #ff3b00;"
                                    <?php if(isset($_SESSION['them_is_admin']) && $_SESSION['them_is_admin'] == "Yes"){echo "selected";}else{echo "";}?>
                                    value="Yes">Yes</option>
                                <option style="background-color: green;"
                                    <?php if(!isset($_SESSION['them_is_admin'])){echo "selected";}else if($_SESSION['them_is_admin'] == "No"){echo "selected";unset($_SESSION['them_is_admin']);}else{echo "";unset($_SESSION['them_is_admin']);}?>
                                    value="No">No</option>
                            </select>
                        </td>

                        <td><input type='submit' name='submit' class='btn btn-success' value='Thêm'></td>
                    </form>
                </tr>
            </tbody>
        </table>

        <div style="display: flex;justify-content: space-between; align-items: center;" class="page-header clearfix">
            <div>
                <h2 style="color: orange;">Danh sách tài khoản</h2>
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
                        `quantri.php?page_layout=danhsachTK&rowsPerPage=${select.value}&loc=<?= $loc ?><?= ($search != "") ? "&search=".$search : ""?>`;
                }
                </script>

            </div>
            <div>
                <label for="loc">Lọc theo quyền:</label>
                <select style="border-color: gray; border-radius: 0.35rem;" id="loc" name="loc" onchange="updateLoc()">
                    <option <?= ($loc == 0) ? "selected" : "" ?> value='0'>Tất cả</option>
                    <option <?= ($loc == 1) ? "selected" : "" ?> value='1'>Admin</option>
                    <option <?= ($loc == 2) ? "selected" : "" ?> value='2'>Người dùng</option>
                </select>

                <script>
                function updateLoc() {
                    const select = document.getElementById('loc');
                    location.href =
                        `quantri.php?page_layout=danhsachTK&rowsPerPage=<?= $rowsPerPage ?>&loc=${select.value}<?= ($search != "") ? "&search=".$search : ""?>`;
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
                            `quantri.php?page_layout=danhsachTK&rowsPerPage=<?= $rowsPerPage ?>&loc=<?= $loc ?>`;
                    } else {
                        location.href =
                            `quantri.php?page_layout=danhsachTK&rowsPerPage=<?= $rowsPerPage ?>&loc=<?= $loc ?>&search=${search.value}`;
                    }
                }
                </script>
            </div>
        </div>

        <?php
            // Cố gắng thực thi truy vấn
            
            if($search != ""){

                if($loc == 1){
                    $sql = "SELECT * FROM taikhoan WHERE is_admin = 1 AND (id = '$search' || username LIKE '%$search%' || email LIKE '%$search%' || phone LIKE '%$search%' || address LIKE '%$search%') ORDER BY id DESC LIMIT $perRow, $rowsPerPage";
                    $sql1 = "SELECT * FROM taikhoan WHERE is_admin = 1 AND (id = '$search' || username LIKE '%$search%' || email LIKE '%$search%' || phone LIKE '%$search%' || address LIKE '%$search%')";
                }else if($loc == 2){
                    $sql = "SELECT * FROM taikhoan WHERE is_admin = 0 AND (id = '$search' || username LIKE '%$search%' || email LIKE '%$search%' || phone LIKE '%$search%' || address LIKE '%$search%') ORDER BY id DESC LIMIT $perRow, $rowsPerPage";
                    $sql1 = "SELECT * FROM taikhoan WHERE is_admin = 0 AND (id = '$search' || username LIKE '%$search%' || email LIKE '%$search%' || phone LIKE '%$search%' || address LIKE '%$search%')";
                }else{
                    $sql = "SELECT * FROM taikhoan WHERE (id = '$search' || username LIKE '%$search%' || email LIKE '%$search%' || phone LIKE '%$search%' || address LIKE '%$search%') ORDER BY id DESC LIMIT $perRow, $rowsPerPage";
                    $sql1 = "SELECT * FROM taikhoan WHERE (id = '$search' || username LIKE '%$search%' || email LIKE '%$search%' || phone LIKE '%$search%' || address LIKE '%$search%')";
                }
                
            }else{
                if($loc == 1){
                    $sql = "SELECT * FROM taikhoan WHERE is_admin = 1 ORDER BY id DESC LIMIT $perRow, $rowsPerPage";
                    $sql1 = "SELECT * FROM taikhoan WHERE is_admin = 1";
                }else if($loc == 2){
                    $sql = "SELECT * FROM taikhoan WHERE is_admin = 0 ORDER BY id DESC LIMIT $perRow, $rowsPerPage";
                    $sql1 = "SELECT * FROM taikhoan WHERE is_admin = 0";
                }else{
                    $sql = "SELECT * FROM taikhoan ORDER BY id DESC LIMIT $perRow, $rowsPerPage";
                    $sql1 = "SELECT * FROM taikhoan";
                }
            }

            if($result = mysqli_query($conn, $sql)){

                //Phân trang
                $tongtaikhoan = mysqli_num_rows(mysqli_query($conn, $sql1));
                $tongsotrang = ceil($tongtaikhoan/$rowsPerPage);


                //Đổ dữ liệu tài khoản
                if(mysqli_num_rows($result) > 0){

            ?>
        <table class='table table-bordered table-striped'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên tài khoản</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th style="width: 8%;">Quyền Admin</th>
                    <th style="width: 9%;">Trạng thái</th>
                    <th>Thời gian tạo</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_array($result)){ ?>
                <tr>
                    <form action='quantri.php?page_layout=suaTK' method='post'>
                        <td>
                            <?= $row['id'] ?>
                            <input required type='hidden' name='id' value='<?= $row['id'] ?>'>
                        </td>
                        <td>
                            <input required type='text' name='username' class='form-control'
                                value='<?= $row['username'] ?>'>
                            <input required type='hidden' name='username_test' value='<?= $row['username'] ?>'>
                        </td>
                        <td>
                            <input required type='email' name='email' class='form-control' value='<?= $row['email'] ?>'>
                            <input required type='hidden' name='email_test' value='<?= $row['email'] ?>'>
                        </td>
                        <td>
                            <input required type='tel' name='phone' class='form-control' value='<?= $row['phone'] ?>'>
                            <input required type='hidden' name='phone_test' value='<?= $row['phone'] ?>'>
                        </td>
                        <td><input required type='text' name='address' class='form-control'
                                value='<?= $row['address'] ?>'></td>
                        <td>
                            <select
                                onchange="if (this.value === 'Yes') {this.style.backgroundColor = '#ff8b00';} else {this.style.backgroundColor = 'black';}"
                                style="color: #fff; background-color: <?= ($row['is_admin']==1) ? '#ff8b00' : 'black' ?>"
                                class='form-control' name='is_admin'>
                                <option style="background-color: #ff8b00;"
                                    <?= ($row['is_admin']==1) ? 'selected' : '' ?> value='Yes'>Yes
                                </option>
                                <option style="background-color: black;" <?= ($row['is_admin']==0) ? 'selected' : '' ?>
                                    value='No'>No</option>
                            </select>
                        </td>

                        <td>
                            <select
                                onchange="if (this.value === 'Yes') {this.style.backgroundColor = 'red';} else {this.style.backgroundColor = 'green';}"
                                style="color: #fff; background-color: <?= ($row['status']==1) ? 'red' : 'green' ?>"
                                class='form-control' name='status'>
                                <option style="background-color: #ff3b00;" <?= ($row['status']==1) ? 'selected' : '' ?>
                                    value='Yes'>Khóa
                                </option>
                                <option style="background-color: green;" <?= ($row['status']==0) ? 'selected' : '' ?>
                                    value='No'>Tốt</option>
                            </select>
                        </td>

                        <td><?= date('d-m-Y H:i:s', strtotime($row['created_at'])) ?></td>
                        <td>
                            <input title='Cập nhật' style='border: none;background: none;' type='submit' name='submit'
                                class='btn-sua material-icons' value='save'>
                            <a style='display: contents;' data-toggle='tooltip'
                                href='quantri.php?page_layout=xoaTK&id=<?= $row['id'] ?>'> <i title='Xóa tài khoản'
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
        echo"<li><a href='quantri.php?page_layout=danhsachTK&rowsPerPage=".($rowsPerPage)."&loc=".($loc)."&page=".($page-1).(($search != "") ? "&search=".$search : "")."'>&laquo;</a></li>";
    }
                              
    for($i = $offset; $i <= min($offset + $so_trang_hien_thi - 1, $tongsotrang); $i++){ ?>
    <li><a <?= ($page==$i) ? "class='active'" : "" ?>
            href='quantri.php?page_layout=danhsachTK&rowsPerPage=<?= $rowsPerPage?>&loc=<?= $loc ?>&page=<?= $i?><?= ($search != "") ? "&search=".$search : ""?>'><?= $i?></a>
    </li>
    <?php }

    if($page>=1 && $page != $tongsotrang){
        echo"<li><a href='quantri.php?page_layout=danhsachTK&rowsPerPage=".($rowsPerPage)."&loc=".($loc)."&page=".($page+1).(($search != "") ? "&search=".$search : "")."'>&raquo;</a></li>";
    }

?>

</ul>

</div>