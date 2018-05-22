<?php $this->layout('layout'); ?>

<div class="content__main-col">
    <header class="content__header">
        <h2 class="content__header-text"><?=$title;?></h2>
        <a class="button button--transparent content__header-button" href="#">Назад</a>
    </header>

    <ul class="gif-list">
        <?php if ($images): ?>
            <?php foreach ($images as $im) : ?>
                <li class="gif gif-list__item">
                    <div class="gif__picture">
                        <a target="_blank" href="/image/view?id=<?=$im->id;?>" class="gif__preview">
                            <img src="/uploads/<?=$im->hash_name;?>" alt="" width="260" height="260">
                        </a>
                    </div>
                </li>
            <?php endforeach; ?>
        <?php else:?>
            <li class="col_text">Список пуст</li>
        <?php endif;?>
    </ul>

</div>
