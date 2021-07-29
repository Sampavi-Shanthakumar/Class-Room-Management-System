
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


if (isset($_GET['Message'])) {
		print '<script type="text/javascript">alert("' . $_GET['Message'] . '");</script>';
}
 ?>
<html>
<?php
if (isset($_GET['Message'])) {
		print '<script type="text/javascript">alert("' . $_GET['Message'] . '");</script>';
}
 ?>




<head>
<link rel="stylesheet" type="text/css" href="css/nav.css">
<link rel="stylesheet" type="text/css" href="css/studentDetails.css">

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <script type="text/javascript">

</script>
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
  <div class="panel-body" style="height:300px">
  		<center><h1 style="font-family:lato">View Principal Details</h1></center>
    <div class="container">
    <div class="row">
      <section>
        <div class="">
            <?php

            $output = '';
            $output .= '
                <table class="table thead-dark" style="margin-top:20px">
                      <tr>
           <th >Principal Id</th>
                          <th >First Name</th>
                           <th >Last Name</th>
                            <th >Gender</th>
            <th>DOB</th>


                           <th>Address</th>
                            <th>Phone No</th>
                           <th>Email </th>

            <th width="5%">update</th>
                           <th width="5%">Delete</th>
                      </tr>
            ';


            $query_m= "SELECT * FROM principal   ";
            $result_m = mysqli_query($db,$query_m);
            if(mysqli_num_rows($result_m) > 0)
            {
                 while($row = mysqli_fetch_array($result_m))
                 {
                    //$_SESSION['.$row["student_id"].'] = $sid;
                    $output .= '
                         <tr>
                    <td>'.$row["principal_id"].'</td>

                              <td>'.$row["first_name"].'</td>
                             <td>'.$row["last_name"].'</td>

                              <td>'.$row["gender"].'</td>
                              <td>'.$row["date_of_birth"].'</td>
                    <td>'.$row["no"].','.$row["street"].','.$row["city"].'</td>
                      <td>'.$row["phone_no"].'</td>
                    <td>'.$row["email"].'</td>







                    <td>
                    <button class="btn btn-success"><a style="color:white" href="updatePrincipalDetails.php?id='.$row["principal_id"].'">Update</a> </button>
                    </td>


                    <td>

										<button class="btn btn-success"><a style="color:white" onClick=\'javascript: return confirm("Please confirm deletion");\' href="deletePrincipaltDetails.php?id='.$row["principal_id"].'">Delete</a> </button>

                    </td>


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



mysqli_close($db);
?>


    </div>
      </section>

</div>
</div>
</div>
</div>
</div>

</body>
  <?php include('Footer.php'); ?>
</html>
