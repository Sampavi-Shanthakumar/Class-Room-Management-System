
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


  	<center><h1 style="font-family:lato">Update Principal Details</h1></center>
		<div class="panel panel-default">
		<div class="panel-body">

      <section class="">

                     <section class=""  id="panel2">
                       <?php


                       $id=$_GET["id"];


                   	  $sql="SELECT * from principal where principal_id = '$id'";
                         $result=mysqli_query($db,$sql);



                         if(!$result)
                         {
                        //echo " Error".mysqli_error($db);
                         }
                         else
                         {

                           while($row=mysqli_fetch_array($result))
                           {


                            ?>



															 <center> <h3 style="font-family:lato">Principal Profile</h3></center>
															 <hr>
															 <div class="row">
																 <div class="col-6">
															  <form action="updatePrincipalDetailsCode.php" method="post" autocomplete="off">
                   		     <fieldset>


														<div class="row">
															<div class="col-6">
                             <div class="form-group"><label>Principal Id: </label><input name="teacherid" placeholder="Teacher Id" value="<?php echo $row["principal_id"];?>" style="width:400px" class="form-control" ></div>
                              <div class="form-group"><label>First Name: </label><input name="firstname" placeholder="First Name" value="<?php echo $row["first_name"];?>" style="width:400px" class="form-control"class="form-control"class="form-control"class="form-control"class="form-control"class="form-control" ></div>
                              <div class="form-group"> <label>Last Name: </label><input name="lastname" placeholder="Last Name" value="<?php echo $row["last_name"];?>" style="width:400px" class="form-control"class="form-control"class="form-control"class="form-control"class="form-control"></div>
                              <div class="form-group"><label>Date_Of Birth: </label><input name="dob" placeholder="date_of_birth" value="<?php echo $row["date_of_birth"];?>" style="width:400px" class="form-control"class="form-control"class="form-control"class="form-control" ></div>
                              <div class="form-group"> <label>Gender: </label><input name="gender" placeholder="gender" value="<?php echo $row["gender"];?>" style="width:400px"  class="form-control"class="form-control"class="form-control"></div>

                                 </fieldset>
															 </div>
															 <div class="col-6">
                   		   <fieldset>
                              <legend>Address</legend>
                              <div class="form-group"><label>Number: </label><input name="no" placeholder="number" value="<?php echo $row["no"];?>" style="width:400px"  class="form-control" class="form-control"></div>
                              <div class="form-group"><label>Street: </label><input name="street" placeholder="street" value="<?php echo $row["street"];?>" style="width:400px" class="form-control" ></div>
                              <div class="form-group"><label>City: </label><input name="city" placeholder="city"  value="<?php echo $row["city"];?>" style="width:400px" class="form-control" ></div>
                              </fieldset>
                              <fieldset>
                              <legend>Contact</legend>
                              <div class="form-group"><label>Phone No: </label><input name="phoneNo" placeholder="phone no" value="<?php echo $row["phone_no"];?>" style="width:400px" class="form-control"></div>
                              <div class="form-group"><label>Email: </label> <input name="email" placeholder="email" value="<?php echo $row["email"];?>" style="width:400px" class="form-control"></div>
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
									</div>
								</div>
							</div>
                    </body>
										<?php include('Footer.php'); ?>

                    </html>
