<!DOCType html>
<html>
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




<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/nav.css">
<link rel="stylesheet" type="text/css" href="css/Adduser.css">
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
<div class="panel panel-default">
<div class="panel-body">
		<form method="post" action="AddTeacherCode.php" autocomplete="off">
		<center><h5 class="heading" style="font-size:30px;font-family:lato;">Teacher Profile</h5></center><hr>

		<div class="row">
		<div class="col-6">
		 <div class="form-group"><label>User Name: </label><br/>
		 <input name="Username" placeholder="user name" type="text" class="form-control" required></div>
		 <div class="form-group"><label>password: </label><br/>
		 <input name="Password" type="password" placeholder="*****" class="form-control" required></div>
		 <div class="form-group"><label>User Type: </label><br/>
			 <select class="form-control" id="user" name="Usertype" style="width:200px" >
					<option value="" selected> Select User Type</option>
				<option value="Student"> Student</option>
				<option value="Teacher"> Teacher</option>
				<option value="Principal"> Principal</option>
			</select></div>
		 <div class="form-group"><label>Teacher Id: </label><br/>
		 <input name="Teacherid" placeholder="teacher id" type="text" pattern="[A-Za-z0-9]{4}" class="form-control" required></div>
	     <div class="form-group"><label>First Name: </label><br/>
		 <input name="Firstname" placeholder="first name" type="text"  id="text4" class="form-control" required></div>
		 <script>
		$(function() {
	 $('#text4').keydown(function (e) {
		 if (e.shiftKey || e.ctrlKey || e.altKey) {
		 e.preventDefault();
					 } else {
				 var key = e.keyCode;
				 if (!((key == 8) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
					e.preventDefault();
						}
					}
			 });
			});

		</script>
		 <div class="form-group"> <label>Last Name: </label><br/>
		 <input name="Lastname" placeholder="last name" type="text"  id="text3"  class="form-control" required></div>
		 <script>
		$(function() {
	 $('#text3').keydown(function (e) {
		 if (e.shiftKey || e.ctrlKey || e.altKey) {
		 e.preventDefault();
					 } else {
				 var key = e.keyCode;
				 if (!((key == 8) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
					e.preventDefault();
						}
					}
			 });
			});

		</script>
		 <div class="form-group"><label>Date Of Birth: </label><br/>
			 <span>
				 <div class="row">
					 <div class="col-4">
						 <select type="text" name="month" class="form-control" style="width:100px">
							 <?php for( $m=1; $m<=12; ++$m ) {
								 $month_label = date('F', mktime(0, 0, 0, $m, 1));
							 ?>
								 <option value="<?php echo $m; ?>"><?php echo $month_label; ?></option>
							 <?php } ?>
						 </select>
					 </span>
				 </div>
				<div class="col-4">
					 <span>

						 <select name="day" class="form-control" style="width:100px">
							 <?php
								 $start_date = 1;
								 $end_date   = 31;
								 for( $j=$start_date; $j<=$end_date; $j++ ) {
									 echo '<option value='.$j.'>'.$j.'</option>';
								 }
							 ?>
						 </select>
					 </span>
				 </div>
				<div class="col-4">
					 <span>
						 <select name="year" class="form-control" style="width:100px">
							 <?php
								 $year = date('Y');
								 $min = $year - 60;
								 $max = $year;
								 for( $i=$max; $i>=$min; $i-- ) {
									 echo '<option value='.$i.'>'.$i.'</option>';
								 }
							 ?>
						 </select>
					 </span>
				 </div>
			 </div>
				 </div>
		 <div class="form-group"> <label>Gender: </label><br/>
			 <label>Male </label>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input name="Gender" placeholder="gender" type="radio" value="Male"  required>&nbsp&nbsp&nbsp&nbsp&nbsp
			 <label>Female </label>&nbsp&nbsp&nbsp&nbsp&nbsp<input name="Gender" placeholder="gender" type="radio" value="Female" required >
		 </div>
	 </div>
   <div class="col-6">
   <div class="form-group"><label for="cell">Subject: </label></br>
 <?php


$query = "SELECT * from subject order by subject_code";
$result = $db->query($query);
    ?>


            <select class="form-control" style="width:200px" id="subject" name="Subject">
                   <option value="">Select Subject </option>
  <?php
    if($result->num_rows>0){
      while($row = $result->fetch_assoc()){
        echo "<option value='".$row['subject_code']."'>".$row["subject_name"]."</option>";
      }
    }
    ?>
</select>

</div>
		 <fieldset>
		 <h3>Address</h3>
		 <div class="form-group"><label>Number: </label><br/>
		 <input name="Number" placeholder="number" type="number" class="form-control" required></div>
		 <div class="form-group"><label>Street: </label><br/>
		 <input name="Street" placeholder="street" type="text"  id="text1"  class="form-control" required></div>
		 <script>
		$(function() {
	 $('#text1').keydown(function (e) {
		 if (e.shiftKey || e.ctrlKey || e.altKey) {
		 e.preventDefault();
					 } else {
				 var key = e.keyCode;
				 if (!((key == 8) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
					e.preventDefault();
						}
					}
			 });
			});

		</script>
		 <div class="form-group"><label>City: </label><br/>
		 <input name="City" placeholder="city" type="text"  id="text2"  class="form-control" required></div>
		 <script>
		$(function() {
	 $('#text2').keydown(function (e) {
		 if (e.shiftKey || e.ctrlKey || e.altKey) {
		 e.preventDefault();
					 } else {
				 var key = e.keyCode;
				 if (!((key == 8) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
					e.preventDefault();
						}
					}
			 });
			});

		</script>
		 </fieldset>
		 <fieldset>
		 <h3>Contact</h3>
		 <div class="form-group"><label>Phone No: </label><br/>
		 <input name="Phoneno" placeholder="phone no" type="tel" maxlength="10" pattern="\d{10}" title="Please enter exactly 10 digits" class="form-control" required></div>
		 <div class="form-group"><label>Email: </label> <br/>
		 <input name="Email" type="email" placeholder="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required class="form-control" required></div>
		 </fieldset>
		</div>
		</div>

		 <input type="submit" value="Add Teacher Details" name="reg_teacher" id="btn" class="btn btn-success" style="margin-left:900px;">
		 </div>
		 </div>
	 </div>
</div>

  <?php include('Footer.php'); ?>
</body>
</html>
