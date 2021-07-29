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

$id = $_GET['id'];
$sql = "SELECT * from class_details cd , teacher t, class c ,division d , subject s where class_detail_id = '$id' and cd.subject_code = s.subject_code and cd.class_id = c.class_id and cd.division_id = d.division_id and cd.teacher_id = t.teacher_id";
$result = mysqli_query($db,$sql);
$row = mysqli_fetch_assoc($result);
?>

<form class="" action=""  method="post">


<?php
$query1 = "SELECT * from teacher order by teacher_id ";
$result1 = $db->query($query1);
    ?>

    <div class="form-group"><label for="cell">Teacher Name: </label><br/>
    <select class="form-control" id="teacher" name="Teacher" style="width:200px">

    <option value=<?php echo $row['teacher_id']?>> <?php echo $row["first_name"]." ".$row["last_name"];?></option>
<?php
if($result1->num_rows>0){
  while($row1 = $result1->fetch_assoc()){
    echo "<option value='".$row1['teacher_id']."'>".$row1['first_name']." ".$row1['last_name']."</option>";
  }
}

?>
    </select>
  </div>



<?php


$query1 = "SELECT * from subject order by subject_code ";
$result1 = $db->query($query1);
    ?>

    <div class="form-group"><label for="cell">Subject: </label><br/>
    <select class="form-control" id="subject" name="Subject" style="width:200px">

             <option value=<?php echo  $row['subject_code']?>> <?php echo $row["subject_name"];?></option>
<?php
if($result1->num_rows>0){
  while($row1 = $result1->fetch_assoc()){
    echo "<option value='".$row1['subject_code']."'>".$row1['subject_name']."</option>";
  }
}

?>
    </select>
  </div>


  <?php


  $query1 = "SELECT * from division order by division_id";
  $result1 = $db->query($query1);
      ?>

      <div class="form-group"><label for="cell">Division: </label><br/>
      <select class="form-control" id="division" name="Division" style="width:200px">

    <option  value="<?php echo $row['division_id']?>"><?php echo $row["division_name"]; ?></option>

  <?php
  if($result1->num_rows>0){
    while($row1 = $result1->fetch_assoc()){
      echo "<option value='".$row1['division_id']."'>".$row1['division_name']."</option>";
    }
  }

  ?>
      </select>
    </div>


<?php


$query = "SELECT * from class order by class_id ";
$result = $db->query($query);
   ?>
   <div class="form-group"><label for="cell">Class: </label><br/>
   <select class="form-control" id="class" name="Grade" style="width:200px" onchange="java_script_:show(this.options[this.selectedIndex].value)">

     <option value=<?php echo $row['class_id']?>> <?php echo $row["grade"];?></option>

 <?php
   if($result->num_rows>0){
     while($row = $result->fetch_assoc()){
       echo "<option value ='".$row['class_id']."' >".$row['grade']."</option>";
     }
   }
   ?>
</select>
</div>


  <button type="sumbit"  name="editSubTeacher" >Update</button>

</form>


<?php
if(isset($_POST['editSubTeacher'])){

  $tid =  $_POST['Teacher'];
  $subject = mysqli_real_escape_string($db, $_POST['Subject']);
  $class = mysqli_real_escape_string($db, $_POST['Grade']);
  $division = mysqli_real_escape_string($db, $_POST['Division']);
echo var_dump($tid." , ".$subject." , ".$class." , ".$division);
  $query = "UPDATE class_details set teacher_id = '$tid' , subject_code = '$subject' , class_id =  '$class' , division_id = '$division' where class_detail_id = '$id'";

  if(mysqli_query($db,$query)){

    $Message = "Updated successfully!";
    header("Location:subTeacher.php?Message=" . urlencode($Message));
  }
  else{
    $Message = "Failure to update!";
    echo $Message;
    header("Location:subTeacher.php?Message=" . urlencode($Message));
  }


}
 ?>
