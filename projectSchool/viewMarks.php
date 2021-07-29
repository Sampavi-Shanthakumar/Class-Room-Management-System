
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
 ?>
<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="css/nav.css">
  <link rel="stylesheet" type="text/css" href="css/students.css">

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <script type="text/javascript">
    $(function(){
    $('#search').click(function(){

    var action ="filter";
    var subject_code = $('#subject').val();
    var userid = $('#userid').val();
    var class_id = $('#class').val();
    var division_id = $('#division').val();
    var term = $('#term').val();

     $.ajax({
               url : "viewStudentMarks.php",
               method:"POST",
               data:{action:action, subject_code:subject_code, userid:userid ,class_id:class_id, division_id:division_id,term:term},
               success:function(data){

                    $('#panel').html(data);
               }
          });


  });
  });


    </script>



</head>
<body style="width:2000px">
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


    <div class="panel panel-default">
  <div class="panel-body" style="height:auto; width:2000px;">
    <center><h1 style="font-family:lato">Students' Marks</h1></center>
    <div class="row">
  <div class="col-4">
  <img src="image/16.jpg" style="margin-left:100px">
  </div>

<div class="col-8">
<?php

$query2 = "SELECT * from subject order by subject_code";
$result2 = $db->query($query2);
			 ?>

			 <div class="form-group"><label for="cell">Subject: </label>
			 <select class="form-control" id="subject" name="Subject" style="width:200px">

								<option value="">select subject </option>
 <?php
	 if($result2->num_rows>0){
		 while($row2 = $result2->fetch_assoc()){
			 echo "<option value='".$row2['subject_code']."'>".$row2["subject_name"]."</option>";
		 }
	 }

	 ?>
			 </select>
</div>

<div>
  <label>Student Id:</label>

  <input name="userid" id="userid" placeholder="Student Id" style="width:200px" class="form-control" >
</div>

<?php


$query = "SELECT * from class order by class_id";
$result = $db->query($query);
	 ?>
	 <div class="form-group"><label for="cell">Class: </label>
	 <select class="form-control" id="class" name="Grade" style="width:200px" >
 <option value=""> select grade</option>
 <?php
	 if($result->num_rows>0){
		 while($row = $result->fetch_assoc()){
			 //echo "<option>".$row["grade"]."</option>";
			 echo "<option value='".$row['class_id']."'>".$row['grade']."</option>";
		 }
	 }
	 ?>
</select>
</div>






<?php


$query1 = "SELECT * from division order by division_id";
$result1 = $db->query($query1);
			 ?>

			 <div class="form-group"><label for="cell">Division: </label>
			 <select class="form-control" id="division" name="Division" style="width:200px">

									<option value="">select division </option>
 <?php
	 if($result1->num_rows>0){
		 while($row1 = $result1->fetch_assoc()){
			 echo "<option value='".$row1['division_id']."'>".$row1["division_name"]."</option>";
		 }
	 }
	 		mysqli_close($db);
	 ?>
			 </select>
</div>

<div class="form-group"><label>Term : </label><br/>
  <select class="form-control" id="term" name="Term" style="width:200px" >
<option value=""> Select Term</option>
<option value="1"> 1st Term</option>
<option value="2"> 2nd Term</option>
<option value="3"> 3rd Term</option>
</select>
</div>

<button type="button" name="action" id="search" class="btn btn-success">Search</button>



</div>
<div>
	<section class="">
      <form action="viewStudentMarks.php" method="post">
				 <section class=""  id="panel"></section>


				</section>

      </form>
</div>


</div>
</div>
</div>
</div>
  <?php include('Footer.php'); ?>
</body>
</html>
