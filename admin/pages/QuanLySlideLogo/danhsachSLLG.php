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
<div class="row">
    <div class="col-md-12">

        <div style=" color: green;" class="page-header clearfix">
            <h2>Thêm slide/logo</h2>
        </div>

        <table class='table table-bordered table-striped'>
            <thead>
                <tr>
                    <th>Tên</th>
                    <th>Kiểu</th>
                    <th style="width: 18%;">Hình ảnh</th>
                    <th>Vị trí</th>
                    <th>Trạng thái</th>
                    <th>Mô tả</th>
                    <th style="width: 10%;">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <form action="quantri.php?page_layout=themSLLG" method="post" enctype="multipart/form-data">
                        <td>
                            <input required type='text' name='name' class='form-control'
                                value='<?php if(isset($_SESSION['them_name'])){echo $_SESSION['them_name']; unset($_SESSION['them_name']);}else{echo "";}?>'>
                        </td>

                        <td>
                            <select class='form-control' style="border-color: gray; border-radius: 0.35rem;" id="type"
                                name="type">
                                <option
                                    <?php if(!isset($_SESSION['them_type'])){echo "selected";}else if($_SESSION['them_type'] == "slide"){echo "selected";unset($_SESSION['them_type']);}else{echo "";unset($_SESSION['them_type']);}?>
                                    value='slide'>Slide</option>
                                <option
                                    <?php if(isset($_SESSION['them_type']) && $_SESSION['them_type'] == "logo"){echo "selected";}else{echo "";}?>
                                    value='logo'>Logo</option>
                            </select>
                        </td>

                        <td>
                            <input required style="width: 100%;" type="file" name="image_url" accept="image/*"
                                onchange="previewImage(this);">
                            <div style="display: contents;" id="imagePreview"></div>
                        </td>


                        <script>
                        function previewImage(input) {
                            var previewElement = document.getElementById('imagePreview');
                            previewElement.innerHTML = ''; // remove previous preview
                            if (input.files && input.files[0]) {
                                var reader = new FileReader();
                                reader.onload = function(e) {
                                    var imgElement = document.createElement('img');
                                    imgElement.setAttribute('src', e.target.result);
                                    imgElement.setAttribute('width', '200');
                                    imgElement.setAttribute('style', 'margin-top: 5px;');
                                    previewElement.appendChild(imgElement);
                                }
                                reader.readAsDataURL(input.files[0]);
                            }
                        }
                        </script>

                        <td>
                            <select class='form-control' style="border-color: gray; border-radius: 0.35rem;"
                                id="position" name="position">
                                <option
                                    <?= (!isset($_SESSION['them_position']) || $_SESSION['them_position'] == 1) ? "selected" : "" ?>
                                    value='1'>1</option>
                                <option
                                    <?= (isset($_SESSION['them_position']) && $_SESSION['them_position'] == 2) ? "selected" : "" ?>
                                    value='2'>2</option>
                                <option
                                    <?= (isset($_SESSION['them_position']) && $_SESSION['them_position'] == 3) ? "selected" : "" ?>
                                    value='3'>3</option>
                                <option
                                    <?= (isset($_SESSION['them_position']) && $_SESSION['them_position'] == 4) ? "selected" : "" ?>
                                    value='4'>4</option>
                                <option
                                    <?= (isset($_SESSION['them_position']) && $_SESSION['them_position'] == 5) ? "selected" : "" ?>
                                    value='5'>5</option>
                                <?php unset($_SESSION['them_position']);  ?>
                            </select>
                        </td>

                        <td>
                            <select
                                onchange="if (this.value === 'Bật') {this.style.backgroundColor = 'lime';} else {this.style.backgroundColor = 'Maroon';}"
                                style="color: #fff; background-color: <?= (isset($_SESSION['them_status']) && $_SESSION['them_status'] == "Bật") ? 'lime' : 'Maroon' ?>"
                                class='form-control' name="status">
                                <option style="background-color: lime;"
                                    <?php if(isset($_SESSION['them_status']) && $_SESSION['them_status'] == "Bật"){echo "selected";}else{echo "";}?>
                                    value="Bật">Bật</option>
                                <option style="background-color: Maroon;"
                                    <?php if(!isset($_SESSION['them_status'])){echo "selected";}else if($_SESSION['them_status'] == "Tắt"){echo "selected";unset($_SESSION['them_status']);}else{echo "";unset($_SESSION['them_status']);}?>
                                    value="Tắt">Tắt</option>
                            </select>
                        </td>


                        <td>
                            <input required type='text' name='description' class='form-control'
                                value='<?php if(isset($_SESSION['them_description'])){echo $_SESSION['them_description']; unset($_SESSION['them_description']);}else{echo "";}?>'>
                        </td>

                        <td><input type='submit' name='submit' class='btn btn-success' value='Thêm'></td>
                    </form>
                </tr>
            </tbody>
        </table>

        <div style="color: orange;" class="page-header clearfix">
            <h2>Danh sách Slide/Logo</h2>
        </div>

        <script>
        function previewImageList(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    input.parentNode.querySelector('img').src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        </script>

        <?php
        // Cố gắng thực thi truy vấn
        $sql = "SELECT * FROM slidelogo ORDER BY id DESC LIMIT $perRow, $rowsPerPage";

        if($result = mysqli_query($conn, $sql)){

        //Phân trang
        $tongsanpham = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM slidelogo"));
        $tongsotrang = ceil($tongsanpham/$rowsPerPage);

        //Đổ dữ liệu sản phẩm
        if(mysqli_num_rows($result) > 0){ ?>
        <table class='table table-bordered table-striped'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th style="width: 18%;">Hình ảnh</th>
                    <th>Tên</th>
                    <th>Kiểu</th>
                    <th>Vị trí</th>
                    <th>Trạng thái</th>
                    <th>Mô tả</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_array($result)){ ?>
                <tr>
                    <form action='quantri.php?page_layout=suaSLLG' method='post' enctype="multipart/form-data">
                        <td>
                            <?= $row['id'] ?>
                            <input required type='hidden' name='id' value='<?= $row['id'] ?>'>
                        </td>

                        <td>
                            <input style="width: 100%;" type="file" name="image_url" accept="image/*"
                                onchange="previewImageList(this)">
                            <img class="mb-1 mt-1" src="../nguoidung/assets/images/slide/<?= $row['url_image'] ?>"
                                width="200" height="80px">
                            <input type="hidden" name="image_url" value="<?= $row['url_image'] ?>">
                        </td>

                        <td>
                            <input required type='text' name='name' class='form-control' value='<?= $row['name'] ?>'>
                        </td>

                        <td>
                            <select class='form-control' style="border-color: gray; border-radius: 0.35rem;"
                                name='type'>
                                <option <?= ($row['type'] == "slide") ? "selected" : "" ?> value='slide'>Slide</option>
                                <option <?= ($row['type'] == "logo") ? "selected" : "" ?> value='logo'>Logo</option>
                            </select>
                        </td>

                        <td>
                            <select class='form-control' style="border-color: gray; border-radius: 0.35rem;"
                                name='position'>
                                <option <?= ($row['position'] == "1") ? "selected" : "" ?> value='1'>1</option>
                                <option <?= ($row['position'] == "2") ? "selected" : "" ?> value='2'>2</option>
                                <option <?= ($row['position'] == "3") ? "selected" : "" ?> value='3'>3</option>
                                <option <?= ($row['position'] == "4") ? "selected" : "" ?> value='4'>4</option>
                                <option <?= ($row['position'] == "5") ? "selected" : "" ?> value='5'>5</option>
                            </select>
                        </td>

                        <td>
                            <select
                                onchange="if (this.value === 'Bật') {this.style.backgroundColor = 'lime';} else {this.style.backgroundColor = 'Maroon';}"
                                style="color: #fff; background-color: <?= ($row['status'] == "Bật") ? 'lime' : 'Maroon' ?>"
                                class='form-control' name="status">
                                <option style="background-color: lime;"
                                    <?= ($row['status'] == "Bật") ? "selected" : "" ?> value="Bật">Bật</option>
                                <option style="background-color: Maroon;"
                                    <?= ($row['status'] == "Tắt") ? "selected" : "" ?> value="Tắt">Tắt</option>
                            </select>
                        </td>

                        <td>
                            <input required type='text' name='description' class='form-control'
                                value='<?= $row['description'] ?>'>
                        </td>

                        <td>
                            <input title='Cập nhật' style='border: none;background: none;' type='submit' name='submit'
                                class='btn-sua material-icons' value='save'>
                            <a style='display: contents;' data-toggle='tooltip'
                                href='quantri.php?page_layout=xoaSLLG&id=<?= $row['id']  ?>'> <i title='Xóa'
                                    class='btn-xoa material-icons'>delete</i> </a>
                        </td>
                    </form>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php mysqli_free_result($result);
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
        echo"<li><a href='quantri.php?page_layout=danhsachSLLG&page=".($page-1)."'>&laquo;</a></li>";
    }
                              
    for($i = $offset; $i <= min($offset + $so_trang_hien_thi - 1, $tongsotrang); $i++){ ?>
    <li><a <?= ($page==$i) ? "class='active'" : "" ?>
            href='quantri.php?page_layout=danhsachSLLG&page=<?= $i?>'><?= $i?></a></li>
    <?php }

    if($page>=1 && $page != $tongsotrang){
        echo"<li><a href='quantri.php?page_layout=danhsachSLLG&page=".($page+1)."'>&raquo;</a></li>";
    }

?>

</ul>

</div>