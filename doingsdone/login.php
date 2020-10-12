<?php
session_start();
require_once('connection.php');
require_once('db.php');
require_once('helpers.php');
$errors=array();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_data=$_POST;
    $errors=logintry($con,$user_data);
    
}
if ($con == false) {
    print("Ошибка подключения: " . mysqli_connect_error());
}
else{
    $page_content = include_template('login-form.php',['title'=>'Авторизация','errors'=>$errors]);
    print($page_content);
}
