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
function createtasklist($con,$userid,$project,$task_search,$filter){
    if($filter==all){
        
    if($task_search!=null){
        $sql = 'SELECT `TASKNAME`,`ENDTIME`,`PROJECT_ID`,`TASK_STATUS`,`FILEREF` FROM `task` WHERE `USER_ID`=? AND MATCH(`TASKNAME`) AGAINST(?) ORDER BY `TASK_ID` DESC';
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt,'is',$userid,$task_search);
    }
    else{
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
    }}
    else if($filter==today){
         $sql = 'SELECT `TASKNAME`,`ENDTIME`,`PROJECT_ID`,`TASK_STATUS`,`FILEREF` FROM `task` WHERE `USER_ID`=?  AND `ENDTIME`= CURRENT_DATE() ORDER BY `TASK_ID` DESC';
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt,'i',$userid);
    }
    else if($filter==tomorrow){
         $sql = 'SELECT `TASKNAME`,`ENDTIME`,`PROJECT_ID`,`TASK_STATUS`,`FILEREF` FROM `task` WHERE `USER_ID`=? AND `ENDTIME`= CURRENT_DATE() + INTERVAL 1 DAY ORDER BY `TASK_ID` DESC';
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt,'i',$userid);
    }
    else if($filter==expired){
         $sql = 'SELECT `TASKNAME`,`ENDTIME`,`PROJECT_ID`,`TASK_STATUS`,`FILEREF` FROM `task` WHERE `USER_ID`=? AND `ENDTIME`< CURRENT_DATE() ORDER BY `TASK_ID` DESC';
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
function login_validate($con,$reg_date){
    $errors = [];
    if(filter_var($reg_date['email'],FILTER_VALIDATE_EMAIL)){
        $sql = 'SELECT COUNT(`EMAIL`) FROM `user` WHERE `EMAIL`= ?';
            
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt,'s',$reg_date['email']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $exists=mysqli_fetch_assoc($result);
        
        if($exists['COUNT(`EMAIL`)']==1){
           
           $errors['email']='202'; 
        }
    }
    else{
        
        $errors['email']='201';
    }
    if(strlen($reg_date['name'])<1 || strlen($reg_date['name'])>30 ){
        
        $errors['name']='203';
    }
    if(strlen($reg_date['password'])<5){
        
        $errors['password']='204';
    }
    
    return $errors;
      }
function add_user($con,$reg_date){
    $passwordHash = password_hash($full_task['password'], PASSWORD_DEFAULT);
    $sql = 'INSERT INTO `user` (`EMAIL`, `PASSWORD`, `FIRST_NAME`) VALUES ( ?,?,?)';
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt,'sss',$reg_date['email'],$passwordHash,$reg_date['name']);
    $res=mysqli_stmt_execute($stmt);
  //   print('Запись добавлена!');
   // var_dump($res);
    if ($res) {
session_start();
 $_SESSION['usid'] = 3; 
 header("Location: index.php?registered=1");
 }
}
function addproject($con,$taskname,$userid){   
    $sql = 'INSERT INTO `project` (`PROJECT_NAME`,`USER_ID`) VALUES (?,?)';
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt,'si',$taskname['name'],$userid);
    $res=mysqli_stmt_execute($stmt);
    if ($res) {
 header("Location: index.php?project=".$taskname['name']);
 }
    else{
       $errors['name']='102'; 
        return $errors;
    }
}
function statuschange($con,$taskname,$userid){
    $sql='SELECT `TASK_STATUS` FROM `task` WHERE `USER_ID`=? AND `TASKNAME`=?';
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt,'is',$userid,$taskname);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $taskstatus=mysqli_fetch_assoc($res);
    $status =$taskstatus['TASK_STATUS'];
    if($status==1){
       $sql = "UPDATE `task` SET `TASK_STATUS` = '0' WHERE `TASKNAME` = ? AND `USER_ID`=?"; 
    }
    else{
       $sql = "UPDATE `task` SET `TASK_STATUS` = '1' WHERE `TASKNAME` = ? AND `USER_ID`=?"; 
    } 
    
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt,'si',$taskname,$userid);
    $res=mysqli_stmt_execute($stmt);
    header("Location: index.php");
}
