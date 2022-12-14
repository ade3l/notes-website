<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/notesFeed.css">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@1,500&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="./scripts/notes.js" defer></script>
</head>
<body>
    <?php 
        session_start();
        if(!isset($_SESSION["LOGGED_IN"]) || !isset($_SESSION["name"]) || !isset($_SESSION["email"])){
            header("location: index.html");
            die();
        }
        // echo '<pre>'; var_dump($_SESSION); echo '</pre>'; 

    ?>
    <section id="leftPanel">
        <div class="user">
            <img src="./images/avatar.png" alt="">
            <p class="userName"><?php echo($_SESSION['name']);?></p>
        </div>
        <ul class="folders">
            <li class = "selected" onclick="location.href='javascript:void(0);'">Notes</li>
            <li onclick="location.href='javascript:void(0);'">Tasks</li>
            <li onclick="location.href='javascript:void(0);'">Folder 1</li>
            <li onclick="location.href='javascript:void(0);'">Folder 2</li>
        </ul>
        <button class="newFolder bottom"><strong>+</strong> New Folder</button>
        
    </section>
    <div class="pageContainer">
        
        <section id="contentsList">
            <div class="topBar">
                <select name="order" id="orderSelector">
                    <option value="latest">Last Updated</option>
                    <option value="oldest">Oldest</option>
                    <option value="Alphabetical">A-Z</option>
                </select>
                <button id="newNote">+ NEW NOTE</button>
            </div>
            <?php 
                $conn = new mysqli("localhost","root","", "notes_website");
                $email = $_SESSION["email"];

                $sql = "SELECT * FROM notes where email='$email'";
                $result = $conn->query($sql);
                if($result){
                    if($result->num_rows>0){
                        while($row = $result->fetch_assoc()){
                            $title = $row['title'];
                            $date = date("d-M-Y",strtotime($row['date']));
                            $note = $row['note'];
                            $id = $row['id'];
                            echo "<div class = 'note' data-key='$id'>";
                            echo "<div class = 'updated'>$date</div>";
                            echo "<div class = 'title'>$title</div>";
                            echo "<div class='description'>$note</div>";
                            echo "<div class='tags'>";
                            echo "<div class='tag'>#TAGNAME</div>
                                    <div class='tag'>#DESIGN</div>
                            <div class='tag'>#NOTES</div>
                            </div>";
                            echo "</div>";


                        }
                    }
                }
            ?>
            
        </section>
        <section id="content">

            <div class="noteTop">
                <button id="deleteNote">DELETE</button>
                <button id="saveNote">SAVE</button>

                <!-- A hidden input field with the note id -->
                <input type="hidden" id="note_id">
                <div class="title" contenteditable="true">Visual Inspiration</div>
                <div class="details">
                    <div class="">
                        <label for="lastUpdated">Last Updated</label>
                        <span class="updated" name = "lastUpdated">May 5, 2022 at 10:30AM</span>
                    </div>
                
                    <div class="">
                        <label for="tags">Tags</label>
                        <span class="tags" name="tags">
                    
                        </span>
                    </div>
                </div>
                <div class="options">
                    <select name="font" id="fontSelector">
                        <option value="Poppins">Poppins</option>
                        <option value="sans-serif">sans-serif</option>
                        <option value="Helvetica">Helvetica</option>
                        <option value="Montserrat">Montserrat</option>
                        <option value="sans-serif">sans-serif</option>
                        <option value="sans-serif">sans-serif</option>
                    </select>
                    <select name="fontSize" id="sizeSelector">
                        <option value="12">12</option>
                        <option value="14">14</option>
                        <option value="16">16</option>
                        <option value="18">18</option>
                        <option value="20">20</option>
                        <option value="22">22</option>
                    </select>
                    <span id="bold"><strong>B</strong></span>
                    <span id="italics"><em>I</em></span>
                </div>
            </div>
            <div class="noteText" contenteditable="true"></div>
        </section>
    </div>
</body>
</html>