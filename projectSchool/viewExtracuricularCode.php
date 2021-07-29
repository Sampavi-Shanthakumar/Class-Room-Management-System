
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
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>






  </head>
  <body>

    <?php
     //select.php

    if(isset($_POST["action"]))  {

    if($_POST["action"] == "filter")
             {

$output = '';


      $id = mysqli_real_escape_string($db, $_POST['userid']);

                    $output .= '

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
                   <th>Edit</th>

                              </tr>
                    ';



                  $query ="SELECT * from extra_activity e , student s , class c , division d where s.student_id=e.student_id and c.class_id = s.class_id and d.division_id=s.division_id and e.student_id = '$id'";

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
                           <td>
                           <button class="btn btn-success"><a style="color:white" href="editExtraActivity.php?id='.$row["extra_activity_id"].'">Update</a> </button>
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
                  }

                    $output .= '</table>
                    </div>';
                    echo $output;
















    		 }
    }

     mysqli_close($db);
     ?>




  </body>
</html>
