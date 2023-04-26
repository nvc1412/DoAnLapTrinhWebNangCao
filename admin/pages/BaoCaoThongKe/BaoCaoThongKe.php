<!-- Page Heading -->
<!-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Thống kê cửa hàng</h1>
    <a href="#" style="background-color: #217346;" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Xuất Excel</a>
</div> -->


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



<!-- Doanh thu -->
<div class="row">

    <!-- Doanh thu ngày -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Doanh thu ngày</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= number_format(getRevenueDay($conn)). " VNĐ"  ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Doanh thu tháng -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Doanh thu tháng</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= number_format(getRevenueMonth($conn)). " VNĐ"  ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Doanh thu năm -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Doanh thu năm</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= number_format(getRevenueYear($conn)). " VNĐ"  ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tổng doanh thu -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div style="border-left: 0.25rem solid #00c3a4;" class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div style="color: #00c3a4;" class="text-xs font-weight-bold text-uppercase mb-1">
                            Tổng doanh thu</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= number_format(getTotalRevenue($conn)). " VNĐ"  ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Đơn hàng -->
<div class="row">

    <!-- Đơn hàng mới -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div style="border-left: 0.25rem solid orange;" class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div style="color: orange;" class="text-xs font-weight-bold text-uppercase mb-1">
                            Đơn hàng mới</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= getNewBill($conn)?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-receipt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Đơn đang giao -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div style="border-left: 0.25rem solid #00bbbb;" class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div style="color: #00bbbb;" class="text-xs font-weight-bold text-uppercase mb-1">
                            Đơn hàng đang giao</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= getTransportBill($conn)?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-truck fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Đơn hàng hủy -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div style="border-left: 0.25rem solid red;" class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div style="color: red;" class="text-xs font-weight-bold text-uppercase mb-1">
                            Đơn hàng giao thất bại</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= getFailBill($conn)?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-recycle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tổng đơn hàng -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div style="border-left: 0.25rem solid OliveDrab;" class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div style="color: OliveDrab;" class="text-xs font-weight-bold text-uppercase mb-1">
                            Sản phẩm bán chạy</div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">
                            <?php $arr = getTop1Product($conn); echo $arr["id"].". ".$arr["name"] ?></div>
                    </div>
                    <div class="col-auto">
                        <img class=""
                            src="../nguoidung/assets/images/sanpham/<?php $arr["image_url"] = explode(",", $arr["image_url"]); echo $arr["image_url"][0] ?>"
                            width="40" height="40">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Tổng -->
<div class="row">

    <!-- Tổng đơn hàng -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div style="border-left: 0.25rem solid Sienna;" class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div style="color: Sienna;" class="text-xs font-weight-bold text-uppercase mb-1">
                            Tổng đơn hàng</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= getSumBill($conn)?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-receipt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tổng sản phẩm -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div style="border-left: 0.25rem solid blue;" class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div style="color: blue;" class="text-xs font-weight-bold text-uppercase mb-1">
                            Tổng sản phẩm</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= getSumProduct($conn)?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-kitchen-set fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tổng bình luận -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div style="border-left: 0.25rem solid SandyBrown;" class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div style="color: SandyBrown;" class="text-xs font-weight-bold text-uppercase mb-1">
                            Tổng bình luận</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= getSumComment($conn)?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-comments fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tổng tài khoản -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div style="border-left: 0.25rem solid IndianRed;" class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div style="color: IndianRed;" class="text-xs font-weight-bold text-uppercase mb-1">
                            Tổng tài khoản</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= getSumAccount($conn)?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- Biểu đồ -->
<div class="row">

    <!-- Biểu đồ cột -->
    <div class="col-xl-8 col-lg-7">
        <!-- Bar Chart -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Doanh thu năm nay</h6>
            </div>
            <div class="card-body">
                <div class="chart-bar">
                    <canvas id="bieudocot"></canvas>
                    <script>
                    function priceFormat(n) {
                        return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }
                    var xValues = ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 7", "Tháng 8",
                        "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"
                    ];

                    var yValues = <?= json_encode(getRevenueOfMonthInYear($conn));?>;
                    var barColors = ["blue", "red", "violet", "yellow", "green", "orange", "brown", "cyan", "lime",
                        "black", "gray", "pink"
                    ];

                    new Chart("bieudocot", {
                        type: "bar",
                        data: {
                            labels: xValues,
                            datasets: [{
                                backgroundColor: barColors,
                                data: yValues
                            }]
                        },
                        options: {
                            maintainAspectRatio: false,
                            layout: {
                                padding: {
                                    left: 10,
                                    right: 25,
                                    top: 25,
                                    bottom: 0,
                                },
                            },
                            scales: {
                                xAxes: [{
                                    gridLines: {
                                        display: false,
                                        drawBorder: false,
                                    },
                                    maxBarThickness: 25,
                                }, ],
                                yAxes: [{
                                    ticks: {
                                        padding: 10,
                                        callback: function(value, index, values) {
                                            return priceFormat(value);
                                        },
                                    },
                                    gridLines: {
                                        color: "rgb(234, 236, 244)",
                                        zeroLineColor: "rgb(234, 236, 244)",
                                        drawBorder: false,
                                        borderDash: [2],
                                        zeroLineBorderDash: [2],
                                    },
                                }, ],
                            },
                            legend: {
                                display: false
                            },
                            tooltips: {
                                titleMarginBottom: 10,
                                titleFontColor: "#6e707e",
                                titleFontSize: 14,
                                backgroundColor: "rgb(255,255,255)",
                                bodyFontColor: "#858796",
                                borderColor: "#dddfeb",
                                borderWidth: 1,
                                xPadding: 15,
                                yPadding: 15,
                                displayColors: false,
                                caretPadding: 10,
                                callbacks: {
                                    label: function(tooltipItem, chart) {
                                        var datasetLabel =
                                            chart.datasets[tooltipItem.datasetIndex].label || "";
                                        return datasetLabel + priceFormat(tooltipItem.yLabel);
                                    },
                                },
                            },
                        }
                    });
                    </script>
                </div>
            </div>
        </div>

    </div>

    <!-- Biểu đồ tròn -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Đơn hàng tháng này</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-pie pt-4">
                    <canvas id="bieudotron"></canvas>
                    <script>
                    var xValues = ["Đang giao", "Thành công", "Thất bại"];
                    var yValues = <?= json_encode(getStatusOfBill($conn)) ?>;
                    var barColors = [
                        "cyan",
                        "lime",
                        "red"
                    ];

                    new Chart("bieudotron", {
                        type: "pie",
                        data: {
                            labels: xValues,
                            datasets: [{
                                backgroundColor: barColors,
                                data: yValues
                            }]
                        },
                        options: {
                            maintainAspectRatio: false,
                            tooltips: {
                                backgroundColor: "rgb(255,255,255)",
                                bodyFontColor: "#858796",
                                borderColor: "#dddfeb",
                                borderWidth: 1,
                                xPadding: 15,
                                yPadding: 15,
                                displayColors: false,
                                caretPadding: 10,
                            },
                            legend: {
                                display: false,
                            },
                        },
                    });
                    </script>
                </div>
                <div class="mt-4 text-center small">
                    <span class="mr-2">
                        <i style="color: cyan;" class="fas fa-circle"></i> Đang giao
                    </span>
                    <span class="mr-2">
                        <i style="color: lime;" class="fas fa-circle text-success"></i> Thành công
                    </span>
                    <span class="mr-2">
                        <i style="color: red;" class="fas fa-circle text-danger"></i> Thất bại
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Danh sách đơn hàng tháng này -->

<div class="row">
    <div class="col-md-12">

        <div style="display: flex;justify-content: space-between; align-items: center;" class="page-header clearfix">
            <div>
                <h2 style="color: orange;">Đơn hàng tháng này</h2>
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
                        `quantri.php?page_layout=BaoCaoThongKe&rowsPerPage=${select.value}&loc=<?= $loc ?><?= ($search != "") ? "&search=".$search : ""?>`;
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
                        `quantri.php?page_layout=BaoCaoThongKe&rowsPerPage=<?= $rowsPerPage ?>&loc=${select.value}<?= ($search != "") ? "&search=".$search : ""?>`;
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
                            `quantri.php?page_layout=BaoCaoThongKe&rowsPerPage=<?= $rowsPerPage ?>&loc=<?= $loc ?>`;
                    } else {
                        location.href =
                            `quantri.php?page_layout=BaoCaoThongKe&rowsPerPage=<?= $rowsPerPage ?>&loc=<?= $loc ?>&search=${search.value}`;
                    }
                }
                </script>
            </div>


            <?php

            // Cố gắng thực thi truy vấn
            if($search != ""){

                $sql = "SELECT donhang.id, taikhoan.username, taikhoan.phone, taikhoan.address, donhang.note, donhang.total, donhang.status, donhang.payment, donhang.created_at 
                            FROM taikhoan JOIN donhang ON taikhoan.id = donhang.user_id 
                                WHERE MONTH(donhang.created_at) = MONTH(CURDATE()) AND YEAR(donhang.created_at) = YEAR(CURDATE()) AND". (($loc !== 0 && $loc !== '0') ? " donhang.status = '$loc' AND" : "") ." (donhang.id = '$search' || donhang.username LIKE '%$search%' || donhang.phone LIKE '%$search%' || donhang.address LIKE '%$search%' || donhang.total LIKE '%$search%') 
                                    ORDER BY donhang.id DESC LIMIT $perRow, $rowsPerPage";
                
                $sql1 = "SELECT donhang.id, taikhoan.username, taikhoan.phone, taikhoan.address, donhang.note, donhang.total, donhang.status, donhang.payment, donhang.created_at 
                            FROM taikhoan JOIN donhang ON taikhoan.id = donhang.user_id  
                                WHERE MONTH(donhang.created_at) = MONTH(CURDATE()) AND YEAR(donhang.created_at) = YEAR(CURDATE()) AND". (($loc !== 0 && $loc !== '0') ? " donhang.status = '$loc' AND" : "") ." (donhang.id = '$search' || donhang.username LIKE '%$search%' || donhang.phone LIKE '%$search%' || donhang.address LIKE '%$search%' || donhang.total LIKE '%$search%')";
            
            }else{

                $sql = "SELECT donhang.id, taikhoan.username, taikhoan.phone, taikhoan.address,
                            donhang.note, donhang.total, donhang.status, donhang.payment, donhang.created_at 
                    FROM taikhoan
                    JOIN donhang ON taikhoan.id = donhang.user_id WHERE MONTH(donhang.created_at) = MONTH(CURDATE()) AND YEAR(donhang.created_at) = YEAR(CURDATE()) ". (($loc !== 0 && $loc !== '0') ? "AND donhang.status = '$loc'" : "") ." ORDER BY donhang.id DESC LIMIT $perRow, $rowsPerPage";

                $sql1 = "SELECT donhang.id, taikhoan.username, taikhoan.phone, taikhoan.address,
                            donhang.note, donhang.total, donhang.status, donhang.payment, donhang.created_at 
                    FROM taikhoan
                    JOIN donhang ON taikhoan.id = donhang.user_id WHERE MONTH(donhang.created_at) = MONTH(CURDATE()) AND YEAR(donhang.created_at) = YEAR(CURDATE()) ". (($loc !== 0 && $loc !== '0') ? "AND donhang.status = '$loc'" : "");
            }
            ?>

            <div>
                <form action='xuatExcel.php' method='post'>
                    <input type="hidden" name="sql" value="<?= $sql ?>" />
                    <button type="submit" name="submit" style="background-color: #217346;"
                        class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                            class="fas fa-download fa-sm text-white-50"></i> Xuất Excel</button>
                </form>

            </div>
        </div>
        <?php if($result = mysqli_query($conn, $sql)){

                //Phân trang
                $tongdonhang = mysqli_num_rows(mysqli_query($conn, $sql1));
                $tongsotrang = ceil($tongdonhang/$rowsPerPage);

                //Đổ dữ liệu sản phẩm
                if(mysqli_num_rows($result) > 0){ ?>
        <table class='table table-bordered table-striped'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th width="12%">Tên khách hàng</th>
                    <th width="10%">Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Ghi chú</th>
                    <th width="13%">Tổng tiền</th>
                    <th width="10%">Trạng thái</th>
                    <th width="9%">Hình thức thanh toán</th>
                    <th width="10%">Thời gian tạo</th>
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
                                    }; ?>; text-align: center; border-radius: 5px;font-weight: bold; width: 140px; height: 30px; padding: 3px 0; color: white;'>
                            <?= $row[6] ?>
                        </p>
                    </td>
                    <td><?= $row[7] ?></td>
                    <td><?= date('d-m-Y H:i:s', strtotime($row[8])) ?></td>

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
        echo"<li><a href='quantri.php?page_layout=BaoCaoThongKe&rowsPerPage=".($rowsPerPage)."&loc=".($loc)."&page=".($page-1).(($search != "") ? "&search=".$search : "")."'>&laquo;</a></li>";
    }
                              
    for($i = $offset; $i <= min($offset + $so_trang_hien_thi - 1, $tongsotrang); $i++){ ?>
    <li><a <?= ($page==$i) ? "class='active'" : "" ?>
            href='quantri.php?page_layout=BaoCaoThongKe&rowsPerPage=<?= $rowsPerPage?>&loc=<?= $loc ?>&page=<?= $i?><?= ($search != "") ? "&search=".$search : ""?>'><?= $i?></a>
    </li>
    <?php }

    if($page>=1 && $page != $tongsotrang){
        echo"<li><a href='quantri.php?page_layout=BaoCaoThongKe&rowsPerPage=".($rowsPerPage)."&loc=".($loc)."&page=".($page+1).(($search != "") ? "&search=".$search : "")."'>&raquo;</a></li>";
    }

?>

</ul>

</div>