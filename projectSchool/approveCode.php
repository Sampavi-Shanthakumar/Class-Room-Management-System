
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


	$count=$_SESSION['count'];
	$i1=0;
	for($i=1;$i<=$count;$i++)
	{
		if(isset($_POST['check'.$i]))
		{
			$checkA[$i1]=$_POST['check'.$i];
			$i1++;
		}
	}

	for($i=0;$i<sizeof($checkA);$i++)
	{
		echo $checkA[$i]."<br>";
	}

	for($i=0;$i<sizeof($checkA);$i++)
	{
		$update_query="update login set status=1 where user_name='$checkA[$i]'";
		$query=mysqli_query($db,$update_query);
		if($_SESSION['Home']=="Students")
		{
			$Message = "Approved successfully!";
		  header("Location:studentApproval.php?Message=" . urlencode($Message));

		}
		else
		{
			$Message = "Approved successfully!";
		  header("Location:teacherApproval.php?Message=" . urlencode($Message));

		}
	}
?>
