
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




    if(isset($_POST["action"]))  {

    if($_POST["action"] == "filter")
             {

     $output = '';
     $userid = '';
     $division_id = '';
     $class_id = '';

      $userid = mysqli_real_escape_string($db, $_POST['userid']);
      $division_id=mysqli_real_escape_string($db, $_POST['division_id']);
      $class_id=mysqli_real_escape_string($db, $_POST['class_id']);




                    $output .= '
                        <table class="table thead-dark">
                              <tr>
    						   <th >Student Id</th>
                                  <th >First Name</th>
                                   <th >Last Name</th>
                                    <th >Gender</th>
    								<th>DOB</th>
                    <th>Address</th>
                    <th>Phone No</th>
                    		<th>Email</th>
                        <th>Grade</th>
                        <th>Division</th>


    							  <th width="5%">update</th>
                                   <th width="5%">Delete</th>
                              </tr>
                    ';


                    $query_m1= "SELECT * FROM student s, class c, division d where s.student_id = '".$userid."' and s.class_id = c.class_id and s.division_id=d.division_id ";
                    $query_m2= "SELECT * FROM student s, class c, division d where  c.class_id='".$class_id."' and d.division_id='".$division_id."' and s.class_id = c.class_id and s.division_id=d.division_id  ";
                    $query_m3= "SELECT * FROM student s, class c , division d where  s.class_id = c.class_id  and s.division_id=d.division_id and c.class_id='".$class_id."'  ";

                    if(!empty($_POST['userid']) ){
                      $result_m= mysqli_query($db, $query_m1);

                    }

                     else if(!empty($_POST['class_id']) && !empty($_POST['division_id']) ){
                      $result_m= mysqli_query($db, $query_m2);
                    }
                    else if(!empty($_POST['class_id']) ){
                       $result_m= mysqli_query($db, $query_m3);

                    }
                    else {
                      echo "Nothing Selected";
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

                            <td>'.$row["no"].','.$row["street"].','.$row["city"].'</td>

                            <td>'.$row["phone_no"].'</td>
                            <td>'.$row["email"].'</td>
                            <td>'.$row["grade"].'</td>
                            <td>'.$row["division_name"].'</td>




                            <td>
                            <button class="btn btn-success"><a style="color:white" href="updateStudentDetails.php?id='.$row["student_id"].'">Update</a> </button>
                            </td>


                            <td>


                            <button class="btn btn-success"><a style="color:white" onClick=\'javascript: return confirm("Please confirm deletion");\' href="deleteStudentDetails.php?id='.$row["student_id"].'">Delete</a> </button>
                            </td>


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
