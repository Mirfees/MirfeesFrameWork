<?php

namespace MyProject\Controllers\Api;

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
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $input = $this->getInputData();
            $articleFromRequest = $input['articles'][0];
            $currentUser = UsersAuthService::getUserByToken();

            $authorId = $articleFromRequest['author_id'];
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
    }
}