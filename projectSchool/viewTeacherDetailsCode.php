
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
     $tid = '';
     $subject_code = '';


      $tid = mysqli_real_escape_string($db, $_POST['userid']);
      $subject_code=mysqli_real_escape_string($db, $_POST['subject_code']);

                    $output .= '
                        <table class="table thead-dark">
                              <tr>
    						   <th >Teacher Id</th>
                                  <th >First Name</th>
                                   <th >Last Name</th>
                                    <th >Gender</th>
    								<th>DOB</th>


                                   <th>Address</th>
                                   	<th>Phone No</th>
                                   <th>Email </th>
                                   <th>Subject</th>
    							  <th width="5%">update</th>
                                   <th width="5%">Delete</th>
                              </tr>
                    ';


                    $query_m1= "SELECT * FROM teacher t, subject s where  t.subject_code = s.subject_code and t.teacher_id = '".$tid."'  ";
                    $query_m2 = "SELECT * FROM teacher t, subject s where  t.subject_code = s.subject_code and t.subject_code ='$subject_code'";


                    if(!empty($_POST['userid'])){
                      $result_m= mysqli_query($db, $query_m1);

                    }

                     else if(!empty($_POST['subject_code']) ){
                      $result_m= mysqli_query($db, $query_m2);
                    }
                    else{
                      echo "Nothing Selected";
                    }






                    if(mysqli_num_rows($result_m) > 0)
                    {
                         while($row = mysqli_fetch_array($result_m))
                         {
                            $output .= '
                                 <tr>
                            <td>'.$row["teacher_id"].'</td>

                                      <td>'.$row["first_name"].'</td>
                                     <td>'.$row["last_name"].'</td>

                                      <td>'.$row["gender"].'</td>
                                      <td>'.$row["date_of_birth"].'</td>
                            <td>'.$row["no"].','.$row["street"].','.$row["city"].'</td>
                              <td>'.$row["phone_no"].'</td>
                            <td>'.$row["email"].'</td>

                            <td>'.$row["subject_name"].'</td>





                            <td>
                            <button class="btn btn-success"><a style="color:white" href="updateTeacherDetails.php?id='.$row["teacher_id"].'">Update</a> </button>
                            </td>


                            <td>

                            <button class="btn btn-success"><a style="color:white" onClick=\'javascript: return confirm("Please confirm deletion");\' href="deleteTeacherDetails.php?id='.$row["teacher_id"].'">Delete</a> </button>

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

    		 }
    }

     mysqli_close($db);
     ?>
