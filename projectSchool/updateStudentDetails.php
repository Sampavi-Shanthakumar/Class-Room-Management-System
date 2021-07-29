<?php
include 'config.php' ;
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
?>
<html>





<head>
<link rel="stylesheet" type="text/css" href="css/nav.css">
<link rel="stylesheet" type="text/css" href="css/viewUser.css">

</head>
<body>
	<?php include('Header.php'); ?>

	<div class="page">
	<div class="nav">
	<ul>
	<li class="home" style="margin-left:50px;"><a href="index.php">Home</a></li>
	<li class="about" style="margin-left:50px;"><a href="About.php">About</a></li>

	<li class="Login" style="margin-left:50px;"><a href="logout">Logout</a></li>

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

  		<center><h1 style="font-family:lato">Update Student Details</h1></center>



      <section class="">

                     <section class=""  id="panel2">

<?php

                       $id=$_GET["id"];

                   	  $sql="SELECT * from student s, class c, division d where s.student_id='".$id."' and s.class_id = c.class_id and s.division_id = d.division_id";
                         $result=mysqli_query($db,$sql);



                         if(!$result)
                         {
                           //echo " Error".mysqli_error($db);
                         }
                         else
                         {
                   		  //echo $id;
                           while($row=mysqli_fetch_array($result))
                           {


                            ?>
														<div class="panel panel-default">
														<div class="panel-body">

                             <form action="updateStudentDetailsCode.php" method="post" autocomplete="off">
                   		     <fieldset>
                          <center><h3 style="font-family:lato">Student Profile</h3></center>
														 <hr>
														 <div class="row">
															 <div class="col-6">
                             <div class="form-group"><label>Student Id: </label><input name="Studentid" type ="text" placeholder="Student Id" value="<?php echo $row["student_id"];?>" style="width:400px" class="form-control" ></div>
                              <div class="form-group"><label>First Name: </label><input name="Firstname" type ="text" placeholder="First Name" value="<?php echo $row["first_name"];?>" style="width:400px" class="form-control" ></div>
                              <div class="form-group"> <label>Last Name: </label><input name="Lastname" type ="text" placeholder="Last Name" value="<?php echo $row["last_name"];?>" style="width:400px" class="form-control"></div>
                              <div class="form-group"><label>Date_Of Birth: </label><input name="DOB" type ="date" placeholder="date_of_birth" value="<?php echo $row["date_of_birth"];?>" style="width:400px" class="form-control" ></div>
                              <div class="form-group"> <label>Gender: </label><input name="Gender" type ="text" placeholder="gender" value="<?php echo $row["gender"];?>" style="width:400px" class="form-control" ></div>
															<?php


															$query1 = "SELECT * from class order by class_id";
															$result1 = $db->query($query1);
																 ?>
																 <div class="form-group"><label for="cell">Class: </label><br/>
																 <select class="form-control" id="class" name="Grade" style="width:200px" >
															 	 					<option value= "<?php echo $row['class_id']?>"selected> <?php echo $row['grade'];?></option>
															 <?php
																 if($result1->num_rows>0){
																	 while($row1 = $result1->fetch_assoc()){
																		 //echo "<option>".$row["grade"]."</option>";
																		 echo "<option value='".$row1['class_id']."'>".$row1['grade']."</option>";
																	 }
																 }
																 ?>
															</select>
														</div>
													<?php


												 	 $query2 = "SELECT * from division order by division_id";
												 	 $result2 = $db->query($query2);
												 					?>

												 					<div class="form-group"><label for="cell">Division: </label><br/>
												 					<select class="form-control" id="division" name="Division" style="width:200px">

												 										 <option value="<?php echo $row['division_id'] ?>"selected><?php echo $row['division_name']; ?> </option>
												 		<?php
												 			if($result2->num_rows>0){
												 				while($row2 = $result2->fetch_assoc()){
												 					echo "<option value='".$row2['division_id']."'>".$row2['division_name']."</option>";
												 				}
												 			}

												 			?>
												 					</select>
												 				</div>
															</div>

															<div class="col-6">
                   		   <fieldset>
                              <legend>Address</legend>
                              <div class="form-group"><label>Number: </label><input name="Number" type="text" placeholder="number" value="<?php echo $row["no"];?>" style="width:400px" class="form-control" ></div>
                              <div class="form-group"><label>Street: </label><input name="Street" type="text" placeholder="street" value="<?php echo $row["street"];?>" style="width:400px" class="form-control" ></div>
                              <div class="form-group"><label>City: </label><input name="City" type="text" placeholder="city"  value="<?php echo $row["city"];?>" style="width:400px" class="form-control"></div>
                              </fieldset>
                              <fieldset>
                              <legend>Contact</legend>
                              <div class="form-group"><label>Phone No: </label><input name="Phoneno" type="text" placeholder="phone no" value="<?php echo $row["phone_no"];?>" style="width:400px" class="form-control"></div>
                              <div class="form-group"><label>Email: </label> <input name="Email" type="email" placeholder="email" value="<?php echo $row["email"];?>" style="width:400px" class="form-control"></div>
                              </fieldset>

                              <div class="form-group"><button type="submit" name="user_edit"  class="btn btn-success" style="margin-left:400px">Edit</button> </div>
</div>
</div>
                              </form>
                            <?php
                   		}
                   	  }
                   	  ?>
                   </section>

                    </section>

                    </body>
										  <?php include('Footer.php'); ?>
                    </html>
