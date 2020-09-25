<main class="content__main">
    <h2 class="content__main-heading">Добавление задачи</h2>

    <form class="form"  action="" method="post" enctype="multipart/form-data" autocomplete="off">
        <div class="form__row">
            <label class="form__label" for="name">Название <sup>*</sup></label>

            <input class="form__input <?= in_array('101',$errors)? "form__input--error":"" ?>" type="text" name="name" id="name" value="<?php if(isset($_POST['name'])){print($_POST['name']); } ?>" placeholder="Введите название">
            <?= in_array('101',$errors)? "<p class='form__message'>Поле наименования не может быть пустым или больше 200</p>":"" ?>
        </div>

        <div class="form__row">
            <label class="form__label" for="project">Проект <sup>*</sup></label>

            <select class="form__input form__input--select <?= in_array('102',$errors)? "form__input--error":"" ?>" name="project" id="project">

                <?php $index=0;
                $num = count($projects);
                while($index<$num): ?>
                    <option <?php if(isset($_GET['project'])&&$_GET['project']==$projects[$index]['PROJECT_NAME'])
                    {print('selected');}
                    elseif (isset($_POST['project'])&&$_POST['project']==$projects[$index]['PROJECT_NAME']){print('selected');}
                    ?> value="<? print($projects[$index]['PROJECT_NAME']); ?>" >
                        <? print($projects[$index]['PROJECT_NAME']); ?></a>
                        <?php $index++ ?>
                    </option>
                <?php endwhile;?>
            </select>
    <?= in_array('102',$errors)? "<p class='form__message'>Поле не заполнено</p>":"" ?>
        </div>

        <div class="form__row">
            <label class="form__label" for="date">Дата выполнения</label>

            <input class="form__input form__input--date <?= in_array('103',$errors)? "form__input--error":"" ?>" type="text" name="date" id="date" value="<?php if(isset($_POST['date'])){print($_POST['date']); } ?>" placeholder="Введите дату в формате ГГГГ-ММ-ДД">
            <?= in_array('103',$errors)? "<p class='form__message'>Дата должна быть больше или равна текущей!</p>":"" ?>
        </div>

        <div class="form__row">
            <label class="form__label" for="file">Файл</label>

            <div class="form__input-file">
                <input class="visually-hidden" type="file" name="file" id="file" value="<?php if(isset($_POST['file'])){print($_POST['file']); } ?>">

                <label class="button button--transparent" for="file">
                    <span>Выберите файл</span>
                </label>
            </div>
            <?= in_array('104',$errors)? "<p class='form__message'>Превышен максимальный размер файла в 10МБ</p>":"" ?>
        </div>

        <div class="form__row form__row--controls">
            <input class="button" type="submit" name="sub" value="Добавить">
        </div>
    </form>
</main>
