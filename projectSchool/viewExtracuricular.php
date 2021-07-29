
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
<link rel="stylesheet" type="text/css" href="css/Adduser.css">


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <script type="text/javascript">
    $(function(){
    $('#search').click(function(){

    var action ="filter";
    var userid = $('#userid').val();


     $.ajax({
               url : "viewExtracuricularCode.php",
               method:"POST",
               data:{action:action, userid:userid},
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
  <center><h1 style="font-family:lato">Students' Extracuricular Activities</h1></center>

<div class="form-group">
  <label>Student Id:</label>

  <input name="userid" id="userid" placeholder="Student Id" style="width:500px" class="form-control" >
</div>






<button type="button" name="action" id="search" class="btn btn-success">Search</button>




<div>
	<section class="">

				 <section class=""  id="panel"></section>


				</section>


</div>


</div>
</div>
</div>


  <?php include('Footer.php'); ?>
</body>
</html>
