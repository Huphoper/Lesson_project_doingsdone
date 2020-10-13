            <main class="content__main">
                <h2 class="content__main-heading">Список задач</h2>

                <form class="search-form" action="" method="GET" autocomplete="off">
                    <input class="search-form__input" type="text" name="task_search" value="" placeholder="Поиск по задачам">
                    <input class="search-form__submit" type="submit" name="" value="Искать">
                </form>

                <div class="tasks-controls">
                    <nav class="tasks-switch">

                        <a href="/?filter=all" class="tasks-switch__item <?php if($filter==all):?>tasks-switch__item--active <?php endif;?>">Все задачи</a>
                        <a href="/?filter=today" class="tasks-switch__item <?php if($filter==today):?>tasks-switch__item--active <?php endif;?>">Повестка дня</a>
                        <a href="/?filter=tomorrow" class="tasks-switch__item <?php if($filter==tomorrow):?>tasks-switch__item--active <?php endif;?>">Завтра</a>
                        <a href="/?filter=expired" class="tasks-switch__item <?php if($filter==expired):?>tasks-switch__item--active <?php endif;?>">Просроченные</a>
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
                    <?php
                    if($tasks=="error"){
//                        print("Ошибка 404: Список задач пуст или проект с таким названием не существует");
                    }
                    else{
                    foreach($tasks as $key =>$val):
                        ?>

                    <tr  <?php if($val['TASK_STATUS']==1 && $show_complete_tasks == 0): ?>hidden <?php endif; ?> <?php if($val['TASK_STATUS']==1){
                        $textclass="tasks__item task task--completed";} else{
                        $textclass="tasks__item task";} ?>
                      <?php
                              if($val['ENDTIME']!='null'){$input_date = new DateTime($val['ENDTIME']);
                              $inputed = strtotime($val['ENDTIME']);
                              $today = strtotime("today");
                              if ($today-$inputed>=86400 ){
                                $textclass="tasks__item task task--important";}}
                     ?>
                     class=<?php echo '"'.$textclass.'"'; ?>  >
                        <td class="task__select">
                            <label class="checkbox task__checkbox">
                                <input class="checkbox__input visually-hidden task__checkbox" type="checkbox" value="<?=filterText($val['TASKNAME']); ?>" <?php
                                if($val['TASK_STATUS']==1): ?>checked <?php endif; ?>>

                                    <span class=" checkbox__text"><?=filterText($val['TASKNAME']); ?> </span>

                            </label>
                        </td>

                        <td class="task__file">
                            <a class="download-link" href="<?php print(filterText($val['FILEREF'])); ?>"><?= returnfilename(filterText($val['FILEREF'])); ?></a>
                        </td>

                        <td class="task__date"><?=filterText($val['ENDTIME']); ?></td>
                    </tr>
                    <?php endforeach; }?>

                    <!--показывать следующий тег <tr/>, если переменная $show_complete_tasks равна единице-->
                </table>
            </main>
