<pre>
    <?php
    var_dump($_POST);
    session_start();
    var_dump($_SESSION);
    ?>
</pre>
<!DOCTYPE html>
<html lang="pl-PL">
    <head>
        <title>EditPost</title>
        <link rel="stylesheet" type="text/css" href="style2.css">


    </head>
    <body>

        <?php
        require_once 'CRUD.php';

        $username = $_SESSION['username'];
        $password = $_SESSION['password'];
        $polaczenie = new CRUD($username, $password);
        $autor = $polaczenie->retrieve_autorzy($username);
        $id = $autor[0]['id'];
        $imie = $autor[0]['imie'];
        $pseudo = $autor[0]['pseudo'];
        $mail = $autor[0]['mail'];




        if (sizeof($_POST) != 0)
        {
            if ($_POST['tryb'] == "Delete")
            {
                if ($polaczenie->delete_user_from_root($_POST['e-mail']))
                {
                    $polaczenie->delete_autorzy($id);
                    $_SESSION['username'] = "anonimus";
                    $_SESSION['password'] = "anonim123";
                    ?>
                    <script>
                        function myFunction()
                        {
                            alert("user successfully deleted");
                            window.location.href = 'FoCL';
                        }
                        myFunction()
                    </script>
                    <?php
                } else
                {
                    ?>
                    <script>
                        function myFunction()
                        {
                            alert("Error occurs with deleting an user");

                        }
                        myFunction()
                    </script>
                    <?php
                }
            } else
            {
                if ($_POST['password'] != "" and ( $_POST['password'] == $_POST['re-password']))
                {


                    if ($polaczenie->rename_user_from_root($username, $_POST['e-mail'], $_POST['password']))
                    {
                        $polaczenie->update_autorzy($id, $_POST['imie'], $_POST['pseudo'], $_POST['e-mail']);
                        $_SESSION['username'] = "anonimus";
                        $_SESSION['password'] = "anonim123";
                        ?>
                        <script>
                            function myFunction()
                            {
                                alert("user successfully edited");
                                window.location.href = 'Login';
                            }
                            myFunction()
                        </script>
                        <?php
                    } else
                    {
                        ?>
                        <script>
                            function myFunction()
                            {
                                alert("Error occurs with updating an user");

                            }
                            myFunction()
                        </script>
                        <?php
                    }
                } else
                {
                    if ($_SESSION['username'] != $_POST['e-mail'])
                    {

                        if ($polaczenie->rename_user_from_root($username, $_POST['e-mail']))
                        {

                            $polaczenie->update_autorzy($id, $_POST['imie'], $_POST['pseudo'], $_POST['e-mail']);
                            $_SESSION['username'] = "anonimus";
                            $_SESSION['password'] = "anonim123";
                            ?>
                            <script>
                                function myFunction()
                                {
                                    alert("user successfully edited");
                                    window.location.href = 'Login';
                                }
                                myFunction()
                            </script>
                            <?php
                        } else
                        {
                            ?>
                            <script>
                                function myFunction()
                                {
                                    alert("Error occurs with updating an user");

                                }
                                myFunction()
                            </script>
                            <?php
                        }
                    } else
                    {
                        $polaczenie->update_autorzy($id, $_POST['imie'], $_POST['pseudo'], $_POST['e-mail']);
                        $autor = $polaczenie->retrieve_autorzy($username);
                        $id = $autor[0]['id'];
                        $imie = $autor[0]['imie'];
                        $pseudo = $autor[0]['pseudo'];
                        $mail = $autor[0]['mail'];
                    }
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
                <li><a href="Login">Login</a></li>

            </ul>
        </nav>
        <section id="content">

            <div id="left-col">
                <ul>
                    <li><a   href="Add_Post"><b>Add post</b></a></li>
                    <li><a href="Edit_Post"><b>Edit post</b></a></li>
                    <li><a href="Add_Comment"><b>Add comment</b></a></li>
                    <li><a href="Edit_Comment"><b>Edit comment</b></a></li>
                    <li><a  class = "active"  href="Edit_user"><b>Edit user</b></a></li>

                </ul>
            </div>

            <form id ="kontakt" method = "POST" action ="Edit_user">
                <h1> Edit user</h1>
                <div class="row">
                    <div class="col-25">
                        <label for="fname">User ID</label>
                    </div>
                    <div class="col-75">
                        <input type="text" name="id_autor" placeholder="Your ID" value =
                        <?php
                        echo $id;
                        ?>
                               readonly >
                    </div>
                </div>

                <div class="row">
                    <div class="col-25">
                        <label for="post_id">User name</label>
                    </div>
                    <div class="col-75">
                        <input type="text" name="imie" placeholder="Your name" value =
                        <?php
                        echo $imie;
                        ?>
                               >
                    </div>
                </div>

                <div class="row">
                    <div class="col-25">
                        <label for="lname">User nickname</label>
                    </div>
                    <div class="col-75">
                        <input type="text" name="pseudo" placeholder="Your nickname" value =
                        <?php
                        echo $pseudo;
                        ?>
                               >
                    </div>
                </div>

                <div class="row">
                    <div class="col-25">
                        <label for="lname">User e-mail</label>
                    </div>
                    <div class="col-75">
                        <input type="email" name= "e-mail" placeholder="Your e-mail" value =
                        <?php
                        echo $mail;
                        ?>
                               >
                    </div>
                </div>


                <div class="row">
                    <div class="col-25">
                        <label for="lname">User password</label>
                    </div>
                    <div class="col-75">
                        <input type="password" name= "password" placeholder="Enter new password">
                    </div>
                </div>

                <div class="row">
                    <div class="col-25">
                        <label for="lname">User re-password</label>
                    </div>
                    <div class="col-75">
                        <input type="password" name= "re-password" placeholder="Repeat new password">
                    </div>
                </div>

                <div class="row">
                    <input id = "edit" type="submit" value="  Edit  " name="tryb">
                </div>
                <div class="row">
                    <input id = "delete" type="submit" value="Delete" name="tryb" style="background-color: #e54b4b">
                </div>
            </form>		

        </section>


        <footer id="footer">
            Copyrights &copy; 2018 Michał Szpak
        </footer>


    </body>
</html>

