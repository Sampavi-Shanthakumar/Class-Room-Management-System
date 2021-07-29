
<?php

require('config.php');
require 'classes/PHPMailer.php';
//require 'classes/PHPMailerAutoload.php';
require 'classes/SMTP.php';

$mail = new PHPMailer;

if(isset($_POST['reset'])){
  //echo "at post";
    $semail = $_POST['email'];

    $query = "SELECT * FROM student WHERE email='".$semail."' " ;
    $result = mysqli_query($db, $query);
    $rows = mysqli_num_rows($result);

    if ($rows > 0) {
        //echo "found record";
        $result =  mysqli_query($db,"SELECT * from student s, login l where s.email = '".$semail."' and s.user_id = l.user_id");

        //echo var_dump($result);
        while($row=mysqli_fetch_array($result)){
            $email = $row['email'];

            $username = $row['first_name'] . " " . $row['last_name'];
            $user_id = $row['user_id'];
            $id = $row['student_id'];

            function token_generator($length) {
                $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
                $random = substr(str_shuffle($chars), 0, $length);
                return $random;
            }

            $random = token_generator(10);
            $token = md5($random);
            //echo $email . $user_id.$token;
            $query2 ="INSERT INTO reset_password (user_id,email,token) values ('".$user_id."', '".$email."','".$token."')";

if(mysqli_query($db, $query2)){


    $result_m = mysqli_query($db,"SELECT * FROM student WHERE student_id='".$id."'");
    while($row=mysqli_fetch_array($result_m)){

$to = $row['email'];
$subject = "your recover password";
$message = '<html>
    <body style="background-color:#CCCCCC; color:#000; font-family: Arial, Helvetica, sans-serif;
                        line-height:1.8em;">
    <h2>User Authentication: Code A Secured Login System</h2>
    <p>Dear '.$username.'<br><br> To reset your login password,<br>
    copy the token below and<br>
    click on the Reset Password link then paste the token in the token field on the form:
    <br /><br />
    <b>Token: '.$token.' <br />
    <i>You must use the token to reset your password.</i></b>
    </p>
    <p><a href="http://localhost/projectCMS/resetPassword.php"> Reset Password</a></p>
    <p><strong>&copy;'.date('Y').' BADULLAGIRLSMAHAVIDYALAYM</strong></p>
    </body>
    </html>';
$headers = "From : kopiv18@gmail.com";

$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'kopiv18@gmail.com';
$mail->Password = 'Fl0wer18!';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;
$mail->setFrom('kopiv18@gmail.com', 'Kopiga');
//$mail->addAddress('bkopi95@gmail.com', 'Sara Shan');
$mail->addAddress($to);
$mail->WordWrap = 50;
$mail->isHTML(true);
$mail->Subject = $subject;
$mail->Body    = $message;
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
if(!$mail->send()) {

$Message = "Failure to sent Reset Link !";
header("Location:ForgotPassword.php?Message=" . urlencode($Message));
   exit;
}
else{
$Message = "Reset Link has been sent";
header("Location:ForgotPassword.php?Message=" . urlencode($Message));
}
                    }
          }


        }
    }else{
      $Message = "Email address is not found!";
      header("Location:ForgotPassword.php?Message=" . urlencode($Message));
    }



}

?>
