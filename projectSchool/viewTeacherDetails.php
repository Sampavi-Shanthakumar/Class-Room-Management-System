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
<html><?php

if (isset($_GET['Message'])) {
		print '<script type="text/javascript">alert("' . $_GET['Message'] . '");</script>';
}
 ?>

<link rel="stylesheet" type="text/css" href="css/nav.css">
<link rel="stylesheet" type="text/css" href="css/studentDetails.css">

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <script type="text/javascript">
    $(function(){
    $('#search').click(function(){

    var action ="filter";
    var userid = $('#userid').val();
    var subject_code = $('#subject').val();


     $.ajax({
               url : "viewTeacherDetailsCode.php",
               method:"POST",
               data:{action:action, userid:userid, subject_code:subject_code},
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
  <div class="panel-body">
  		<center><h1 style="font-family:lato">View Teacher Details</h1></center>
      <div class="container">
      <div class="row">
        <div class="col-6">
          <img src="image/search2.jpg">
        </div>
        <div class="col-6" style="margin-top:50px">


      <section>
        <div class="form-group">

          <label>Teacher Id:</label>

          <input name="userid" id="userid" placeholder="Teacher Id" style="width:200px" class="form-control"></div>

       <?php


      $query = "SELECT * from subject order by subject_code";
      $result = $db->query($query);
          ?>

<div class="form-group">
                  <select class="form-control" id="subject" style="width:200px">
                         <option value="">Select Subject </option>
        <?php
          if($result->num_rows>0){
            while($row = $result->fetch_assoc()){
              echo "<option value='".$row['subject_code']."'>".$row["subject_name"]."</option>";
            }
          }
          ?>
</select></div>





      <button type="button" name="action" id="search" class="btn btn-success" style="float:right">Search</button>
</div>
      <div>
        <section class=""  id="panel"></section>
      </div>


      </section>


</div>
</div>
</div>
</div>
</div>
</body>
<?php include('Footer.php'); ?>
</html>
