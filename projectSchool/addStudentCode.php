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



if (isset($_POST['reg_student'])) {
  // receive all input values from the form
  $sid = mysqli_real_escape_string($db, $_POST['Studentid']);
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
  $grade = mysqli_real_escape_string($db, $_POST['Grade']);
  $aesthetic = mysqli_real_escape_string($db, $_POST['Aesthetic']);
  $basket_1 = mysqli_real_escape_string($db, $_POST['Basket_1']);
  $basket_2 = mysqli_real_escape_string($db, $_POST['Basket_2']);
  $basket_3 = mysqli_real_escape_string($db, $_POST['Basket_3']);
  $division_id = mysqli_real_escape_string($db, $_POST['Division']);

  $uname = mysqli_real_escape_string($db,$_POST['Username']);
  $pwd = mysqli_real_escape_string($db,$_POST['Password']);
  $usertype = mysqli_real_escape_string($db,$_POST['Usertype']);

  $dob = $year ."-".$month."-".$day;

}

$sql_i = "SELECT student_id FROM Student where student_id='$sid'";
$result_i = mysqli_query($db, $sql_i);
if(mysqli_num_rows($result_i) > 0)  {
  $Message = "Student Id Alreay Exists!";
  header("Location:AddStudent.php?Message=" . urlencode($Message));

}
else{
    $query1 = "INSERT INTO login (user_name,password,user_type) values ('$uname','$pwd','$usertype')";
    if(mysqli_query($db, $query1)){
      $user_id = mysqli_insert_id($db);


$sql = "SELECT class_id from class where grade = '$grade'";
$result = mysqli_query($db,$sql);
$row = mysqli_fetch_array($result);
$class_id = $row['class_id'];


		$query2 = "INSERT INTO student (student_id,first_name,last_name,gender,phone_no,email,date_of_birth,no,street,city,class_id,division_id,user_id)
  			  VALUES('$sid', '$fname' , '$lname','$gender','$pno','$email','$dob','$no','$street','$city','$class_id','$division_id','$user_id' )";

    $query3 = "INSERT INTO optional_subject (student_id,aesthetic,basket_1,basket_2,basket_3) values ('$sid','$aesthetic','$basket_1','$basket_2','$basket_3')";
          if(mysqli_query($db, $query2) && mysqli_query($db, $query3) ){
    $Message = "submitted successfully!";
    header("Location:AddStudent.php?Message=" . urlencode($Message));

}
else {
  $query4 = "DELETE from login where user_id = '$user_id'";
  mysqli_query($db,$query4);

  $Message = "Submission Failure!";
  header("Location:AddStudent.php?Message=" . urlencode($Message));
}
} else{
    $Message = "Submission Failure!";
    header("Location:AddStudent.php?Message=" . urlencode($Message));
}

}





?>
