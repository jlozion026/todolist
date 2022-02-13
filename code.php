<?php

session_start();

require 'connection.php';




if(isset($_POST['update-btn']))

{

    $id = $_POST['id'];

    $title = $_POST['title'];



    try {



        $query = "UPDATE todos SET title=:title WHERE id=:id";

        $statement = $conn->prepare($query);

        $data = [

            ':title' => $title,

            ':id' => $id

        ];

        $query_excute = $statement ->execute($data);



        if($query_execute)

        {

            $_SESSION['message'] = "Updated Succesfully";

            header('Location: index.php');

            exit(0);

        }

        else

        {

            $_SESSION['message'] = "Not Updated";

            header('Location: index.php');

            exit(0);

        }




    } catch (PDOException $e) {

        echo $e->getMessage();

    }

}



?>