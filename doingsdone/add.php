<?php
session_start();
if (isset($_SESSION['usid'])) {
$userid = $_SESSION['usid'];
require_once('connection.php');
require_once('db.php');
require_once('helpers.php');

$errors=array();
$project=null;
$projects=createprojectlist($con,$userid);
if(isset($_GET['project'])){
    $project = htmlspecialchars($_GET['project']);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_task=$_POST;
    $file=$_FILES;


    $errors=task_validate($full_task,$file);

    if(count($errors)){

    }
    else{
        addtask($con,$full_task,$userid,$file);
    }
}

if ($con == false) {
    print("Ошибка подключения: " . mysqli_connect_error());
}
else {
    $page_content = include_template('form-task.php',[
        'con'=>$con,'userid'=>$userid,'errors'=>$errors,'project'=>$project,'projects'=>$projects] );
// окончательный HTML код
    $layout_content = include_template('layout.php',[
        'title'=>'Добавить задачу','content'=> $page_content,'con'=>$con,'userid'=>$userid,'project'=>$project,'projects'=>$projects]);

    print($layout_content);
}
}
else{
    require_once('guest.php');
}

