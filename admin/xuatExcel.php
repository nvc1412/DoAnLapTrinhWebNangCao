<?php

require_once("./includes/config.php");
require_once("PHPExcel.php");

date_default_timezone_set('Asia/Ho_Chi_Minh');

if(isset($_POST['submit'])){
    $sql = $_POST['sql'];

    $DanhSachDonHang = array();
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
            $DanhSachDonHang[] = $row;
        } 
    }

    $excel = new PHPExcel();
    $excel->setActiveSheetIndex(0);
    $excel->getActiveSheet()->setTitle('Danh sách đơn hàng');

    $excel->getActiveSheet()->setCellValue('A1', 'ID');
    $excel->getActiveSheet()->setCellValue('B1', 'Tên khách hàng');
    $excel->getActiveSheet()->setCellValue('C1', 'Số điện thoại');
    $excel->getActiveSheet()->setCellValue('D1', 'Địa chỉ');
    $excel->getActiveSheet()->setCellValue('E1', 'Ghi chú');
    $excel->getActiveSheet()->setCellValue('F1', 'Tổng tiền');
    $excel->getActiveSheet()->setCellValue('G1', 'Trạng thái');
    $excel->getActiveSheet()->setCellValue('H1', 'Hình thức thanh toán');
    $excel->getActiveSheet()->setCellValue('I1', 'Thời gian tạo');

    for ($col = 'A'; $col <= 'I'; $col++) {
        $excel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
    }

    $excel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);

    $numRow = 2;
    foreach($DanhSachDonHang as $row){
        $excel->getActiveSheet()->setCellValue('A' . $numRow, $row[0]);
        $excel->getActiveSheet()->setCellValue('B' . $numRow, $row[1]);
        $excel->getActiveSheet()->setCellValue('C' . $numRow, $row[2]);
        $excel->getActiveSheet()->setCellValue('D' . $numRow, $row[3]);
        $excel->getActiveSheet()->setCellValue('E' . $numRow, $row[4]);
        $excel->getActiveSheet()->setCellValue('F' . $numRow, (number_format( $row[5]). " VNĐ"));
        $excel->getActiveSheet()->setCellValue('G' . $numRow, $row[6]);
        $excel->getActiveSheet()->setCellValue('H' . $numRow, $row[7]);
        $excel->getActiveSheet()->setCellValue('I' . $numRow, (date('d-m-Y H:i:s', strtotime($row[8]))));
        $numRow++;
    }

    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Danh_sach_don_hang_'.date('d-m-Y_H-i-s').'.xlsx"');
    PHPExcel_IOFactory::createWriter($excel, 'Excel2007')->save('php://output');

    mysqli_close($conn);
    
}else{
    header('Location: error.php');
    exit();
}
?>