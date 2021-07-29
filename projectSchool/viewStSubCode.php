

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

$sql = "SELECT * from teacher where user_id = '$uid'";
$result1 = mysqli_query($db,$sql);
$row1 = mysqli_fetch_array($result1);
$tid = $row1['teacher_id'];


    if(isset($_POST["action"]))  {

    if($_POST["action"] == "filter")
             {

     $output = '';
     $fromDate = '';
     $toDate = '';
     $division= '';
     $class = '';
     $subject_code = '';

      $fromDate = mysqli_real_escape_string($db, $_POST['fromDate']);
      $toDate = mysqli_real_escape_string($db,$_POST['toDate']);
      $division=mysqli_real_escape_string($db, $_POST['division']);
      $class=mysqli_real_escape_string($db, $_POST['grade']);
      $subject_code = mysqli_real_escape_string($db,$_POST['subject']);
//echo var_dump($fromDate.$toDate.$division.$class.$subject_code);




                    $output .= '
                        <table class="table thead-dark">
                              <tr>
    						                   <th >Student Id</th>
                                  <th > Name</th>
                                   <th >Date</th>
                                    <th >Time</th>


                    ';

                    $query = "SELECT * from submission sub , student s where sub.subject_code = '$subject_code' and sub.student_id = s.student_id and s.class_id = '$class' and s.division_id = '$division' and sub.date_sub >= '$fromDate' and sub.date_sub <= '$toDate' ";
                    $result = mysqli_query($db,$query);
      if(mysqli_num_rows($result) > 0)
                    {
                         while($row = mysqli_fetch_array($result))
                         {
                            $output .= '
                                 <tr>
                            <td>'.$row["student_id"].'</td>
                                      <td>&#x1f5ce; <a href="'.$row["location"].'">'.$row["name"].'</a></td>

                                     <td>'.$row["date_sub"].'</td>

                                      <td>'.$row["time_sub"].'</td>




                                 </tr>
                            ';
                              //href="deleteStudentDetails.php?id='.$row["student_id"].'"
                              //onClick=\"javascript: return confirm('Please confirm deletion');\" href='delete.php?id=".$query2['id']."'
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
