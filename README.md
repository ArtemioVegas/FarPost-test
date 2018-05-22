Тестовое задание для FarPost
========================

Без применения frameworks, cms и библиотек напишите собственный сценарий регистрации/авторизации пользователей на сайте (через e-mail). 
После авторизации, пользователь должен получить инструменты для загрузки пачки фотографий. 
Фото должны загружаться без перезагрузки страницы. 
В качестве результата загрузки должны появляться превьюшки, клик по которым должен открывать выбранное фото в полном размере в новой вкладке. 
При оценке задания будет обращаться внимание на концептуальное качество кода, его чистоту. 
Озадачиваться вёрсткой необязательно. 
Результат нужно представить в виде исходного кода и работающего приложения в интернете.

Requirements
------------

  * PHP 7.0 or higher;
  * FileInfo PHP extension enabled;

Installation
------------

Execute this command to install the project:

```bash
$ composer install
```

Usage
-----

There's no need to configure anything to run the application. Just execute this
command to run the built-in web server and access the application in your
browser at <http://localhost:8000>:

```bash
$ cd <project_name>/
$ php -S localhost:8000
```