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


echo "hellooooo";

$name = $_FILES['file']['name'];
$size = $_FILES['file']['size'];
$type = $_FILES['file']['type'];
$tmp_name = $_FILES['file']['tmp_name'];
$division = $_POST['Division'];
$class = $_POST['Grade'];

$max_size = 500000;
$extension = pathinfo($name,PATHINFO_EXTENSION);



if(isset($name) && !empty($name)){
  if(($extension == "jpg" || $extension == "jpeg" || $extension == "png" || $extension == "pdf") && ($type=="application/pdf" || $type=="image/gif" || $type=="image/jpeg" || $type=="image/png") && $extension == $size<=$max_size){
		$location = "uploads/";
		if(move_uploaded_file($tmp_name, $location.$name)){
			$query = "INSERT INTO `timetable` (division_id,class_id,name,location) VALUES ('$division','$class','$name' ,'$location$name')";


      if(mysqli_query($db, $query)){
        $Message = "Uploaded Successfully";
        header("Location:uploadTimetable.php?Message=" . urlencode($Message) );

    }
    }else{
      $Message = "Failed to Upload File";
      header("Location:uploadTimetable.php?Message=" . urlencode($Message) );

    }
  }else{
    $Message = "File size should be 500 KiloBytes";
    header("Location:uploadTimetable.php?Message=" . urlencode($Message));

  }
}else{
  $Message = "Please Select a File";
  header("Location:uploadTimetable.php?Message=" . urlencode($Message));

}


 ?>
