<?php

$conn = mysqli_connect("localhost", "root", '', "vendakka");  

if(mysqli_connect_errno()) {  
    die("Failed to connect with MySQL: ". mysqli_connect_error());  
}

// else if(isset($_GET['submit']))
// {
$search_string = $_POST['search'];
$query="SELECT * FROM stock natural join farmer natural join users WHERE product_name LIKE '%$search_string%' and stock_quantity > 0";
$res=mysqli_query($conn,$query);

$rows = [];
while ($row = mysqli_fetch_assoc($res)) {
    $rows[] = $row;
}
echo json_encode($rows);


mysqli_close($conn);
// }

?>