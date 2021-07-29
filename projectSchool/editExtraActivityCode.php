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



if(isset($_POST['edit_activity'])){

  $sid = mysqli_real_escape_string($db, $_POST['student_id']);
  $section = mysqli_real_escape_string($db,$_POST['section']);
  $type = mysqli_real_escape_string($db,$_POST['type']);
  $year = mysqli_real_escape_string($db,$_POST['year']);
  $level = mysqli_real_escape_string($db,$_POST['level']);
  $place = mysqli_real_escape_string($db,$_POST['place_no']);

$query = "UPDATE extra_activity set student_id ='$sid' , section = '$section' , type = '$type', year = '$year', participation_level = '$level', place = '$place' where extra_activity_id = '$id'";

if(mysqli_query($db, $query)){
  $Message = "Updated successfully!";
  header("Location:viewExtracuricular.php?Message=".urlencode($Message));
}

else{
  $Message = "Update Failure!";
  header("Location:viewExtracuricular.php?Message=".urlencode($Message));
  }
}

 ?>
