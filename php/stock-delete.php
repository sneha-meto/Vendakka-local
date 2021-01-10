<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'vendakka');
if ($conn->connect_error || !$conn) {
  header("Location: http://localhost/Vendakka-local/templates/stock-page.html?toast=Failed-To-Delete");
  }  
  
  if(isset($_POST['id'])){
    $id = $_POST['id'];
    mysqli_query($conn,"UPDATE stock SET stock_quantity = 0 WHERE stock_id='$id'");
    mysqli_close($conn);
  }
?>