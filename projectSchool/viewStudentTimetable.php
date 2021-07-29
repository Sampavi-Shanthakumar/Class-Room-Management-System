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

$sql = "SELECT * from student where user_id = '$uid'";
$result1 = mysqli_query($db,$sql);
$row1 = mysqli_fetch_array($result1);
$sid = $row1['student_id'];
$class = $row1['class_id'];
$division = $row1['division_id'];

$query = "SELECT * FROM timetable where class_id='$class' and division_id = '$division' ";
$result = mysqli_query($db, $query);




if(mysqli_query($db,$query)){
  	$r = mysqli_fetch_assoc($result);
  echo ('<img src="'.$r["location"].'" />');
  //header("Location:student.php");
}

   ?>
