<?php
session_start();
$conn = mysqli_connect("localhost", "group6", "bbgmo@group6", "group6");
if(!isset($_SESSION['email'])){
    echo '<script>window.location = "../login/login.php"</script>';
}
$email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>My Files</title>
        <link rel="stylesheet" type= "text/css" href="myfiles.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            // hide textarea of the result and show user's files
            function showFiles(){
                document.getElementById("fileresult").style.display = "none";
                document.getElementById("main").style.display = "block";
            }
        </script>
        <script>
            // run sendfiel.php to upload file to server and to run python script
            function processFile(){
                // make upload button disabled to not upload many times
                document.getElementById("buttonUpload").disabled = true; 
                
                var fd = new FormData(); // a var to hold the data from the form 
                var file = $('#userfile')[0].files; // get the first file (which is the only file in this case

                // Check file selected or not
                if(file.length > 0){
                    
                    fd.append('userfile',file[0]); // add file to form data
                    
                    $("#progress").show(); // show message to user that file is being processd
                    
                    // run sendfile.php while in the same page
                    $.ajax({
                        url: 'sendfile.php',
                        type: 'post',
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function(response){ // if everything is right
                            $("#progress").hide(); // hide the message                             
                            location.reload(); // reload the page to get the new file in the list
                            document.getElementById("buttonUpload").disabled = false; // allow upload button to be clicked
                            
                        },
                        error : function(jqXHR, textstatus, errorthrown){ // in case of error
                            alert("something wend wrong");
                        }
                   });
                   
                }else{ // if user did not select a file (file.length=0)
                   alert("Please select a file.");
                }
            }
        </script>
    </head>
    <body>
    
        <!-- header of the page -->
    <div id="header-wrapper">
        <div id="header">
            <div id="logo">
                <h1><a href="../index.php">PREPROCESSADVISOR</a></h1>
            </div>
            <div id="menu">
                    <ul>
                        <li><b style="color:#DADBD5;"><?php echo $_SESSION['email'];?></b></li> <!-- email of user -->
                        <li><a href="../logout/logout.php" accesskey="2" title=""><b>Log Out</b></a></li><!<!-- logout link's -->
                    </ul>
            </div>
        </div>
    </div>    
        
        <!-- main content -->
    <div id="wrapper">
        <div id="page-wrapper">
            <div id="page">
                <div id="main" style="display: block">
                    <?php
                        // get all files for the user
                        $getFilesQuery = "SELECT * FROM files WHERE user_email='".$email."'";
                        $result = mysqli_query($conn, $getFilesQuery);
                        
                        if($result->num_rows > 0){ // if user has files show them in a table
                            echo '<h3> My Files </h3>';
                            echo '<div align="center">';
                            echo '<table class="files">';
                            $i = 1;
                            while ($row = mysqli_fetch_array($result)) {
                                echo '<tr><td class="id">'.$i.'</td>';
                                echo '<td calss="filename">'.$row['file_name'].'</td>';
                                // the id of the file is linked with the link throug data-value 
                                echo '<td class="result"><a href="#" onclick="return false" id="a'.$i.'" data-value="'.$row['id'].'">Show result</a> </td></tr>';
                                // a script to get the result and show it when show result link is clicked
                                echo '<script>'
                                . '$("#a'.$i.'").on("click",function(e) {
                    
                                        var id = $(this).data("value"); // get file id 

                                        $.ajax({
                                        url : "result.php",
                                        type : "POST",
                                        data : {id:id} ,
                                        success: function(response){
                                            document.getElementById("main").style.display = "none"; // hide the table of files
                                            document.getElementById("fileresult").style.display = "block"; // show the result 
                                            $("#result").html(response); // write the respone from result.php to the div result
                                        }
                                        }); 
                                    });'
                                        . '</script>';
                                $i++;

                            }
                            echo '</table>';
                            echo '</div>';
                        }
                        else{ // if user has no files
                            echo '<p>No Files </p>';
                        }       
                    ?>
                    
                    <!-- form to upload file -->
                    <div align="center">
                        <form enctype="multipart/form-data" action="sendfile.php" method="POST" name="fileForm" id="fileForm">
                            <!-- MAX_FILE_SIZE must precede the file input field -->
                            <input type="hidden" name="MAX_FILE_SIZE" value="1000000000" /> <!<!-- 1 GB  -->
                            <label for="myFile">Click on the "Choose File" button to upload a file:</label>
                            <input name="userfile" id="userfile" type="file" />
                            <div>
                                <input type="button" id="buttonUpload" value="uplaod and process" onclick="processFile()" ><br>
                                <!-- message when file is uploading and being processed -->
                                <div id="progress" >File is uploading and being processed...<br>Please wait</div>
                                <!-- scirpt to hide the progress. It will be shown once the user uplaod a file's -->
                                <script>$("#progress").hide();</script>
                            </div>
                        </form> 
                    </div>
                </div>
                <!-- when user click on show result this div will be shown-->
                <div id="fileresult" align="center" style="display: none">
                    <div id="result"></div>
                    <br>
                    <!-- when clicked, user goes back to files list -->
                    <input type="button" onclick="showFiles()" value="back">
                </div>

            </div>
        </div>
    </div>

        <!-- bottom of page -->
    <div id="footer" class="container">
        <p>This website is done by some students from Istanbul Bilgi University </p>    
        <p>If you have any suggestion or improvements, please do not hesitate to email us on preprocessadvisor@gmail.com</p>
    </div>
        
    </body>
</html>
