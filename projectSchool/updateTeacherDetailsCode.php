
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

 if(isset($_POST['teacherid']))
 {
   $id=$_POST['teacherid'];
 }

 if(isset($_POST['firstname']))
 {
   $fname=$_POST['firstname'];
 }

 if(isset($_POST['lastname']))
 {
   $lname=$_POST['lastname'];
 }

 if(isset($_POST['dob']))
 {
   $dob=$_POST['dob'];
 }

 if(isset($_POST['gender']))
 {
   $Gender=$_POST['gender'];
 }

 if(isset($_POST['no']))
 {
   $Number=$_POST['no'];
 }

 if(isset($_POST['street']))
 {
   $Street=$_POST['street'];
 }

 if(isset($_POST['city']))
 {
   $City=$_POST['city'];
 }

 if(isset($_POST['phoneNo']))
 {
   $Phone_No=$_POST['phoneNo'];
 }

 if(isset($_POST['email']))
 {
   $Email=$_POST['email'];
 }

 if(isset($_POST['subject']))
 {
   $subject=$_POST['subject'];
 }

//$query = "SELECT subject_code from subject"



 $sql = "UPDATE teacher SET first_name='".$fname."',last_name='$lname',gender='$Gender',
 email='$Email',
 date_of_birth='$dob',
 no=$Number,
 street='$Street',
 city='$City',
 subject_code = '$subject' where teacher_id='$id'";
   mysqli_query($db, $sql);

   if ($db->query($sql) === TRUE) {
       $Message = "submitted successfully!";
       header("Location:viewTeacherDetails.php?Message=" . urlencode($Message));
   } else {
       $Message = "Submission Failure!";
       header("Location:viewTeacherDetails.php?Message=" . urlencode($Message));
   }
 }

?>
