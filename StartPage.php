
<pre>
    <?php
    session_start();
    var_dump($_POST);
    var_dump($_SESSION);
    ?>
</pre>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html lang="pl-PL">
    <head>
        <title>FORUM</title>
        <link rel="stylesheet" type="text/css" href="style2.css">
    </head>
    <body>

        <?php
        require_once 'InicjalizacjaBazy.php';
        require_once 'CRUD.php';

        if (sizeof($_SESSION) == 0)
        {
            new InicjalizacjaBazy();
            $_SESSION['username'] = "anonimus";
            $_SESSION['password'] = "anonim123";
        }

        $username = $_SESSION['username'];
        $password = $_SESSION['password'];
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
            <ul>
                <li><a class = "active" href = "FoCL">News</a></li>
                <li><a href="Registration">Registration</a></li>
                <li><a href="Login">Login</a></li>

            </ul>
        </nav>

        <section id="content">
            <?php
            if ($_SESSION['username'] == "anonimus")
            {

                echo "<div id ='article' style='width: 96%'>";

                $polaczenie = "";
                $polaczenie = new CRUD($username, $password);

                $wpisy = $polaczenie->retrieve_wpisy("all");
                $wpisy = array_reverse($wpisy);
                $licznik = 0;
                foreach ($wpisy as &$wpis)
                {
                    echo "<h1>" . $wpis['tytul'] . "</h1>"
                    . "<p>" . $wpis['tresc'] . "</p>";

                    $licznik++;
                    //if($licznik==5)
                    //   break;
                }

                echo "</div>";
            } else
            {
                ?>
                <div id="left-col">
                    <ul>
                        <li><a href="Add_Post"><b>Add post</b></a></li>
                        <li><a href="Edit_Post"><b>Edit post</b></a></li>
                        <li><a href="Add_Comment"><b>Add comment</b></a></li>
                        <li><a href="Edit_Comment"><b>Edit comment</b></a></li>
                        <li><a href="Edit_user"><b>Edit user</b></a></li>

                    </ul>
                </div>
                <?php
                echo "<div id ='article'>";

                $polaczenie = "";
                $polaczenie = new CRUD($username, $password);

                $wpisy = $polaczenie->retrieve_wpisy("all");
                $wpisy = array_reverse($wpisy);
                $licznik = 0;
                foreach ($wpisy as &$wpis)
                {
                    $komentarze = $polaczenie->retrieve_komentarze("id_wpis", $wpis['id']);
                    $komentarze = array_reverse($komentarze);
                    $autor = $polaczenie->retrieve_autorzy($wpis['id_autor']);
                    ?>

                    <h1><?php echo $wpis['tytul']; ?> </h1>
                    <div id ="tag">
                        <?php
                        $tagi = $polaczenie->retrieve_wpisy_tagi("id_wpis", $wpis['id']);

                        foreach ($tagi as &$tagi2)
                        {
                            $tag = $polaczenie->retrieve_tagi("id", $tagi2['id_tag']);
                            echo "#" . $tag[0]['tag'];
                        }
                        ?>
                    </div>
                    <div id ="komentarz-autor">
                        Author: <font color ="#a83b23"><?php echo $autor[0]['pseudo']; ?></font>
                    </div>
                    <div id ="komentarz-tresc">
                        <p><?php echo $wpis['tresc']; ?> </p>
                    </div>
                    <div id = "komentarz-naglowek">
                        Comments<br>
                    </div>
                    <?php
                    foreach ($komentarze as &$komentarz)
                    {

                        $autor = $polaczenie->retrieve_autorzy($komentarz['id_autor']);
                        ?>
                        <div id ="komentarz-autor">
                            Author: <font color ="#a83b23"><?php echo $autor[0]['pseudo']; ?></font>
                        </div>
                        <div id ="komentarz-tresc">
                            <p>
                                <?php echo $komentarz['tresc'] ?>
                            </p>
                        </div>

                        <?php
                    }

                    $licznik++;
                    //if($licznik==5)
                    //   break;
                }

                echo "</div>";
            }
            ?>

        </section>

        <footer id="footer">
            Copyrights &copy; 2018 Michal Szpak
        </footer>
        <script src ="StickyBar.js"></script>
    </body>
</html>