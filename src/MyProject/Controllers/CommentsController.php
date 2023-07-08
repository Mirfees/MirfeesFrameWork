<?php

namespace MyProject\Controllers;

use MyProject\Models\Comments\Comment;
use MyProject\Exceptions\ForbiddenException;
use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Exceptions\UnauthorizedException;
use MyProject\Models\Articles\Article;
use MyProject\View\View;
use MyProject\Models\Users\User;

class CommentsController extends AbstractController
{
    public function addComment($articleId)
    {

        if ($this->user === null) {
            throw new UnauthorizedException('Необходимо зайти в аккаунт');
        }

        if (!empty($_POST)) {
            try {
                var_dump($_POST['commentText']);
                var_dump($articleId);
                $commentText = $_POST['commentText'];
                Comment::addComment($commentText, $this->user, $articleId);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('/errors/500.php', ['error' => $e->getMessage()]);
                return;
            }
        }


    }
}