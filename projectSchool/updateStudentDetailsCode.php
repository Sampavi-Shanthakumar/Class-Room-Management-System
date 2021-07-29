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


   if(isset($_POST["user_edit"])){
     $sid = mysqli_real_escape_string($db, $_POST['Studentid']);
    $fname = mysqli_real_escape_string($db, $_POST['Firstname']);
    $lname = mysqli_real_escape_string($db, $_POST['Lastname']);
    $gender = mysqli_real_escape_string($db, $_POST['Gender']);
    $pno = mysqli_real_escape_string($db, $_POST['Phoneno']);
    $email = mysqli_real_escape_string($db, $_POST['Email']);
    $dob = mysqli_real_escape_string($db, $_POST['DOB']);
    $no = mysqli_real_escape_string($db, $_POST['Number']);
    $street = mysqli_real_escape_string($db, $_POST['Street']);
    $city = mysqli_real_escape_string($db, $_POST['City']);
    $grade = mysqli_real_escape_string($db, $_POST['Grade']);
    $division = mysqli_real_escape_string($db, $_POST['Division']);


 $sql = "UPDATE student SET first_name='".$fname."',last_name='$lname',gender='$gender',
 email='$email',
 date_of_birth='$dob',
 no=$no,
 street='$street',
 city='$city',
 class_id='$grade',
 division_id='$division' where student_id='$sid'";
   mysqli_query($db, $sql);


   if ($db->query($sql) === TRUE) {
      $Message = "submitted successfully!";
      header("Location:viewStudentDetails.php?Message=" . urlencode($Message));
   } else {
      $Message = "Submission Failure!";
      header("Location:viewStudentDetails.php?Message=" . urlencode($Message));
   }
 }

?>
