<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\ForbiddenException;
use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Exceptions\UnauthorizedException;
use MyProject\Models\Articles\Article;
use MyProject\View\View;
use MyProject\Models\Users\User;
use MyProject\Models\Comments\Comment;

class ArticlesController extends AbstractController
{
    public function view(int $articleId)
    {
        $article = Article::getById($articleId);
        $comments = Comment::getAllComments($articleId);

        if ($article === null) {
            throw new NotFoundException();
        }

        $this->view->renderHtml('articles/view.php', [
            'article' => $article,
            'comments' => $comments,
        ]);
    }

    public function delete(int $articleId) {
        $article = Article::getById($articleId);

        $article->delete();
    }

    public function add(): void
    {
        if ($this->user === null) {
            throw new UnauthorizedException('Необходимо зарегистрироваться');
        }

        if ($this->user->getRole() !== 'admin') {
            throw new ForbiddenException('Недостаточно прав!');
        }

        if (!empty($_POST)) {
            try {
                $article = Article::createFromArray($_POST, $this->user);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('articles/add.php', ['error' => $e->getMessage()]);
                return;
            }

            header('Location: /articles/' . $article->getId(), true, 302);
            exit();
        }
        $this->view->renderHtml('articles/add.php');
    }

    public function edit(int $articleId): void
    {
        $article = Article::getById($articleId);


        if($article === null) {
            throw new NotFoundException();
        }

        if ($this->user === null) {
            throw new UnauthorizedException('Необходимо зарегистрироваться');
        }

        if ($this->user->getRole() !== 'admin') {
            throw new ForbiddenException('Недостаточно прав!');
        }

        if(!empty($_POST)) {
            try {
                $article->updateFromArray($_POST);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('articles/edit.php', ['error' => $e->getMessage(), 'article' => $article]);
            }

            header('Location: /articles/' . $article->getId(), true, 302);
            exit();
        }
        $this->view->renderHtml('articles/edit.php', ['article' => $article]);

    }
}