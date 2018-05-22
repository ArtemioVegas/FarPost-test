<?php
namespace Artemio\controllers;

class MainController extends BaseController {

    public function actionIndex() {
        $this->pageTitle = 'Главная страница';

        return $this->templateEngine->render('main');
    }
}