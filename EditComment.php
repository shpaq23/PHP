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
                // alert(d);
                var id_autor = document.getElementById("id_autor").value;
                // alert(id_autor);
                var kom_id = ""
                var tresc = "";


                $.getJSON('Getter.php?id_post=' + d + '&id_autor=' + id_autor + '&tryb=kom_id', function (data) {
                    $.each(data, function (i, field) {
                        if (i == "kom_id")
                        {
                            kom_id = field;
                        } else if (i == "tresc")
                        {
                            tresc = field;
                        }
                        //  console.log(i);
                        //  console.log(field);

                    });
                    // console.log(data);
                    // console.log(kom_id);
                    //console.log(tresc);
                    // console.log(content);
                    document.getElementById("tresc").innerHTML = tresc;
                    $('#com_id')
                            .find('option')
                            .remove()
                            .end();
                    var x = document.getElementById("com_id");
                    for (i = 0; i < kom_id.length; i++)
                    {
                        var opt = document.createElement("option");
                        //   console.log(kom_id[i]);
                        opt.value = kom_id[i];
                        opt.text = kom_id[i];
                        x.add(opt);
                    }
                    $(document).ready(function ()
                    {
                        document.getElementById("com_id").disabled = false;
                        document.getElementById("tresc").disabled = false;
                        document.getElementById("edit").disabled = false;
                        document.getElementById("delete").disabled = false;
                    });
                });
                if (kom_id == "")
                {
                    $('#com_id')
                            .find('option')
                            .remove()
                            .end();
                    $(document).ready(function ()
                    {
                        document.getElementById("com_id").disabled = true;
                        document.getElementById("tresc").disabled = true;
                        document.getElementById("edit").disabled = true;
                        document.getElementById("delete").disabled = true;
                    });

                }
                if (tresc == "")
                {
                    document.getElementById("tresc").innerHTML = tresc;
                }


            }


            function myFunction2()
            {
                var kom_id = document.getElementById("com_id").value;
                var tresc = "";

                $.getJSON('Getter.php?id_kom=' + kom_id + '&tryb=tresc', function (data) {
                    $.each(data, function (i, field) {
                        if (i == "tresc")
                        {
                            tresc = field;
                        }
                    });
                    // console.log(data);
                    //console.log(tresc);

                    document.getElementById("tresc").innerHTML = tresc;
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

        if (sizeof($_POST) > 0)
        {
            $kom_id = $_POST['com'];
            $tresc = $_POST['tresc'];
            if ($_POST['tryb'] == 'Delete')
            {
                $polaczenie->delete_komentarez($kom_id);
            } else
            {
                $polaczenie->update_komentarze($kom_id, $tresc);
            }
        }

        $wpisy = $polaczenie->retrieve_wpisy("all");
        $id_autor = $polaczenie->retrieve_autorzy($username);
        $id_autor = $id_autor[0]['id'];
        $tresc = "";

        //  echo $id_autor;
        //  echo $wpisy[1]['id'];
        //  echo $wpisy[1]['id_autor'];

        $komentarze = $polaczenie->retrieve_komentarze("id_autor_wpis", $id_autor, $wpisy[0]['id']);
        if (isset($komentarze[0]['tresc']))
        {
            $tresc = $komentarze[0]['tresc'];
        } else
        {
            ?>
            <script>
                $(document).ready(function ()
                {
                    document.getElementById("com_id").disabled = true;
                    document.getElementById("tresc").disabled = true;
                    document.getElementById("edit").disabled = true;
                    document.getElementById("delete").disabled = true;

                });
            </script>
            <?php
        }

        if (sizeof($wpisy) == 0)
        {
            ?>
            <script>
                $(document).ready(function ()
                {
                    document.getElementById("post_id").disabled = true;
                    document.getElementById("com_id").disabled = true;
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
                    <li><a href="Add_Post"><b>Add post</b></a></li>
                    <li><a href="Edit_Post"><b>Edit post</b></a></li>
                    <li><a href="Add_Comment"><b>Add comment</b></a></li>
                    <li><a class = "active"  href="Edit_Comment"><b>Edit comment</b></a></li>
                    <li><a href="Edit_user"><b>Edit user</b></a></li>

                </ul>
            </div>

            <form id ="kontakt" method = "POST" action ="Edit_Comment">
                <h1> Edit comment</h1>
                <div class="row">
                    <div class="col-25">
                        <label for="fname">Author ID</label>
                    </div>
                    <div class="col-75">
                        <input id ="id_autor" type="text" name="id_autor" placeholder="Your ID" value =
                        <?php
                        echo $id_autor;
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
                        <label for="post_id">Select comment by id</label>
                    </div>
                    <div class="col-75">
                        <select id="com_id" name="com" onchange = "myFunction2()">
                            <?php
                            foreach ($komentarze as &$komentarz)
                            {
                                echo "<option value ='" . $komentarz['id'] . "'>" . $komentarz['id'] . "</option>";
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

