<?php
$user_id = $username = $phone = $email = $address = $payment = $note = "";
$price = 0;
$discount = 0;


// echo $_SESSION['userid']."<br>";
// echo $_POST['username']."<br>";
// echo $_POST['phone']."<br>";
// echo $_POST['email']."<br>";
// echo $_POST['address']."<br>";
// echo $_POST['payment']."<br>";
// echo date("d/m/Y H:i:s")."<br>";
// echo str_replace(array('/', ':', ' '), '', date("d/m/Y H:i:s"))."<br>";

if(isset($_SESSION['giohang'])){

    if(isset($_POST['payment'])){
   
        $user_id = $_SESSION['userid'];
        $username = $_SESSION['username'];
        $user_name = $_POST['user_name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $payment = $_POST['payment'];
        $note = (!empty($_POST['note'])) ? $_POST['note'] : "Không có ghi chú!";
        $total = $_POST['total'];
    
        $sql = "INSERT INTO donhang (user_id, username, email, phone, address, note, payment, total) 
        VALUES ($user_id, '$user_name', '$email', '$phone', '$address', '$note', '$payment', 0)";
        if (mysqli_query($conn, $sql)) {

            // Lấy id của đơn hàng cuối cùng xong tăng 1
            $order_id = mysqli_insert_id($conn);
            
            foreach($_SESSION['giohang'] as $product_id=>$quantity){
                $price = getPriceProduct($conn, $product_id);
                $discount = getDiscountProduct($conn, $product_id);
                if($discount == 0){
                    $sql = "INSERT INTO chitietdonhang (order_id, product_id, quantity, price) VALUES ($order_id, $product_id, $quantity, $price)";
                }else{
                    $sql = "INSERT INTO chitietdonhang (order_id, product_id, quantity, price) VALUES ($order_id, $product_id, $quantity, $discount)";
                }
                if (mysqli_query($conn, $sql)) {
                    continue;
                }
                else {
                    echo "ERROR: Không thể thực thi $sql. " . mysqli_error($conn);
                }
            }

            unset($_SESSION["giohang"]);
            $_SESSION['order_id'] = $order_id;
            $_SESSION['order_user_name'] = $user_name;
            $_SESSION['order_phone'] = $phone;
            $_SESSION['order_email'] = $email;
            $_SESSION['order_address'] = $address;
            $_SESSION['order_payment'] = $payment;
            $_SESSION['order_total'] = $total;
            // echo "<script> location.href = 'index.php'; </script>";
            // exit();
        } else {
            echo "ERROR: Không thể thực thi $sql. " . mysqli_error($conn);
        }
        mysqli_close($conn);

        if($payment == "COD"){

            // echo "<script> location.href = 'index.php?page_layout=ThanhCong'; </script>";
            header('Location: index.php?page_layout=ThanhCong');
            exit();
                     
        }else if($payment == "MOMO"){

            $orderInfo = "Thanh toán qua MoMo";
            $amount = $total;
            $orderId = time() . "";
            $redirectUrl = $momo_redirectUrl;
            $ipnUrl = $momo_ipnUrl;
            $extraData = $momo_extraData;

            $requestId = time() . "";
            $requestType = "payWithATM";
            // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
            
            //before sign HMAC SHA256 signature
            $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
            $signature = hash_hmac("sha256", $rawHash, $secretKey);
            $data = array('partnerCode' => $partnerCode,
                'partnerName' => "Test",
                "storeId" => "MomoTestStore",
                'requestId' => $requestId,
                'amount' => $amount,
                'orderId' => $orderId,
                'orderInfo' => $orderInfo,
                'redirectUrl' => $redirectUrl,
                'ipnUrl' => $ipnUrl,
                'lang' => 'vi',
                'extraData' => $extraData,
                'requestType' => $requestType,
                'signature' => $signature);
            $result = execPostRequest($endpoint, json_encode($data));
            $jsonResult = json_decode($result, true);  // decode json

            //Just a example, please check more in there

            // echo "<script> location.href = '".$jsonResult['payUrl']."'; </script>";
            header('Location: ' . $jsonResult['payUrl']);
            die();

        }else if($payment == "VNPAY"){
        
            $vnp_TxnRef = $order_id; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
            $vnp_OrderInfo = $note;
           
            $vnp_OrderType = "billpayment";
            $vnp_Amount = $total * 100;
            $vnp_Locale = "vn";
            $vnp_BankCode = "NCB";
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

            $vnp_ExpireDate = $expire;
            
            $inputData = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef,
                "vnp_ExpireDate"=>$vnp_ExpireDate
            );
            
            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }
            
            //var_dump($inputData);
            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }
            
            $vnp_Url = $vnp_Url . "?" . $query;
            if (isset($vnp_HashSecret)) {
                $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            }
            $returnData = array('code' => '00'
                , 'message' => 'success'
                , 'data' => $vnp_Url);
                if (isset($_POST['redirect'])) {

                    // echo "<script> location.href = '$vnp_Url'; </script>";
                    header('Location: ' . $vnp_Url);
                    die();
                } else {
                    echo json_encode($returnData);
                }


        }
    
    }else{
        // echo "<script> location.href = 'Error.php'; </script>";
        header('Location: Error.php');
        exit();
    }

}else{
    // echo "<script> location.href = 'index.php'; </script>";
    header('Location: index.php');
    exit();
}
?>