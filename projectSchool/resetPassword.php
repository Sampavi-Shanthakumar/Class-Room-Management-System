<?php
if (isset($_GET['Message'])) {
		print '<script type="text/javascript">alert("' . $_GET['Message'] . '");</script>';
}
 ?>
<?php
require ('config.php');
session_start();
$msg = '';
if(isset($_POST['pwd_reset'])){

  $email = $_POST['email'];
  $reset_token = $_POST['reset_token'];
  $password1 = $_POST['new_password'];
  $password2 = $_POST['confirm_password'];



  if($password1 != $password2){
    //  $result = flashMessage("New password and confirm password does not match");
      $msg = "New password and confirm password does not match";
      //echo "<script type='text/javascript'>alert('$message');</script>";

}
else{
  $query = "SELECT * from reset_password where email='".$email."'";
  $result = mysqli_query($db, $query);
  $rows = mysqli_num_rows($result);

  if ($rows > 0) {
      //echo "found record";
      while($row=mysqli_fetch_array($result)){
        $token = $row['token'];
        $user_id = $row['user_id'];

        if($token !== $reset_token) {
            //$isValid = false;
            //$result = flashMessage("You have entered an invalid token");
            $msg = "You have entered an invalid token";
        }
        else{
          $query = "UPDATE login set password = '".$password1."' where user_id = '".$user_id."'";
          if(mysqli_query($db,$query)){
            $query2 = "DELETE from reset_password where user_id = '".$user_id."'";
            mysqli_query($db,$query2);

        $Message = "Password have been changed successfully!";
        header("Location:login.php?Message=" . urlencode($Message));
          }
          else{
          //  $result = flashMessage("Failure to change Password!");
					//$message = "Failure to change Password!";
          $Message = "Failure to change Password!";
          header("Location:resetPassword.php?Message=" . urlencode($Message));
          }
        }

      }
}
else{
$msg = "Email address is not found";
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

<li class="Login" style="margin-left:50px;"><a href="login.php">Login</a></li>

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
  <center><h3 class="form-signin-heading">Reset Password</h3></center>
  <div class="row">
  <div class="col-6">
  <img src="image/password.jpg">
  </div>


  <div class="col-6">

<form method="post" class="form-signin" autocomplete="off">

<div class="form-group">
	<div class="form-group">
    <div style = "font-size:14px; color:#cc0000; margin-top:10px"><?php echo $msg; ?></div>
	<label class="label1">Email:</label>
	<input type="text" class="form-control"  name="email"  placeholder="Enter Your Email">
	</div>
	<div class="form-group">
	<label class="label1">Token:</label>
	<input type="text" class="form-control"  name="reset_token"  placeholder="Enter the token">
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
