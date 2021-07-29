<?php
include 'config.php';
session_start();

$time = $_SERVER['REQUEST_TIME'];
$timeout_duration = 30*60;

if (isset($_SESSION['LAST_ACTIVITY']) &&
 ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
  session_unset();
  session_destroy();
  session_start();
}

$_SESSION['LAST_ACTIVITY'] = $time;





if(isset($_SESSION['userid'])){
  $uid=$_SESSION['userid'];
  //$uid = $_SESSION['userid'];
}
else {
   header("Location:Login.php");
}

$sql = "SELECT * from login where user_id = '$uid'";
$result1 = mysqli_query($db,$sql);
$row1 = mysqli_fetch_array($result1);



if (isset($_GET['Message'])) {
		print '<script type="text/javascript">alert("' . $_GET['Message'] . '");</script>';
}


$msg = '';
if(isset($_POST['pwd_reset'])){

  $pwd = $_POST['pwd'];
  $password1 = $_POST['new_password'];
  $password2 = $_POST['confirm_password'];



  if($password1 != $password2){
    //  $result = flashMessage("New password and confirm password does not match");
      $msg = "New password and confirm password does not match";
      //echo "<script type='text/javascript'>alert('$message');</script>";

}
else{
  if(md5($pwd) == $row1['password']){
          $pwd = md5($password1);
          $query = "UPDATE login set password = '".$pwd."' where user_id = '".$uid."'";
          if(mysqli_query($db,$query)){

        $Message = "Password have been changed successfully!";
        header("Location:changePassword.php?Message=" . urlencode($Message));
          }
          else{
          $Message = "Failure to change Password!";
          header("Location:changePassword.php?Message=" . urlencode($Message));
          }
        }
        else{
          $Message = "Password is wrong!";
          header("Location:changePassword.php?Message=" . urlencode($Message));
        }

      }

}


 ?>



<!DOCTYPE html>
<html>

<head>
<link rel="stylesheet" type="text/css" href="css/nav.css">
<link rel="stylesheet" type="text/css" href="css/ForgotPassword.css">
<link rel="stylesheet" type="text/css" href="css/resetPassword.css">
</head>
<body>
	<?php include('Header.php'); ?>

<div class="page">
<div class="nav">
<ul>
<li class="home" style="margin-left:50px;"><a href="index.php">Home</a></li>
<li class="about" style="margin-left:50px;"><a href="About.php">About</a></li>

<li class="Login" style="margin-left:50px;"><a href="logout.php">Logout</a></li>

<li class="syllabus"style="margin-left:50px;"><a href="#">Syllabus</a>
<ul>
<li><a href="GradeSix.php">Grade 6</a></li>
<li><a href="GradeSeven.php">Grade 7</a></li>
<li><a href="GradeEight.php">Grade 8</a></li>
<li><a href="GradeNine.php">Grade 9</a></li>
<li><a href="GradeTen.php">Grade 10</a></li>
<li><a href="GradeEleven.php">Grade 11</a></li>
</ul>
</li>

</ul>
</div>



<div class="container">
  <div class="panel panel-default">
<div class="panel-body">
  <center><h3 class="form-signin-heading">change Password</h3></center>
  <div class="row">
  <div class="col-6">
  <img src="image/password.jpg">
  </div>


  <div class="col-6">

<form method="post" class="form-signin" autocomplete="off">

<div class="form-group">
	<div class="form-group">
    <div style = "font-size:14px; color:#cc0000; margin-top:10px"><?php echo $msg; ?></div>
	<label class="label1">Old Password:</label>
	<input type="password" class="form-control"  name="pwd"  placeholder="Enter Your password">
	</div>

<div class="form-group">
<label class="label1">New Password:</label>
<input type="password" class="form-control"  name="new_password"  placeholder="Enter Your New Password">
</div>
<div class="form-group">
<label class="label1">Confirm Password:</label>
<input type="password" class="form-control"  name="confirm_password" placeholder="ReEnter Your New Password">

</div>

</div>
<center><input type="submit" value="Reset" class="btn btn-success" name="pwd_reset" ></center>
</div>



</form>
</div>

</div>
</div>
</div>
</div>


<?php include('Footer.php'); ?>
</body>
</html>
