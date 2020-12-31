
<?php    
    
      
    $conn = mysqli_connect("localhost", "root", '', "vendakka");  

    if(mysqli_connect_errno()) {  
        die("Failed to connect with MySQL: ". mysqli_connect_error());  
    }
            
            $name=$_POST['username'];
           
            $enterpass=$_POST['password'];
            $query="SELECT * FROM `users` WHERE username='$name'";
            $result=mysqli_query($conn , $query);
            $row=mysqli_fetch_array($result); 
            
            $fetchpass=$row['password'];
            mysqli_close($conn);

                if($enterpass==$fetchpass && $fetchpass!=null)
                {   session_start();
                    $_SESSION['username'] =$name;
                    $_SESSION['usertype'] =$row['usertype'];
                    $_SESSION['farm_name'] =$row['farm_name'];
                    header("Location: http://localhost/Vendakka-local/templates/login.html?toast=Login-successful!");
                }
                else{
                    header("Location: http://localhost/Vendakka-local/templates/login.html?toast=Incorrect-username-or-password!");
                } 
            
            

        
?>
