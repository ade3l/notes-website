<?php 
    session_start();
        $email = $_SESSION["email"];
        $conn = new mysqli("localhost", "root", "","notes_website","3306") ;
        $sql = "INSERT INTO notes (email, id, title, note, date, tags) VALUES ('$email', UUID(),'Untitled', ' ', UTC_TIMESTAMP(), '[]')";
        $result = $conn->query($sql);
        if($result){
            // send response to the client in xml format
            echo "<response><valid>true</valid></response>";
        }
        else{
            echo "<response><valid>false</valid></response>";
        }
    

?>