<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <base href="/">
    <title><?=$ctrl->getTitle();?></title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/custom.css">
    <script src="/js/jquery-2.2.4.min.js"></script>
    <script src="/js/uploadHandler.js"></script>

    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
</head>

<body>
<img id="loadImg" src="img/ajax-loader.gif" />
<div class="container">
    <header class="main-header">
        <h1 class="visually-hidden">Demo Project</h1>

        <a class="logo" href="/">
          <img class="logo__img" src="img/logo.svg" alt="Demo Project" width="160" height="38"></a>
    </header>

    <div class="main-content">
        <section class="navigation">
            <h2 class="visually-hidden">Навигация</h2>

            <div class="navigation__item">
                <h3 class="navigation__title navigation__title--account">Навигация</h3>

                <?php if ($user->isGuest()): ?>
                <nav class="navigation__links">
                    <a href="/signup">Регистрация</a>
                    <a href="/signin">Вход</a>
                </nav>
                <?php else: ?>
                    <nav class="navigation__links">
                        <a href="javascript:;"><?=$this->e($user->getUserModel()->name);?></a>
                        <a href="/image/add">Загрузить изображения</a>
                        <a href="/image/all">Мои загрузки</a>
                        <a href="/logout">Выход</a>
                    </nav>
                <?php endif; ?>
            </div>
        </section>

        <main class="content">
            <?=$this->section('content'); ?>
        </main>
    </div>

    <footer class="main-footer">
        <div class="main-footer__col">
            Developed by Artemio Vegas: <a href="https://github.com/ArtemioVegas">Мой github</a>.
        </div>
    </footer>
</div>
</body>
</html>