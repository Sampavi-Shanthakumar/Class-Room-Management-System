<?php

if (isset($_GET['Message'])) {
		print '<script type="text/javascript">alert("'.$_GET['Message'].'");</script>';
}

   include("config.php");

   $error = "";

   if(isset($_POST['login'])) {
      // username and password sent from form

      $myusername = mysqli_real_escape_string($db,$_POST['username']);
      $mypassword = mysqli_real_escape_string($db,$_POST['password']);
			$pwd = md5($mypassword);

      $sql = "SELECT * FROM login WHERE user_name =? and password =?";
			$stmt = $db->prepare($sql);
			$stmt->bind_param("si", $myusername,$pwd);
			$stmt->execute();
				//fetching result would go here, but will be covered later


      //$result = mysqli_query($db,$stmt);

			$result = $stmt->get_result();
      $row = $result->fetch_assoc();


      $count = mysqli_num_rows($result);

      // If result matched $myusername and $mypassword, table row must be 1 row

      if($count == 1) {
				$myuserid = $row['user_id'];
         //$_SESSION['username'] = $myusername;

         $activate = $row['status'];
         if ($activate==1){
                    //$query=mysqli_query($db,"SELECT * FROM login WHERE user_name='$myusername' && password='$pwd' && status='1'");
										 session_start();
										$_SESSION['username']=$myusername;
										$_SESSION['userid']=$myuserid;
                    $str= $row['user_type'];
                    $user = $str[0];
                  //  echo var_dump($user);
                  //  echo var_dump($str);
                  switch ($user) {
                    case 'S':
                      header("Location:Student.php");
                      break;
                      case 'T':
                        header("Location:Teacher.php");
                        break;
                        case 'A':
                          header("Location:Admin.php");
                          break;
                          default:
                          header("Location:Principal.php");
                          break;
                  }
                  //  header("Location:welcome.php");
                  //switch($user[0])

                }
                else{
                  $error = "Your Login Name or Password is invalid";
                }


      }
      else {
         $error = "Your Login Name or Password is invalid";
      }

   }
?>

<html>
<body>





<head>
<link rel="stylesheet" type="text/css" href="css/nav.css">
<link rel="stylesheet" type="text/css" href="css/Login.css">
<link href="https://fonts.googleapis.com/css?family=PT+Serif" rel="stylesheet">
</head>
<body>



	<?php include('Header.php'); ?>

	<div class="body">
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
<div class="row">
<div class="col-6">
<img src="image/11.jpg" class="img1">
 <div class="overlay">
    <div class="text">Welcome</div>
  </div>
</div>
<div class="col-6">
	<div class="panel panel-default">
<div class="panel-body">
	<form class="form-signin" method="post" autocomplete="off">
	<center><h2 class="form-signin-heading" style="font-family:lato">LOGIN HERE</h2></center>
	<img src="image/login1.png" class="img">
		<div style = "font-size:14px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
    <div class="form-group">
      <label class="label1">User Name</label>
      <input type="name" class="form-control" id="user" name="username" placeholder="User Name" required>
    </div>
    <div class="form-group">
      <label class="label1">Password</label>
      <input type="password" class="form-control" id="pwd" name="password" placeholder="Password" required>
    </div>
    <a href="ForgotPassword.php" style="color:red;text-decoration:none">Forgotten Password</a>
    <center><button type="submit" name="login" class="btn btn-success" >LOGIN</button></center>

  </form>
</div>
</div>
</div>
</div>
</div>
 </div>
 </div>
  <?php include('Footer.php'); ?>
