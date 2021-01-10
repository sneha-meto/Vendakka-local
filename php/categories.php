<?php
$conn = mysqli_connect("localhost", "root", '', "vendakka"); 
if (! $conn)
{
  die('Could not connect: ' . mysqli_error());
}
    $category = $_POST['category'];
    $query="SELECT stock_id, product_name, product_image, category, unit, farmer_id, price, farm_name
    FROM stock
    NATURAL JOIN farmer
    natural join users WHERE category='$category' and stock_quantity > 0";
// $query="SELECT * FROM stock natural join farmer natural join users WHERE category ='$category' and stock_quantity > 0";
$res = mysqli_query($conn, $query);
$rows = [];

while ($row = mysqli_fetch_assoc($res))
{
    $rows[] = $row;
}
echo json_encode($rows);
mysqli_close($conn);
  ?>