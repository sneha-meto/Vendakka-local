<?php
session_start();

$product_name=$_POST["product-name"];
$category=$_POST["category"];
$quantity=$_POST["quantity"];
$unit=$_POST["unit"];
$cost=$_POST["cost"];
$file=$_FILES["file-name"]["name"];

  // image upload code
  $target_dir = "../uploads/";
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo('./'.basename($_FILES["file-name"]["name"]),PATHINFO_EXTENSION));
  // Check if image file is a actual image or fake image
  if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["file-name"]["tmp_name"]);
    if($check !== false) {
      echo "File is an image - " . $check["mime"] . ".\n";
      $uploadOk = 1;
    } else {
      echo "File is not an image.\n";
      $uploadOk = 0;
    }
  }

    // Check file size
    if ($_FILES["file-name"]["size"] > 2200000) {
      echo "Sorry, your file is too large.\n";
      $uploadOk = 0;
    }
    
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.\n";
      $uploadOk = 0;
    }
    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      header("Location: http://localhost/Vendakka-local/templates/add-product.html?toast=Upload-Failed.");

    // if everything is ok, try to upload file
    } else {

      $conn = new mysqli('localhost', 'root', '', 'vendakka');
      if ($conn->connect_error || !$conn) {
      die('Could not connect: ' . mysqli_error());
      } 

      else if(!isset($_SESSION['username'])==null){
        
        $name=$_SESSION['username'];
        $grab="SELECT * from users where username ='$name'";
        $res_grab=mysqli_query($conn,$grab);
        $res_row=mysqli_fetch_array($res_grab);
        $uid=$res_row['uid'];

        $query="SELECT * FROM `farmer` WHERE uid='$uid'";
        $result=mysqli_query($conn , $query);
        $row=mysqli_fetch_array($result); 
        $farmer_id=$row['farmer_id'];
        

        $insert = "INSERT INTO stock(product_name, category, stock_quantity,farmer_id, price, unit)
          VALUES ('$product_name','$category','$quantity','$farmer_id','$cost','$unit')";
        mysqli_query($conn, $insert);
        $stock_id=$conn->insert_id;
        $image= "../uploads/".$stock_id."-".$file;
        $img_insert = "UPDATE stock set product_image = '$image' where stock_id ='$stock_id'";
        mysqli_query($conn, $img_insert);

        mysqli_close($conn);

      $target_file = $target_dir .$stock_id.'-'. basename($_FILES["file-name"]["name"]);
      if (move_uploaded_file($_FILES["file-name"]["tmp_name"], $target_file)) {
          header("Location: http://localhost/Vendakka-local/templates/add-product.html?toast=Product-added-successfully."); 
      } else {
        header("Location: http://localhost/Vendakka-local/templates/add-product.html?toast=Product-upload-failed.");
      }
    }



  
  }



?>