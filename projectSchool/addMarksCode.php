
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
  //$uid = $_SESSION['userid'];
}
else {
   header("Location:Login.php");
}


if(isset($_POST['add_marks'])){
$subject = mysqli_real_escape_string($db, $_POST['Subject']);
$term = mysqli_real_escape_string($db,$_POST['Term']);
$class_id = mysqli_real_escape_string($db,$_POST['Grade']);
$division_id = mysqli_real_escape_string($db,$_POST['Division']);



foreach($_POST['Studentid'] as $k=>$val){
  $sid = $val; // give you first name
  $marks = $_POST["marks"][$k]; // will give you last ame


  $query1 = "SELECT * from term_mark where student_id = '$sid' and term_no='$term'";
  $result1 = mysqli_query($db,$query1);
  if(mysqli_num_rows($result1) > 0){
    $query = "UPDATE term_mark set $subject ='$marks' where student_id ='$sid' and term_no='$term'";
    mysqli_query($db, $query);
  }
  else{
    $query = "INSERT INTO term_mark (student_id,$subject,term_no,class_id,division_id) values ('$sid','$marks','$term','$class_id','$division_id')";
    mysqli_query($db,$query);
    }

    $count =0;
    $avg =0;
    $tot = 0;
    $sql = "SELECT * from term_mark where student_id = '$sid' and term_no='$term'";
    $result=mysqli_query($db,$sql);
    if(mysqli_num_rows($result) > 0){
      while ($row = mysqli_fetch_array($result)) {
              for ( $i=2; $i <= 23; $i++) {
                $tot = $tot + $row[$i];
                if($row[$i] != null){
                  $count = $count + 1;
                }
              }
              $avg = round(($tot/$count),2);
              $query = "UPDATE term_mark set total='$tot',average = '$avg' where student_id='$sid' and term_no='$term'";
              mysqli_query($db,$query);
          }
        }



$sql = "SELECT * FROM term_mark where term_no='$term' and class_id ='$class_id' and division_id='$division_id' ORDER BY total DESC";
$result = mysqli_query($db,$sql);



  $rank = 0;
  $last_score = false;
  $rows = 0;

  while($row = mysqli_fetch_array( $result ) ){
    $sid = $row['student_id'];



    $rows++;
    if( $last_score!= $row['total'] ){
      $last_score = $row['total'];
      $rank = $rows;
    }

    $sid = $row['student_id'];
    $query = "UPDATE term_mark set rank = '$rank' where student_id = '$sid' and term_no='$term'";


    }
  }



}
if(mysqli_query($db, $query)){

$Message = "submitted successfully!";
header("Location:addMarks.php?Message=" . urlencode($Message));
}

else{
$Message = "Submission Failure!";
header("Location:addMarks.php?Message=" . urlencode($Message));
}









?>
