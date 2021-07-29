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



$query = "SELECT * FROM timetable t , class c , division d where c.class_id=t.class_id and d.division_id=t.division_id ";
$result = mysqli_query($db, $query);


 ?>


<!DOCTYPE html>

  <head>
   <script>
    function DeleteFile(id) {
        if (confirm("Are you sure?")) {
            // your deletion code
            window.location.href='deleteTimetable.php?id='+id;
        }
        return false;
    }
    </script>




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







<table class="table">
  <thead>
    <tr>

      <th>Class</th>
      <th>Division</th>
      <th>Name</th>
      <th>Edit</th>

    </tr>
  </thead>
  <tbody>
  <?php
  	while($r = mysqli_fetch_assoc($result)){
   ?>
    <tr>
      <td><?php echo $r['grade'] ?></td>
      <td><?php echo $r['division_name'] ?></td>
      <td><a href="<?php echo $r['location'] ?>"><?php echo $r['name']; ?></a></td>
      <td><a href="deleteTimetable.php?id=<?php echo $r['id'] ?>" class="btn btn-danger"onclick='DeleteFile(<?php echo $r['id'] ?>)'>Edit</a></td>
    </tr>
    <?php
    }
    ?>
  </tbody>
</table>
</div>
</div>
</div>
</div>
<?php include('Footer.php'); ?>

  </body>
</html>
