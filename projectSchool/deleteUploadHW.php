
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


//echo var_dump($_GET['id']);
$id = $_GET['id'];
if(isset($_GET['id']) && !empty($_GET['id'])){
	$selsql = "SELECT * FROM upload  WHERE id='$id'";
  //echo var_dump($selsql);
  //echo var_dump(mysqli_query($db, $selsql));
	$result = mysqli_query($db, $selsql);
	$r = mysqli_fetch_assoc($result);
	$subject_code =$r['subject_code'];
	unlink($r['location']);
}else{
	header("Location: view.php");
}


if(!unlink($r['location'])){
	$delsql="DELETE FROM `upload` WHERE id='$id'";
	if(mysqli_query($db, $delsql)){
		header("Location: viewUploadHW.php?subject_code=$subject_code");
	}
}
 ?>
