
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
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php

    if(isset($_POST["action"]))  {

    if($_POST["action"] == "filter")
             {

$output = '';
$sub_code = '';
$div_id = '';
$class_id = '';
$userid = '';
$term = '';

      $sub_code= mysqli_real_escape_string($db, $_POST['subject_code']);
      $div_id=mysqli_real_escape_string($db, $_POST['division_id']);
      $class_id=mysqli_real_escape_string($db, $_POST['class_id']);
      $term = mysqli_real_escape_string($db, $_POST['term']);


    $query1="SELECT grade from class c where c.class_id = '$class_id'";
    $result1=mysqli_query($db,$query1);
    $row1 = mysqli_fetch_array($result1);
    $grade = $row1["grade"];


    $query5 = "SELECT * FROM subject WHERE subject_name = 'Music' or subject_name = 'Dance' or subject_name = 'Art'";
    $result5 = mysqli_query($db,$query5);
    while($row5=mysqli_fetch_array($result5)){
        $aes[] = $row5["subject_code"];

  }


    $output .= '

<div  class="form-group">
        <table class="table thead-dark">
              <tr>
   <th >Student Id</th>
   <th >Full Name</th>
   <th>class</th>
   <th>Division</th>

    ';





      if($class_id != null && $sub_code == null && $term != null){
        $query2 = "SELECT * FROM subject s WHERE NOT EXISTS ( SELECT * FROM options o WHERE s.subject_code = o.subject_code) order by subject_code";
        $result2 = mysqli_query($db,$query2);
        while($row2=mysqli_fetch_array($result2)){
            $output .='<th>'.$row2["subject_name"].'</th>';
        }


          if($grade < 10){
            $query3 = "SELECT * from subject where subject_name = 'Music' or subject_name = 'Dance' or subject_name = 'Art' order by subject_code";
            $result3 = mysqli_query($db,$query3);
            while($row3=mysqli_fetch_array($result3)){
                $output .='<th>'.$row3["subject_name"].'</th>';
            }
          }
          else{
            $query3 = "SELECT * from subject s , options o where s.subject_code = o.subject_code";
            $result3 = mysqli_query($db,$query3);
            while($row3=mysqli_fetch_array($result3)){
                $output .='<th>'.$row3["subject_name"].'</th>';
              }
          }

            $output .='
            <th>Total</th>
            <th>Average</th>
            <th>Rank</th>
            <th>Term</th>

            </tr>

            ';
            if($class_id != null && $div_id != null ){
                $query_m = "SELECT concat(s.first_name,' ', s.last_name) as full_name , tm.* , c.grade, d.division_name from student s , term_mark tm , class c , division d where s.student_id = tm.student_id and c.class_id =tm.class_id and d.division_id = tm.division_id and
                      tm.class_id = '$class_id' and tm.division_id ='$div_id' and tm.term_no = '$term'";

              }
              else{
                $query_m = "SELECT concat(s.first_name,' ', s.last_name) as full_name , tm.* , c.grade, d.division_name from student s , term_mark tm , class c , division d where s.student_id = tm.student_id and c.class_id =tm.class_id and d.division_id = tm.division_id and
                              tm.class_id = '$class_id'  and tm.term_no = '$term'";
              }

$result_m = mysqli_query($db,$query_m);
$n = mysqli_num_fields($result_m);
if(mysqli_num_rows($result_m) > 0)
{

while($row_m = mysqli_fetch_array($result_m)){
  $output .= '
  <tr>
    <td>'.$row_m['student_id'].'</td>
    <td>'.$row_m['full_name'].'</td>
    <td>'.$row_m['grade'].'</td>
    <td>'.$row_m['division_name'].'</td>'
    ;

    if($grade >= 10){
    for( $i=3; $i <= $n-5; $i++){
      $output .=  '<td>'.$row_m[$i].'</td>';
    }
  }
  else{
    for( $i=3; $i <= 8; $i++){
      $output .=  '<td>'.$row_m[$i].'</td>';
    }
      $output .=  '<td>'.$row_m[$aes[0]].'</td>
                  <td>'.$row_m[$aes[1]].'</td>
                  <td>'.$row_m[$aes[2]].'</td>
                  <td>'.$row_m['total'].'</td>
                  <td>'.$row_m['average'].'</td>
                  <td>'.$row_m['rank'].'</td>
                  <td>'.$row_m['term_no'].'</td>
      ';

  }
    $output .='</tr>';

  }
$output .=  '</table>
              </div>';
}
echo $output;

}
//===================================================================================

else if ($class_id != null  && $sub_code != null && $term != null) {
  $query2 = "SELECT * FROM subject where subject_code = '$sub_code'";
  $result2 = mysqli_query($db,$query2);
  $row2=mysqli_fetch_array($result2);
      $output .='<th>'.$row2["subject_name"].'</th>

                </tr>';

                $basket ='';
                $query_o="SELECT * from options where subject_code='$sub_code'";
                $result_o = mysqli_query($db,$query_o);
                if(mysqli_num_rows($result_o) > 0){
                $row_o = mysqli_fetch_array($result_o);
                $basket= $row_o["basket"];
              }
                if($basket != null){
                  if($grade >= 10) {
                  if($class_id != null && $div_id != null ){
                    $query_m = "SELECT concat(s.first_name,' ', s.last_name) as full_name , tm.$sub_code ,tm.student_id , c.grade, d.division_name , o.* from student s , term_mark tm , class c , division d , optional_subject o where s.student_id = tm.student_id and c.class_id =tm.class_id and d.division_id = tm.division_id and tm.student_id = o.student_id and tm.class_id = '$class_id' and tm.division_id ='$div_id' and tm.term_no = '$term' and (o.basket_1='$sub_code' or o.basket_2='$sub_code' or o.basket_3='$sub_code')";
                }
                else{
                      $query_m = "SELECT concat(s.first_name,' ', s.last_name) as full_name , tm.$sub_code ,tm.student_id , c.grade, d.division_name , o.* from student s , term_mark tm , class c , division d , optional_subject o where s.student_id = tm.student_id and c.class_id =tm.class_id and d.division_id = tm.division_id and tm.student_id = o.student_id and tm.class_id = '$class_id'  and tm.term_no = '$term' and (o.basket_1='$sub_code' or o.basket_2='$sub_code' or o.basket_3='$sub_code')";
                }
                }
                else{
                  if($class_id != null && $div_id != null ){
                    $query_m = "SELECT concat(s.first_name,' ', s.last_name) as full_name , tm.$sub_code ,tm.student_id , c.grade, d.division_name , o.* from student s , term_mark tm , class c , division d , optional_subject o where s.student_id = tm.student_id and c.class_id =tm.class_id and d.division_id = tm.division_id and tm.student_id = o.student_id and tm.class_id = '$class_id' and tm.division_id ='$div_id' and tm.term_no = '$term' and o.aesthetic='$sub_code'";
                  }
                  else{
                      $query_m = "SELECT concat(s.first_name,' ', s.last_name) as full_name , tm.$sub_code ,tm.student_id , c.grade, d.division_name , o.* from student s , term_mark tm , class c , division d , optional_subject o where s.student_id = tm.student_id and c.class_id =tm.class_id and d.division_id = tm.division_id and tm.student_id = o.student_id and tm.class_id = '$class_id'  and tm.term_no = '$term'  and o.aesthetic='$sub_code'";
                  }
                }
          }
          else{
            if($class_id != null && $div_id != null ){
            $query_m = "SELECT concat(s.first_name,' ', s.last_name) as full_name , tm.$sub_code ,tm.student_id , c.grade, d.division_name  from student s , term_mark tm , class c , division d   where s.student_id = tm.student_id and c.class_id =tm.class_id and d.division_id = tm.division_id and tm.class_id = '$class_id' and tm.division_id='$div_id' and tm.term_no = '$term' ";
          }
          else{
            $query_m = "SELECT concat(s.first_name,' ', s.last_name) as full_name , tm.$sub_code ,tm.student_id , c.grade, d.division_name  from student s , term_mark tm , class c , division d   where s.student_id = tm.student_id and c.class_id =tm.class_id and d.division_id = tm.division_id and  tm.class_id = '$class_id'  and tm.term_no = '$term' ";

          }
        }

  $result_m = mysqli_query($db,$query_m);
  //$n = mysqli_num_fields($result_m);
  if(mysqli_num_rows($result_m) > 0)
  {

  while($row_m = mysqli_fetch_array($result_m)){
    $output .= '
    <tr>
      <td>'.$row_m['student_id'].'</td>
      <td>'.$row_m['full_name'].'</td>
      <td>'.$row_m['grade'].'</td>
      <td>'.$row_m['division_name'].'</td>
      <td>'.$row_m[$sub_code].'</td>
      </tr>';

  }
  $output .='</table>
            </div>';
  echo $output;

}



}
else{
  //echo "Select the option";
  $Message = "Please select an option!";
  header("Location:studentMarks.php?Message=" . urlencode($Message));
}




}

}

   mysqli_close($db);
     ?>
  </body>
</html>
