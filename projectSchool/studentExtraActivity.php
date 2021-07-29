
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

$sql = "SELECT * from student where user_id = '$uid'";
$result = mysqli_query($db,$sql);
$row = mysqli_fetch_assoc($result);
$sid = $row['student_id'];
 ?>
<!DOCTYPE html>
<html>

<head>
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

  <div class="panel panel-default">
  <div class="panel-body" style="margin-left:30px;margin-right:30px;">
  <center><h1 style="font-family:lato">Students' Extracuricular Activities</h1></center>

<div>
	<section class="">

              <div  class="form-group">
                      <table class="table thead-dark">
                            <tr>
                 <th>Student Name</th>
                  <th>Class</th>
                   <th>Division</th>
                 <th>Section</th>
                 <th>Type</th>
                   <th>Year</th>
                 <th>participation Level</th>
                 <th>Place </th>


                            </tr>



                <?php
                 $output = '';
                $query ="SELECT * from extra_activity e , student s , class c , division d where s.student_id=e.student_id and c.class_id = s.class_id and d.division_id=s.division_id and e.student_id = '$sid'";

                  if(mysqli_query($db, $query)){
                    $result= mysqli_query($db, $query);


                if((mysqli_num_rows($result)) > 0)
                  {
                       while($row= mysqli_fetch_array($result))
                       {

                            $output .= '
                                 <tr>

                         <td>'.$row["first_name"].' '.$row["last_name"].'</td>
                         <td>'.$row["grade"].'</td>
                         <td>'.$row["division_name"].'</td>
                         <td>'.$row["section"].'</td>
                         <td>'.$row["type"].'</td>
                         <td>'.$row["year"].'</td>
                         <td>'.$row["participation_level"].'</td>
                         <td>'.$row["place"].'</td>


                                 </tr>
                            ';
                       }
                  }
                  else
                  {
                       $output .= '
                            <tr>
                                 <td colspan="4">Data not Found</td>
                            </tr>
                       ';
                  }
                }

                  $output .= '</table>
                  </div>';
                  echo $output;

?>




				</section>


</div>


</div>
</div>
</div>


  <?php include('Footer.php'); ?>
</body>
</html>
