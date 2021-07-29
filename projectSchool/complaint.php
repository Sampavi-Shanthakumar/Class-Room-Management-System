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
$sql = "SELECT * from student s, login l , class c , division d where l.user_id ='".$uid."' and l.user_id = s.user_id and c.class_id=s.class_id and d.division_id=s.division_id";
$result = mysqli_query($db,$sql);
$row = mysqli_fetch_array($result);
$sid = $row['student_id'];
$class = $row['class_id'];
$division = $row['division_id'];

if (isset($_GET['Message'])) {
		print '<script type="text/javascript">alert("' . $_GET['Message'] . '");</script>';
}
 ?>
 <html>






<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>

.panel-body{font-family: Arial, Helvetica, sans-serif;width:60%;margin-left: 20%;
box-sizing: border-box;}
input[type=text], select, textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  margin-top: 6px;
  margin-bottom: 16px;
  resize: vertical;
}

input[type=submit] {
  background-color: #4CAF50;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
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




<center><h3>Complaint Form</h3></center>

<div class="container">
  <form action="" method="post" autocomplete="off">

    <label>First Name</label>
    <input type="text"  name="Firstname" placeholder="Your name.." required>

    <label>Last Name</label>
    <input type="text" id="lname" name="Lastname" placeholder="Your last name.." required>

    <label>To</label>
    <select name="recipient">
      <option value="Admin" selected>Admin</option>
      <?php


   	 $query = "SELECT * from teacher t , class_details cd where cd.teacher_id = t.teacher_id and cd.class_id='$class' and cd.division_id='$division' GROUP BY cd.teacher_id";
   	 $result = $db->query($query);

   			if($result->num_rows>0){
   				while($row = $result->fetch_assoc()){
   					  echo "<option value='".$row['teacher_id']."'>".$row["first_name"]." ".$row["last_name"]."</option>";
   				}
   			}
   			?>
    </select>

    <label >Title</label>
    <input type="text"  name="Title" placeholder="Title.." required>

    <label>Subject</label>
    <textarea name="subject" placeholder="Write something.." style="height:200px" required></textarea>

    <input type="submit" value="Submit" name="Complaint">
  </form>
</div>
</div>
</div>
</div>
</div>
<?php include('Footer.php'); ?>
</body>
</html>


<?php
  if(isset($_POST['Complaint'])){
    $fname = mysqli_real_escape_string($db,$_POST['Firstname']);
    $lname = mysqli_real_escape_string($db,$_POST['Lastname']);
    $recipient = mysqli_real_escape_string($db,$_POST['recipient']);
    $title = mysqli_real_escape_string($db,$_POST['Title']);
    $subject = mysqli_real_escape_string($db,$_POST['subject']);



    $query = "INSERT INTO complaint(student_id,first_name,last_name,recipient,title,subject) VALUES ('$sid' , '$fname' , '$lname' , '$recipient' , '$title' , '$subject')";
    if(mysqli_query($db,$query)){
      $Message = "Complaint submitted successfully";
      header("Location:complaint.php?Message=" . urlencode($Message));
    }
    else {
      $Message = "Complaint submitted failure!";
      header("Location:complaint.php?Message=" . urlencode($Message));
    } if ($Message != null) {
  		print '<script type="text/javascript">alert("' .$Message. '");</script>';
  }

    }

 ?>
