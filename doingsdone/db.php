<?php
require_once('connection.php');
if ($con == false) {
 print("Ошибка подключения: " . mysqli_connect_error());
}
else {
$page_content = include_template('main.php' );
// окончательный HTML код
$layout_content = include_template('layout.php',['title'=>'Дела в порядке','content'=> $page_content]);

print($layout_content);
}
?>

