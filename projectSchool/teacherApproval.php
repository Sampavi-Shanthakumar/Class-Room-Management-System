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



if (isset($_GET['Message'])) {
		print '<script type="text/javascript">alert("' . $_GET['Message'] . '");</script>';
}
 ?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/nav.css">
<link rel="stylesheet" type="text/css" href="css/approval.css">
</head>
<body>

<div class="page" style="width:1650px">
<?php include('Header.php'); ?>
<div class="nav">
<ul>
<li class="home" style="margin-left:50px;"><a href="index.php">Home</a></li>
<li class="about" style="margin-left:50px;"><a href="About.php">About</a></li>

<li class="Login" style="margin-left:50px;"><a href="logout.php">Logout</a></li>

<li class="syllabus"style="margin-left:50px;"><a href="#">Syllabus</a>
<ul>
<li><a href="GradeSix.php">Grade 6</a></li>
<li><a href="GradeSeven.php">Grade 7</a></li>
<li><a href="GradeEight.php">Grade 8</a></li>
<li><a href="GradeNine.php">Grade 9</a></li>
<li><a href="GradeTen.php">Grade 10</a></li>
<li><a href="GradeEleven.php">Grade 11</a></li>

</ul>
</li>

</ul>
</div>

   <div class="page">
     <form action="approveCode.php" method="post">
     <table class="table table-bordered">
       <thead>
         <tr>
         <th>Approve</th>
         <th>Username</th>
         <th>Password</th>
         <th>User Type</th>
   	  <th>Teacher Id</th>
   	  <th>First Name</th>
   	  <th>Last Name</th>
   	  <th>Date of Birth</th>
   	  <th>Gender</th>
   	  <th>Subject</th>
   	  <th>Number</th>
   	  <th>Street</th>
   	  <th>City</th>
   	  <th>Phone Number</th>
      <th>Email</th>
         </tr>
       </thead>
       <tbody>
   	<?php


   	$sql="select * from login l inner join teacher t inner join subject s on l.user_id=t.user_id and s.subject_code = t.subject_code";
   	$result=mysqli_query($db,$sql);
   	$i1=1;
   	while($row=mysqli_fetch_array($result))
   	{
      if($row['status'] == 0){
   		echo"
   		<tr>
           <td><input type='checkbox' name='check".$i1."' value=".$row[0].">&nbsp;</td>
   		<td><input type='text' value=".$row[0]."></td>

   		<td>".$row['password']."</td>
   		<td>".$row['user_type']."</td>
   		<td>".$row['teacher_id']."</td>
   		<td>".$row['first_name']."</td>
   		<td>".$row['last_name']."</td>
   		<td>".$row['date_of_birth']."</td>
   		<td>".$row['gender']."</td>
   		<td>".$row['subject_name']."</td>
   		<td>".$row['no']."</td>
   		<td>".$row['street']."</td>
   		<td>".$row['city']."</td>
   		<td>".$row['phone_no']."</td>
      	<td>".$row['email']."</td>
   		</tr>
   		";
   		$i1++;
   	}
  }
   	$_SESSION['count']=$i1;
   	$_SESSION['Home']="Teachers";
   	?>
       </tbody>
     </table>
   </div>
   <div class="form-group"><button type="submit" value="approve" class="btn btn-success" style="float:right">Approve</button> </div>
   </form>


    <?php include('Footer.php'); ?>
	</div>
</body>
</html>
