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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script>


            function myFunction()
            {
                //document.getElementById("kontakt").submit();
                var d = document.getElementById("post_id").value;
                var tags = "";
                var title = "";
                var content = "";


                $.getJSON('Getter.php?id=' + d + '&tryb=post', function (data) {
                    $.each(data, function (i, field) {
                        if (i == "title")
                        {
                            title = field;
                        } else if (i == "tags")
                        {
                            tags = field;
                        } else if (i == "content")
                        {
                            content = field;
                        }
                        //  console.log(i);
                        //  console.log(field);

                    });
                    //  console.log(data);
                    //  console.log(tags);
                    // console.log(title);
                    // console.log(content);

                    document.getElementById("tytul").value = title;
                    document.getElementById("tags").value = tags;
                    document.getElementById("tresc").innerHTML = content;


                });


            }
        </script>

    </head>
    <body>

        <?php
        require_once 'CRUD.php';

        $username = $_SESSION['username'];
        $password = $_SESSION['password'];
        $polaczenie = new CRUD($username, $password);
        $autor = $polaczenie->retrieve_autorzy($username);
        $id = $autor[0]['id'];
        $wpisy = $polaczenie->retrieve_wpisy("id_autor", $id);
        $tytul = "";
        $tresc = "";
        $tags = "";



        if (sizeof($_POST) != 0)
        {

            ///////EDYTOWANIE LUB USUWANIE
            if (sizeof($_POST) == 6)
            {
                if ($_POST['tryb'] == 'Delete')
                {
                    $polaczenie->delete_wpisy($_POST['post']);
                    $wpisy = $polaczenie->retrieve_wpisy("id_autor", $id);
                } else
                {
                    $tytul = $_POST['tytul'];
                    $id_wpisu = $_POST['post'];
                    $tresc = $_POST['tresc'];
                    $tags = $_POST['tags'];
                    $polaczenie->update_wpisy($id_wpisu, $tytul, $tresc);

                    $tagi = explode("#", $tags);
                    foreach ($tagi as &$tag)
                    {
                        $polaczenie->create_tagi($tag);
                        echo $tag;
                    }
                    $polaczenie->delete_tagi(" ");

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
                        $polaczenie->create_wpisy_tagi($id_wpisu, $id_tag);
                    }



                    $wpisy = $polaczenie->retrieve_wpisy("id_autor", $id);
                    $tags = "";
                }
            }
        }
        /////////PIERWSZE WLACZENIE PIERWSZY POST UZYTKJOWNIKA

        if (isset($wpisy[0]['tytul']))
        {
            $tytul = $wpisy[0]['tytul'];
        }
        if (isset($wpisy[0]['tresc']))
        {
            $tresc = $wpisy[0]['tresc'];
        }
        if (isset($wpisy[0]['id']))
        {
            $id_wpisu = $wpisy[0]['id'];
        }
        if (isset($wpisy[0]['id']))
        {
            $wpisy_tagi = $polaczenie->retrieve_wpisy_tagi("id_wpis", $wpisy[0]['id']);

            foreach ($wpisy_tagi as &$tagi)
            {
                $tag = $polaczenie->retrieve_tagi("id", $tagi['id_tag']);

                $tags = $tags . "#" . $tag[0]['tag'];
            }
        }
        if ($tytul == "")
        {
            ?>
            <script>
                $(document).ready(function ()
                {
                    document.getElementById("post_id").disabled = true;
                    document.getElementById("tytul").disabled = true;
                    document.getElementById("tags").disabled = true;
                    document.getElementById("tresc").disabled = true;
                    document.getElementById("edit").disabled = true;
                    document.getElementById("delete").disabled = true;
                });
            </script>
            <?php
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
                    <li><a class = "active" href="Edit_Post"><b>Edit post</b></a></li>
                    <li><a href="Add_Comment"><b>Add comment</b></a></li>
                     <li><a href="Edit_Comment"><b>Edit comment</b></a></li>
                    <li><a href="Edit_user"><b>Edit user</b></a></li>

                </ul>
            </div>

            <form id ="kontakt" method = "POST" action ="Edit_Post">
                <h1> Edit post</h1>
                <div class="row">
                    <div class="col-25">
                        <label for="fname">Author ID</label>
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
                        <label for="post_id">Select post by id</label>
                    </div>
                    <div class="col-75">
                        <select id="post_id" name="post" onchange = "myFunction()">
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
                        <label for="lname">Title</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id ="tytul" name="tytul" placeholder="Your title"
                        <?php
                        echo "value='$tytul' >";
                        ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-25">
                        <label for="lname">Tags</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id = "tags" name="tags" placeholder="Separate your tags with #" 
                        <?php
                        echo "value='$tags' >";
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="kom">Content</label>
                    </div>
                    <div class="col-75">
                        <textarea name="tresc" id = "tresc" placeholder="Write something" style="height:200px"><?php
                            echo $tresc;
                            ?></textarea>
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

