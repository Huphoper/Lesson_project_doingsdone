
 <section class="content__side">
                <h2 class="content__side-heading">Проекты</h2>

                <?php
     require('connection.php');


                $sql = 'SELECT `PROJECT_NAME`,`PROJECT_ID`,(SELECT COUNT(*) FROM `task` WHERE `PROJECT_ID`=`project`.`PROJECT_ID`) AS `CNT` FROM `project` WHERE `USER_ID`='.$userid;
     $result = mysqli_query($con, $sql);
     $projects = mysqli_fetch_all($result,MYSQLI_ASSOC);

     ?>

                <?php
                $project = htmlspecialchars($_GET['project']);

      if($project!=null){
          $sql='SELECT `TASKNAME`,`ENDTIME`,`task`.`PROJECT_ID`,`TASK_STATUS`,`FILEREF` FROM `task` INNER JOIN `project` WHERE `task`.`USER_ID`='.$userid.' AND `PROJECT_NAME`= "'.$project.'" AND `task`.`PROJECT_ID`=`project`.`PROJECT_ID`';
         // print($sql);
      }
      else{
     $sql = 'SELECT `TASKNAME`,`ENDTIME`,`PROJECT_ID`,`TASK_STATUS`,`FILEREF` FROM `task` WHERE `USER_ID`='.$userid;
      }
     $result = mysqli_query($con, $sql);
     $tasks = mysqli_fetch_all($result,MYSQLI_ASSOC);


     ?>
                <?php function itemcount($projects){


                    return $projects[CNT];
                }
                $show_completed = htmlspecialchars($_GET['show_completed']);

                if($show_completed==null){
                    $show_complete_tasks = 0;
                }
                else{
                    $show_complete_tasks =$show_completed;
                }
function filterText($str){
    $text = htmlspecialchars($str);
    return $text;
}
                ?>
                <nav class="main-navigation">
                    <ul class="main-navigation__list">
                        <?php $index=0;
                                $num = count($projects);
                        while($index<$num): ?>
                        <li class="main-navigation__list-item <?php
                        if($projects[$index][PROJECT_NAME]==$project){
                            print('main-navigation__list-item--active');
                        }
                        ?>" >

                            <a class="main-navigation__list-item-link" href="index.php?project=<?=$projects[$index][PROJECT_NAME]?>"><? print($projects[$index][PROJECT_NAME]); ?></a>

                            <span class="main-navigation__list-item-count"><?= filterText(itemcount($projects[$index])); ?></span>
                                 <?php $index++ ?>
                        </li>
                    <?php endwhile;?>
                    </ul>
                </nav>

                <a class="button button--transparent button--plus content__side-button"
                   href="pages/form-project.html" target="project_add">Добавить проект</a>
            </section>

            <main class="content__main">
                <h2 class="content__main-heading">Список задач</h2>

                <form class="search-form" action="index.php" method="post" autocomplete="off">
                    <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

                    <input class="search-form__submit" type="submit" name="" value="Искать">
                </form>

                <div class="tasks-controls">
                    <nav class="tasks-switch">
                        <a href="/" class="tasks-switch__item tasks-switch__item--active">Все задачи</a>
                        <a href="/" class="tasks-switch__item">Повестка дня</a>
                        <a href="/" class="tasks-switch__item">Завтра</a>
                        <a href="/" class="tasks-switch__item">Просроченные</a>
                    </nav>

                    <label class="checkbox">
                        <!--добавить сюда атрибут "checked", если переменная $show_complete_tasks равна единице-->
                        <input class="checkbox__input visually-hidden show_completed" type="checkbox" <?php if($show_complete_tasks == 1): ?>checked <?php endif; ?> >
                        <span class="checkbox__text">Показывать выполненные</span>
                    </label>
                </div>
                <table class="tasks">
                    <?php
                    $textclass="";
                    $cur_date = date_create("now");
                    ?>
                    <?php  foreach($tasks as $key =>$val): ?>

                    <tr  <?php if($val[TASK_STATUS]==1 && $show_complete_tasks == 0): ?>hidden <?php endif; ?> <?php if($val[TASK_STATUS]==1){ $textclass="tasks__item task task--completed";} else{
                        $textclass="tasks__item task";} ?>
                      <?php
                              if($val[ENDTIME]!='null'){$input_date = new DateTime($val[ENDTIME]);
                              $inputed = strtotime($val[ENDTIME]);
                              $today = strtotime("now");
                              if ($today-$inputed<=86400 ){
                                $textclass="tasks__item task task--important";
                              } }
                     ?>
                     class=<?php echo '"'.$textclass.'"'; ?>  >
                        <td class="task__select">
                            <label class="checkbox task__checkbox">
                                <input class="checkbox__input visually-hidden task__checkbox" type="checkbox" value="1" <?php if($val[TASK_STATUS]==1): ?>checked <?php endif; ?>>
                                <span class="checkbox__text"><?=filterText($val[TASKNAME]); ?> </span>
                            </label>
                        </td>

                        <td class="task__file">
                            <a class="download-link" href="#"><?=filterText($val[FILEREF]); ?></a>
                        </td>

                        <td class="task__date"><?=filterText($val[ENDTIME]); ?></td>
                    </tr>
                    <?php endforeach; ?>

                    <!--показывать следующий тег <tr/>, если переменная $show_complete_tasks равна единице-->
                </table>
            </main>
