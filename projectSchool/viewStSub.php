

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




<html>
<head>
<style>

.panel-body{font-family: Arial, Helvetica, sans-serif;width:60%;margin-left: 20%;
box-sizing: border-box;}
</style>
<link rel="stylesheet" type="text/css" href="css/nav.css">
<link rel="stylesheet" type="text/css" href="submission.css">
</head>
<body>
	<?php include('Header.php'); ?>

<div class="page" style="height:auto;">
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
<?php




$sql = "SELECT * from teacher where user_id = '$uid'";
$result1 = mysqli_query($db,$sql);
$row1 = mysqli_fetch_array($result1);
$tid = $row1['teacher_id'];
 ?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <script type="text/javascript">
    $(function(){
    $('#search').click(function(){

    var action ="filter";
    var subject = $('#subject').val();
    var fromDate = $('#fromDate').val();
    var toDate = $('#toDate').val();
    var grade = $('#grade').val();
    var division = $('#division').val();

     $.ajax({
               url : "viewStSubCode.php",
               method:"POST",
               data:{action:action, subject:subject, division:division ,grade:grade, fromDate:fromDate , toDate:toDate},
               success:function(data){

                    $('#panel').html(data);
               }
          });


  });
  });


    </script>
<div>
<?php


$query = "SELECT * from class c, class_details cd where cd.teacher_id = '$tid' and cd.class_id = c.class_id GROUP BY cd.class_id";
$result = $db->query($query);
   ?>
   <div class="form-group"><label for="cell">Class: </label><br/>
   <select class="form-control" id="grade" name="Grade" style="width:200px" >
 <option value="" selected> select grade</option>
 <?php
   if($result->num_rows>0){
     while($row = $result->fetch_assoc()){
       echo "<option value='".$row['class_id']."'>".$row['grade']."</option>";
     }
   }
   ?>
</select>
</div>

<?php


$query1 = "SELECT * from division d, class_details cd where cd.teacher_id = '$tid' and cd.division_id = d.division_id GROUP BY cd.division_id";
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

  <?php


  $query1 = "SELECT * from subject s, class_details cd where cd.teacher_id = '$tid' and cd.subject_code = s.subject_code group by cd.subject_code";
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

    <label>Due Date</label><br>
    <label>from</label><input type="date" name="duedate" id="fromDate" required class="input">
    <label>To</label><input type="date" name="duedate" id="toDate" required class="input">

<button type="button" name="action" id="search" class="btn btn-success" style="float:right">Search</button>
</div>

<div>


				 <section class=""  id="panel"></section>


				</section>




</div>
</div>
</div>
</div>
</div>
<?php include('Footer.php'); ?>
</body>
</html>
