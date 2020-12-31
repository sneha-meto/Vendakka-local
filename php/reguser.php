<?php

$conn = new mysqli('localhost', 'root', '', 'vendakka');
if ($conn->connect_error || !$conn) {
  // die('Could not connect: ' . mysqli_error());
  header("Location: http://localhost/Vendakka-local/templates/registration.html?toast=Registation-Failed");

  }
  else if(isset($_POST['submit']))
  {
$username=$_POST['username'];
$password=$_POST['password'];
$usertype=$_POST['usertype'];
$phone=$_POST['phone'];
$street=$_POST["street"];
$city=$_POST["city"];
$farm_name=$_POST["farm_name"];

$grab="select * from users where username ='$username'";
$res_grab=mysqli_query($conn,$grab);

if (mysqli_num_rows($res_grab)>0)
{  mysqli_close($conn);
  header("Location: http://localhost/Vendakka-local/templates/registration.html?toast=Sorry,-this-Username-is-already-taken.");
}
else{
  $insert = "INSERT INTO users(username,password,usertype,phone,street,city,farm_name)
  VALUES ('$username','$password','$usertype','$phone','$street','$city','$farm_name')";
  mysqli_query($conn, $insert);

  $res_grab=mysqli_query($conn,$grab);

  $row=mysqli_fetch_array($res_grab);
  $uid=$row['uid'];

    if ($usertype=='farmer')
    { $split = "INSERT INTO farmer(uid) VALUES ('$uid')"; }
    else { $split = "INSERT INTO customer(uid) VALUES ('$uid')"; }
    $res=mysqli_query($conn,$split);
    mysqli_close($conn);
    header("Location: http://localhost/Vendakka-local/templates/registration.html?toast=Registered"); 
  }
  
  }


?>