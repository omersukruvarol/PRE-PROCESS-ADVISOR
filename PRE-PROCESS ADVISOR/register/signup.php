<!DOCTYPE html>
<?php
ini_set("pcre.jit", "0"); // for email validation (to allow regualr expressions evaluation)
$name = $_POST['name'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$password = $_POST['password'];
$conn = mysqli_connect("localhost", "group6", "bbgmo@group6", "group6");
$signedup = False ;
if($name == NULL or $surname == NULL or $password == NULL or $email == NULL){
    $message = '<p class="error">Please fill all the requirments</p>';
}
else if(strlen($password) < 8){
    $message = '<p class="error">password should be at least 8 characters</p>';
}
else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $message = '<p class="error">please enter a valid email address</p>';
}
else{
    $query = "SELECT email FROM users WHERE email='".$email."'";
    $result = mysqli_query($conn, $query);
    
    if($result->num_rows != 0){
        $message = '<p class="error">the email '.$email.' is already used</p>';
        mysqli_free_result($result);
    }else{
        
        $password = md5($password);
        // insert into users
        $query2 = "INSERT INTO `users`(`email`, `name`, `surname`, `password`) VALUES ('".$email."','".$name."','".$surname."','".$password."')";
        $result2 = mysqli_query($conn, $query2);
        if($result2){
            $signedup = True;
            session_start();
            $_SESSION['email']=$email;
        }
        else{
            $message = '<p class="error">Something went wrong... Please try again.</p>';
        } 
         
    }
}

                
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <div align="center">
            
                <?php
                mysqli_close($conn);
                if($signedup){
                    echo '<script>window.location = "../login/login.php"</script>';                    
                }
                else{
                    echo '<p>'.$message.'</p>';
                    }

                ?>
            
        </div>
    </body>
</html>


