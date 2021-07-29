<?php
include 'config.php';
session_start();

if(isset($_SESSION['userid'])){
  $uid=$_SESSION['userid'];
  //$uid = $_SESSION['userid'];
}
else {
   header("Location:Login.php");
}

$time = $_SERVER['REQUEST_TIME'];
$timeout_duration = 30*60;


if (isset($_SESSION['LAST_ACTIVITY']) &&
 ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
  session_unset();
  session_destroy();
  session_start();
}

$_SESSION['LAST_ACTIVITY'] = $time;




$sql = "SELECT * from student s, login l , class c , division d where l.user_id ='".$uid."' and l.user_id = s.user_id and c.class_id=s.class_id and d.division_id=s.division_id";
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

<div class="body">
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
    	<div class="col-sm-2"><a class="btn btn-info" href="changePassword.php" style="margin-top:5px;margin-left:60px;"> Change Password</a></br></div>
    </div>
    <div class="row">
  		<div class="col-sm-3"><!--left col-->


      <div class="text-center">
        <img src="image/img1.png" class="img1" style="width:200px" alt="student">


      </div></hr><br>






            <h5 style="color:black;font-size:35px;">Actions</h5>

            <li class="list-group-item text-center" style="margin-top:20px;width:200px;"><a href="report.php" style="text-decoration:none"><strong>View mark</strong></a></li>
            <li class="list-group-item text-center" style="margin-top:20px;width:200px;"><a href="complaint.php" style="text-decoration:none"><strong>Complaint</strong></a></li>

            <li class="list-group-item text-center" style="margin-top:20px;width:200px;"><a href="viewStudentTimetable.php" style="text-decoration:none"><strong>Timetable</strong></a></li>
            <li class="list-group-item text-center" style="margin-top:20px;width:200px;"><a href="studentExtraActivity.php" style="text-decoration:none"><strong>View Achievement</strong></a></li>





<?php
$query = "SELECT * from subject order by subject_code";
$result1 = $db->query($query);
 ?>
 <P><strong>Subject Submission</strong></p>
 <select onchange="location = this.value;" class="form-control">
 <option value="" selected> subject</option>

 <?php
   if($result1->num_rows>0)
   {
     while($row1 = $result1->fetch_assoc()){
       echo "<option value='homework.php?subject_code=".$row1["subject_code"]."'>".$row1['subject_name']."</option>";
     }
   }
   ?>
</select>

        </div><!--/col-3-->
		<div class="panel panel-default">
<div class="panel-body" style="width:700px;margin-left:100px;">
    	<div class="col-sm-9">


                  <form class="form" action="##" method="post" id="registrationForm">
                      <center><h3 style="margin-left:50px;font-family:lato;">Personal Details</h3></center>
                      <hr>
                      <div class="form-group">

                          <div class="col-xs-12">
                              <label for="Firstname"><h4>First name:&nbsp;&nbsp; <?php echo $row['first_name'];?></h4></label>

                          </div>
                      </div>
                      <div class="form-group">

                          <div class="col-xs-12">
                            <label for="Lastname"><h4>Last name:&nbsp;&nbsp;<?php echo $row['last_name'];?></i></h4></label>

                          </div>
                      </div>

                      <div class="form-group">

                          <div class="col-xs-12">
                              <label for="dob"><h4>Date of Birth:&nbsp;&nbsp;<?php echo $row['date_of_birth'];?></h4></label>

                          </div>
                      </div>

                      <div class="form-group">
                          <div class="col-xs-12">
                             <label for="Gender"><h4>Gender:&nbsp;&nbsp; <?php echo $row['gender'];?></h4></label>

                          </div>
                      </div>
                      <div class="form-group">

                          <div class="col-xs-12">
                              <label for="Class"><h4>Class:&nbsp;&nbsp;<?php echo $row['grade'];?></h4></label>

                          </div>
                      </div>
                      <div class="form-group">

                          <div class="col-xs-12">
                              <label for="Division"><h4>Division:&nbsp;&nbsp;<?php echo $row['division_name'];?></h4></label>

                          </div>
                      </div>
					  <label><h4>Address</h4></label>
					  <hr>
                      <div class="form-group">

                          <div class="col-xs-12">
                              <label for="Number"><h4>Number:&nbsp;&nbsp; <?php echo $row['no'];?></h4></label>

                          </div>
                      </div>
                      <div class="form-group">

                          <div class="col-xs-12">
                            <label for="Street"><h4>Street:&nbsp;&nbsp;<?php echo $row['street'];?></h4></label>

                          </div>
                      </div>
                      <div class="form-group">

                          <div class="col-xs-12">
                            <label for="City"><h4>City:&nbsp;&nbsp;<?php echo $row['city'];?></h4></label>

                          </div>
                      </div>
					  <div class="form-group">
                          <label><h4>Contact</h4></label>
						  <hr>
                          <div class="col-xs-12">
                            <label for="Phonenumber"><h4>Phone Number:&nbsp;&nbsp; <?php echo $row['phone_no'];?> </h4></label>

                          </div>
                      </div>
					  <div class="form-group">

                          <div class="col-xs-12">
                            <label for="Email"><h4>Email:&nbsp;&nbsp;<?php echo $row['email'];?></h4></label>

                          </div>
                      </div>

              	</form>
             </div>
            </div>
	</div>
	</div>
	</div>
  <?php include('Footer.php'); ?>
  </body>
  </html>
<?php
}
?>
