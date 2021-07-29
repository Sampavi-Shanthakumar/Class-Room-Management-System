
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
<link rel="stylesheet" type="text/css" href="css/Adduser.css">
<link rel="stylesheet" type="text/css" href="css/addMarks.css">

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <script type="text/javascript">
    $(function(){
    $('#search').click(function(){

    var action ="filter";
    var userid = $('#userid').val();

    var term = $('#term').val();

     $.ajax({
               url : "reportStudent.php",
               method:"POST",
               data:{action:action, userid:userid,term:term},
               success:function(data){

                    $('#panel').html(data);
               }
          });


  });
  });


    </script>



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
  <div class="panel panel-default">
<div class="panel-body" style="margin-left:30px;margin-right:30px;">
  <center><h3 style="font-family:lato">Students' Marks Report</h3></center>
  <div class="row">
  <div class="col-6">
  <img src="image/report-card.jpg">
  </div>


  <div class="col-6" style="margin-top:30px">


<div class="form-group"><label>Term : </label><br/>
  <select class="form-control" id="term" name="Term" style="width:200px" class="form-control">
<option value=""> Select Term</option>
<option value="1"> 1st Term</option>
<option value="2"> 2nd Term</option>
<option value="3"> 3rd Term</option>
</select>
</div>





<button type="button" name="action" id="search" class="btn btn-success" style="margin-left:300px">Search</button>
</div>
</div>



<div>
	<section class="">

				 <section class=""  id="panel"></section>


				</section>


</div>


</div>




</body>
  <?php include('Footer.php'); ?>
</html>
