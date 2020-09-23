<?php
require('connection.php');
require('db.php');
require('helpers.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_task=$_POST;
    $file=$_FILES;
    //var_dump($_FILES);
    if(strlen($full_task[name])<1){
        print("Проверка имени не прошла");
    }
    else{
        addtask($con,$full_task,$userid,$file);
    }
        $inputed = strtotime($full_task[date]);
        $today = strtotime("today");
        if ($today>$inputed ){
            print_r("Дата должна быть больше или равна текущей!");
        }


}

if ($con == false) {
    print("Ошибка подключения: " . mysqli_connect_error());
}
else {
    $page_content = include_template('form-task.php',['con'=>$con,'userid'=>$userid,'project'=>$project] );
// окончательный HTML код
    $layout_content = include_template('layout.php',['title'=>'Добавить задачу','content'=> $page_content,'con'=>$con,'userid'=>$userid]);

    print($layout_content);
}

