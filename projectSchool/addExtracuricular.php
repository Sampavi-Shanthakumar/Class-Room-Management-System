<?php
  include("config.php");
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




if(isset($_POST['add_activity'])){

foreach($_POST['student_id'] as $k=>$val){

  $sid = mysqli_real_escape_string($db, $_POST['student_id'][$k]);
  $section = mysqli_real_escape_string($db,$_POST['section'][$k]);
  $type = mysqli_real_escape_string($db,$_POST['type'][$k]);
  $year = mysqli_real_escape_string($db,$_POST['year'][$k]);
  $level = mysqli_real_escape_string($db,$_POST['level'][$k]);
  $place = mysqli_real_escape_string($db,$_POST['place_no'][$k]);

$query = "INSERT INTO extra_activity (student_id,section,type,year,participation_level,place) VALUES ('$sid' , '$section' ,'$type','$year','$level','$place')";

if(mysqli_query($db, $query)){

$Message = "submitted successfully!";
header("Location:extracuricular.php?Message=" . urlencode($Message));
}

else{
$Message = "Submission Failure!";
header("Location:extracuricular.php?Message=" . urlencode($Message));
    }
  }
}


?>
