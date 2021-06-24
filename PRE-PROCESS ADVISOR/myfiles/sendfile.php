<?php
session_start();
$message = ''; 
// get details of the uploaded file
$fileTmpPath = $_FILES['userfile']['tmp_name']; // temp location of file on server
$fileName = $_FILES['userfile']['name']; // name of uploaded file
$fileSize = $_FILES['userfile']['size']; // size fo the file
$fileType = $_FILES['userfile']['type']; // type of file (text/csv)
$fileNameArray = explode(".", $fileName); // split file name and extension, first is the name second is the extension
$fileExtension = strtolower(end($fileNameArray)); // get file extension with lowercase letters

// create a new uniqe file name
$newFileName = $fileNameArray[0].'_'.md5(time() . $fileName) . '.' . $fileExtension;

// check if file has the accepted extension
$allowedfileExtensions = array('csv'); // this check must be with javascript, will try to implement it

if (in_array($fileExtension, $allowedfileExtensions)){
    // directory in which the uploaded file will be moved
    $uploadFileDir = '../uploaded_files/';
    $dest_path = $uploadFileDir . $newFileName; // dir + name of new file

    // move file from temp to the required folder
    if(move_uploaded_file($fileTmpPath, $dest_path)) { // if successful move
        echo 'file is uploaded successfully';

        // add file to database
        $conn = mysqli_connect("localhost", "group6", "bbgmo@group6", "group6");
        $query = "INSERT INTO `files`(`user_email`, `file_name`, `server_file_name`) VALUES ('".$_SESSION['email']."','".$fileName."','".$newFileName."')";
        $result = mysqli_query($conn, $query);

        if($result){ // on success adding
            // run python script with the new file name as an argument
            exec("/Users/moqa/anaconda3/bin/python projectno1.py $newFileName");
        }
    }
    else{ // if move was not successful
        //echo 'file was not uploaded successfully';
    }
}
?>


