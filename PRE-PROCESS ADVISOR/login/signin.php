<?php
// connection to database 
$conn = mysqli_connect("localhost", "group6", "bbgmo@group6", "group6"); // (server, name, password, database name)
$email = $_POST['email']; // get user entered value
$password = $_POST['password']; 

// check if user has entered email
if($email == NULL or $password == NULL){
    echo '<p class="error">Please fill email and password</p>';
}
else{
    $password = md5($password); // md5 is to encrypt password
    // query from database 
    $query = "SELECT email, password FROM users WHERE email='".$email."' AND password='".$password."'";
    $result = mysqli_query($conn, $query);

    // if we found more than 0 rows then user exist and login is successful
    if($result->num_rows != 0){
        session_start();
        $_SESSION['email']=$email;
        echo '<script>window.location = "../myfiles/myfiles.php"</script>';
    }
    else{ // if email or passwrod is incorrect
        echo '<p class="error">please try again</p>';
    }
    mysqli_free_result($result);
    mysqli_close($conn);
}
?>