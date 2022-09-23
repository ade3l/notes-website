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
    <script src="./scripts/login.js" defer></script>
</head>
<body>
<?php
        session_start();
        $email = $password = "";
        $valid = false;
        $error = "";
        if(isset($_SESSION["LOGGED_IN"])){
            header("Location: notes.html");
            die();
        }
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            if(!empty($_POST["email"]) && !empty($_POST["password"])){
                $name = "";
                $email = clean_input($_POST["email"]);
                $password = clean_input($_POST["password"]);
                // echo $email." ".$password;
                $conn = new mysqli("localhost", "root", "","notes_website","3306");
                if($conn->connect_error){
                    die("Connection faild:". $conn->connect_error);
                }
                $sql = "SELECT * from login_info where email= '$email' and password = '$password' ";
                $result = $conn -> query($sql);
                if($result){
                    if($result->num_rows == 0){
                        $valid = false;
                        $error = "Please recheck your username and password";
                    }
                    if($result->num_rows == 1){
                        while($row = $result->fetch_assoc()){
                            $name = $row["name"];
                            
                        }
                        $valid = true;
                    }
                }
                else{
                    echo "failure";
                }
                $conn->close();

                if($valid){
                    echo "here";
                    session_start();
                    $_SESSION["LOGGED_IN"] = "TRUE";
                    $_SESSION["name"] = $name;
                    header("Location: notes.php");
                    die();
                }
            }
        }
        
        function clean_input($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    ?>
    <section class="page-container">
        <div class="left-half" style="background-image: url(images/bg4.jpg);">
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
                <p>Don't have account?</p>
                <a href="./signUp.html">Sign up</a>
            </div>
            </div>
          </div>
        </div>
        <div class="right-half">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="loginForm">
                
                <h1>Login</h1>
                <?php if(!$valid) echo "<p>".$error."</p>"; $error = "";?>
                <div class="inputField">
                    <label for="email">Email address</label>
                    <input type="email" name="email" placeholder="Enter your email" value="<?php echo $email;?>">
                </div>
                <div class="inputField">
                
                    <label for="password">Password</label>
                    <input type="password" name="password" placeholder="Enter password" autocomplete="current-password">
                </div>
                <div class = "showPassword">
                    <input type="checkbox" name="password_show" id="">
                    <label class="text-small" for="password_show" id="password_conf">show password</label>
                </div>
                <button id="login">Login →</button>
            </form>
        </div>
      </section>
</body>
</html>