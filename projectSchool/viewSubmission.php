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

$sql = "SELECT * from student where user_id = '$uid'";
$result1 = mysqli_query($db,$sql);
$row1 = mysqli_fetch_array($result1);
$sid = $row1['student_id'];
$subject_code = $_GET['subject_code'];

$query = "SELECT * FROM submission where student_id='$sid' and subject_code='$subject_code'";
$result = mysqli_query($db, $query);


 ?>


<!DOCTYPE html>



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

    <script>
    function DeleteFile(id) {
        if (confirm("Are you sure?")) {
            // your deletion code
            window.location.href='deleteSubmission.php?id='+id;
        }
        return false;
    }
    </script>



  </head>
  <body>




<table class="table">
  <thead>
    <tr>

      <th>Name</th>
      <th>Date</th>
      <th>Time</th>
      <th>edit</th>

    </tr>
  </thead>
  <tbody>
  <?php
  	while($r = mysqli_fetch_assoc($result)){
   ?>
    <tr>
      <td>&#x1f5ce; <a href="<?php echo $r['location'] ?>"><?php echo $r['name']; ?></a></td>
      <td><?php echo $r['date_sub'] ?></td>
      <td><?php echo $r['time_sub'] ?></td>
      <td><a href="deleteSubmission.php?id=<?php echo $r['id'] ?>" class="btn btn-danger"onclick='DeleteFile(<?php echo $r['id'] ?>)'>Edit</a></td>
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
