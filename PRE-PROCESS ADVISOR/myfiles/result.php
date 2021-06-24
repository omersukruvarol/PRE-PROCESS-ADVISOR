<?php 
session_start();

$conn = mysqli_connect("localhost", "group6", "bbgmo@group6", "group6"); // (server, user, password, database name)
$email = $_SESSION['email']; // get user email 
if(isset($_POST['id'])){ // check if id is set
    $id = $_POST['id'];

    // get the result of the row that is equal to id
    $query = "SELECT * FROM files WHERE id='".$id."'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);

    // show result in a textarea which can not be resized or edited
    echo '<textarea cols="100" rows="20" style="resize: none;" readonly>'.$row["result"].'</textarea>';
}

?>