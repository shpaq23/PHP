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

    </head>
    <body>

        <?php
        require_once 'CRUD.php';

        $username = $_SESSION['username'];
        $password = $_SESSION['password'];

        if (sizeof($_POST) != 0)
        {
            $polaczenie = new CRUD($username, $password);

            $id_autor = $_POST['id_autor'];
            $tytul = $_POST['tytul'];
            $tags = $_POST['tags'];
            $tresc = $_POST['tresc'];

            $tagi = explode("#", $tags);
            foreach ($tagi as &$tag)
            {
                $polaczenie->create_tagi($tag);
                //echo $tag;
            }
            $polaczenie->delete_tagi(" ");

            $polaczenie->create_wpisy($id_autor, $tytul, $tresc);

            $id_wpis = $polaczenie->retrieve_wpisy("all");
            $id_wpis = array_reverse($id_wpis);
            $id_wpis = $id_wpis[0]['id'];

            $ile = 0;
            foreach ($tagi as &$tag)
            {
                if ($ile == 0)
                {
                    $ile++;
                    continue;
                }
                $id_tag = $polaczenie->retrieve_tagi("tag", $tag);
                $id_tag = $id_tag[0]['id'];
                $polaczenie->create_wpisy_tagi($id_wpis, $id_tag);
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
                    <li><a  class = "active" href="Add_Post"><b>Add post</b></a></li>
                    <li><a href="Edit_Post"><b>Edit post</b></a></li>
                    <li><a href="Add_Comment"><b>Add comment</b></a></li>
                     <li><a href="Edit_Comment"><b>Edit comment</b></a></li>
                    <li><a href="Edit_user"><b>Edit user</b></a></li>
                </ul>
            </div>

            <form id ="kontakt" method = "POST" action ="Add_Post">
                <h1> Add post</h1>
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
                        <label for="lname">Title</label>
                    </div>
                    <div class="col-75">
                        <input type="text" name="tytul" placeholder="Your title" >
                    </div>
                </div>

                <div class="row">
                    <div class="col-25">
                        <label for="lname">Tags</label>
                    </div>
                    <div class="col-75">
                        <input type="text" name="tags" placeholder="Separate your tags with #" >
                    </div>
                </div>




                <div class="row">
                    <div class="col-25">
                        <label for="kom">Content</label>
                    </div>
                    <div class="col-75">
                        <textarea name="tresc" placeholder="Write something" style="height:200px" ></textarea>
                    </div>
                </div>


                <div class="row">
                    <input type="submit" value="Add" name="tryb">
                </div>
            </form>		

        </section>


        <footer id="footer">
            Copyrights &copy; 2018 Michał Szpak
        </footer>


    </body>
</html>

