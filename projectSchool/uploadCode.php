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


$name = $_FILES['file']['name'];
$size = $_FILES['file']['size'];
$type = $_FILES['file']['type'];
$tmp_name = $_FILES['file']['tmp_name'];
$subject_code = $_GET['subject_code'];
$time = date("H:i:s");
$date = date("Y-m-d");

$max_size = 500000;
//$extension = substr($name, strpos($name, '.') + 1);
$extension = pathinfo($name,PATHINFO_EXTENSION);
//echo var_dump($extension);



if(isset($name) && !empty($name)){

	if( $extension == "pdf" && $type=="application/pdf" && $extension == $size<=$max_size){
		$location = "uploads/";
		if(move_uploaded_file($tmp_name, $location.$name)){

			$query = "INSERT INTO `submission` (student_id,subject_code,name, size, type, location,date_sub,time_sub) VALUES ('$sid','$subject_code','$name', '$size', '$type', '$location$name','$date','$time')";


			if(mysqli_query($db, $query)){
        $Message = "Uploaded Successfully";
        header("Location:homework.php?Message=" . urlencode($Message)."&subject_code=" .urlencode($subject_code) );

		}
		}else{
      $Message = "Failed to Upload File";
      header("Location:uploadPage.php?Message=" . urlencode($Message)."&subject_code=" .urlencode($subject_code) );

		}
	}else{
    $Message = "File size should be 500 KiloBytes & Only PDF File";
    header("Location:uploadPage.php?Message=" . urlencode($Message)."&subject_code=" .urlencode($subject_code) );

	}
}else{
  $Message = "Please Select a File";
  header("Location:uploadPage.php?Message=" . urlencode($Message)."&subject_code=" .urlencode($subject_code) );

}





/*
$connection = mysqli_connect('localhost', 'root','', 'upload');
if (!$connection){
    die("Database Connection Failed" . mysqli_error($connection));
}
*/




 ?>
