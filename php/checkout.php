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

        $insert = "INSERT INTO orders (customer_id) VALUES ('$customer_id')";
        mysqli_query($conn, $insert);
        $order_id = $conn->insert_id;

        $sel = "SELECT * FROM cart WHERE customer_id = '$customer_id'";
        $cart_res=mysqli_query($conn,$sel);
        while($cart_row = mysqli_fetch_array($cart_res)){
            $farmer_id = $cart_row['farmer_id'];
            $stock_id = $cart_row['stock_id'];
            $quantity = $cart_row['quantity'];

            $insert_items = "INSERT INTO items (order_id, stock_id, farmer_id, customer_id, quantity)
            VALUES ('$order_id','$stock_id','$farmer_id','$customer_id','$quantity')";
            mysqli_query($conn, $insert_items);
            mysqli_query($conn,"UPDATE stock SET stock_quantity = stock_quantity - '$quantity' WHERE stock_id='$stock_id'");
        }
        mysqli_query($conn,"DELETE FROM cart WHERE customer_id='$customer_id'");

    }
    mysqli_close($conn);
    }
?>