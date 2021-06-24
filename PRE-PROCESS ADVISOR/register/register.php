<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>َRegister</title>
    <link rel="stylesheet" href="register.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            function registerUser(){
                var values = $("#signupForm").serialize();
                $.ajax({
                    url : "signup.php",
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

      <form class="box" action="signup.php" method="post" name="signupForm" id="signupForm">
  <h1>Register</h1>
  <input type="text" name="name" placeholder="Name">
  <input type="text" name="surname" placeholder="Surname">
  <input type="email" name="email" placeholder="Email">
  <input type="password" name="password" placeholder="Password">
  <input type="button" name="register" value="Register" onclick="registerUser()">
  <div id="res"></div>
</form>

      
  </body>
</html>
