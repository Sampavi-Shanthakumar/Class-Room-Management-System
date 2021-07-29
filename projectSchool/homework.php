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


if (isset($_GET['Message'])) {
		print '<script type="text/javascript">alert("' . $_GET['Message'] . '");</script>';
}



$query = "SELECT * from student where user_id = '$uid'";
$result1 = mysqli_query($db,$query);
$row1 = mysqli_fetch_array($result1);
$class = $row1['class_id'];
$division = $row1['division_id'];
$sid = $row1['student_id'];
$subject_code = $_GET['subject_code'];

$sql = "SELECT * from upload where subject_code = '$subject_code' and class_id = '$class' and division_id ='$division' ";
$result = mysqli_query($db, $sql);


 ?>


<!DOCTYPE html>


<head>
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



<p><strong>View and Download Homework</strong><P>

  <?php
  if(mysqli_query($db,$sql)){
  	while($r = mysqli_fetch_array($result)){
?>
      <a href="<?php echo $r['location'] ?>"> <?php echo $r['name'] ?> </a></br>
      <?php
    }
  }
    ?>

</br>
<hr>
<p><strong>Upload and View Submissions</strong><P>
<a href='uploadPage.php?subject_code=<?php echo $subject_code ?>'> Sumission </a></br>
<a href='viewSubmission.php?subject_code=<?php echo $subject_code ?>'> View Submissions </a>
</div>
</div>
</div>
</div>
<?php include('Footer.php'); ?>
  </body>
</html>
