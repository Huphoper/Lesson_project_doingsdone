<?php

//var_dump($con);
function get_first_name($con,$userid){
    $sql = 'SELECT `FIRST_NAME` FROM `user` WHERE `USER_ID`='.$userid;
    $result = mysqli_query($con, $sql);
    $firstname=mysqli_fetch_assoc($result);

    //print_r($firstname[FIRST_NAME]);
    return $firstname[FIRST_NAME];
}
function createprojectlist($con,$userid){
    $sql = 'SELECT `PROJECT_NAME`,`project`.`PROJECT_ID`, COUNT(`task`.`TASK_ID`) AS `CNT` FROM `project` LEFT JOIN `task` ON `task`.`PROJECT_ID`=`project`.`PROJECT_ID` WHERE `project`.`USER_ID`='.$userid.' GROUP BY `PROJECT_ID`';

    $result = mysqli_query($con, $sql);
    $projects = mysqli_fetch_all($result,MYSQLI_ASSOC);
    return $projects;
}
function createtasklist($con,$userid,$project){
    if($project!=null){
        $sql='SELECT `TASKNAME`,`ENDTIME`,`task`.`PROJECT_ID`,`TASK_STATUS`,`FILEREF` FROM `task` INNER JOIN `project` WHERE `task`.`USER_ID`='.$userid.' AND `PROJECT_NAME`= "'.$project.'" AND `task`.`PROJECT_ID`=`project`.`PROJECT_ID` ORDER BY `TASK_ID` DESC';

    }
    else{
        $sql = 'SELECT `TASKNAME`,`ENDTIME`,`PROJECT_ID`,`TASK_STATUS`,`FILEREF` FROM `task` WHERE `USER_ID`='.$userid.' ORDER BY `TASK_ID` DESC';
    }
    $result = mysqli_query($con, $sql);
    $tasks = mysqli_fetch_all($result,MYSQLI_ASSOC);
    if(count($tasks)<1){
        $tasks="error";

    }


    return $tasks;

}
function addtask($con,$full_task,$userid,$file){
//print_r($con);
 //   print_r($full_task);
 //   print_r($userid);
    //var_dump($file);
    $file_url="";
    //print_r("Задача отправлена");
    if(isset($file['file'])){
        $file_name = $file['file']['name'];
        $file_path = __DIR__ . '/uploads/';
        $file_url = '/uploads/' . $file_name;
        move_uploaded_file($file['file']['tmp_name'], $file_path . $file_name);

        //print("<a href='$file_url'>$file_name</a>");

    }
        $taskstatus="'0'";

    $sql = 'SELECT `PROJECT_ID` FROM `project` WHERE `USER_ID`='.$userid.' AND `PROJECT_NAME`="'.$full_task[project].'"';
    $result = mysqli_query($con, $sql);
    $projectid=mysqli_fetch_assoc($result);
    $sql = 'INSERT INTO `task` (`TASK_STATUS`, `TASKNAME`, `FILEREF`, `ENDTIME`, `PROJECT_ID`, `USER_ID`) VALUES ('.$taskstatus.', ?,"'.$file_url.'" , ?,'.$projectid[PROJECT_ID].','.$userid.')';

    $stmt = mysqli_prepare($con, $sql);
  //  var_dump($sql);
    mysqli_stmt_bind_param($stmt,'ss',$full_task[name],$full_task[date]);
    $res=mysqli_stmt_execute($stmt);
    if ($res) {
 header("Location: index.php");
 }
}


