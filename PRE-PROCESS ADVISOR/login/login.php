<?php
session_start();
if(isset($_SESSION['email'])){
    echo '<script>window.location = "../myfiles/myfiles.php"</script>';
}
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function loginUser(){
            var values = $("#signinForm").serialize();
            $.ajax({
                url : "signin.php",
                type : "POST",
                data : values ,
                success: function(response){
                    $("#res").html(response);
                },
                error : function(jqXHR, textstatus, errorthrown){

                }
            });
        }
    </script>
  </head>
  <body>

      <form class="box" action="signin.php" method="post" name="signinForm" id="signinForm">
  <h1>Login</h1>
  <input type="text" name="email" placeholder="Email">
  <input type="password" name="password" placeholder="Password">
  <input type="button" name="login" value="Login" onclick="loginUser()">
  <div id="res"></div>
  
</form>


  </body>
</html>

