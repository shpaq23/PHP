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

            $username = $_POST['username'];
            $password = $_POST['password'];
            $name = $_POST['name'];
            $nick = $_POST['nick'];

            if ($_POST['type'] == "rejestruj")
            {
                $crud = new CRUD("root", "");
                if ($crud->create_user($username, $password))
                {
                    ?>
                    <script>
                        function myFunction()
                        {
                            alert("user successfully created");
                        }
                        myFunction()
                    </script>
                    <?php
                    $crud->create_autor($name, $nick, $username);
                } else
                {
                    ?>
                    <script>
                        function myFunction()
                        {
                            alert("Error occurs with creating an user");
                        }
                        myFunction()
                    </script>
                    <?php
                }
                $username = $_SESSION['username'];
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

                <li><a class = "active" href="Registration">Registration</a></li>
                <li><a href="Login">Login</a></li>

            </ul>
        </nav>
        <section id="content">
            <div id = "loginpanel">
                <div class = "imgcontainer">
                    <img src = "avatar2.jpg" alt="Avatar" class= "avatar">
                </div>
                <div class = "container">
                    <form method = "POST" action ="Registration">
                        <label><b>Username</b></label>
                        <input type="email" placeholder="Enter email" name="username" required>
                        <label><b>Name</b></label>
                        <input type="text" placeholder="Enter name" name="name" required>

                        <label><b>Nick</b></label>
                        <input type="text" placeholder="Enter nick" name="nick" required>
                        <label><b>Password</b></label>
                        <input type="password" placeholder="Enter Password" name="password" required>

                        <input type="text "name="type" value="rejestruj" hidden required>

                        <input  type="submit" style="background-color: #e54b4b" value="Registration"></input>

                    </form>
                </div>
            </div>

        </section>


        <footer id="footer">
            Copyrights &copy; 2018 Michał Szpak
        </footer>


    </body>
</html>

