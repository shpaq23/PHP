<?php

class CRUD
{

    var $polaczenie;
    var $sql;

    function CRUD($username, $password)
    {
        if ($password == "")
        {
            $this->polaczenie = new PDO('mysql: host=localhost;', $username);
        } else
        {
            $this->polaczenie = new PDO('mysql: host=localhost;', $username, $password);
        }

        $this->sql = 'USE studenci';
        $this->polaczenie->query($this->sql);
    }

    ///tworzenie uzytkownikow

    function create_user($username, $password)
    {
        // echo $username;
        // echo $password;
        // echo "CREATE USER '" . $username . "' @'localhost' IDENTIFIED BY '" . $password . "'";

        $this->sql = "CREATE USER '" . $username . "' @'localhost' IDENTIFIED BY '" . $password . "'";
        $wynik = $this->polaczenie->query($this->sql);
        if (!$wynik)
            return false;
        $this->sql = "GRANT SELECT, UPDATE, INSERT, DELETE ON studenci.* TO '" . $username . "' @'localhost'";
        $wynik = $this->polaczenie->query($this->sql);

        return true;
    }

    function rename_user_from_root($oldusername, $username, $password = "")
    {
        $a = new CRUD("root", "");

        if ($a->rename_user($oldusername, $username, $password))
            return true;
        else
            return false;
    }

    function delete_user_from_root($username)
    {
        $a = new CRUD("root", "");
        if ($a->delete_user($username))
            return true;
        else
            return false;
    }

    function delete_user($username)
    {

        $this->sql = "DROP USER '" . $username . "'@'localhost'";
        $wynik = $this->polaczenie->query($this->sql);
        if (!$wynik)
            return false;
        return true;
    }

    function rename_user($oldusername, $username, $password = "")
    {
        

        if ($password != "")
        {
            $this->sql = "RENAME USER '" . $oldusername . "'@'localhost' TO '" . $username . "' @'localhost'";
            $wynik = $this->polaczenie->query($this->sql);
            $this->sql = "SET PASSWORD FOR '" . $username . "'@'localhost' = PASSWORD('" . $password . "')";
          //  echo $this->sql;
            $wynik = $this->polaczenie->query($this->sql);
            if (!$wynik)
                return false;
        }
        else
        {
            $this->sql = "RENAME USER '" . $oldusername . "'@'localhost' TO '" . $username . "' @'localhost'";
            $wynik = $this->polaczenie->query($this->sql);
            echo $this->sql;
            if (!$wynik)
                return false;
        }
        return true;
    }

////TWORZENIE
    function create_autor($imie, $pseudo, $mail)
    {
        $this->sql = "INSERT INTO
            autorzy(imie, pseudo, mail)
            VALUES ('$imie', '$pseudo', '$mail');";
        //echo $imie. $pseudo. $mail;
        $this->polaczenie->query($this->sql);
    }

    function create_wpisy($id_autor, $tytul, $tresc)
    {
        $this->sql = "INSERT INTO
            wpisy(id_autor, tytul, tresc)
            VALUES ('$id_autor','$tytul','$tresc');";
        //echo $imie. $pseudo. $mail;
        $this->polaczenie->query($this->sql);
    }

    function create_komentarze($tresc, $id_wpis, $id_autor)
    {
        $this->sql = "INSERT INTO komentarze (tresc, id_wpis, id_autor) VALUES
                    ('$tresc', '$id_wpis', '$id_autor');";
        $this->polaczenie->query($this->sql);
    }

    function create_wpisy_tagi($id_wpis, $id_tag)
    {
        $this->sql = "INSERT INTO wpisy_tagi (id_wpis, id_tag) VALUES
                    ('$id_wpis', '$id_tag');";
        $this->polaczenie->query($this->sql);
    }

    function create_tagi($tag)
    {
        $this->sql = "INSERT INTO tagi (tag) VALUES
                    ('$tag');";
        $this->polaczenie->query($this->sql);
    }

///AKTUALIZOWANIE
    function update_autorzy($id, $imie, $pseudo, $mail)
    {
        $this->sql = "UPDATE autorzy
                    SET imie = '$imie', pseudo = '$pseudo', mail = '$mail'
                    WHERE id = '$id';";
        $this->polaczenie->query($this->sql);
    }

    function update_wpisy($id, $tytul, $tresc)
    {
        $this->sql = "UPDATE wpisy
                    SET tytul = '$tytul', tresc = '$tresc'
                    WHERE id = '$id';";
        $this->polaczenie->query($this->sql);
    }

    function update_komentarze($id, $tresc)
    {
        $this->sql = "UPDATE komentarze
                      SET tresc = '$tresc'
                      WHERE id = '$id';";
        $this->polaczenie->query($this->sql);
    }

    function update_wpisy_tagi($id_wpis, $id_tag)
    {
        $this->sql = "UPDATE wpisy_tagi
                    SET id_tag = '$id_tag'
                    WHERE id_wpis = '$id_wpis';";
        $this->polaczenie->query($this->sql);
    }

    function update_tagi($id, $tag)
    {
        $this->sql = "UPDATE tagi
                    SET tag = '$tag'
                    WHERE id = '$id';";
        $this->polaczenie->query($this->sql);
    }

//USUWANIE
    function delete_autorzy($id)
    {
        $this->sql = "DELETE FROM autorzy
                      WHERE id = '$id';";
        $this->zapytanie = $this->polaczenie->query($this->sql);
    }

    function delete_wpisy($id)
    {
        $this->sql = "DELETE FROM wpisy
                      WHERE id = '$id';";
        $this->polaczenie->query($this->sql);
    }

    function delete_komentarez($id)
    {
        $this->sql = "DELETE FROM komentarze
                      WHERE id = '$id';";
        $this->polaczenie->query($this->sql);
    }

    function delete_wpisy_tagi($id)
    {
        $this->sql = "DELETE FROM wpisy_tagi
                      WHERE id_wpis = '$id';";
        $this->polaczenie->query($this->sql);
    }

    function delete_tagi($id)
    {
        $this->sql = "DELETE FROM tagi
                      WHERE id = '$id'
                      OR tag = '$id';";
        $this->polaczenie->query($this->sql);
    }

////SELEKTY

    function retrieve_autorzy($zapytanie)
    {

        $this->sql = "SELECT * FROM autorzy
                    WHERE id = '$zapytanie'
                    OR imie = '$zapytanie'
                    OR pseudo = '$zapytanie'
                    OR mail = '$zapytanie';";
        $row = $this->polaczenie->query($this->sql)->fetchAll();

        return $row;
    }

    function retrieve_wpisy($rodzaj, $zapytanie = "")
    {
        switch ($rodzaj)
        {
            case "id":
                $this->sql = "SELECT * FROM wpisy
                           WHERE id = '$zapytanie';";
                break;
            case "id_autor":
                $this->sql = "SELECT * FROM wpisy
                          WHERE id_autor = '$zapytanie';";
                break;
            case "tytul":
                $this->sql = "SELECT * FROM wpisy
                          WHERE tytul = '$zapytanie';";
            case "all":
                $this->sql = "SELECT * FROM wpisy;";
                break;
        }
        $row = $this->polaczenie->query($this->sql)->fetchAll();
        return $row;
    }

    function retrieve_komentarze($rodzaj, $zapytanie, $zapytanie2 = "")
    {
        switch ($rodzaj)
        {
            case "id":
                $this->sql = "SELECT * FROM komentarze
                    WHERE id = '$zapytanie';";
                break;
            case "id_wpis":
                $this->sql = "SELECT * FROM komentarze
                    WHERE id_wpis = '$zapytanie';";
                break;
            case "id_autor":
                $this->sql = "SELECT * FROM komentarze
                    WHERE id_autor = '$zapytanie';";
                break;
            case "id_autor_wpis":
                $this->sql = "SELECT * FROM komentarze
                    WHERE id_autor = '$zapytanie'  
                    AND id_wpis = '$zapytanie2';";
                break;
        }
        $row = $this->polaczenie->query($this->sql)->fetchAll();
        return $row;
    }

    function retrieve_wpisy_tagi($rodzaj, $zapytanie)
    {
        switch ($rodzaj)
        {
            case "id_wpis":
                $this->sql = "SELECT * FROM wpisy_tagi
                            WHERE id_wpis = '$zapytanie';";
                break;
            case "id_tag":
                $this->sql = "SELECT * FROM wpisy_tagi
                             WHERE id_tag = '$zapytanie';";
                break;
        }
        $row = $this->polaczenie->query($this->sql)->fetchAll();
        return $row;
    }

    function retrieve_tagi($rodzaj, $zapytanie)
    {
        switch ($rodzaj)
        {
            case "id":
                $this->sql = "SELECT * FROM tagi
                            WHERE id = '$zapytanie';";
                break;
            case "tag":
                $this->sql = "SELECT * FROM tagi
                             WHERE tag = '$zapytanie';";
                break;
        }
        $row = $this->polaczenie->query($this->sql)->fetchAll();
        return $row;
    }

    function przerwij_polaczenie()
    {

        unset($this->polaczenie);
    }

}
?>



