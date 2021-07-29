
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
     $teacher_id = '';
     $division_id = '';
     $class_id = '';
     $subject_code = '';

      $teacher_id = mysqli_real_escape_string($db, $_POST['teacher_id']);
      $division_id=mysqli_real_escape_string($db, $_POST['division_id']);
      $class_id=mysqli_real_escape_string($db, $_POST['class_id']);
      $subject_code = mysqli_real_escape_string($db, $_POST['subject_code']);




                    $output .= '
                        <table class="table thead-dark">
                              <tr>
                                  <th >First Name</th>
                                   <th >Last Name</th>
                                    <th >Class</th>
    								<th>Division</th>
                    <th>Subject</th>
                    <th width="5%">Edit</th>
                              </tr>
                    ';


                    $query_m1= "SELECT * FROM class_details cd , teacher t , class c , division d , subject s where cd.class_id = c.class_id and cd.division_id = d.division_id and cd.teacher_id = t.teacher_id and cd.subject_code = s.subject_code and cd.class_id = '$class_id' and cd.division_id = '$division_id' ";
                    $query_m2= "SELECT * FROM class_details cd , teacher t , class c , division d , subject s where cd.class_id = c.class_id and cd.division_id = d.division_id and cd.teacher_id = t.teacher_id and cd.subject_code = s.subject_code and cd.teacher_id = '$teacher_id'";
                    $query_m3= "SELECT * FROM class_details cd , teacher t , class c , division d , subject s where cd.class_id = c.class_id and cd.division_id = d.division_id and cd.teacher_id = t.teacher_id and cd.subject_code = s.subject_code and cd.subject_code = '$subject_code'";


                    if(!empty($_POST['teacher_id']) ){
                      $result_m= mysqli_query($db, $query_m2);

                    }

                     else if ($_POST['class_id'] && $_POST['division_id']){
                      $result_m= mysqli_query($db, $query_m1);
                    }

                    else if ($_POST['subject_code']){
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
                            <td>'.$row["first_name"].'</td>
                            <td>'.$row["last_name"].'</td>
                            <td>'.$row["grade"].'</td>
                            <td>'.$row["division_name"].'</td>
                            <td>'.$row["subject_name"].'</td>
                            <td>
                            <button class="btn btn-success"><a style="color:white" href="editSubTeacher.php?id='.$row["class_detail_id"].'">Update</a> </button>
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
