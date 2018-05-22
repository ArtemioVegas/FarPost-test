<?php $this->layout('layout');
$f = $form;
?>

<div class="content__main-col">
    <header class="content__header content__header--left-pad">
        <h2 class="content__header-text"><?=$title;?></h2>

        <a class="button button--transparent content__header-button" href="#">Назад</a>
    </header>

    <form class="form form__margin" id="former_id" action="" method="post" enctype="multipart/form-data">
        <div class="form__column">
            <div class="form__input-file">
                <input class="visually-hidden" type="file" name="path[]" id="preview" value="" accept="image/*" multiple>
                <label for="preview">
                    <span>Выбрать файл(ы)</span>
                </label>
            </div>
        </div>

        <div class="form__controls">
            <input class="button form__control" id="subm_button" type="submit" name="saver[submit]" value="Добавить">
        </div>
    </form>

    <ul class="gif-list">
    </ul>

</div>

<script>
    var maxCOuntFiles = <?=$maxFiles;?>;
    var maxSize = <?=$maxSize;?>;
</script>