![📝TO_DO_LIST_CRUD📝](https://user-images.githubusercontent.com/82523427/153743634-469c1d7f-e9e2-4028-bb01-4da0ff963dc4.png)
 
# To Do List

This project has basic function like adding task list. Displaying the task name, when it was created and a check box to indicate that the task is done. You can also update the task list created and you can also delte the task once done.



## Creating the Database and Table

Create the `database` and name it anything you want, but for this excersice we use `to_do_list`. Create then a table that has name `todos` and inside the parenthesis, make sure to use the following command below.

~~~sql
CREATE DATABASE to_do_list;
USE to_do_list;

CREATE TABLE todos (
  id  INT(11) AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(30) NOT NULL,
  email VARCHAR(30) NOT NULL
);
~~~
