<?php

namespace MyProject\Controllers;

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

    public function sayHello(string $name)
    {
        $title = 'Страница приветствия';
        $this->view->renderHtml('main/hello.php',   [   'name'    =>  $name,
                                                                    'title'   =>  $title,
                                                                ]);
    }

    public function sayBye(string $name)
    {
        $title = 'Страница прощания';
        $this->view->renderHtml('main/bye.php', [   'name'  => $name,
                                                                'title' =>  $title,]);
    }
}
