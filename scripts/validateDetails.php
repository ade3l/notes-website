<?php
    session_start();
    if($_SERVER["REQUEST_METHOD"]=="POST"){
      $json = file_get_contents("php://input");
      $data = json_decode($json);
      $email = clean_input($data->email);
      $password = hash("sha256",clean_input($data->password));
      $conn = new mysqli("localhost", "root","","notes_website");
      $sql = "SELECT * from login_info where email= '$email' and password = '$password' ";
      $result = $conn -> query($sql);
      if($result){
          if($result->num_rows == 0){
              echo "here";
              $valid = false;
              $error = "Please recheck your email and password";
            }
            if($result->num_rows == 1){
            while($row = $result->fetch_assoc()){
                $name = $row["name"];
            }
            $valid = true;
        }
      }
      if($valid){
        $_SESSION["LOGGED_IN"] = "TRUE";
        $_SESSION["name"] =" $name";
        $_SESSION["email"] = "$email";
        echo "success";
      }
      else{
        echo "failure";
      }
    }
    function clean_input($data){
        $data = stripslashes($data);
        $data = trim($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>