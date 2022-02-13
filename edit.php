<?php

        require 'connection.php';

    ?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>To-Do List</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="style.css">

    <title>Edit & Update</title>

</head>

<body>

    <div class="main-section">

       <div class="add-section">
       <h2 class='headertext'>UPDATE YOUR TO DO LIST <img src="img/original.gif" width="30px"></h2>

          <?php

         if(isset($_GET['id'])){

            $id= $_GET['id'];



            $query = "SELECT * FROM todos WHERE id=:id";

            $statement =$conn->prepare($query);

            $data = [':id' => $id];

            $statement->execute($data);

            $result=$statement->fetch(PDO::FETCH_OBJ);

          }

          ?>    

          <form action="code.php" method="POST" autocomplete="off">

          <input type="hidden" name="id" value="<?=$result->id?>"/>

          <input type="text" name="title" value="<?=$result->title;?>"/>

          <button type="submit" name="update-btn">EDIT</span></button>

          </form>

       </div>



</body>

</html>