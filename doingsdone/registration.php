<?php
require_once('connection.php');
require_once('db.php');
require_once('helpers.php');
$errors=array();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reg_date=$_POST;
    $errors=login_validate($con,$reg_date);
    if(count($errors)){

    }
    else{
        add_user($con,$reg_date);
    }
}
if ($con == false) {
    print("Ошибка подключения: " . mysqli_connect_error());
}
else{
    $page_content = include_template('register.php',['errors'=>$errors]);
    print($page_content);
}
