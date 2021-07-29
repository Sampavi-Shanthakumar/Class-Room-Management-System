
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

$id = $_GET['id'];
$sql = "SELECT * from extra_activity e , student s where e.student_id = s.student_id and e.extra_activity_id = '$id'";
$result = mysqli_query($db,$sql);
$row = mysqli_fetch_assoc($result);
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



        <h3>
        <center><h3 style="font-family:lato">Students' Extra Curricular Activities</h3></center>
         </h3>
         <div class="container">
           <form class="" action="editExtraActivityCode.php?id=<?php echo $id;?>" method="post" autocomplete="off">


         <table class="table table-bordered" id="tableA" style="background-color:#e5e7ea">
           <thead>
             <tr class="bg-info" style="text-align: center;">
               <th scope="col" style="font-family:lato;background-color:#e5e7ea;">Student Id</th>
               <th scope="col" style="font-family:lato;background-color:#e5e7ea;">Section</th>
               <th scope="col" style="font-family:lato;background-color:#e5e7ea;">Type</th>
                 <th scope="col" style="font-family:lato;background-color:#e5e7ea;">Year</th>
               <th scope="col" style="font-family:lato;background-color:#e5e7ea;">participation Level</th>
               <th scope="col" style="font-family:lato;background-color:#e5e7ea;">Place </th>

             </tr>
           </thead>
           <tbody>
             <tr>
               <td><input type="text" class="form-control" id="data12"  name="student_id" value="<?php echo $row['student_id'] ?>"></td>
               <td><input type="text" class="form-control" id="data13" name="section" value="<?php echo $row['section']; ?>"></td>
               <td><input type="text" class="form-control" id="data14" name="type" value="<?php echo $row['type']; ?>"></td>
               <td><input type="text" class="form-control" id="data15" name="year" value="<?php echo $row['year']; ?>" ></td>
               <td>
                 <select class="form-control" id="sel1" name="level">
                   <option value="<?php echo $row['participation_level']; ?>"> <?php echo $row['participation_level']; ?></option>
                   <option value="Divional">Divisional</option>
                   <option value="Zonal">Zonal</option>
                   <option value="District">District</option>
                   <option value="Provincal">Provincal</option>
                   <option value="National">National</option>
                 </select>
               </td>

							 <td><input type="text" class="form-control" id="data17" name="place_no" value="<?php echo $row['place']; ?>"></td>

             </tr>

           </tbody>
         </table>



         <button type="submit" name="edit_activity" class="btn btn-secondary">Submit</button>
         </div>
     </form>
     <?php include('Footer.php'); ?>

     </body>
     </html>
