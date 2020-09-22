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
        $sql='SELECT `TASKNAME`,`ENDTIME`,`task`.`PROJECT_ID`,`TASK_STATUS`,`FILEREF` FROM `task` INNER JOIN `project` WHERE `task`.`USER_ID`='.$userid.' AND `PROJECT_NAME`= "'.$project.'" AND `task`.`PROJECT_ID`=`project`.`PROJECT_ID`';

    }
    else{
        $sql = 'SELECT `TASKNAME`,`ENDTIME`,`PROJECT_ID`,`TASK_STATUS`,`FILEREF` FROM `task` WHERE `USER_ID`='.$userid;
    }
    $result = mysqli_query($con, $sql);
    $tasks = mysqli_fetch_all($result,MYSQLI_ASSOC);
    if(count($tasks)<1){
        $tasks="error";

    }


    return $tasks;

}


