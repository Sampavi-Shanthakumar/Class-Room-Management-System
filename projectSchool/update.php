
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
    <?php

    if(isset($_POST["action"]))  {

    if($_POST["action"] == "update")
             {

     $output = '';

      $sid = mysqli_real_escape_string($db, $_POST["userid"]);
      echo "hello";
      $output .='
      $sql="select * from student where student_id='$sid'";
      $result=mysqli_query($db,$sql);

      if(!$result)
      {
        echo " Error".mysqli_error($db);
      }
      else
      {
        while($row=mysqli_fetch_array($result,MYSQLI_NUM))
        {
          echo "
          <div>
          <form>
          <div class='form-group'><center><legend>Student Profile</legend></center></div>
          <div class='form-group'><label>Student Id: </label><input name='studentid' placeholder='Student Id' value=".$row['student_id']." style='width:400px'  ></div>
           <div class='form-group'><label>First Name: </label><input name='firstname' placeholder='First Name' value=".$row['first_name']." style='width:400px'  ></div>
           <div class='form-group'> <label>Last Name: </label><input name='lastname' placeholder='Last Name' value=".$row['last_name']." style='width:400px' ></div>
           <div class='form-group'><label>Date Of Birth: </label><input name='dob' placeholder='date of birth' value=".$row['date_of_birth']." style='width:400px'  ></div>
           <div class='form-group'> <label>Gender: </label><input name='gender' placeholder='gender' value=".$row['gender']." style='width:400px'  ></div>
           <div class='form-group'> <label>Grade: </label><input type='text' name='grade' placeholder='Grade' value=".$row['Grade']." style='width:400px'></div>
           <div class='form-group'> <label>Division: </label><input type='text' name='division' placeholder='Division' value=".$row['division']." style='width:400px' ></div>
           <fieldset>
           <legend>Address</legend>
           <div class='form-group'><label>Number: </label><input name='no' placeholder='number' value=".$row['no']." style='width:400px'  ></div>
           <div class='form-group'><label>Street: </label><input name='street' placeholder='street' value=".$row['street']." style='width:400px'  ></div>
           <div class='form-group'><label>City: </label><input name='city' placeholder='city'  value=".$row['city']." style='width:400px' ></div>
           </fieldset>
           <fieldset>
           <legend>Contact</legend>
           <div class='form-group'><label>Phone No: </label><input name='phoneNo' placeholder='phone no' value=".$row['phone_no']." style='width:400px' ></div>
           <div class='form-group'><label>Email: </label> <input name='email' placeholder='email' value=".$row['email']." style='width:400px' ></div>
           </fieldset>

           <div class='form-group'><button type='submit' name='user_edit' value='Edit' class='btn btn-info btn-lg'>Edit</button> </div>
           <div class='form-group'><button type='submit' name='user_delete' value='Delete'  class='btn btn-info btn-lg'><a href = 'delete.php'>Delete</a></button> </div>

           </form>
           </div>';
           echo $output;
    }
    }
    		 }
    }

     mysqli_close($db);
     ?>



  <?php include('Footer.php'); ?>
</body>
</html>
