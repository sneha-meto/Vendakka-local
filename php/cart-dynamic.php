<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'vendakka');
if ($conn->connect_error || !$conn) {
  header("Location: http://localhost/Vendakka-local/templates/stock-page.html?toast=Failed-To-Delete");
  }  
  
  if(isset($_POST['id'])){
    $id = $_POST['id'];
    $val = $_POST['value'];

    $res = mysqli_query($conn,"SELECT * FROM cart WHERE cart_id ='$id'");
    $row = mysqli_fetch_array($res);
    $stock_id = $row['stock_id'];

    $res2 = mysqli_query($conn,"SELECT * FROM stock WHERE stock_id ='$stock_id'");
    $row2 = mysqli_fetch_array($res2);
    $stk_qty = $row2['stock_quantity'];

    mysqli_query($conn,"UPDATE cart SET quantity ='$val' WHERE cart_id='$id'");

    mysqli_close($conn);
  }
?>
