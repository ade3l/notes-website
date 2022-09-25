<?php 
    $conn = new mysqli("localhost", "root", "","notes_website","3306") ;
    if($conn->connect_error){
        die("Connection failed: ");
    }
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        if(isset($_REQUEST["action"]) && isset($_REQUEST["email"]) && isset($_REQUEST["id"])){
            $action = $_REQUEST["action"];
            $email = $_REQUEST["email"];
            $id = $_REQUEST["id"];

            if($action=="delete"){
                $sql = "DELETE FROM notes WHERE id='$id' and email='$email'";
                $result = $conn->query($sql);
                if($result){
                    echo "success";
                }
                else{
                    echo "failure";
                }
            }
            
        }
        $json = file_get_contents('php://input');
        $data = json_decode($json);
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
?>