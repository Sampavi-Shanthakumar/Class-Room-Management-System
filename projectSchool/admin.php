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
$sql = "SELECT * from admin a, login l where l.user_id ='".$uid."' and l.user_id = a.user_id ";
$result = mysqli_query($db,$sql);
$row = mysqli_fetch_array($result);
$count = mysqli_num_rows($result);
  if($count == 1) {

?>
<html>
<body>





<head>
<link rel="stylesheet" type="text/css" href="css/nav.css">
<link rel="stylesheet" type="text/css" href="css/User.css">
</head>
<body>
	<?php include('Header.php'); ?>

<div class="page">
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
<div class="container">
    <div class="row">
  		<div class="col-sm-10"><h1 style="font-family:lato">My Profile</h1></div>
    	<div class="col-sm-2"><a class="btn btn-info" href="changePassword.php" style="margin-top:5px;margin-left:60px;"> Change Password</a></div>
    </div>
    <div class="row">
  		<div class="col-sm-3">


      <div class="text-center">
        <img src="image/admin.jpeg" class="img1" style="width:200px" alt="admin">


      </div></hr><br>

<form name="jump" class="center">
<h5 style="color:black;font-size:35px;">Actions</h5></center>

<label class="l1">Add User:</label>
<select name="formal" onchange="javascript:handleSelect(this)"  class="form-control" id="sell" style="width:200px">
<option value="#">Select an option</option>
<option value="AddStudent">Students</option>
<option value="AddTeacher">Teachers</option>
<option value="AddPrincipal">Principal</option>
</select>
<label class="l2">View User:</label>
<select name="formal" onchange="javascript:handleSelect(this)"  class="form-control" id="sell" style="width:200px">
<option value="#">Select an option</option>
<option value="viewStudentDetails">Students</option>
<option value="viewTeacherDetails">Teachers</option>
<option value="viewPrincipal">Principal</option>
</select>
<li class="list-group-item text-center" style="margin-top:20px;width:200px;"><a href="subTeacher.php" style="text-decoration:none"><strong> Subject-Teacher-Class Information</strong></a></li>
<li class="list-group-item text-center" style="margin-top:20px;width:200px;"><a href="extracuricular.php" style="text-decoration:none"><strong>Add Extra Curricular Activities</strong></a></li>
<li class="list-group-item text-center" style="margin-top:20px;width:200px;"><a href="viewExtracuricular.php" style="text-decoration:none"><strong>Student Extra Curricular Activities</strong></a></li>
<li class="list-group-item text-center" style="margin-top:20px;width:200px;"><a href="uploadTimetable.php" style="text-decoration:none"><strong>Upload Timetable</strong></a></li>
<li class="list-group-item text-center" style="margin-top:20px;width:200px;"><a href="viewTimetable.php" style="text-decoration:none"><strong>View Timetable</strong></a></li>
<li class="list-group-item text-center" style="margin-top:20px;width:200px;"><a href="viewComplaintAdmin.php" style="text-decoration:none"><strong>View Complaints</strong></a></li>
</form>

 </div><!--/col-3-->
 <div class="panel panel-default">
<div class="panel-body" style="width:700px;margin-left:100px;">
    	<div class="col-sm-9">


                  <form class="form" action="##" method="post" id="registrationForm">
                      <center><h3 style="margin-left:50px;font-family:lato;">Personal Details</h3></center>
                      <hr/>
                      <div class="form-group">

                          <div class="col-xs-12">

                              <label for="Firstname"><h4>First name:&nbsp; &nbsp; <?php echo $row['first_name'];?></h4></label>

                          </div>
                      </div>
                      <div class="form-group">

                          <div class="col-xs-12">
                            <label for="Lastname"><h4>Last name:&nbsp; &nbsp;<?php echo $row['last_name'];?></i></h4></label>

                          </div>
                      </div>

                      <div class="form-group">

                          <div class="col-xs-12">
                              <label for="dob"><h4>Date of Birth:&nbsp; &nbsp;<?php echo $row['date_of_birth'];?></h4></label>

                          </div>
                      </div>

                      <div class="form-group">
                          <div class="col-xs-12">
                             <label for="Gender"><h4>Gender:&nbsp; &nbsp; <?php echo $row['gender'];?></h4></label>

                          </div>
                      </div>

					  <label><h4>Address</h4></label>
					  <hr>
                      <div class="form-group">

                          <div class="col-xs-12">
                              <label for="Number"><h4>Number:&nbsp; &nbsp; <?php echo $row['no'];?></h4></label>

                          </div>
                      </div>
                      <div class="form-group">

                          <div class="col-xs-12">
                            <label for="Street"><h4>Street:&nbsp; &nbsp;<?php echo $row['street'];?></h4></label>

                          </div>
                      </div>
                      <div class="form-group">

                          <div class="col-xs-12">
                            <label for="City"><h4>City:&nbsp; &nbsp;<?php echo $row['city'];?></h4></label>

                          </div>
                      </div>
					  <div class="form-group">
                          <label><h4>Contact</h4></label>
						  <hr>
                          <div class="col-xs-12">
                            <label for="Phonenumber"><h4>Phone Number:&nbsp; &nbsp; <?php echo $row['phone_no'];?> </h4></label>

                          </div>
                      </div>
					  <div class="form-group">

                          <div class="col-xs-12">
                            <label for="Email"><h4>Email:&nbsp; &nbsp;<?php echo $row['email'];?></h4></label>

                          </div>
                      </div>
</div>
</div>
</div>
</div>
</div>
</div>
	<script type="text/javascript">
function handleSelect(elm)
{
window.location = elm.value+".php";
}
</script>
  <?php include('Footer.php'); ?>
</body>
</html>
<?php
}
 ?>
