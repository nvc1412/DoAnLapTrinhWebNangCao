<?php
	$dbHost = 'localhost';
	$dbUsername = 'root';
	$dbPassword = '';
	$dbName = 'doanweb';

	$conn = mysqli_connect($dbHost,$dbUsername,$dbPassword,$dbName);
	
	if($conn){
		$setLang = mysqli_query($conn, "SET NAMES 'utf8'");
	}else{
		die("Kết nối đến cơ sở dữ liệu thất bại: " . mysqli_connect_error());
	}
?>