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


if (isset($_POST['reg_principal'])) {
  // receive all input values from the form
  $pid = mysqli_real_escape_string($db, $_POST['Principalid']);
  $fname = mysqli_real_escape_string($db, $_POST['Firstname']);
  $lname = mysqli_real_escape_string($db, $_POST['Lastname']);
  $gender = mysqli_real_escape_string($db, $_POST['Gender']);
  $pno = mysqli_real_escape_string($db, $_POST['Phoneno']);
  $email = mysqli_real_escape_string($db, $_POST['Email']);
  $day = mysqli_real_escape_string($db, $_POST['day']);
  $month = mysqli_real_escape_string($db, $_POST['month']);
  $year = mysqli_real_escape_string($db, $_POST['year']);
  $no = mysqli_real_escape_string($db, $_POST['Number']);
  $street = mysqli_real_escape_string($db, $_POST['Street']);
  $city = mysqli_real_escape_string($db, $_POST['City']);
    $uname = mysqli_real_escape_string($db,$_POST['Username']);
  $pwd = mysqli_real_escape_string($db,$_POST['Password']);
  $usertype = mysqli_real_escape_string($db,$_POST['Usertype']);

  $dob = $year ."-".$month."-".$day;

}

$sql_i = "SELECT principal_id FROM principal where principal_id='$pid'";
$result_i = mysqli_query($db, $sql_i);
if(mysqli_num_rows($result_i) > 0)  {
  $Message = "Student Id Alreay Exists!";
  header("Location:AddTeacher.php?Message=" . urlencode($Message));
}
else{

    $query2 = "INSERT INTO login (user_name,password,user_type,status) values ('$uname','$pwd','$usertype',1)";
    if(mysqli_query($db, $query2)){
      $user_id = mysqli_insert_id($db);
		$query1 = "INSERT INTO principal (principal_id,first_name,last_name,gender,phone_no,email,date_of_birth,no,street,city,user_id)
  			  VALUES('$pid', '$fname' , '$lname','$gender','$pno','$email','$dob','$no','$street','$city','$user_id' )";



          if(mysqli_query($db, $query1)){
    $Message = "submitted successfully!";
    header("Location:AddTeacher.php?Message=" . urlencode($Message));

}
else {
  $query4 = "DELETE from login where user_id = '$user_id'";
  mysqli_query($db,$query4);

  $Message = "Submission Failure!";
  header("Location:AddTeacher.php?Message=" . urlencode($Message));
}
} else{
    $Message = "Submission Failure!";
    header("Location:AddTeacher.php?Message=" . urlencode($Message));
}

}

?>
