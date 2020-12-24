<?php

$conn = new mysqli('localhost', 'root', '', 'venda');
if ($conn->connect_error || !$conn) {
  // die('Could not connect: ' . mysqli_error());
  header("Location: http://localhost/Vendakka-local/templates/registration.html?toast=Failed");

  }
  else if(isset($_POST['submit']))
  {
$username=$_POST['username'];
$password=$_POST['password'];
$usertype=$_POST['usertype'];
$phone=$_POST['phone'];
$street=$_POST['street'];
$city=$_POST['city'];
$farm_name=$_POST['farm_name'];

  $sql = "INSERT INTO users(username,password,usertype,phone,street,city,farm_name)
  VALUES ('$username','$password','$usertype','$phone','$street','$city','$farm_name')";
mysqli_query($conn, $sql);

$sql2="select * from users where username ='$username'";
$res=mysqli_query($conn,$sql2);
$row=mysqli_fetch_array($res);
$uid=$row['uid'];

  if ($usertype=='farmer')
  { $sql3 = "INSERT INTO farmer(uid) VALUES ('$uid')"; }
  else { $sql3 = "INSERT INTO customer(uid) VALUES ('$uid')"; }
  $res=mysqli_query($conn,$sql3);

mysqli_close($conn);
header("Location: http://localhost/Vendakka-local/templates/registration.html?toast=Registered"); 
}


?>