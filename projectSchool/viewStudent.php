<?php
         //select.php
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

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

  </head>
 <body>


<?php
    if(isset($_POST["action"]))  {

    if($_POST["action"] == "filter")
             {

$output = '';

      $sub_code= mysqli_real_escape_string($db, $_POST['subject']);
      $div_id=mysqli_real_escape_string($db, $_POST['division']);
      $class_id=mysqli_real_escape_string($db, $_POST['grade']);
      $userid = mysqli_real_escape_string($db, $_POST['userid']);


                    $output .= '
                    <div class="form-group"><label>Term : </label><br/>
                			<select class="form-control" id="term" name="Term" style="width:200px required" >
                		<option value=""> Select Term</option>
               		<option value="1"> 1st Term</option>
               		<option value="2"> 2nd Term</option>
                  <option value="3"> 3rd Term</option>
                		</select>
               	</div>
                <div  class="form-group">
                        <table >
                              <tr>
    						   <th >Student Id</th>
                                  <th >First Name</th>
                                   <th >Last Name</th>

    							  <th width="5%">Mark</th>

                              </tr>
                    ';



                    $query1="SELECT grade from class c where c.class_id = '$class_id'";
                    $result=mysqli_query($db,$query1);
                    $row = mysqli_fetch_array($result);
                    $grade = $row["grade"];


                    $query2="SELECT * from options where subject_code='$sub_code'";
                    $result1 = mysqli_query($db, $query2);

                    if(mysqli_num_rows($result1) > 0){
                    $row1 = mysqli_fetch_array($result1);
                    $basket= $row1["basket"];

                    if($grade < 10 && $basket=='basket_2'){
                      $query3 = "SELECT * from students s , optional_subject o where s.student_id = o.student_id and o.aesthetic = '$sub_code' and s.class_id='$class_id' and s.division_id='$div_id'";
                    }
                    else{
                     if($basket=='basket_1'){
                       $query3= "SELECT * from student s , optional_subject o where s.student_id=o.student_id and basket_1='$sub_code' and s.class_id='$class_id' and s.division_id='$div_id'";
                       }
                     else if ($basket=='basket_2'){
                       $query3= "SELECT * from student s , optional_subject o where s.student_id=o.student_id and basket_2='$sub_code' and s.class_id='$class_id' and s.division_id='$div_id'";
                       }
                       else{
                       $query3= "SELECT * from student s , optional_subject o where s.student_id=o.student_id and basket_3='$sub_code'and s.class_id='$class_id' and s.division_id='$div_id'";
                       }
                    }
                  }
                  elseif ($userid != null) {
                    $query3 = "SELECT * from student s where s.student_id='$userid'";
                  }
                    else{
                      $query3= "SELECT * from student s where class_id = '$class_id' and division_id='$div_id' ";
                    }




                    if(mysqli_query($db, $query3)){
                      $result2= mysqli_query($db, $query3);


                  if((mysqli_num_rows($result2)) > 0)
                    {
                         while($row2= mysqli_fetch_array($result2))
                         {
                           $class_id = $row2['class_id'];
                           $div_id = $row2['division_id'];
                              $output .= '
                                   <tr>
                                   <input type="hidden" name="Studentid[]" value="'.$row2["student_id"].'" />
                           <td>'.$row2["student_id"].'</td>

                                        <td>'.$row2["first_name"].'</td>
                                       <td>'.$row2["last_name"].'</td>

                                        <td> <input type="text" name = "marks[]"> </td>

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

                    <input type="hidden" name="Subject" value="'.$sub_code.'" />
                    <input type="hidden" name="Grade" value="'.$class_id.'" />
                    <input type="hidden" name="Division" value="'.$div_id.'" />
                    <input type="submit" value="Add Marks" name="add_marks" id="btn" class="btn btn-success"></input>
                    </div>';
                    echo $output;


    		 }
    }

     mysqli_close($db);
     ?>




  </body>

</html>
