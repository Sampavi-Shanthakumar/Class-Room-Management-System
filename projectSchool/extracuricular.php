
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
<html>

<head>
<link rel="stylesheet" type="text/css" href="css/nav.css">
<link rel="stylesheet" type="text/css" href="css/Adduser.css">
<?php
if (isset($_GET['Message'])) {
		print '<script type="text/javascript">alert("' . $_GET['Message'] . '");</script>';
}
 ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script script type="text/javascript">

function addRow(){

  $('#sub').attr('disabled','disabled');

  var table = document.getElementById('tableA');

  var e =table.rows.length;
  var x = table.insertRow(e);
	var id_no=e;

  var c1=x.insertCell(0);
      c1.innerHTML  = id_no;
  var c2=x.insertCell(1);
      c2.innerHTML  = "<input type='text' class='form-control' id='data"+id_no+"2' name='student_id[]' placeholder='student id'>";
  var c3=x.insertCell(2);
      c3.innerHTML  = "<input type='text' class='form-control' id='data"+id_no+"3' name='section[]' placeholder='section' >";
  var c4=x.insertCell(3);
      c4.innerHTML  = "<input type='text' class='form-control' id='data"+id_no+"4' name='type[]' placeholder='type' >";
  var c5=x.insertCell(4);
      c5.innerHTML  = "<input type='text' class='form-control' id='data"+id_no+"5' name='year[]' placeholder='year'>";
  var c6=x.insertCell(5);
      c6.innerHTML  = "<select class='form-control' id='sel"+id_no+"' name='level[]'><option value=''>Level</option><option value='Divional'>Divisional</option><option value='Zonal'>Zonal</option><option value='District'>District</option><option value='Provincal'>Provincal</option><option value='National'>National</option></select>";
  var c8=x.insertCell(6);
      c8.innerHTML  = "<input type='text' class='form-control' id='data"+id_no+"7' name='place_no[]' placeholder='place' >";
	var c9=x.insertCell(7);
      c9.innerHTML  = "<button type='button' class='btn btn-danger' onClick='deleteRow("+e+")'>Remove Row</button>";





}


function deleteRow(y) {

	var table = document.getElementById('tableA');
	var n =table.rows.length;

  for(var i=y; i<n-1; i++){
      document.getElementById("data"+i+"2").value=document.getElementById("data"+(i+1)+"2").value;
      document.getElementById("data"+i+"3").value=document.getElementById("data"+(i+1)+"3").value;
      document.getElementById("data"+i+"4").value=document.getElementById("data"+(i+1)+"4").value;
      document.getElementById("data"+i+"5").value=document.getElementById("data"+(i+1)+"5").value;
      document.getElementById("data"+i+"6").value=document.getElementById("data"+(i+1)+"6").value;
      document.getElementById("data"+i+"7").value=document.getElementById("data"+(i+1)+"7").value;
      document.getElementById("sel"+i).value=document.getElementById("sel"+(i+1)).value;
  }

  document.getElementById("tableA").deleteRow(n-1);

}

</script>
</head>
<body>
	<?php include('Header.php'); ?>

<div class="page">
<div class="nav">
<ul>
<li class="home" style="margin-left:50px;"><a href="index.php">Home</a></li>
<li class="about" style="margin-left:50px;"><a href="about.php">About</a></li>

<li class="Login" style="margin-left:50px;"><a href="logout.php">Logout</a></li>

<li class="syllabus"style="margin-left:50px;"><a href="#">Syllabus</a>
<ul>
<li><a href="#">Grade 6</a></li>
<li><a href="#">Grade 7</a></li>
<li><a href="#">Grade 8</a></li>
<li><a href="#">Grade 9</a></li>
<li><a href="#">Grade 10</a></li>
<li><a href="#">Grade 11</a></li>

</ul>
</li>

</ul>
</div>



        <h3>
        <center><h3 style="font-family:lato">Students' Extra Curricular Activities</h3></center>
         </h3>
         <div class="container">
           <form class="" action="addExtracuricular.php" method="post" autocomplete="off">


         <table class="table table-bordered" id="tableA" style="background-color:#e5e7ea">
           <thead>
             <tr class="bg-info" style="text-align: center;">
               <th scope="col" style="background-color:#e5e7ea"></th>
               <th scope="col" style="font-family:lato;background-color:#e5e7ea;">Student Id</th>
               <th scope="col" style="font-family:lato;background-color:#e5e7ea;">Section</th>
               <th scope="col" style="font-family:lato;background-color:#e5e7ea;">Type</th>
                 <th scope="col" style="font-family:lato;background-color:#e5e7ea;">Year</th>
               <th scope="col" style="font-family:lato;background-color:#e5e7ea;">participation Level</th>
               <th scope="col" style="font-family:lato;background-color:#e5e7ea;">Place </th>

             </tr>
           </thead>
           <tbody>
             <tr id='row1'>

               <td>1</td>
               <td><input type="text" class="form-control" id="data12"  name="student_id[]" placeholder="student id"></td>
               <td><input type="text" class="form-control" id="data13" name="section[]" placeholder="section" ></td>
               <td><input type="text" class="form-control" id="data14" name="type[]" placeholder="type" ></td>
               <td><input type="text" class="form-control" id="data15" name="year[]" placeholder="Year" ></td>
               <td>
                 <select class="form-control" id="sel1" name="level[]">
                   <option value="">Level</option>
                   <option value="Divional">Divisional</option>
                   <option value="Zonal">Zonal</option>
                   <option value="District">District</option>
                   <option value="Provincal">Provincal</option>
                   <option value="National">National</option>
                 </select>
               </td>

							 <td><input type="text" class="form-control" id="data17" name="place_no[]" placeholder="place"></td>
         	   <td><button type="button" class="btn btn-danger" onClick="deleteRow(1)">Remove Row</button></td>
             </tr>

           </tbody>
         </table>


         <button type="button" class="btn btn-success"  onClick="addRow()">Add Row</button>

         <button type="submit" name="add_activity" class="btn btn-secondary">Submit</button>
         </div>






     </form>

    <?php include('Footer.php'); ?>
</body>
</html>
