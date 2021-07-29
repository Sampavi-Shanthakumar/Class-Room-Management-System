<?php
  define('DB_SEVER' , 'localhost');
  define('DB_USERNAME' , 'root');
  define('DB_PASSWORD' , '');
  define('DB_DATABASE' , 'schooldb_new');
  $db = new mysqli(DB_SEVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

  // Check connection
if($db === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Print host information
//echo "Connect Successfully. Host info: " . mysqli_get_host_info($db);

?>
