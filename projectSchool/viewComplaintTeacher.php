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
}
else {
   header("Location:Login.php");
}

$sql = "SELECT * from teacher t, login l , subject s where l.user_id ='".$uid."' and l.user_id = t.user_id and t.subject_code=s.subject_code";
$result = mysqli_query($db,$sql);
$row = mysqli_fetch_array($result);
$tid = $row['teacher_id'];

if (isset($_GET['Message'])) {
		print '<script type="text/javascript">alert("' . $_GET['Message'] . '");</script>';
}
 ?>
<html>






<head>
<style>

.panel-body{font-family: Arial, Helvetica, sans-serif;width:60%;margin-left: 20%;
box-sizing: border-box;}
</style>
<link rel="stylesheet" type="text/css" href="css/nav.css">
<link rel="stylesheet" type="text/css" href="submission.css">
</head>
<body>
	<?php include('Header.php'); ?>

<div class="page" style="height:auto;">
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
<div class="panel-body"style="height:auto" >




<?php

$output = '';
  $query = "SELECT c.* from complaint c, teacher t where c.recipient = t.teacher_id and c.recipient = '$tid' ";
  $result = mysqli_query($db,$query);
  if(mysqli_num_rows($result) > 0){
    while ($row = mysqli_fetch_array($result)) {
      $output .= '
      <div class="w3-container">
      <div class="w3-card-4"  style="width:100%; margin-bottom:20px;box-sizing: border-box; border: 2px solid black;">
        <header class="w3-container w3-light-grey">
          <h3 style="margin-left:10px; color:blue;">&#x2709;'.$row["student_id"].'</h3>
          <p><span>&#8618;<span>'.$row["first_name"].' '.$row["last_name"].'</p>
        </header>
        <div class="w3-container">
          <p><strong>&#9734'.$row["title"].'</strong></p>
          <hr>
          <p style="margin-left:20px;">'.$row["subject"].'</p><br>
        </div>
        <button class="btn btn-danger" style="margin-left:500px;margin-bottom:10px;"><a style="color:black" onClick=\'javascript: return confirm("Please confirm deletion");\' href="deleteComplaint.php?id='.$row["complaint_id"].'">Delete</a> </button>

      </div>
    </div>
      ';

    }
    echo $output;
  }


 ?>
</div>
</div>
</div>
</div>
<?php include('Footer.php'); ?>


</body>
</html>
