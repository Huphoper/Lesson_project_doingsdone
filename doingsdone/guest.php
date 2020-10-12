<?php
require_once('connection.php');
require_once('db.php');
require_once('helpers.php');
$errors=array();

if ($con == false) {
    print("Ошибка подключения: " . mysqli_connect_error());
}
else{
    $page_content = include_template('guest-form.php');
    print($page_content);
}
