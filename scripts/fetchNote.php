<?php
    $note_id = $_REQUEST["note_id"];
    $email = $_REQUEST["email"];
    $conn = new mysqli("localhost", "root","", "notes_website");
    $sql = "SELECT * FROM notes where id = '$note_id' and email = '$email'";
    if($conn->connect_error){
        echo "connection failure";
        die();
    }
    $result = $conn->query($sql);
    if($result){
        if($result->num_rows==1){
            $row = $result->fetch_assoc();
            $id = $row['id'];
            $title = $row['title'];
            $date = date("M d, Y \a\\t h:ia",strtotime($row['date']));
            $note = $row['note'];
            $tags = $row['tags'];
            //return the data in json format
            echo json_encode(array("id"=>$id, "title"=>$title, "date"=>$date, "note"=>$note, "tags"=>$tags));
        }
    }
?>