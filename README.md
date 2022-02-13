![📝TO_DO_LIST_CRUD📝 (1)](https://user-images.githubusercontent.com/82523427/153744156-242ee223-4c45-4be9-8467-1c0c3aaeace0.png)

 
# To Do List

This project has basic function like adding task list, displaying the task name, a check box to indicate that the task is done, and displays the time when it as created. You can also update the task list created and you can also delete the task once done.

## Creating the Database and Table

Create the `database` and name it `to_do_list`. Create then a table that has name `todos`. You can make use of the following command below. 

~~~sql
CREATE DATABASE to_do_list;
USE to_do_list;

CREATE TABLE todos (
  'id'  INT(11) AUTO_INCREMENT PRIMARY KEY,
  'title' TEXT(30) NOT NULL,
  'date_time' datetime NOT NULL DEFAULT current_timestamp(),
  'checked' tinyint(1) NOT NULL DEFAULT 0

);
~~~

## Creating the Config file 

Following the creation of the table, we must write a PHP script to connect to the MySQL database server. Create a file called `connection.php` and paste the code below into it.
We'll use the PHP `require` function to include this config file on other pages later. In addition we use pdo type of connection

```php
<?php 
$sName = "localhost";
$uName = "root";
$pass = "";
$db_name = "to_do_list";
 
try {
    $conn = new PDO("mysql:host=$sName;dbname=$db_name", 
                    $uName, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
  echo "Connection failed : ". $e->getMessage();
}

```
Note: Before testing this code, replace the credentials with your MySQL server's settings, for example, replace the database name `'to_do_list'` with your own database name, username `'root'` with your own database username, and specify a database password if one exists.

## Creating the Landing Page 

Landing Page shows the index page or the first page of the Web Application. It display the Input text, add button, and different todo-items recorded in the database table.
It also has action icons for each todo-item, which allow you to edit, delete, check and uncheck.

![image](https://user-images.githubusercontent.com/82523427/153747200-f36e35cb-807b-401c-863b-ca3f56f4b900.png)

```php
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
    
</head>
<body>
    <div class="main-section">
       <div class="add-section">
       <h2 class='headertext'>TO DO LIST <img src="img/original.gif" width="30px"></h2>
          <form action="add.php" method="POST" autocomplete="off">
             <?php if(isset($_GET['mess']) && $_GET['mess'] == 'error'){ ?>
                <input type="text" 
                     name="title" 
                     style="border-color: #ff6666"
                     placeholder="This field is required" />
                 <button type="submit">Add</span></button>
             <?php }else{ ?>
        
              <input type="text" 
                     name="title" 
                     placeholder="What needs to be done?" />
              <button type="submit">Add</span></button>
             <?php } ?>
          </form>
       </div>
       <?php 
          $todos = $conn->query("SELECT * FROM todos ORDER BY id DESC");
       ?>
       <div class="show-todo-section">
            <?php if($todos->rowCount() <= 0){ ?>
                <div class="todo-item">
                    <div class="empty">
                        <img src="img/taskade-minimalist-todo-list-1.gif" width="100%" />
                        <img src="img/mR5uHXLuePGT.gif" width="80px">
                    </div>
                </div>
            <?php } ?>

            <?php while($todo = $todos->fetch(PDO::FETCH_ASSOC)) { ?>
                <div class="todo-item">
                    <span id="<?php echo $todo['id']; ?>"
                          class="remove-to-do">x</span>
                    <?php if($todo['checked']){ ?> 
                        <input type="checkbox"
                               class="check-box"
                               data-todo-id ="<?php echo $todo['id']; ?>"
                               checked />
                        <h2 class="checked"><?php echo $todo['title'] ?></h2>
                    <?php }else { ?>
                        <input type="checkbox"
                               data-todo-id ="<?php echo $todo['id']; ?>"
                               class="check-box" />
                        <h2><?php echo $todo['title'] ?></h2>
                    <?php } ?>
                    <br>
                    <small>created: <?php echo $todo['date_time'] ?></small>
                    <a class="btn btn-success btn-sm" href="edit.php?id=<?php echo $todo['id']; ?>" role="button">Edit</a> 
                </div>
            <?php } ?>
       </div>
    </div>
    <script src="js/jquery-3.2.1.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.remove-to-do').click(function(){
                const id = $(this).attr('id');              
                $.post("remove.php", 
                      {
                          id: id
                      },
                      (data)  => {
                         if(data){
                             $(this).parent().hide(600);
                         }
                      }
                );
            });
            $(".check-box").click(function(e){
                const id = $(this).attr('data-todo-id');
                
                $.post('check.php', 
                      {
                          id: id
                      },
                      (data) => {
                          if(data != 'error'){
                              const h2 = $(this).next();
                              if(data === '1'){
                                  h2.removeClass('checked');
                              }else {
                                  h2.addClass('checked');
                              }
                          }
                      }
                );
            });
        });
    </script>
</body>
</html>
```

## Creating Read Page

Read Page is the one that that will retrieve / view the specific entries in our program. The Read page will represent as the face of the whole program. The data retrieved will be from the `todos` table and display it to the to-do-list section. 

```php
<body>
    <div class="main-section">
       <div class="add-section">
       <h2 class='headertext'>TO DO LIST <img src="img/original.gif" width="30px"></h2>
          <form action="add.php" method="POST" autocomplete="off">
             <?php if(isset($_GET['mess']) && $_GET['mess'] == 'error'){ ?>
                <input type="text" 
                     name="title" 
                     style="border-color: #ff6666"
                     placeholder="This field is required" />
                 <button type="submit">Add</span></button>
             <?php }else{ ?>
        
              <input type="text" 
                     name="title" 
                     placeholder="What needs to be done?" />
              <button type="submit">Add</span></button>
             <?php } ?>
          </form>
       </div>
       <?php 
          $todos = $conn->query("SELECT * FROM todos ORDER BY id DESC");
       ?>
       <div class="show-todo-section">
            <?php if($todos->rowCount() <= 0){ ?>
                <div class="todo-item">
                    <div class="empty">
                        <img src="img/taskade-minimalist-todo-list-1.gif" width="100%" />
                        <img src="img/mR5uHXLuePGT.gif" width="80px">
                    </div>
                </div>
            <?php } ?>

            <?php while($todo = $todos->fetch(PDO::FETCH_ASSOC)) { ?>
                <div class="todo-item">
                    <span id="<?php echo $todo['id']; ?>"
                          class="remove-to-do">x</span>
                    <?php if($todo['checked']){ ?> 
                        <input type="checkbox"
                               class="check-box"
                               data-todo-id ="<?php echo $todo['id']; ?>"
                               checked />
                        <h2 class="checked"><?php echo $todo['title'] ?></h2>
                    <?php }else { ?>
                        <input type="checkbox"
                               data-todo-id ="<?php echo $todo['id']; ?>"
                               class="check-box" />
                        <h2><?php echo $todo['title'] ?></h2>
                    <?php } ?>
                    <br>
                    <small>created: <?php echo $todo['date_time'] ?></small>
                    <a class="btn btn-success btn-sm" href="edit.php?id=<?php echo $todo['id']; ?>" role="button">Edit</a> 
                </div>
            <?php } ?>
       </div>
    </div>
```

## Creating the Create Page
In this section we created the `add.php` file of our TO DO LIST application. Once the add button was clicked, it will update the to-do-list section. It will be possible by linking the form to the `add.php` and will run the following code below.
![image](https://user-images.githubusercontent.com/82523427/153747688-7c269353-9a60-4f0c-94cd-805ea53e0963.png) 
![image](https://user-images.githubusercontent.com/82523427/153747728-5bd04339-b679-4cc1-afb8-1fcb3c6ef11b.png)

```php
<?php

if(isset($_POST['title'])){
    require 'connection.php';

    $title = $_POST['title'];

    if(empty($title)){
        header("Location: index.php?mess=error");
    }else {
        $stmt = $conn->prepare("INSERT INTO todos(title) VALUE(?)");
        $res = $stmt->execute([$title]);

        if($res){
            header("Location: index.php?mess=success"); 
        }else {
            header("Location: index.php");
        }
        $conn = null;
        exit();
    }
}else {
    header("Location: index.php?mess=error");
}

```
## Creating the Update Page
We created the edit function by creating the `edit.php`. Once the edit button clicked, you will proceed to a new page or form that has the task you want to edit. 


![image](https://user-images.githubusercontent.com/82523427/153747771-191ed4a5-255e-4ab2-9b21-50901293007d.png)

![image](https://user-images.githubusercontent.com/82523427/153748112-f7d1d237-3031-4cc7-ba0c-3f228e7785e7.png)

![image](https://user-images.githubusercontent.com/82523427/153747860-5340e6d2-e104-4f1e-930d-186b37cf343e.png)


```php
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
```
After editing, click the edit button and it will go to the `code.php` and execute the edit function and update.
![image](https://user-images.githubusercontent.com/82523427/153747886-fd81983f-47df-405b-89b7-8188931edcf7.png)

```php
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

```

## Creating the Delete page
We created the delete function by creating the `remove.php`. Once the x button clicked, it will go to the `remove.php`and it will automatically delete the created list.

```php
<?php

if(isset($_POST['id'])){
    require 'connection.php';

    $id = $_POST['id'];

    if(empty($id)){
       echo 0;
    }else {
        $stmt = $conn->prepare("DELETE FROM todos WHERE id=?");
        $res = $stmt->execute([$id]);

        if($res){
            echo 1;
        }else {
            echo 0;
        }
        $conn = null;
        exit();
    }
}else {
    header("Location: index.php?mess=error");
}
```
## Creating Checking Page
We also added a check function wherein you can click check to cross out the created task. We created the `check.php` file to choose the specific task to be crossed out. The following code below shows the data how to check and uncheck the task created.

```php
<?php

if(isset($_POST['id'])){
    require 'connection.php';

    $id = $_POST['id'];

    if(empty($id)){
       echo 'error';
    }else {
        $todos = $conn->prepare("SELECT id, checked FROM todos WHERE id=?");
        $todos->execute([$id]);

        $todo = $todos->fetch();
        $uId = $todo['id'];
        $checked = $todo['checked'];

        $uChecked = $checked ? 0 : 1;

        $res = $conn->query("UPDATE todos SET checked=$uChecked WHERE id=$uId");

        if($res){
            echo $checked;
        }else {
            echo "error";
        }
        $conn = null;
        exit();
    }
}else {
    header("Location: index.php?mess=error");
}

```


