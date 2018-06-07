<pre>
    <?php
    var_dump($_POST);
    session_start();
    ?>
</pre>
<!DOCTYPE html>
<html lang="pl-PL">
    <head>
        <title>Login</title>
        <link rel="stylesheet" type="text/css" href="style2.css">

    </head>
    <body>

        <?php
        require_once 'CRUD.php';

        if (sizeof($_POST) == 0)
        {
            $username = $_SESSION['username'];
            $password = $_SESSION['password'];
        } else
        {


            if ($_POST['type'] == "loguj")
            {
                $username = $_POST['username'];
                $password = $_POST['password'];
                try
                {
                    $crud = new CRUD($username, $password);
                    ?>
                    <script>
                        function myFunction()
                        {
                            alert("Successfully logged in");
                        }
                        myFunction()
                    </script>
                    <?php
                    $_SESSION['username'] = $_POST['username'];
                    $_SESSION['password'] = $_POST['password'];
                } catch (PDOException $e)
                {
                    ?>
                    <script>
                        function myFunction()
                        {
                            alert("Error occurs with trying to log in");
                        }
                        myFunction()
                    </script>
                    <?php
                    $username = "anonimus";
                    $password = "anonim123";
                }
            }
        }
        ?>
        <header id = "header">
            <div id = "title">
                <h1>Forum of cat lovers</h1>
            </div>
            <div id ="username">
                <p> Logged User: <br><b><?php echo $username ?></b> </p>
            </div>
            <div id = "background">
                <img src="background.jpg" alt="background" />
            </div>
        </header>
        <nav id="top-menu">
            <ul id = "menu" class = "topnav">
                <li><a href = "FoCL">News</a></li>

                <li><a href="Registration">Registration</a></li>
                <li><a  class = "active" href="Login">Login</a></li>



            </ul>
        </nav>
        <section id="content">
            <div id = "loginpanel">
                <div class = "imgcontainer">
                    <img src = "avatar2.jpg" alt="Avatar" class= "avatar">
                </div>
                <div class = "container">
                    <form method = "POST" action ="Login">
                        <label><b>Username</b></label>
                        <input type="email" placeholder="Enter email" name="username" required>
                        <label><b>Password</b></label>
                        <input type="password" placeholder="Enter Password" name="password" required>

                        <input type="text "name="type" value="loguj" hidden required>


                        <input type="submit" value="Login"></input>

                    </form>
                </div>
            </div>

        </section>


        <footer id="footer">
            Copyrights &copy; 2018 Michał Szpak
        </footer>


    </body>
</html>

