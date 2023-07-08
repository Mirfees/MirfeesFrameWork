<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Exceptions\UserActivationException;
use MyProject\Models\Users\EmailSender;
use MyProject\Models\Users\UserActivationService;
use MyProject\Models\Users\UsersAuthService;
use MyProject\View\View;
use MyProject\Models\Users\User;

class UsersController extends AbstractController
{
    public function signUp()
    {
        if (!empty($_POST)) {
            try {
                $user = User::signUp($_POST);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('users/signUp.php', ['error' => $e->getMessage()]);
                return;
            }
        }

        if($user instanceof User) {
            $code = UserActivationService::createActivationCode($user);

            EmailSender::send($user, 'Активация', 'userActivation.php', [
                'userId' => $user->getId(),
                'code' => $code
            ]);
            $this->view->renderHtml('users/signUpSuccessful.php');
            return;
        }

        $this->view->renderHtml('users/signUp.php');
    }

    public function activate(int $userId, string $activationCode)
    {
        try {
            $user = User::getById($userId);

            if ($user === null) {
                throw new UserActivationException('Пользователь не найден');
            }

            if ($user->isConfirmed()) {
                throw new UserActivationException('Пользователь уже активирован');
            }

            $isCodeValid = UserActivationService::checkActivationCode($user, $activationCode);

            if (!$isCodeValid) {
                throw new UserActivationException('Неверный код активации');
            }

            if ($isCodeValid) {
                $user->activate();
                echo 'OK!';

                UserActivationService::deleteActivationCode($user);
            }
        } catch(UserActivationException $e) {
            $this->view->renderHtml('error/500.php', ['error' => $e->getMessage()]);
            UserActivationService::deleteActivationCode($user);
            return;
        }

    }

    public function login() {

        if(!empty($_POST)) {
            try {
                $user = User::login($_POST);
                UsersAuthService::createToken($user);
                header('Location: /');
                exit();
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('users/login.php', ['error' => $e->getMessage()]);
                return;
            }
        }
      $this->view->renderHtml('users/login.php');
    }

    public function logout()
    {
        User::logout();
        header('Location: /');
        exit();
    }

}