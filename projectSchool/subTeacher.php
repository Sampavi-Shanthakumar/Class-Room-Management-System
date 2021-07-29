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


if (isset($_GET['Message'])) {
		print '<script type="text/javascript">alert("' . $_GET['Message'] . '");</script>';
}
 ?>
<html>
<body>





<head>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script type="text/javascript">
$(function(){
$('#search').click(function(){

var action ="filter";
var teacher_id = $('#teacher').val();
var class_id = $('#class').val();
var division_id = $('#division').val();
var subject_code = $('#subject').val();

 $.ajax({
           url : "viewSubTeacherCode.php",
           method:"POST",
           data:{action:action, teacher_id:teacher_id, class_id:class_id, division_id:division_id, subject_code:subject_code},
           success:function(data){

                $('#panel').html(data);
           }
      });


});
});
</script>
<link rel="stylesheet" type="text/css" href="css/nav.css">
<link rel="stylesheet" type="text/css" href="submission.css">
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
<div class="panel-body"style="height:auto" >
<div class="container">
		<div class="row">
<div class="col-6">

<form class="" action="" name="subTeacher" method="post">


<?php
$query1 = "SELECT * from teacher order by teacher_id ";
$result1 = $db->query($query1);
    ?>

    <div class="form-group"><label for="cell">Teacher Name: </label><br/>
    <select class="form-control" id="teacher" name="Teacher" style="width:200px">

               <option value="">select name </option>
<?php
if($result1->num_rows>0){
  while($row1 = $result1->fetch_assoc()){
    echo "<option value='".$row1['teacher_id']."'>".$row1['first_name']." ".$row1['last_name']."</option>";
  }
}

?>
    </select>
  </div>



<?php


$query1 = "SELECT * from subject order by subject_code ";
$result1 = $db->query($query1);
    ?>

    <div class="form-group"><label for="cell">Subject: </label><br/>
    <select class="form-control" id="subject" name="Subject" style="width:200px">

               <option value="">select subject </option>
<?php
if($result1->num_rows>0){
  while($row1 = $result1->fetch_assoc()){
    echo "<option value='".$row1['subject_code']."'>".$row1['subject_name']."</option>";
  }
}

?>
    </select>
  </div>



<?php


$query = "SELECT * from class order by class_id ";
$result = $db->query($query);
   ?>
   <div class="form-group"><label for="cell">Class: </label><br/>
   <select class="form-control" id="class" name="Grade" style="width:200px" onchange="java_script_:show(this.options[this.selectedIndex].value)">
 <option value="" selected> select grade</option>
 <?php
   if($result->num_rows>0){
     while($row = $result->fetch_assoc()){
       echo "<option value ='".$row['class_id']."' >".$row['grade']."</option>";
     }
   }
   ?>
</select>
</div>

<?php


$query1 = "SELECT * from division order by division_id";
$result1 = $db->query($query1);
    ?>

    <div class="form-group"><label for="cell">Division: </label><br/>
    <select class="form-control" id="division" name="Division" style="width:200px">

               <option value="">select division </option>
<?php
if($result1->num_rows>0){
  while($row1 = $result1->fetch_assoc()){
    echo "<option value='".$row1['division_id']."'>".$row1['division_name']."</option>";
  }
}

?>
    </select>
  </div>
  <button type="sumbit" name="subTeacher" class="btn btn-info">Add</button>

</form>
<button type="button" name="action" id="search" class="btn btn-success" style="float:right">Search</button>

<div>
  <section class=""  id="panel" style="margin-top:20px"></section>
</div>

<?php
if(isset($_POST['subTeacher'])){
  $Message ='';
  $tid = mysqli_real_escape_string($db, $_POST['Teacher']);
  $subject = mysqli_real_escape_string($db, $_POST['Subject']);
  $class = mysqli_real_escape_string($db, $_POST['Grade']);
  $division = mysqli_real_escape_string($db, $_POST['Division']);

  $query = "INSERT INTO class_details (teacher_id,subject_code,class_id,division_id) values ('$tid' , '$subject' , '$class' , '$division')";
  //mysqli_query($db,$query);
  if(mysqli_query($db,$query)){
    $Message = "Inserted successfully!";
    //header("Location:viewPrincipal.php?Message=" . urlencode($Message));
  }
  else{
    $Message = "Failure to insert!";
    //header("Location:viewPrincipal.php?Message=" . urlencode($Message));
  }

  if ($Message != null) {
  		print '<script type="text/javascript">alert("' .$Message. '");</script>';
  }
}
 ?>
 </div>
<div class="col-6">
<img src="image/teacher.jpg" style="weight:300px;height:300px;margin-top:15px;margin-left:35px;border-radius:5px; box-shadow:5px 10px #888888">
</div>
</div>
</div>
</div>
</div>
</div>
</div>
 <?php include('Footer.php'); ?>
 </body>
</html>
