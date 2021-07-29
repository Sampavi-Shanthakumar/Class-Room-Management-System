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

$sql = "SELECT * from teacher where user_id = '$uid'";
$result1 = mysqli_query($db,$sql);
$row1 = mysqli_fetch_array($result1);
$tid = $row1['teacher_id'];


$name = $_FILES['file']['name'];
$size = $_FILES['file']['size'];
$type = $_FILES['file']['type'];
$tmp_name = $_FILES['file']['tmp_name'];
$subject_code = $_POST['Subject'];
$division = $_POST['Division'];
$class = $_POST['Grade'];
$time = date("H:i:s");
$date = date("Y-m-d");
//echo var_dump($size);
//echo var_dump($type);
//echo var_dump($tmp_name);

$max_size = 500000;
//$extension = substr($name, strpos($name, '.') + 1);
$extension = pathinfo($name,PATHINFO_EXTENSION);
//echo var_dump($extension);



if(isset($name) && !empty($name)){
  //if(($extension == $size<=$max_size){
  if(($extension == "jpg" || $extension == "jpeg" || $extension == "png" || $extension == "pdf") && ($type=="application/pdf" || $type=="image/gif" || $type=="image/jpeg" || $type=="image/png") && $extension == $size<=$max_size){
		$location = "uploads/";
		if(move_uploaded_file($tmp_name, $location.$name)){

			$query = "INSERT INTO `upload` (teacher_id,subject_code,division_id,class_id,name, size, type, location,date_upload,time_upload) VALUES ('$tid','$subject_code','$division','$class','$name', '$size', '$type', '$location$name','$date','$time')";
			//echo var_dump($query);
			//$result = mysqli_query($db, $query);

      if(mysqli_query($db, $query)){
        $Message = "Uploaded Successfully";
        header("Location:uploadPageTeacher.php?Message=" . urlencode($Message)."&subject_code=" .urlencode($subject_code) );

    }
    }else{
      $Message = "Failed to Upload File";
      header("Location:uploadPageTeacher.php?Message=" . urlencode($Message)."&subject_code=" .urlencode($subject_code) );

    }
  }else{
    $Message = "File size should be 500 KiloBytes";
    header("Location:uploadPageTeacher.php?Message=" . urlencode($Message)."&subject_code=" .urlencode($subject_code) );

  }
}else{
  $Message = "Please Select a File";
  header("Location:uploadPageTeacher.php?Message=" . urlencode($Message)."&subject_code=" .urlencode($subject_code) );

}

 ?>
