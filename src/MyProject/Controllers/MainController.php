<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\ForbiddenException;
use MyProject\Exceptions\UnauthorizedException;
use MyProject\Models\Articles\Article;
use MyProject\View\View;
use MyProject\Models\Users\UsersAuthService;

class MainController extends AbstractController
{
    public function main()
    {
        $articles = Article::findAll();
        $title = 'Главная страница';
        $this->view->renderHtml('main/main.php', ['articles' => $articles, 'title' => $title, 'user' => UsersAuthService::getUserByToken()]);
    }

    public function mainAdminer()
    {
        if ($this->user === null) {
            throw new UnauthorizedException('Необходимо войти в аккаунт');
        }

        if ($this->user->getRole() !== 'admin') {
            throw new ForbiddenException('Недостаточно прав!');
        }

        $this->view->renderHtml('/../templates/adminer/main/main.php', [], 200);
    }
}
