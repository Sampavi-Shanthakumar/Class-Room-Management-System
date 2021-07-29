
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

<!DOCTYPE html>
<head>
<style>


.form-signin {
  max-width: 330px;
  padding: 15px;
  margin: 0 auto;
}
.form-signin .form-signin-heading,
.form-signin .checkbox {
  margin-bottom: 10px;
}
.form-signin .checkbox {
  font-weight: normal;
}
.form-signin .form-control {
  position: relative;
  height: auto;
  -webkit-box-sizing: border-box;
     -moz-box-sizing: border-box;
          box-sizing: border-box;
  padding: 10px;
  font-size: 16px;
}
.form-signin .form-control:focus {
  z-index: 2;
}
.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
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
   <div class="container">
		<div class="row">
<div class="col-6">





    <form class="form-signin" method="POST" enctype="multipart/form-data" action="uploadTimetableCode.php">
      <?php if(isset($smsg)){ ?><div class="alert alert-success" role="alert"> <?php echo $smsg; ?> </div><?php } ?>
      <?php if(isset($fmsg)){ ?><div class="alert alert-danger" role="alert"> <?php echo $fmsg; ?> </div><?php } ?>


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



  <h2 class="form-signin-heading">Upload File</h2>
<div class="form-group">
<label for="InputFile">File input</label>
<input type="file" name="file" id="InputFile">

</div>
  <button class="btn btn-lg btn-success" type="submit">Upload</button>
</form>
</div>
<div class="col-6">
<img src="image/upload.jpg" style="weight:400px;height:400px;margin-top:15px;margin-left:35px;border-radius:50%; box-shadow:5px 10px #888888">
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
