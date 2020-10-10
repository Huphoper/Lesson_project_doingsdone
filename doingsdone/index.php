<?php
// показывать или нет выполненные задачи
if (/*isset($_GET['registered'])*/1==1) {
require_once('connection.php');
require_once('helpers.php');
require_once('db.php');
$project=null;
$show_completed=null;
$task_search=null;
if(isset($_GET['project'])){
   $project = htmlspecialchars($_GET['project']);
}
if(isset($_GET['show_completed'])){
    $show_completed = htmlspecialchars($_GET['show_completed']);
}
if(isset($_GET['task_search'])){
    $task_search = htmlspecialchars($_GET['task_search']);
}
if($show_completed==null){
    $show_complete_tasks = 0;
}
else{
    $show_complete_tasks =$show_completed;
}
$projects=createprojectlist($con,$userid);
$tasks=createtasklist($con,$userid,$project,$task_search);
if ($con == false) {
    print("Ошибка подключения: " . mysqli_connect_error());
}
else {

    $page_content = include_template('main.php',[
        'con'=>$con,'show_complete_tasks'=>$show_complete_tasks,'userid'=>$userid,'project'=>$project,'projects'=>$projects,'tasks'=>$tasks] );
// окончательный HTML код
    $layout_content = include_template('layout.php',[
        'title'=>'Дела в порядке','content'=> $page_content,'con'=>$con,'userid'=>$userid,'project'=>$project,'projects'=>$projects]);

    print($layout_content);
}
}
else{
    require_once('registration.php');
}

