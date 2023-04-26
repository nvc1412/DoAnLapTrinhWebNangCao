<?php

include "PHPMailer/src/PHPMailer.php";
include "PHPMailer/src/Exception.php";
include "PHPMailer/src/OAuth.php";
include "PHPMailer/src/POP3.php";
include "PHPMailer/src/SMTP.php";
 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer{
    public function lienhemail($mailLienHe, $nameLienHe, $noidung){
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions

        $mail->CharSet = "UTF-8";
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = '(bảo mật thông tin)';                 // SMTP username
            $mail->Password = '(bảo mật thông tin)';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to
        
            //Recipients
            $mail->setFrom($mailLienHe, $nameLienHe);
            
            $mail->addAddress('(bảo mật thông tin)', 'HouseHaven Shop');     // Add a recipient
            // $mail->addAddress('ellen@example.com');               // Name is optional

            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('(bảo mật thông tin)');
            // $mail->addBCC('bcc@example.com');
        
            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        
            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Liên hệ hỗ trợ!';
            $mail->Body = "Từ địa chỉ email: ".$mailLienHe."<br>"."Tên tài khoản: ".$nameLienHe."<br>"."Nội dung tin nhắn: ".$noidung;
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
            $mail->send();
            // echo "<script> location.href = 'index.php?page_layout=GuiMail&status=thanhcong'; </script>";
            header('Location: index.php?page_layout=GuiMail&status=thanhcong');
            exit();
        } catch (Exception $e) {
            echo 'Không thể gửi tin nhắn! Lỗi: ', $mail->ErrorInfo;
        }
    }


    public function thanhtoanmail($mail_dathang, $name_dathang, $noidung){
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions

        $mail->CharSet = "UTF-8";
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = '(bảo mật thông tin)';                 // SMTP username
            $mail->Password = '(bảo mật thông tin)';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to
        
            //Recipients
            $mail->setFrom('(bảo mật thông tin)', 'HouseHaven Shop');
            
            $mail->addAddress($mail_dathang, $name_dathang);     // Add a recipient
            // $mail->addAddress('ellen@example.com');               // Name is optional

            // $mail->addReplyTo('info@example.com', 'Information');
            $mail->addCC('(bảo mật thông tin)');
            // $mail->addBCC('bcc@example.com');
        
            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        
            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Thông tin đặt hàng!';
            $mail->Body = "Từ địa chỉ email: (bảo mật thông tin)<br>Tên: HouseHaven Shop<br>Nội dung: <br>".$noidung;
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
            $mail->send();
            // echo "<script> location.href = 'index.php?page_layout=GuiMail&status=thanhcong'; </script>";
        } catch (Exception $e) {
            echo 'Không thể gửi tin nhắn! Lỗi: ', $mail->ErrorInfo;
        }
    }

}



?>