<?php

use Artemio\controllers\UserController;
use Artemio\controllers\FileController;

return [
    'signup'    => [UserController::class, 'actionSignup'],
    'signin'    => [UserController::class, 'actionSignin'],
    'logout'    => [UserController::class, 'actionLogout'],
    'image\/add'  => [FileController::class, 'actionAdd'],
    'image\/view'  => [FileController::class, 'actionView'],
    'image\/all'  => [FileController::class, 'actionAll'],
];