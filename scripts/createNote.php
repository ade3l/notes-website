<?php 
    session_start();
        $email = $_SESSION["email"];
        $conn = new mysqli("localhost", "root", "","notes_website","3306") ;
        $sql = "INSERT INTO notes (email, id, title, note, date, tags) VALUES ('$email', UUID(),'Untitled', ' ', UTC_TIMESTAMP(), '[]')";
        $result = $conn->query($sql);
        if($result){
            echo "success";
        }
        else{
            echo "failure";
        }
    

?>