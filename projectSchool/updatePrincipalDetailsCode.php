
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
 $new_id = mysqli_real_escape_string($db, $_POST['teacherid']);
  $fname = mysqli_real_escape_string($db, $_POST['firstname']);
  $lname = mysqli_real_escape_string($db, $_POST['lastname']);
  $gender = mysqli_real_escape_string($db, $_POST['gender']);
  $pno = mysqli_real_escape_string($db, $_POST['phoneNo']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $dob = mysqli_real_escape_string($db, $_POST['dob']);
  $no = mysqli_real_escape_string($db, $_POST['no']);
  $street = mysqli_real_escape_string($db, $_POST['street']);
  $city = mysqli_real_escape_string($db, $_POST['city']);










 $sql = "UPDATE principal SET principal_id='".$new_id."',first_name='".$fname."',last_name='$lname',gender='$gender',
 email='$email',
 date_of_birth='$dob',
 no=$no,
 street='$street',
 city='$city'
 where principal_id='$id'";
   mysqli_query($db, $sql);

   if ($db->query($sql) === TRUE) {
      $Message = "submitted successfully!";
      header("Location:viewPrincipal.php?Message=" . urlencode($Message));
   } else {
      $Message = "Submission Failure!";
      header("Location:viewPrincipal.php?Message=" . urlencode($Message));
   }
 }

?>
