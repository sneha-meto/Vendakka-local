<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'vendakka');
if ($conn->connect_error || !$conn) {
  // die('Could not connect: ' . mysqli_error());
  header("Location: http://localhost/Vendakka-local/templates/stock-page.html?toast=Sorry,-cannot-connect.");

  } 

  if(!isset($_SESSION['username'])==null){
    
     $name=$_SESSION['username'];

    $query2="SELECT * FROM stock NATURAL JOIN farmer
    natural join users WHERE username ='$name' and stock_quantity > 0";
    $res2 = mysqli_query($conn, $query2);
    $rows2 = [];
    while ($row2 = mysqli_fetch_assoc($res2)) {
        $rows2[] = $row2;
    }
   echo json_encode($rows2); 
   
    mysqli_close($conn);
    
    }



?>