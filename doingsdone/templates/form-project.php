<main class="content__main">
        <h2 class="content__main-heading">Добавление проекта</h2>

        <form class="form"  action="" method="post" autocomplete="off">
          <div class="form__row">
            <label class="form__label" for="project_name">Название<sup>*</sup></label>
              <input class="form__input <?= in_array('101',$errors)? "form__input--error":"" ?> <?= in_array('102',$errors)? "form__input--error":"" ?>" type="text" name="name" id="name" value="<?php if(isset($_POST['name'])){print($_POST['name']); } ?>" placeholder="Введите название проекта">
            <?= in_array('101',$errors)? "<p class='form__message'>Поле наименования не может быть пустым или больше 25</p>":"" ?>
              <?= in_array('102',$errors)? "<p class='form__message'>Поле наименования проекта должно быть уникальным</p>":"" ?>
          </div>

          <div class="form__row form__row--controls">
            <input class="button" type="submit" name="" value="Добавить">
          </div>
        </form>
      </main>