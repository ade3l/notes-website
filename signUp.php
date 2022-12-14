<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lorem ipsum</title>
    <link rel="stylesheet" href="./styles/signUpLogin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
     <?php
        session_start();
        if(isset($_SESSION["LOGGED_IN"])){
            header("Location: notes.php");
        }
        $valid = false;
        $error = "";
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            
            // echo "here1";
            $name = $email = $pwd = $pwd_conf = "";
            $name = clean_input($_POST["name"]);
            $email = clean_input($_POST["email"]);
            $pwd = clean_input($_POST["password"]);
            $pwd_conf = clean_input($_POST["password_conf"]);
            // echo "input ".$email." ".$pwd." ".$pwd_conf;
            if($name != "" && $email!="" && strcmp($pwd,$pwd_conf)==0){
                $pwd = hash("sha256",$pwd);
                $conn = new mysqli("localhost", "root", "", "notes_website");
                if($conn->connect_error){
                    echo "connection failure"+ $conn->connection_error;
                    die();
                }
                $sql = "SELECT * FROM login_info where email = '$email' ;";
                $result = $conn->query($sql);
                if($result){
                    if($result->num_rows!=0){
                        $valid = false;
                        $error = "An account with this email already exists";
                    }
                    else{
                        $sql = "INSERT INTO login_info values('$email','$pwd','$name');";
                        $conn->query($sql);
                        session_start();
                        $_SESSION["LOGGED_IN"] = "TRUE";
                        $_SESSION["name"] = $name;
                        $_SESSION["email"] = $email;
                        header("Location: notes.php");
                    }
                }
                $conn->close();
            }
            else {
                $error = "Please check that all fields are filled";
            }
        }
        function clean_input($data){
            $data = stripslashes($data);
            $data = trim($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    ?> 
    <section class="page-container">
        <div class="left-half">
          <div class="container">
            <div class="top">
                <div class="name">
                    Lorem, <br>ipsum dolor.
                </div>
                <hr>
                <p>We are</p>
                <p class="large">Invite only right now.</p>
                <p class="small">We are working on expanding and rolling out for everyone who signs up.</p>
                <p class="small">We invite you to join our network.</p>
            </div>
            <div class="bottom">
                <p>Already have account?</p>
                <a href="./login.html">Sign in</a>
            </div>
            </div>
          </div>
        </div>
        <div class="right-half">
            <form action="signUp.php" method="post" id="#signUpForm">
                <h1>Sign up</h1>
                <?php if($error!="") echo $error;?>
                <div class="inputField">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="" placeholder="Enter your name"  required >
                </div>
                <div class="inputField">
                    <label for="email">Email address</label>
                    <input type="email" name="email" id="" placeholder="Enter your email"  >
                </div>
                <div class="inputField">
                
                    <label for="password">Password</label>
                    <input type="password" name="password" placeholder="Enter password">
                </div>
                <div class="inputField">
                    <label for="password_conf">Confirm password</label>
                    <input type="password" name="password_conf" placeholder="Re-enter password">
                </div>
                <div class = "showPassword">
                    <input type="checkbox" name="password_show" id="">
                    <label class="text-small" for="password_show">show password</label>
                </div>
                <button id="signUp" type="submit">Get started ???</button>
            </form>
        </div>
      </section>
    <script src="./scripts/signUp.js" defer></script>

</body>
</html>