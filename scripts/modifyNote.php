<?php 
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        if(isset($_REQUEST["action"]) && isset($_REQUEST["email"]) && isset($_REQUEST["id"])){
            $action = $_REQUEST["action"];
            $email = $_REQUEST["email"];
            $id = $_REQUEST["id"];
            $conn = new mysqli("localhost", "root", "","notes_website","3306");

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
    }
?>