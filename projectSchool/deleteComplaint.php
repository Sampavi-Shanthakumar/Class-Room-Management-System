
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

$id=$_GET["id"];
    //$studentId=$_POST["student_id"];

   $sql = "DELETE  FROM complaint WHERE complaint_id = '$id'";
echo var_dump($sql);
if (!mysqli_query($db, $sql)) {

  $Message = "Records deleted failure!";
  header("Location:viewComplaint.php?Message=" . urlencode($Message));
}
else{

  $Message = "Records deleted successfully";
  header("Location:viewComplaint.php?Message=" . urlencode($Message));
}


?>
