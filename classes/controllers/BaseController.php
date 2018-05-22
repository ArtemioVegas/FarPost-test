<?php
namespace Artemio\controllers;

use Artemio\models\UserModel;
use Artemio\services\AuthUser;
use Artemio\services\ModelFactory;
use League\Plates\Engine;

class BaseController {

    /**
     * @var Engine
     */
    protected $templateEngine;

    /**
     * @var ModelFactory
     */
    protected $modelFactory;

    /**
     * @var AuthUser
     */
    protected $user;

    protected $rules = [
        'guest' => ["/image/add","/image/all", "/logout"],
        'user'  => ["/signin", "/signup"]
    ];

    protected $pageTitle;

    public function __construct(Engine $templateEngine, ModelFactory $modelFactory) {
        $this->templateEngine = $templateEngine;
        $this->modelFactory = $modelFactory;
        $this->user = new AuthUser(UserModel::class, $modelFactory);

        $this->templateEngine->addData(['ctrl' => $this]);
    }

    public function getTitle() {

        return $this->pageTitle;
    }

    public function redirect($path) {
        header("Location: " . $path);
        exit;
    }

    public function beforeAction() {
        $this->user->proceedAuth();

        $uri = $_SERVER['REQUEST_URI'];
        $this->templateEngine->addData(['user' => $this->user]);

        $rules = $this->user->isGuest() ? $this->rules['guest'] : $this->rules['user'];

        if (in_array($uri, $rules)) {
            $this->redirect('/');
        }
    }

    public function getParam($name, $default = null) {
        $value = $_REQUEST[$name] ?? $default;

        return $value;
    }

    public function isAjax() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }
}