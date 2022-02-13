![📝TO_DO_LIST_CRUD📝](https://user-images.githubusercontent.com/82523427/153743634-469c1d7f-e9e2-4028-bb01-4da0ff963dc4.png)
 
# To Do List

This project has basic function like adding task list. Displaying the task name, when it was created and a check box to indicate that the task is done. You can also update the task list created and you can also delte the task once done.



## Creating the Database and Table

Create the `database` and name it `to_do_list`. Create then a table that has name `todos` and inside the parenthesis, make sure to use the following command below. 

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
  $conn = new PDO("mysql:host=$sName;dbname=$db_name", $uName, $pass);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 }catch(PDOException $e){
  echo "Connection failed : ". $e->getMessage();
 }

```
