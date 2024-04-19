<?php

namespace MyProject\Controllers\Api;

use MyProject\Controllers\AbstractController;
use MyProject\Exceptions\NotFoundException;
use MyProject\Models\Articles\Article;

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
        if($_SERVER["REQUEST_METHOD"]) {
            $input = json_decode(
                file_get_contents('php://input'),
                true
            );

            var_dump($input);
        }
    }
}