<?php
namespace Artemio\services;

use Artemio\models\UserModel;

class AuthUser {

    /**
     * @var UserModel $userModel
     */
    protected $userModel;

    /**
     * @var ModelFactory $modelFactory
     */
    protected $modelFactory;

    /**
     * AuthUser constructor.
     * @param string $userModelClass
     * @param ModelFactory $modelFactory
     */
    public function __construct($userModelClass, ModelFactory $modelFactory) {
        $this->modelFactory = $modelFactory;
        $this->userModel = $this->modelFactory->getEmptyModel($userModelClass);
    }

    /**
     * @return UserModel
     */
    public function getUserModel(): UserModel {
        return $this->userModel;
    }

    public function isGuest() {
        return empty($_SESSION['user']);
    }

    public function logout() {
        unset($_SESSION['user']);
        unset($_COOKIE['ut']);

        setcookie('ut', '', time() - 3600, '/');
    }

    public function proceedAuth() {
        if (!isset($_SESSION['user'])) {
            if (isset($_COOKIE['ut'])) {
                $token = $_COOKIE['ut'];
                $this->loginByToken($token);
            }
        }

        if (isset($_SESSION['user'])) {
            $this->userModel = $_SESSION['user'];
            // хаки для внедрения инстанса PDO после десериализации
            $this->userModel->setDb($this->modelFactory->getDatabaseConnect());
            $this->userModel->setModelFactory($this->modelFactory);
        }

        return $this->userModel;
    }

    public function loginByEmail($email) {
        $user = $this->userModel->findOneBy(['email' => $email]);

        if ($user->id) {
            $token = $this->userModel->generateHash([$user->dt_add, $user->email, $user->name, $user->password]);
            $user->updateToken($token);

            setcookie('ut', $token, strtotime('+6 month'), '/');
            $_SESSION['user'] = $user;
        }
    }

    public function loginByToken($token) {
        $user = $this->userModel->findOneBy(['token' => $token]);

        if ($user->id) {
            $_SESSION['user'] = $user;
        }
    }
}