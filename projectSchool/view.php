
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
<link rel="stylesheet" type="text/css" href="css/approval.css">
    <meta charset="utf-8">
    <title></title>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
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
<li><a href="#">Grade 6</a></li>
<li><a href="#">Grade 7</a></li>
<li><a href="#">Grade 8</a></li>
<li><a href="#">Grade 9</a></li>
<li><a href="#">Grade 10</a></li>
<li><a href="#">Grade 11</a></li>

</ul>
</li>

</ul>
</div>
    <?php
     //select.php

    if(isset($_POST["action"]))  {

    if($_POST["action"] == "filter")
             {

     $output = '';
     $userid = '';
     $division = '';
     $class1 = '';

      $userid = mysqli_real_escape_string($db, $_POST["userid"]);
      $division=mysqli_real_escape_string($db, $_POST["division"]);
      $class1=mysqli_real_escape_string($db, $_POST["class1"]);




                    $output .= '
                        <table class="table thead-dark">
                              <tr>
    						   <th >Student Id</th>
                                  <th >First Name</th>
                                   <th >Last Name</th>
                                    <th >Gender</th>
    								<th>DOB</th>
    								<th>Phone No</th>
                                   <th>Address</th>
    							  <th width="5%">update</th>
                                   <th width="5%">Delete</th>
                              </tr>
                    ';


                    $query_m1= "SELECT * FROM student where student_id = '".$userid."'  ";
                    $query_m2= "SELECT * FROM student s, class c, division d where  s.class_id = c.class_id and s.division_id=d.division_id and c.grade='".$class1."' and d.division_name='".$division."' ";
                    $query_m3= "SELECT * FROM student s, class c where  s.class_id = c.class_id  and c.grade='".$class1."'  ";

                    if(isset($_POST['userid'])){
                      $result_m= mysqli_query($db, $query_m1);

                    }

                    if(isset($_POST["class1"]) && isset($_POST["division"])){
                     $result_m= mysqli_query($db, $query_m2);

                    }
                     if(isset($_POST["class1"])){
                      $result_m= mysqli_query($db, $query_m3);


                    }



                    if(mysqli_num_rows($result_m) > 0)
                    {
                         while($row = mysqli_fetch_array($result_m))
                         {
                              $output .= '
                                   <tr>
    							         <td>'.$row["student_id"].'</td>

                                        <td>'.$row["first_name"].'</td>
                                       <td>'.$row["last_name"].'</td>

                                        <td>'.$row["gender"].'</td>
                                        <td>'.$row["date_of_birth"].'</td>
                                        <td>'.$row["phone_no"].'</td>
    									 <td>'.$row["no"].','.$row["street"].','.$row["city"].'</td>


                                         <td><button type="button" name="update" id="'.$row["student_id"].'">Update</button></td>

                                        <td><button type="button" name="delete" id="'.$row["student_id"].'" >Delete</button></td>
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
                    $output .= '</table>';
                    echo $output;

    		 }
    }

     mysqli_close($db);
     ?>


</div>

 <?php include('Footer.php'); ?>
</body>
</html>
