<?php
namespace Artemio\controllers;

use Artemio\forms\LoginForm;
use Artemio\forms\SignupForm;
use Artemio\models\UserModel;

class UserController extends BaseController {

    public function actionSignup() {
        $this->pageTitle = 'Регистрация пользователя';
        $form = new SignupForm();

        /**
         * @var UserModel $userModel
         */
        $userModel = $this->modelFactory->getEmptyModel(UserModel::class);
        $form->setModel($userModel);

        if ($form->isSubmitted()) {
            $form->validate();

            if ($form->isValid()) {
                $user = $form->getData();

                $userModel->createNewUser($user['email'], $user['password'], $user['name']);

                $this->redirect('/');
            }
        }

        return $this->templateEngine->render('user/signup', ['form' => $form]);
    }

    public function actionSignin() {
        $this->pageTitle = 'Вход на сайт';

        $form = new LoginForm();
        $userModel = $this->modelFactory->getEmptyModel(UserModel::class);
        $form->setModel($userModel);

        if ($form->isSubmitted()) {
            $form->validate();

            if ($form->isValid()) {
                $this->user->loginByEmail($form->email);

                $this->redirect('/');
            }
        }

        return $this->templateEngine->render('user/signin', ['form' => $form]);
    }

    public function actionLogout() {
        $this->user->logout();
        $this->redirect('/');
    }
}