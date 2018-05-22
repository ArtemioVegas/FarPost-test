<?php
namespace Artemio\forms;

class SignupForm extends BaseForm {

    protected $name = 'signup';

    protected $fields = ['email', 'password', 'name'];
    protected $labels = [
        'email' => 'E-mail', 'password' => 'Пароль', 'name' => 'Имя',
    ];
    protected $rules = [
        ['email', ['email']],
        ['unique', 'email'],
        ['required', ['email', 'password', 'name']]
    ];
}