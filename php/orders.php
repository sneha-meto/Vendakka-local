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
        $order_query= "SELECT * FROM orders WHERE customer_id = '$customer_id'";
        $order_res=mysqli_query($conn,$order_query);
        $order_rows = [];
        while($order_row = mysqli_fetch_assoc($order_res)){
                
            $order_id=$order_row['order_id'];
            $item_query= "SELECT * FROM items natural join customer natural join users natural join stock  WHERE order_id = '$order_id'";
            $item_res=mysqli_query($conn,$item_query);
            $rows = [];
            while ($item_row = mysqli_fetch_assoc($item_res)) {
                $rows[] = $item_row;
            }
            $order_rows[] = $rows;
        }
        echo json_encode($order_rows);
    }

    else if ($type == "farmer"){

        //todo for farmer
        $query="SELECT * FROM users natural join farmer  WHERE username = '$name'";
        $res= mysqli_query($conn,$query);
        $row= mysqli_fetch_array($res);
        $farmer_id= $row['farmer_id'];
        $item_query= "SELECT * FROM items natural join stock natural join users natural join customer WHERE farmer_id = '$farmer_id'";
        $item_res = mysqli_query($conn,$item_query);
        $item_res2 = mysqli_query($conn,$item_query);

        $item_row = mysqli_fetch_assoc($item_res);
        $order_id = $item_row['order_id'];  // order id of first item 
        // order_id variable keeps track of current order 
        $order_rows = [];
        $rows = [];
        while ($item_row2 = mysqli_fetch_assoc($item_res2)) {
            $order_id2=$item_row2['order_id'];
            
            if ($order_id2==$order_id){
            //   add to inner array

            $rows[] = $item_row2;
            }
            else{
            //   new inner array
            
            $order_rows[] = $rows;
            $rows = [];
            $rows[] = $item_row2;

            $order_id =$order_id2;
            }
        }
        $order_rows[] = $rows;

        echo json_encode($order_rows);
        
    }

    


    mysqli_close($conn);
}




?>