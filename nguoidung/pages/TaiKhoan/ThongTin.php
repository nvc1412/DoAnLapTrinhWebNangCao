<?php

$page = (isset($_GET['page'])) ? $_GET['page'] : 1;
$rowsPerPage = 5;
$perRow = $page*$rowsPerPage-$rowsPerPage;

$id = "";
if(isset($_SESSION["logged"]) && $_SESSION["logged"] != 0){
    if(isset($_SESSION['userid'])){
        $id = $_SESSION['userid'];
    }else{
        header('Location: Error.php');
        exit();
    }
}else{
    header('Location: index.php?page_layout=DangNhap');
    exit();
}


$RegexFomatPhone = "/^0[3|5|7|8|9]\d{8}$/";

$password_old = $password_new = $password_again = "";
$errorMsg2 = "";
$dmkthanhcong = "";

if (isset($_POST['submit'])) {

    $_SESSION['errorMsg1'] = "";
    
    $username_test = $_POST["username_test"];
    $email_test = $_POST["email_test"];
    $phone_test = $_POST["phone_test"];
    
    // Xác thực tên
    if(empty(trim($_POST["username"]))){
       $_SESSION['errorMsg1'] = "* Vui lòng điền tên.";
    } else if($_POST["username"] != $username_test){
        $username = trim($_POST["username"]);
        $sql = "SELECT * FROM taikhoan WHERE username = '$username'";
        if ($test = mysqli_query($conn, $sql)) {
            if(mysqli_num_rows($test) > 0){
                $_SESSION['errorMsg1'] = "* Username đã được sử dụng.";
            }else{
                $username = trim($_POST["username"]);
            }
        } else {
            echo "ERROR: Không thể thực thi $sql. " . mysqli_error($conn);
        }
    }else{
        $username = trim($_POST["username"]);
    }
    
    // Xác thực email
    if(empty(trim($_POST["email"]))){
        $_SESSION['errorMsg1'] = "* Vui lòng điền email.";     
    } else if(trim($_POST["email"]) != $email_test){
        $email = trim($_POST["email"]);
        $sql = "SELECT * FROM taikhoan WHERE email = '$email'";
        if ($test = mysqli_query($conn, $sql)) {
            if(mysqli_num_rows($test) > 0){
                $_SESSION['errorMsg1'] = "* Email đã được sử dụng.";
            }else{
                $email = trim($_POST["email"]);
            }
        } else {
            echo "ERROR: Không thể thực thi $sql. " . mysqli_error($conn);
        }
    }else{
        $email = trim($_POST["email"]);
    }

    // Xác thực số điện thoại
    if(empty(trim($_POST["phone"]))){
        $_SESSION['errorMsg1'] = "* Vui lòng điền số điện thoại.";     
    }else if(!preg_match($RegexFomatPhone, $_POST["phone"])){
        $_SESSION['errorMsg1'] = "Số điện thoại không hợp lệ!";
    }else if(trim($_POST["phone"]) != $phone_test){
        $phone = trim($_POST["phone"]);
        $sql = "SELECT * FROM taikhoan WHERE phone = '$phone'";
        if ($test = mysqli_query($conn, $sql)) {
            if(mysqli_num_rows($test) > 0){
                $_SESSION['errorMsg1'] = "* Số điện thoại đã được sử dụng.";
            }else{
                $phone = trim($_POST["phone"]);
            }
        } else {
            echo "ERROR: Không thể thực thi $sql. " . mysqli_error($conn);
        }
    }else{
        $phone = trim($_POST["phone"]);
    }

    // Xác thực địa chỉ
    if(empty(trim($_POST["address"]))){
        $_SESSION['errorMsg1'] = "* Vui lòng điền address.";     
    } else{
        $address = trim($_POST["address"]);
    }

    // Kiểm tra lỗi đầu vào trước khi chèn vào cơ sở dữ liệu
    if(empty($_SESSION['errorMsg1'])){
        
        $sql = "UPDATE taikhoan SET username='$username', email='$email', phone='$phone', address='$address' WHERE id=$id";

        if (mysqli_query($conn, $sql)) {
            unset($_SESSION['errorMsg1']);
            $_SESSION['success'] = "Cập nhật thành công!";
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['phone'] = $phone;
            $_SESSION['address'] = $address;
            header("Location: index.php?page_layout=ThongTin");
            exit();
        } else {
            echo "ERROR: Không thể thực thi $sql. " . mysqli_error($conn);
        }
        // Đóng kết nối
        mysqli_close($conn);
    }else{
        header("Location: index.php?page_layout=ThongTin");
        exit();
    }
}

if (isset($_POST['submit-dmk'])) {
    
    $password_old = md5($_POST['password_old']);
    $password_new = $_POST['password_new'];
    $password_again = $_POST['password_again'];

    $sql = "SELECT * FROM taikhoan WHERE id = $id AND password='$password_old'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) !== 1){
        $errorMsg2 = "Mật khẩu cũ không đúng!";
        $password_old = $_POST['password_old'];
    }else if($password_new != $password_again){
        $errorMsg2 = "Mật khẩu xác nhận không khớp!";
        $password_old = $_POST['password_old'];
    }else{
        // Kiểm tra lỗi đầu vào trước khi chèn vào cơ sở dữ liệu
        if(empty($errorMsg2)){
            $password = md5($password_again);
            $sql = "UPDATE taikhoan SET password='$password' WHERE id=$id";
            if (mysqli_query($conn, $sql)) {
                $dmkthanhcong = "Đổi mật khẩu thành công!";
                $password_old = "";
                $password_new = "";
                $password_again = "";
            } else {
                echo "ERROR: Không thể thực thi $sql. " . mysqli_error($conn);
            }
            // Đóng kết nối
            // mysqli_close($conn);
        }
    }    

}


?>



<section style="margin: 30px 0;" id="form">
    <!--form-->
    <div class="container">
        <div class="row">

            <div class="col-sm-4">
                <div class="signup-form">
                    <h2>Thông tin tài khoản</h2>
                    <h5><?php if(isset( $_SESSION['errorMsg1'])){ echo $_SESSION['errorMsg1']; unset($_SESSION['errorMsg1']);}else{ echo "";} ?>
                    </h5>
                    <h4><?php if(isset( $_SESSION['success'])){ echo $_SESSION['success']; unset($_SESSION['success']);}else{ echo "";} ?>
                    </h4>
                    <form action="" method="post">
                        <input name="username"
                            value="<?= (isset($_SESSION['username']) ? $_SESSION['username'] : "") ?>" type="text"
                            placeholder="Username" required />
                        <input required type='hidden' name='username_test'
                            value='<?= (isset($_SESSION['username']) ? $_SESSION['username'] : "") ?>'>
                        <input name="email" value="<?= (isset($_SESSION['email']) ? $_SESSION['email'] : "") ?>"
                            type="email" placeholder="Email" required />
                        <input required type='hidden' name='email_test'
                            value='<?= (isset($_SESSION['email']) ? $_SESSION['email'] : "") ?>'>
                        <input name="phone" value="<?= (isset($_SESSION['phone']) ? $_SESSION['phone'] : "") ?>"
                            type="tel" placeholder="Số điện thoại" required />
                        <input required type='hidden' name='phone_test'
                            value='<?= (isset($_SESSION['phone']) ? $_SESSION['phone'] : "") ?>'>
                        <input name="address" value="<?= (isset($_SESSION['address']) ? $_SESSION['address'] : "") ?>"
                            type="text" placeholder="Địa chỉ" required />
                        <button name="submit" type="submit" class="btn btn-default">Cập nhật</button>
                    </form>
                </div>

                <div style="margin-top: 35px;" class="signup-form">
                    <h2>Đổi mật khẩu</h2>

                    <h5><?= (isset($errorMsg2)) ? $errorMsg2 : "" ?></h5>
                    <h4><?= (isset($dmkthanhcong)) ? $dmkthanhcong : "" ?></h4>

                    <form action="" method="post">
                        <div class="input-password">
                            <input name="password_old" value="<?= (isset($password_old)) ? $password_old : "" ?>"
                                id="pass-old" type="password" placeholder="Mật khẩu cũ" required />
                            <i onclick="showPass('pass-old','icon-pass-old')" id="icon-pass-old"
                                class="fa fa-eye-slash"></i>
                        </div>
                        <div class="input-password">
                            <input name="password_new" value="<?= (isset($password_new)) ? $password_new : "" ?>"
                                id="pass-new" type="password" placeholder="Mật khẩu mới" required />
                            <i onclick="showPass('pass-new','icon-pass-new')" id="icon-pass-new"
                                class="fa fa-eye-slash"></i>
                        </div>
                        <div class="input-password">
                            <input name="password_again" value="<?= (isset($password_again)) ? $password_again : "" ?>"
                                id="pass-again" type="password" placeholder="Nhập lại mật khẩu mới" required />
                            <i onclick="showPass('pass-again','icon-pass-again')" id="icon-pass-again"
                                class="fa fa-eye-slash"></i>
                        </div>
                        <button name="submit-dmk" type="submit" class="btn btn-default">Đổi mật khẩu</button>
                    </form>
                </div>

            </div>
            <div class="col-sm-8">
                <h2 class="">Thông tin lịch sử mua hàng</h2>

                <style>
                .ellipsis {
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    max-width: 100px;
                    cursor: pointer;
                }

                .ellipsis:hover::before {
                    content: attr(title_show);
                    background-color: #333;
                    color: #fff;
                    font-size: 14px;
                    font-family: Arial, sans-serif;
                    border-radius: 5px;
                    padding: 5px;
                    position: absolute;
                    z-index: 1;
                    white-space: pre-line;
                    bottom: 100%;
                }
                </style>


                <?php

            // Cố gắng thực thi truy vấn
            $sql = "SELECT donhang.id, taikhoan.username, taikhoan.phone, taikhoan.address,
                            donhang.note, donhang.total, donhang.status, donhang.payment, donhang.created_at 
                    FROM taikhoan
                    JOIN donhang ON taikhoan.id = donhang.user_id WHERE taikhoan.id = $id
                    ORDER BY donhang.id DESC LIMIT $perRow, $rowsPerPage;";

            $sql1 = "SELECT donhang.id, taikhoan.username, taikhoan.phone, taikhoan.address,
                            donhang.note, donhang.total, donhang.status, donhang.payment, donhang.created_at 
                        FROM taikhoan
                        JOIN donhang ON taikhoan.id = donhang.user_id WHERE taikhoan.id = $id";
            
            if($result = mysqli_query($conn, $sql)){

                //Phân trang
                $tongdonhang = mysqli_num_rows(mysqli_query($conn, $sql1));
                $tongsotrang = ceil($tongdonhang/$rowsPerPage);

                //Đổ dữ liệu sản phẩm
                if(mysqli_num_rows($result) > 0){ ?>
                <div class="table-responsive cart_info">
                    <table class='table table-bordered table-striped'>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên</th>
                                <th>SĐT</th>
                                <th>Địa chỉ</th>
                                <th>Ghi chú</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>HTTT</th>
                                <th>Thời gian</th>
                                <th>HĐ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = mysqli_fetch_array($result)){ ?>
                            <tr>
                                <td><?= $row[0] ?></td>
                                <td><?= $row[1] ?></td>
                                <td><?= $row[2] ?></td>
                                <td style='position: relative;'>
                                    <p title_show='<?= $row[3] ?>' class='ellipsis mb-0'><?= $row[3] ?></p>
                                </td>
                                <td style='position: relative;'>
                                    <p title_show='<?= $row[4] ?>' class='ellipsis mb-0'><?= $row[4] ?></p>
                                </td>
                                <td><?= number_format( $row[5]). " VNĐ" ?></td>

                                <td>

                                    <p
                                        style='background-color: <?php switch($row[6])
                                    {
                                        case "Chờ thanh toán": echo "orange"; break;
                                        case "Chờ xử lý": echo "blue"; break;
                                        case "Đang vận chuyển": echo "Cyan"; break;
                                        case "Thành công": echo "Lime"; break;
                                        case "Thất bại": echo "red"; break;
                                        case "Hủy": echo "Maroon"; break;
                                    }; ?>; text-align: center; border-radius: 5px;font-weight: bold; width: 120px; height: 30px; padding: 4px 0; color: white;'>
                                        <?= $row[6] ?>
                                    </p>
                                </td>

                                <td><?= $row[7] ?></td>
                                <td><?= date('d-m-Y H:i:s', strtotime($row[8])) ?></td>
                                <td>
                                    <a style='display: contents;' data-toggle='tooltip'
                                        href='index.php?page_layout=ThongTinChiTiet&id=<?= $row[0] ?>'>
                                        <i title='Xem chi tiết đơn hàng' class='fa fa-eye'></i> </a>
                                </td>
                            </tr>
                            <?php } ?>

                        </tbody>

                    </table>
                </div>
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

            <ul class="pagination">
                <?php

                    if($page<=$tongsotrang  && $page != 1){
                        echo"<li><a href='index.php?page_layout=ThongTin&page=".($page-1)."'>&laquo;</a></li>";
                    }
                              
                    for($i=1; $i<=$tongsotrang; $i++){ ?>
                <li <?= ($page==$i) ? "class='active'" : "" ?>><a
                        href='index.php?page_layout=ThongTin&page=<?= $i?>'><?= $i?></a></li>
                <?php }

                    if($page>=1 && $page != $tongsotrang){
                        echo"<li><a href='index.php?page_layout=ThongTin&page=".($page+1)."'>&raquo;</a></li>";
                    }

                    ?>

            </ul>
        </div>

    </div>
    </div>
</section>
<!--/form-->