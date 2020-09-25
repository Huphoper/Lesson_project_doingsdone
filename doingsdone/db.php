<?php
function get_first_name($con,$userid){
    $sql = 'SELECT `FIRST_NAME` FROM `user` WHERE `USER_ID`= ?';
    $stmt = mysqli_prepare($con, $sql);

    mysqli_stmt_bind_param($stmt,'i',$userid);

    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);



    $firstname=mysqli_fetch_assoc($res);
    $first =$firstname['FIRST_NAME'];

    return $first;
}
function createprojectlist($con,$userid){
    $sql = 'SELECT `PROJECT_NAME`,`project`.`PROJECT_ID`, COUNT(`task`.`TASK_ID`) AS `CNT` FROM `project` LEFT JOIN `task` ON `task`.`PROJECT_ID`=`project`.`PROJECT_ID` WHERE `project`.`USER_ID`= ? GROUP BY `PROJECT_ID`';
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt,'i',$userid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $projects = mysqli_fetch_all($result,MYSQLI_ASSOC);
    return $projects;
}
function createtasklist($con,$userid,$project){
    if($project!=null){
        $sql='SELECT `TASKNAME`,`ENDTIME`,`task`.`PROJECT_ID`,`TASK_STATUS`,`FILEREF` FROM `task` INNER JOIN `project` WHERE `task`.`USER_ID`=? AND `PROJECT_NAME`= ? AND `task`.`PROJECT_ID`=`project`.`PROJECT_ID` ORDER BY `TASK_ID` DESC';
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt,'is',$userid,$project);
    }
    else{
        $sql = 'SELECT `TASKNAME`,`ENDTIME`,`PROJECT_ID`,`TASK_STATUS`,`FILEREF` FROM `task` WHERE `USER_ID`=? ORDER BY `TASK_ID` DESC';
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt,'i',$userid);
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $tasks = mysqli_fetch_all($result,MYSQLI_ASSOC);
    if(count($tasks)<1){
        $tasks="error";

    }


    return $tasks;

}
function addtask($con,$full_task,$userid,$file){
    $file_url="";

    if(isset($file['file'])&&$file['file']['error']==0){
        $file_name = $file['file']['name'];
        $file_path = __DIR__ . '/uploads/';
        $file_url = '/uploads/' . $file_name;
        move_uploaded_file($file['file']['tmp_name'], $file_path . $file_name);



    }
    $taskstatus="'0'";
    $projectid=null;
    $sql = 'SELECT `PROJECT_ID` FROM `project` WHERE `USER_ID`=? AND `PROJECT_NAME`=?';
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt,'is',$userid,$full_task['project']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $projectid=mysqli_fetch_assoc($result);
    if($projectid==null){
        header("Location: index.php");
    }
    {

    $sql = 'INSERT INTO `task` (`TASK_STATUS`, `TASKNAME`, `FILEREF`, `ENDTIME`, `PROJECT_ID`, `USER_ID`)
VALUES ( 0, ?,? ,?,?,?)';

    $stmt = mysqli_prepare($con, $sql);

    mysqli_stmt_bind_param($stmt,'sssii',$full_task['name'],$file_url,$full_task['date'],$projectid['PROJECT_ID'],$userid);

    $res=mysqli_stmt_execute($stmt);

    }
    if ($res) {
 header("Location: index.php?project=".$full_task['project']);
 }
}


