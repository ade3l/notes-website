<?php 
    try {
        $conn = new mysqli("localhost", "root", "","notes_website","3306") ;
        if($conn->connect_error){
            die("Connection failed: ");
        }
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            $json = file_get_contents('php://input');
            $data = json_decode($json);
            if($data->action == "delete"){
                $email = $data->email;
                $id = $data->id;
                $sql = "DELETE FROM notes WHERE id='$id' and email='$email'";
                $result = $conn->query($sql);
                if($result){
                    echo "success";
                }
                else{
                    echo "failure";
                }
            }
            if($data->action=="save"){
                $title = $data->title;
                $note = $data->note;
                $id = $data->id;
                $email = $data->email;
                $date = date("Y-m-d H:i:s:u");
                $sql = "UPDATE notes SET title='$title', note='$note', date = UTC_TIMESTAMP() WHERE id='$id' and email='$email'";
                $result = $conn->query($sql);
                if($result){
                    echo "success";
                }
                else{
                    echo "failure";
                }
            }
        }
    }
    catch(Exception $e){
        echo "failure";
    }
?>