<?php

namespace MyProject\Controllers\Api;

use MyProject\Controllers\UsersController;
use MyProject\Exceptions\ForbiddenException;
use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Controllers\AbstractController;
use MyProject\Exceptions\NotFoundException;
use MyProject\Exceptions\UnauthorizedException;
use MyProject\Models\Articles\Article;
use MyProject\Models\Users\User;
use MyProject\Models\Users\UsersAuthService;

class ArticlesApiController extends AbstractController
{
    public function view(int $articleId) {
        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundException("Такой статьи нет");
        }

        $this->view->renderJson([
            'articles' => [$article]
        ]);
    }

    public function viewAll() {
        $articles = Article::findAll();

        $this->view->renderJson($articles);
    }

    public function add() {
        $input = $this->getInputData();
        $articleFromRequest = $input['articles'][0];
        $currentUser = UsersAuthService::getUserByToken();
        $authorId = $articleFromRequest['author_id'];

        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            throw new InvalidArgumentException("Неправильный метод запроса");
        }

        if ($currentUser === null) {
            throw new UnauthorizedException("Войдите в аккаунт, чтобы добавлять статьи");
        }

        if ($currentUser->getId() !== (int) $authorId) {
            throw new UnauthorizedException("Добавляйте статьи от своего аккаунта");
        }

        $author = User::getById($authorId);
        $article = Article::createFromArray($articleFromRequest, $author);
        $article->save();

        header('Location: /api/articles/' . $article->getId(), true, 302);
    }

    public function update(int $articleId) {
        $currentUser = UsersAuthService::getUserByToken();
        $article = Article::getById($articleId);
        if($article === null) {
            throw new NotFoundException("Такой статьи не существует");
        }

        if($_SERVER["REQUEST_METHOD"] !== "PATCH") {
            throw new InvalidArgumentException("Неправильный метод запроса");
        }

        if (!$currentUser) {
            throw new UnauthorizedException("Удалять статьи могут только авторизированные пользователи");
        }

        if ($currentUser->getId() !== $article->getAuthorId() && !UsersController::isAdmin()) {
            throw new UnauthorizedException("Вы не являетесь админом или автором статьи");
        }

        $article->delete();

        $this->view->renderJson([
            'message' => "Статья с ID " . $articleId . " успешно удалена"
        ]);
    }

    public function delete(int $articleId) {
        $currentUser = UsersAuthService::getUserByToken();
        $article = Article::getById($articleId);
        if($article === null) {
            throw new NotFoundException("Такой статьи не существует");
        }

        if($_SERVER["REQUEST_METHOD"] !== "DELETE") {
            throw new InvalidArgumentException("Неправильный метод запроса");
        }

        if (!$currentUser) {
            throw new UnauthorizedException("Удалять статьи могут только авторизированные пользователи");
        }

        if ($currentUser->getId() !== $article->getAuthorId() && !UsersController::isAdmin()) {
            throw new UnauthorizedException("Вы не являетесь админом или автором статьи");
        }

        $article->delete();
        $this->view->renderJson([
            'message' => "Статья с ID " . $articleId . " успешно удалена"
        ]);
    }
}