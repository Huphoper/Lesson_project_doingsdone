<?php
// показывать или нет выполненные задачи
require_once('connection.php');
require_once('helpers.php');
require_once('db.php');


$project = htmlspecialchars($_GET['project']);
$show_completed = htmlspecialchars($_GET['show_completed']);

if($show_completed==null){
    $show_complete_tasks = 0;
}
else{
    $show_complete_tasks =$show_completed;
}
if ($con == false) {
    print("Ошибка подключения: " . mysqli_connect_error());
}
else {

    $page_content = include_template('main.php',['con'=>$con,'show_complete_tasks'=>$show_complete_tasks,'userid'=>$userid,'project'=>$project] );
// окончательный HTML код
    $layout_content = include_template('layout.php',['title'=>'Дела в порядке','content'=> $page_content,'con'=>$con,'userid'=>$userid,'project'=>$project]);

    print($layout_content);
}


