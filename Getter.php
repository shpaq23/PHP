    <?php

    require_once 'CRUD.php';
    $polaczenie = new CRUD("root", "");

    if ($_GET['tryb'] == 'post')
    {

        $id_post = $_GET['id'];
        $title = "";
        $content = "";
        $tags = "";

        $wpis = $polaczenie->retrieve_wpisy("id", $id_post);
        $title = $wpis[0]['tytul'];
        $content = $wpis[0]['tresc'];
        $wpisy_tagi = $polaczenie->retrieve_wpisy_tagi("id_wpis", $wpis[0]['id']);

        foreach ($wpisy_tagi as &$tagi)
        {
            $tag = $polaczenie->retrieve_tagi("id", $tagi['id_tag']);

            $tags = $tags . "#" . $tag[0]['tag'];
        }


        $myObj = new \stdClass();
        $myObj->title = $title;
        $myObj->content = $content;
        $myObj->tags = $tags;
        $polaczenie->przerwij_polaczenie();



        echo json_encode($myObj);
    }
    if ($_GET['tryb'] == 'kom_id')
    {
        $id_post = $_GET['id_post'];
        $id_autor = $_GET['id_autor'];
        $wpis = $polaczenie->retrieve_wpisy("id", $id_post);


        $komentarze = $polaczenie->retrieve_komentarze("id_autor_wpis", $id_autor, $id_post);
        $tresc = $komentarze[0]['tresc'];

        $kom_id = [];
        $a = 0;
        foreach ($komentarze as &$komentarz)
        {
            $kom_id[$a] = $komentarz['id'];
            //  echo $kom_id[$a];
            $a = $a + 1;
        }

        $myObj = new \stdClass();
        $myObj->kom_id = $kom_id;
        $myObj->tresc = $tresc;
        $polaczenie->przerwij_polaczenie();

        //echo $komentarze[0]['tresc'];
        //  echo $komentarze[1]['tresc'];
        // echo $komentarze[2]['tresc'];
        echo json_encode($myObj);
    }
    if ($_GET['tryb'] == 'tresc')
    {
        $id_kom = $_GET['id_kom'];
        $tresc = $polaczenie->retrieve_komentarze("id", $id_kom);
        $tresc = $tresc[0]['tresc'];
        
        $myObj = new \stdClass();
        $myObj->tresc = $tresc;
        $polaczenie->przerwij_polaczenie();

        echo json_encode($myObj);
        
    }
    ?>