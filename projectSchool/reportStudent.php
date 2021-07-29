
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

  $term= mysqli_real_escape_string($db, $_POST['term']);
  if(isset($_POST['userid'])){
    $id= mysqli_real_escape_string($db, $_POST['userid']);
      $query1="SELECT * from student s, class c , division d where c.class_id = s.class_id and d.division_id= s.division_id and  s.student_id = '$id'";
  }
  else{
  $query1="SELECT * from student s, class c , division d where c.class_id = s.class_id and d.division_id= s.division_id and  s.user_id = '$uid'";
}

  $result1=mysqli_query($db,$query1);
  $row1 = mysqli_fetch_array($result1);
  $grade = $row1['grade'];
  $division= $row1['division_name'];
  $id = $row1['student_id'];


$output = '';
      $output .= '
<hr>
<center><h3 style="font-family:lato;color:#003366;"> Student Report</h3></center>
<hr>
<span style="color:#007acc">Student Name :</span> '.$row1['first_name'].' '.$row1['last_name'].'</br>
<span style="color:#007acc">Class :</span> '.$row1['grade'].'</br>
<span style="color:#007acc">Division :</span> '.$row1['division_name'].'</br>
  <div  class="form-group">
          <table class="table thead-dark">
                <tr style="background-color:#80ffbf">
     <th >Subject</th>
     <th >Marks</th>
     </tr>';

$sql = "SELECT * from term_mark where student_id='$id' and term_no='$term'";
$rs = mysqli_query($db,$sql);
$row_m = mysqli_fetch_array($rs);

           //$output .='<th>'.$row2["subject_name"].'</th>';
           if($grade < 10){
             $query3 = "SELECT s.subject_name ,s.subject_code from subject s where s.subject_code=(SELECT o.aesthetic from optional_subject o WHERE o.student_id = '$id')";
             $result3 = mysqli_query($db,$query3);



             $query2 = "SELECT * FROM subject s WHERE NOT EXISTS ( SELECT * FROM options o WHERE s.subject_code = o.subject_code) or s.subject_code = 'S11' or s.subject_code = 'S12' or s.subject_code = 'S22' or s.subject_code = 'S23' order by subject_code";
             $result2 = mysqli_query($db,$query2);
               //$n1 = mysqli_num_fields($result2);

             while($row2=mysqli_fetch_array($result2)){
              $output .='
                <tr>
                  <td> '.$row2['subject_name'].'</td>

                   <td>'.$row_m[$row2['subject_code']].'</td>
                    </tr>';

                  }

                  while($row3=mysqli_fetch_array($result3)){
                    $output .='
                      <tr>
                        <td> '.$row3['subject_name'].'</td>

                         <td>'.$row_m[$row3['subject_code']].'</td>
                          </tr>';
                        }




           }
           else{
             $query_s = "SELECT * from optional_subject o where o.student_id = '$id'";
             $r_s = mysqli_query($db,$query_s);
             while($row_s = mysqli_fetch_array($r_s)){
               $op = array($row_s['basket_1'],$row_s['basket_2'],$row_s['basket_3']);
             }
             $query3 = "SELECT * from subject where subject_code = '$op[0]' or subject_code = '$op[1]' or subject_code = '$op[2]' ";
             $result3 = mysqli_query($db,$query3);


             $query2 = "SELECT * FROM subject s WHERE NOT EXISTS ( SELECT * FROM options o WHERE s.subject_code = o.subject_code) order by subject_code";
             $result2 = mysqli_query($db,$query2);
               //$n1 = mysqli_num_fields($result2);

             while($row2=mysqli_fetch_array($result2)){
              $output .='
                <tr>
                  <td> '.$row2['subject_name'].'</td>

                   <td>'.$row_m[$row2['subject_code']].'</td>
                    </tr>';

                  }

                  while($row3=mysqli_fetch_array($result3)){
                      $output .='<tr>
                        <td> '.$row3['subject_name'].'</td>
                        <td>'.$row_m[$row3['subject_code']].'</td>
                         </tr>';

                    }

           }
           $output .='
          <tr style="background-color:#ccb3ff"> <td> Total</td> <td>'.$row_m['total'].'</td></tr>
          <tr style="background-color:#e6b3ff"> <td> Average</td> <td>'.$row_m['average'].'</td></tr>
          <tr style="background-color:#df80ff"> <td> Rank</td> <td>'.$row_m['rank'].'</td></tr>
           </table>';

echo $output;




 ?>
