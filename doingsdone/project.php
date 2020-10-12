<?php
session_start();
if (isset($_SESSION['usid'])) {
$userid = $_SESSION['usid'];
require_once('connection.php');
require_once('db.php');
require_once('helpers.php');
$errors=array();
$projects=createprojectlist($con,$userid);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $taskname=$_POST;
    $errors=project_validate($taskname);
    if(count($errors)){

    }
    else{
        $errors=addproject($con,$taskname,$userid);
    }
}

if ($con == false) {
    print("Ошибка подключения: " . mysqli_connect_error());
}
else {
    $page_content = include_template('form-project.php',[
        'con'=>$con,'userid'=>$userid,'errors'=>$errors,'projects'=>$projects] );
// окончательный HTML код
    $layout_content = include_template('layout.php',[
        'title'=>'Добавить задачу','content'=>$page_content,'con'=>$con,'userid'=>$userid,'project'=>$project,'projects'=>$projects]);

    print($layout_content);
}

}
else{
    require_once('guest.php');
}