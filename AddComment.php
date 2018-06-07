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
        <title>AddPost</title>
        <link rel="stylesheet" type="text/css" href="style2.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    </head>
    <body>

        <?php
        require_once 'CRUD.php';

        $username = $_SESSION['username'];
        $password = $_SESSION['password'];
        $polaczenie = new CRUD($username, $password);
        $wpisy = $polaczenie->retrieve_wpisy("all");
        $polaczenie->przerwij_polaczenie();

        if (sizeof($wpisy) == 0)
        {
            ?>
            <script>
                $(document).ready(function ()
                {
                    document.getElementById("post_id").disabled = true;
                    document.getElementById("tresc").disabled = true;
                    document.getElementById("edit").disabled = true;

                });
            </script>
            <?php
        }
        if (sizeof($_POST) != 0)
        {
            $polaczenie = new CRUD($username, $password);

            $id_autor = $_POST['id_autor'];
            $id_wpis = $_POST['post'];
            $tresc = $_POST['tresc'];

            $polaczenie->create_komentarze($tresc, $id_wpis, $id_autor);
            $polaczenie->przerwij_polaczenie();
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
                    <li><a href="Add_Post"><b>Add post</b></a></li>
                    <li><a href="Edit_Post"><b>Edit post</b></a></li>
                    <li><a class = "active" href="Add_Comment"><b>Add comment</b></a></li>
                     <li><a href="Edit_Comment"><b>Edit comment</b></a></li>
                    <li><a href="Edit_user"><b>Edit user</b></a></li>

                </ul>
            </div>

            <form id ="kontakt" method = "POST" action ="Add_Comment">
                <h1> Add comment</h1>
                <div class="row">
                    <div class="col-25">
                        <label for="fname">Author ID</label>
                    </div>
                    <div class="col-75">
                        <input type="text" name="id_autor" placeholder="Your ID" value =
                        <?php
                        $polaczenie = new CRUD($username, $password);
                        $autor = $polaczenie->retrieve_autorzy($username);
                        $id = $autor[0]['id'];
                        echo $id;
                        ?>
                               readonly >
                    </div>
                </div>


                <div class="row">
                    <div class="col-25">
                        <label for="post_id">Select post by id</label>
                    </div>
                    <div class="col-75">
                        <select id="post_id" name="post">
                            <?php
                            foreach ($wpisy as &$wpis)
                            {
                                echo "<option value ='" . $wpis['id'] . "'>" . $wpis['id'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-25">
                        <label for="kom">Comment</label>
                    </div>
                    <div class="col-75">
                        <textarea name="tresc" id = "tresc" placeholder="Write a comment" style="height:200px" ></textarea>
                    </div>
                </div>


                <div class="row">
                    <input id = "edit"  type="submit" value="Add" name="tryb">
                </div>
            </form>		

        </section>


        <footer id="footer">
            Copyrights &copy; 2018 Michał Szpak
        </footer>


    </body>
</html>

