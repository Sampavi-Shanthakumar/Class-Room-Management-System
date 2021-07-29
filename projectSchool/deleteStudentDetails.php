
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

   $sql = "DELETE s.*, l.* FROM student s INNER JOIN login l
    WHERE s.user_id = l.user_id and s.student_id = '$id'";
echo var_dump($sql);
if (!mysqli_query($db, $sql)) {
  //echo "Error: " . $sql . "<br>" . mysqli_error($db);
  $Message = "Records deleted failure!";
  header("Location:viewStudentDetails.php?Message=" . urlencode($Message));
}
else{
  //echo "Records deleted successfully";
  $Message = "Records deleted successfully";
  header("Location:viewStudentDetails.php?Message=" . urlencode($Message));
}


?>
