<?php

session_start();
$name=$_SESSION['username']; 

$conn = mysqli_connect("localhost", "root", '', "vendakka");  

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
    $query= "SELECT * FROM users natural join customer  WHERE username = '$name'";
    $res=mysqli_query($conn,$query);
    $row=mysqli_fetch_array($res);
    $customer_id=$row['customer_id'];

    $id = $_POST['id'];
    $query2="SELECT * FROM stock WHERE stock_id = '$id'";
    $res2=mysqli_query($conn,$query2);
    $row2=mysqli_fetch_array($res2);
    $farmer_id=$row2['farmer_id'];
    $qty="1";

    //if product already exists in cart, skip
  
    $res3 = mysqli_query($conn,"SELECT cart_id FROM cart WHERE stock_id = '$id'");
    $row3=mysqli_fetch_array($res3);
    if(count($row3) == 0) {
        $insert = "INSERT INTO cart(customer_id, farmer_id, stock_id, quantity)
        VALUES ('$customer_id','$farmer_id','$id','$qty')";
        mysqli_query($conn, $insert);
    } 
  





mysqli_close($conn);
?>
