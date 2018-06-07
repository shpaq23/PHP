<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InicjalizacjaBazy
 *
 * @author shpaq
 */
class InicjalizacjaBazy
{

    var $polaczenie;
    var $sql;

    public function InicjalizacjaBazy()
    {
        $this->polaczenie = new PDO('mysql: host=localhost;', 'root');

        $this->sql = "CREATE USER IF NOT EXISTS 'anonimus' @'localhost' IDENTIFIED BY 'anonim123'";
        $this->polaczenie->query($this->sql);


        $this->sql = "GRANT SELECT ON studenci.wpisy TO 'anonimus' @'localhost'";
        $this->polaczenie->query($this->sql);





        ////////OPCJONALNIE DROPUJE NAJPIERW TABLE///////

        $this->sql = 'DROP DATABASE studenci';
        $this->polaczenie->query($this->sql);
        /////////////////
        #NAWIAZANIE POLACZENI I TWORZENIE BAAZY DANYCH

        $database = "CREATE DATABASE IF NOT EXISTS studenci";

        $this->polaczenie->query($database);

        #NAWIAZANIE POLACZENIA Z UTWORZONA BAZA DANYCH
        try
        {

            $this->sql = 'USE studenci';
            $this->polaczenie->query($this->sql);

            $this->sql = 'CREATE TABLE IF NOT EXISTS tagi(
				id INT PRIMARY KEY AUTO_INCREMENT,
				tag VARCHAR(10),
                                UNIQUE(tag)
				);';
            $this->polaczenie->query($this->sql);

            $this->sql = 'CREATE TABLE IF NOT EXISTS autorzy(
				id INT PRIMARY KEY AUTO_INCREMENT,
				imie VARCHAR(20),
				pseudo VARCHAR(20),
				mail VARCHAR(30)
				);';
            $this->polaczenie->query($this->sql);

            $this->sql = 'CREATE TABLE IF NOT EXISTS wpisy(
				id INT PRIMARY KEY AUTO_INCREMENT,
				id_autor INT,
				tytul VARCHAR(100),
				tresc TEXT,
				FOREIGN KEY(id_autor) REFERENCES autorzy(id) ON DELETE CASCADE ON UPDATE CASCADE
				);';
            $this->polaczenie->query($this->sql);

            $this->sql = 'CREATE TABLE IF NOT EXISTS wpisy_tagi(
				id_wpis INT,
				id_tag INT,
				FOREIGN KEY(id_wpis) REFERENCES wpisy(id) ON DELETE CASCADE ON UPDATE CASCADE,
				FOREIGN KEY(id_tag) REFERENCES tagi(id) ON DELETE CASCADE ON UPDATE CASCADE,
				PRIMARY KEY (id_wpis, id_tag)
				);';
            $this->polaczenie->query($this->sql);

            $this->sql = 'CREATE TABLE IF NOT EXISTS komentarze(
				id INT AUTO_INCREMENT PRIMARY KEY,
				tresc VARCHAR(250),
				id_wpis INT,
				id_autor INT,
				FOREIGN KEY (id_wpis) REFERENCES wpisy(id) ON DELETE CASCADE ON UPDATE CASCADE,
				FOREIGN KEY (id_autor) REFERENCES autorzy(id) ON DELETE CASCADE ON UPDATE CASCADE
				);';
            $this->polaczenie->query($this->sql);

            /////////////// TWORZENIE REKORDOW ////////////
            $this->sql = "CREATE USER IF NOT EXISTS 'shpaq23@gmail.com' @'localhost' IDENTIFIED BY '12345'";
            $this->polaczenie->query($this->sql);
            $this->sql = "GRANT SELECT, UPDATE, INSERT, DELETE ON studenci.* TO 'shpaq23@gmail.com' @'localhost'";
            $this->polaczenie->query($this->sql);

            $this->sql = "CREATE USER IF NOT EXISTS 'odzikik@gmail.com' @'localhost' IDENTIFIED BY '12345'";
            $this->polaczenie->query($this->sql);
            $this->sql = "GRANT SELECT, UPDATE, INSERT, DELETE ON studenci.* TO 'odzikik@gmail.com' @'localhost'";
            $this->polaczenie->query($this->sql);

            $this->sql = "CREATE USER IF NOT EXISTS 'przemook@gmail.com' @'localhost' IDENTIFIED BY '12345'";
            $this->polaczenie->query($this->sql);
            $this->sql = "GRANT SELECT, UPDATE, INSERT, DELETE ON studenci.* TO 'przemook@gmail.com' @'localhost'";
            $this->polaczenie->query($this->sql);

            
            
            $this->sql = "INSERT INTO
            autorzy(imie, pseudo, mail)
            VALUES ('Michal', 'Shpaq', 'shpaq23@gmail.com');
            
            INSERT INTO
            autorzy(imie, pseudo, mail)
            VALUES ('Piotr', 'Odziooik', 'odzikik@gmail.com');
            
            INSERT INTO
            autorzy(imie, pseudo, mail)
            VALUES ('Przemek', 'Przemo23', 'przemook@gmail.com');
            
            
            
            INSERT INTO tagi (tag) VALUES
                    ('wiosna'),('lato'),('jesien'),('fit'),('gym'),('boy'),('cat');
            
            INSERT INTO
            wpisy(id_autor, tytul, tresc)
            VALUES ('1','Lorem 1','Lorem ipsum dolor sit amet turpis rutrum pede eget dolor quam, ultrices eget, accumsan quam, lobortis cursus non, lacus. Curabitur ut nunc tempus et, elementum diam tempor magna sapien, tempus nulla. Maecenas ac magna neque, vitae ornare non, ipsum. Fusce venenatis placerat, egestas ac, felis. Maecenas semper turpis rutrum id, elementum eleifend, metus in lorem pretium wisi. Integer mi quis justo. Donec commodo, tincidunt fermentum. Aliquam tempor magna. Curabitur egestas. Mauris vitae ante. Vestibulum enim. Etiam congue sodales nibh rutrum pede porta elementum. Morbi cursus dui vitae massa. Donec euismod orci luctus sagittis. Aliquam vel nulla. Proin urna. Aliquam tempus erat volutpat. Maecenas diam ut ligula. Pellentesque aliquam id, wisi. Sed molestie, lectus nec nunc justo imperdiet in, elementum vel, purus. Aenean feugiat tempus. Quisque cursus, lacus vehicula viverra. Ut eget tempus leo semper lobortis. In hac habitasse platea dictumst. Duis non felis. Etiam vel quam eros quis augue. Suspendisse a nisl. Ut pretium. Vestibulum laoreet venenatis risus. Nunc velit non nonummy rutrum. Donec enim vel risus. Donec gravida varius felis sagittis porttitor. Aenean gravida massa metus et posuere urna.');
            
            INSERT INTO
            wpisy(id_autor, tytul, tresc)
            VALUES ('2','Lorem 2','Lorem ipsum dolor sit amet turpis rutrum pede eget dolor quam, ultrices eget, accumsan quam, lobortis cursus non, lacus. Curabitur ut nunc tempus et, elementum diam tempor magna sapien, tempus nulla. Maecenas ac magna neque, vitae ornare non, ipsum. Fusce venenatis placerat, egestas ac, felis. Maecenas semper turpis rutrum id, elementum eleifend, metus in lorem pretium wisi. Integer mi quis justo. Donec commodo, tincidunt fermentum. Aliquam tempor magna. Curabitur egestas. Mauris vitae ante. Vestibulum enim. Etiam congue sodales nibh rutrum pede porta elementum. Morbi cursus dui vitae massa. Donec euismod orci luctus sagittis. Aliquam vel nulla. Proin urna. Aliquam tempus erat volutpat. Maecenas diam ut ligula. Pellentesque aliquam id, wisi. Sed molestie, lectus nec nunc justo imperdiet in, elementum vel, purus. Aenean feugiat tempus. Quisque cursus, lacus vehicula viverra. Ut eget tempus leo semper lobortis. In hac habitasse platea dictumst. Duis non felis. Etiam vel quam eros quis augue. Suspendisse a nisl. Ut pretium. Vestibulum laoreet venenatis risus. Nunc velit non nonummy rutrum. Donec enim vel risus. Donec gravida varius felis sagittis porttitor. Aenean gravida massa metus et posuere urna.');
            
            INSERT INTO
            wpisy(id_autor, tytul, tresc)
            VALUES ('1','Lorem 3','333Lorem ipsum dolor sit amet turpis rutrum pede eget dolor quam, ultrices eget, accumsan quam, lobortis cursus non, lacus. Curabitur ut nunc tempus et, elementum diam tempor magna sapien, tempus nulla. Maecenas ac magna neque, vitae ornare non, ipsum. Fusce venenatis placerat, egestas ac, felis. Maecenas semper turpis rutrum id, elementum eleifend, metus in lorem pretium wisi. Integer mi quis justo. Donec commodo, tincidunt fermentum. Aliquam tempor magna. Curabitur egestas. Mauris vitae ante. Vestibulum enim. Etiam congue sodales nibh rutrum pede porta elementum. Morbi cursus dui vitae massa. Donec euismod orci luctus sagittis. Aliquam vel nulla. Proin urna. Aliquam tempus erat volutpat. Maecenas diam ut ligula. Pellentesque aliquam id, wisi. Sed molestie, lectus nec nunc justo imperdiet in, elementum vel, purus. Aenean feugiat tempus. Quisque cursus, lacus vehicula viverra. Ut eget tempus leo semper lobortis. In hac habitasse platea dictumst. Duis non felis. Etiam vel quam eros quis augue. Suspendisse a nisl. Ut pretium. Vestibulum laoreet venenatis risus. Nunc velit non nonummy rutrum. Donec enim vel risus. Donec gravida varius felis sagittis porttitor. Aenean gravida massa metus et posuere urna.');
            
            INSERT INTO
            wpisy(id_autor, tytul, tresc)
            VALUES ('2','Lorem 4','Lorem ipsum dolor sit amet turpis rutrum pede eget dolor quam, ultrices eget, accumsan quam, lobortis cursus non, lacus. Curabitur ut nunc tempus et, elementum diam tempor magna sapien, tempus nulla. Maecenas ac magna neque, vitae ornare non, ipsum. Fusce venenatis placerat, egestas ac, felis. Maecenas semper turpis rutrum id, elementum eleifend, metus in lorem pretium wisi. Integer mi quis justo. Donec commodo, tincidunt fermentum. Aliquam tempor magna. Curabitur egestas. Mauris vitae ante. Vestibulum enim. Etiam congue sodales nibh rutrum pede porta elementum. Morbi cursus dui vitae massa. Donec euismod orci luctus sagittis. Aliquam vel nulla. Proin urna. Aliquam tempus erat volutpat. Maecenas diam ut ligula. Pellentesque aliquam id, wisi. Sed molestie, lectus nec nunc justo imperdiet in, elementum vel, purus. Aenean feugiat tempus. Quisque cursus, lacus vehicula viverra. Ut eget tempus leo semper lobortis. In hac habitasse platea dictumst. Duis non felis. Etiam vel quam eros quis augue. Suspendisse a nisl. Ut pretium. Vestibulum laoreet venenatis risus. Nunc velit non nonummy rutrum. Donec enim vel risus. Donec gravida varius felis sagittis porttitor. Aenean gravida massa metus et posuere urna.');
            
            INSERT INTO
            wpisy(id_autor, tytul, tresc)
            VALUES ('3','Lorem 5','Lorem ipsum dolor sit amet turpis rutrum pede eget dolor quam, ultrices eget, accumsan quam, lobortis cursus non, lacus. Curabitur ut nunc tempus et, elementum diam tempor magna sapien, tempus nulla. Maecenas ac magna neque, vitae ornare non, ipsum. Fusce venenatis placerat, egestas ac, felis. Maecenas semper turpis rutrum id, elementum eleifend, metus in lorem pretium wisi. Integer mi quis justo. Donec commodo, tincidunt fermentum. Aliquam tempor magna. Curabitur egestas. Mauris vitae ante. Vestibulum enim. Etiam congue sodales nibh rutrum pede porta elementum. Morbi cursus dui vitae massa. Donec euismod orci luctus sagittis. Aliquam vel nulla. Proin urna. Aliquam tempus erat volutpat. Maecenas diam ut ligula. Pellentesque aliquam id, wisi. Sed molestie, lectus nec nunc justo imperdiet in, elementum vel, purus. Aenean feugiat tempus. Quisque cursus, lacus vehicula viverra. Ut eget tempus leo semper lobortis. In hac habitasse platea dictumst. Duis non felis. Etiam vel quam eros quis augue. Suspendisse a nisl. Ut pretium. Vestibulum laoreet venenatis risus. Nunc velit non nonummy rutrum. Donec enim vel risus. Donec gravida varius felis sagittis porttitor. Aenean gravida massa metus et posuere urna.');
            
            
            INSERT INTO wpisy_tagi (id_wpis, id_tag) VALUES
                    ('1', '1'),('1', '2'),('1', '3'),('2', '2'),('3', '1'),
                    ('2', '1'),('2', '3'),('3', '3'),('5', '2'),('4', '4');
                    
            INSERT INTO komentarze (tresc, id_wpis, id_autor) VALUES
                    ('KOM1 nean feugiat tempus. Quisque cursus, lacus vehicula viverra. Ut eget tempus leo semper lobortis. In hac habitasse platea dictumst. Duis non felis. Etiam vel quam eros quis augue. Suspendisse a nisl. Ut pretium. Vestibulum laoreet venenatis risus. Nunc velit non nonummy rutrum.', '1', '2'),
                    ('KOM2 nean feugiat tempus. Quisque cursus, lacus vehicula viverra. Ut eget tempus leo semper lobortis. In hac habitasse platea dictumst. Duis non felis. Etiam vel quam eros quis augue. Suspendisse a nisl. Ut pretium. Vestibulum laoreet venenatis risus. Nunc velit non nonummy rutrum.', '1', '3'),
                    ('KOM3 nean feugiat tempus. Quisque cursus, lacus vehicula viverra. Ut eget tempus leo semper lobortis. In hac habitasse platea dictumst. Duis non felis. Etiam vel quam eros quis augue. Suspendisse a nisl. Ut pretium. Vestibulum laoreet venenatis risus. Nunc velit non nonummy rutrum.', '2', '1'),
                    ('KOM4 nean feugiat tempus. Quisque cursus, lacus vehicula viverra. Ut eget tempus leo semper lobortis. In hac habitasse platea dictumst. Duis non felis. Etiam vel quam eros quis augue. Suspendisse a nisl. Ut pretium. Vestibulum laoreet venenatis risus. Nunc velit non nonummy rutrum.', '2', '3'),
                    ('KOM5 nean feugiat tempus. Quisque cursus, lacus vehicula viverra. Ut eget tempus leo semper lobortis. In hac habitasse platea dictumst. Duis non felis. Etiam vel quam eros quis augue. Suspendisse a nisl. Ut pretium. Vestibulum laoreet venenatis risus. Nunc velit non nonummy rutrum.', '3', '1'),
                    ('KOM6 nean feugiat tempus. Quisque cursus, lacus vehicula viverra. Ut eget tempus leo semper lobortis. In hac habitasse platea dictumst. Duis non felis. Etiam vel quam eros quis augue. Suspendisse a nisl. Ut pretium. Vestibulum laoreet venenatis risus. Nunc velit non nonummy rutrum.', '3', '2'),
                    ('KOM7 nean feugiat tempus. Quisque cursus, lacus vehicula viverra. Ut eget tempus leo semper lobortis. In hac habitasse platea dictumst. Duis non felis. Etiam vel quam eros quis augue. Suspendisse a nisl. Ut pretium. Vestibulum laoreet venenatis risus. Nunc velit non nonummy rutrum.', '4', '1'),
                    ('KOM8 nean feugiat tempus. Quisque cursus, lacus vehicula viverra. Ut eget tempus leo semper lobortis. In hac habitasse platea dictumst. Duis non felis. Etiam vel quam eros quis augue. Suspendisse a nisl. Ut pretium. Vestibulum laoreet venenatis risus. Nunc velit non nonummy rutrum.', '4', '2'),
                    ('KOM9 nean feugiat tempus. Quisque cursus, lacus vehicula viverra. Ut eget tempus leo semper lobortis. In hac habitasse platea dictumst. Duis non felis. Etiam vel quam eros quis augue. Suspendisse a nisl. Ut pretium. Vestibulum laoreet venenatis risus. Nunc velit non nonummy rutrum.', '5', '3'),
                    ('KOM10 nean feugiat tempus. Quisque cursus, lacus vehicula viverra. Ut eget tempus leo semper lobortis. In hac habitasse platea dictumst. Duis non felis. Etiam vel quam eros quis augue. Suspendisse a nisl. Ut pretium. Vestibulum laoreet venenatis risus. Nunc velit non nonummy rutrum.', '5', '1');


            
            
            ";
            //echo $imie. $pseudo. $mail;

            $this->polaczenie->query($this->sql);

            //////////LOGOWANIE NA ANONIMA

            unset($this->polaczenie);
            $this->sql = null;

            return true;
        } catch (PDOException $er)
        {
            echo "zle" . $er;
            return false;
        }
    }

    function test()
    {

        $zapytanie = '1';
        $this->sql = "SELECT * FROM wpisy
                    WHERE id = 1";

        $row = $this->polaczenie->query($this->sql)->fetchAll();
        return $row;
    }

}
