<?php
require('connection.php');
require('db.php');
require('helpers.php');
$errors=array();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_task=$_POST;
    $file=$_FILES;
    //var_dump($_FILES);
    
    $errors=validate($full_task,$file);
   // var_dump($errors);
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
    $page_content = include_template('form-task.php',['con'=>$con,'userid'=>$userid,'errors'=>$errors] );
// окончательный HTML код
    $layout_content = include_template('layout.php',['title'=>'Добавить задачу','content'=> $page_content,'con'=>$con,'userid'=>$userid]);

    print($layout_content);
}

