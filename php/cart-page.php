<?php

session_start();
$name=$_SESSION['username'];
$type=$_SESSION['usertype'];
$conn = mysqli_connect("localhost", "root", '', "vendakka");  

if(mysqli_connect_errno()) {  
    die("Failed to connect with MySQL: ". mysqli_connect_error());  
}
else{
    if ($type == "customer"){
        $query= "SELECT * FROM users natural join customer  WHERE username = '$name'";
        $res=mysqli_query($conn,$query);
        $row=mysqli_fetch_array($res);
        $customer_id=$row['customer_id'];
        $cart_query= "SELECT * FROM cart natural join stock natural join users natural join farmer WHERE customer_id = '$customer_id'";
        $cart_res=mysqli_query($conn,$cart_query);
        $rows = [];
        while ($cart_row = mysqli_fetch_assoc($cart_res)) {
            $rows[] = $cart_row;
        }
        echo json_encode($rows);
        

    mysqli_close($conn);
}}


?>