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

$sql = "SELECT * FROM `upload`";
$result = mysqli_query($db, $sql);


 ?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>


    <script>
    function DeleteFile(id) {
        if (confirm("Are you sure?")) {
            // your deletion code
            window.location.href='delete.php?id='+id;
        }
        return false;
    }
    </script>


  </head>
  <body>




<table class="table">
  <thead>
    <tr>
      <th>S.No</th>
      <th>Name</th>
      <th>Size</th>
      <th>Type</th>
      <th>Location</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
  <?php
  	while($r = mysqli_fetch_assoc($result)){
   ?>
    <tr>
      <th scope="row"><?php echo $r['id'] ?></th>
      <td><?php echo $r['name'] ?></td>
      <td><?php echo $r['size'] ?></td>
      <td><?php echo $r['type'] ?></td>
      <td><a href="<?php echo $r['location'] ?>">View</a></td>
      <td><a href="delete.php?id=<?php echo $r['id'] ?>" onclick='DeleteFile(<?php echo $r['id'] ?>)'>Delete</a></td>
    </tr>
    <?php
    }
    ?>
  </tbody>
</table>


  </body>
</html>
