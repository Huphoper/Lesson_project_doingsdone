<?php
require('connection.php');
require('db.php');
require('helpers.php');
$project = htmlspecialchars($_GET['project']);
//require('templates/form-task.php');
if ($con == false) {
    print("Ошибка подключения: " . mysqli_connect_error());
}
else {
    $page_content = include_template('form-task.php',['con'=>$con,'userid'=>$userid,'project'=>$project] );
// окончательный HTML код
    $layout_content = include_template('layout.php',['title'=>'Добавить задачу','content'=> $page_content,'con'=>$con,'userid'=>$userid]);

    print($layout_content);
}
