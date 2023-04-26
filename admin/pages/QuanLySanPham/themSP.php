<?php

// Xác định các biến và khởi tạo với các giá trị trống
$category_id = $brand_id = $name = $description = $image_url = $price = $discount = $quantity = "";
$category_id_err = $brand_id_err = $name_err = $description_err = $image_url_err = $price_err = $discount_err = $quantity_err = "";

$array_image_url = [];
$target_dir = "../nguoidung/assets/images/sanpham/"; // khi dùng "../" là trở ra đường dẫn đầu tiên (localhost://)

// Xử lý dữ liệu biểu mẫu khi biểu mẫu được gửi
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Lấy dữ liệu đầu vào
    $id = $_POST["id"];
    

    // Xác thực danh mục
    if(empty(trim($_POST["category_id"]))){
        $category_id_err = "* Vui lòng điền danh mục sản phẩm.";     
    } else{
        $category_id = trim($_POST["category_id"]);
    }

    // Xác thực thương hiệu
    if(empty(trim($_POST["brand_id"]))){
        $brand_id_err = "* Vui lòng điền thương hiệu sản phẩm.";     
    } else{
        $brand_id = trim($_POST["brand_id"]);
    }

    // Xác thực tên
    if(empty(trim($_POST["name"]))){
        $name_err = "* Vui lòng điền tên sản phẩm.";     
    } else{
        $name = trim($_POST["name"]);
    }

    // Xác thực mô tả
    if(empty(trim($_POST["description"]))){
        $description_err = "* Vui lòng điền mô tả.";     
    } else{
        $description = trim($_POST["description"]);
    }


    // Xác thực ảnh
    if($_FILES["image_url"]["name"] == [""]){
        // không chọn ảnh hoặc rỗng
        $image_url_err = "* Vui lòng chọn ảnh.";
    } else{
        // chọn ảnh mới
        $totalFiles = count($_FILES["image_url"]["name"]);

        for($i = 0; $i < $totalFiles; $i++){
            $target_file = $target_dir . basename($_FILES["image_url"]["name"][$i]);
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            // Kiểm tra ảnh thật hay giả
            $check = getimagesize($_FILES["image_url"]["tmp_name"][$i]);
            if($check == false) {
                $image_url_err = "* File không phải một ảnh.";
            }

            // kiểm tra định dạng file
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                $image_url_err = "* Chỉ cho phép các tệp có định dạng là JPG, JPEG, PNG và GIF.";
            }

            // kiểm tra cỡ file
            if ($_FILES["image_url"]["size"][$i] > 500000) {
                $image_url_err = "* File quá lớn, vui lòng chọn file có kích cỡ bé hơn.";
            }

            // // kiểm tra file đã tồn tại
            // if (file_exists($target_file)) {
            //     $image_url_err = "* File đã tồn tại.";
            // }
        }
    }


    // Xác thực giá
    if(empty(trim($_POST["price"])) && trim($_POST["price"]) != 0 ){
        $price_err = "* Vui lòng điền giá.";
        echo trim($_POST["price"]);     
    } elseif(!ctype_digit(trim($_POST["price"]))){
        $price_err = "* Vui lòng điền giá phải là số.";
        $price = trim($_POST["price"]);
    } else{
        $price = trim($_POST["price"]);
    }

    // Xác thực giảm giá
    if(empty(trim($_POST["discount"])) && trim($_POST["discount"]) != 0 ){
        $discount_err = "* Vui lòng điền số % giảm giá.";
        echo trim($_POST["discount"]);     
    } elseif(!ctype_digit(trim($_POST["discount"]))){
        $discount_err = "* Vui lòng điền giảm giá phải là số.";
        $discount = trim($_POST["discount"]);
    } else{
        $discount = trim($_POST["discount"]);
    }
    
    // Xác thực số lượng
    if(empty(trim($_POST["quantity"])) && trim($_POST["quantity"]) != 0 ){
        $quantity_err = "* Vui lòng điền số lượng.";
        echo trim($_POST["quantity"]);     
    } elseif(!ctype_digit(trim($_POST["quantity"]))){
        $quantity_err = "* Vui lòng điền số phải là số.";
        $quantity = trim($_POST["quantity"]);
    } else{
        $quantity = trim($_POST["quantity"]);
    }
    
    $category = getAllCategory($conn);
    $brand = getAllBrand($conn);
    
    // Kiểm tra lỗi đầu vào trước khi chèn vào cơ sở dữ liệu
    if(empty($category_id_err) && empty($brand_id_err) && empty($name_err) && empty($description_err) && empty($image_url_err) && empty($price_err) && empty($discount_err) && empty($quantity_err) ){
        
        
        foreach($_FILES["image_url"]["name"] as $value){
            array_push($array_image_url, $value);
        }
        $image_url = implode(",", $array_image_url);
        

        // Chuẩn bị câu lệnh Update
        $sql = "INSERT INTO sanpham (category_id, brand_id, name, description, image_url, price, discount, quantity) VALUES ($category_id, $brand_id, '$name', '$description', '$image_url', $price, $discount, $quantity)";

        if (mysqli_query($conn, $sql)) {
            // Update thành công. Chuyển hướng đến trang đích

            // Thêm từng ảnh được chọn
            // Loop through each file
            for($i=0; $i<$totalFiles; $i++){
                $target_file = $target_dir . basename($_FILES["image_url"]["name"][$i]);
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                move_uploaded_file($_FILES["image_url"]["tmp_name"][$i], $target_file);
            }

            header("Location: quantri.php?page_layout=danhsachSP");
            exit();
        } else {
            echo "ERROR: Không thể thực thi $sql. " . mysqli_error($conn);
        }
        // Đóng kết nối
        mysqli_close($conn);
    }
}else{
    $category = getAllCategory($conn);
    $brand = getAllBrand($conn);
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="page-header">
            <h2>Thêm sản phẩm</h2>
        </div>
        <p>Điền thông tin để thêm sản phẩm.</p>


        <form style="display: flex; flex-direction: column;"
            action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post"
            enctype="multipart/form-data">


            <div style="display: flex;">
                <div style="flex: 1; margin-right: 20px">
                    <div class="form-group <?php echo (!empty($category_id_err)) ? 'has-error' : ''; ?>">
                        <label class="mt-2">Danh mục:</label>
                        <select
                            style="height: calc(1.5em + 0.75rem + 2px);padding: 0.375rem 0.75rem;color: #6e707e;border: 1px solid #d1d3e2;border-radius: 0.35rem;float: right;width: 70%;"
                            name="category_id" id="category_id">
                            <?php foreach ($category[0] as $key => $value) { ?>
                            <option <?php echo ($category_id==$value) ? "selected" : "" ?> value="<?= $value?>">
                                <?= $category[1][$key]?></option>;
                            <?php } ?>
                        </select>
                        <span style="display: inline-block;float: right;margin-right: 20px;"
                            class="help-block text-danger"><?php echo $category_id_err;?></span>
                    </div>

                    <div class="form-group <?php echo (!empty($brand_id_err)) ? 'has-error' : ''; ?>">
                        <label class="mt-2">Hãng:</label>
                        <select
                            style="height: calc(1.5em + 0.75rem + 2px);padding: 0.375rem 0.75rem;color: #6e707e;border: 1px solid #d1d3e2;border-radius: 0.35rem;float: right;width: 70%;"
                            name="brand_id" id="brand_id">
                            <?php foreach ($brand[0] as $key => $value) { ?>
                            <option <?php echo ($brand_id==$value) ? "selected" : "" ?> value="<?= $value?>">
                                <?= $brand[1][$key]?></option>;
                            <?php } ?>
                        </select>
                        <span style="display: inline-block;float: right;margin-right: 20px;"
                            class="help-block text-danger"><?php echo $brand_id_err;?></span>
                    </div>

                    <div class="mt-4 form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                        <label class="mt-2">Tên:</label>
                        <input
                            style="height: calc(1.5em + 0.75rem + 2px);padding: 0.375rem 0.75rem;color: #6e707e;border: 1px solid #d1d3e2;border-radius: 0.35rem;float: right;width: 70%;"
                            type="text" name="name" value="<?php echo $name; ?>">
                        <span style="display: inline-block;float: right;margin-right: 20px;"
                            class="help-block text-danger"><?php echo $name_err;?></span>
                    </div>

                    <div class="mt-4 form-group <?php echo (!empty($price_err)) ? 'has-error' : ''; ?>">
                        <label class="mt-2">Giá:</label>
                        <input
                            style="height: calc(1.5em + 0.75rem + 2px);padding: 0.375rem 0.75rem;color: #6e707e;border: 1px solid #d1d3e2;border-radius: 0.35rem;float: right;width: 70%;"
                            type="text" name="price" value="<?php echo $price; ?>">
                        <span style="display: inline-block;float: right;margin-right: 20px;"
                            class="help-block text-danger"><?php echo $price_err;?></span>
                    </div>

                    <div class="mt-4 form-group <?php echo (!empty($discount_err)) ? 'has-error' : ''; ?>">
                        <label class="mt-2">Giảm giá:</label>
                        <input
                            style="height: calc(1.5em + 0.75rem + 2px);padding: 0.375rem 0.75rem;color: #6e707e;border: 1px solid #d1d3e2;border-radius: 0.35rem;float: right;width: 70%;"
                            type="text" name="discount" value="<?php echo $discount; ?>">
                        <span style="display: inline-block;float: right;margin-right: 20px;"
                            class="help-block text-danger"><?php echo $discount_err;?></span>
                    </div>

                    <div class="mt-4 form-group <?php echo (!empty($quantity_err)) ? 'has-error' : ''; ?>">
                        <label class="mt-2">Số lượng:</label>
                        <input
                            style="height: calc(1.5em + 0.75rem + 2px);padding: 0.375rem 0.75rem;color: #6e707e;border: 1px solid #d1d3e2;border-radius: 0.35rem;float: right;width: 70%;"
                            type="number" name="quantity" value="<?php echo $quantity; ?>" min=0>
                        <span style="display: inline-block;float: right;margin-right: 20px;"
                            class="help-block text-danger"><?php echo $quantity_err;?></span>
                    </div>

                    <div class="form-group <?php echo (!empty($image_url_err)) ? 'has-error' : ''; ?>">
                        <label class="mt-2">Ảnh:</label>
                        <input type="file" name="image_url[]" id="image_url" multiple>
                        <span style="display: inline-block;float: right;margin-right: 20px;margin-bottom: 20px;"
                            class="help-block text-danger"><?php echo $image_url_err;?></span>
                    </div>

                    <div class="mt-5">
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <input type="submit" class="btn btn-primary" value="Gửi">
                        <a href="quantri.php?page_layout=danhsachSP" class="btn btn-success">Cancel</a>
                    </div>

                </div>


                <div style="flex: 3">
                    <div class="form-group <?php echo (!empty($description_err)) ? 'has-error' : ''; ?>">
                        <label>Mô tả:</label>
                        <textarea row="5" id="description" name="description"
                            class="form-control"><?php echo $description; ?></textarea>
                        <script type="text/javascript">
                        CKEDITOR.replace('description');

                        // CKEDITOR.replace('description', {
                        //     filebrowserBrowseUrl: 'ckeditor/ckfinder/ckfinder.html',
                        //     filebrowserUploadUrl: 'ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                        //     filebrowserWindowWidth: '1000',
                        //     filebrowserWindowHeight: '700'
                        // });
                        </script>
                        <span class="help-block text-danger"><?php echo $description_err;?></span>
                    </div>
                </div>

            </div>


        </form>
    </div>
</div>
</div>