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
    /**
     * @param $articleId
     * @return void
     * @throws UnauthorizedException
     */
    public function add ($articleId)
    {
        if ($this->user === null) {
            throw new UnauthorizedException('Необходимо зайти в аккаунт');
        }

        if (!empty($_POST)) {
            try {
                $commentText = $_POST;
                Comment::add($commentText, $this->user, $articleId);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('errors/500.php', ['error' => $e->getMessage()]);
                return;
            }
            header('Location: /articles/' . $articleId, true, 302);
            exit();
        }
    }

    /**
     * @param $commentId
     * @return void
     * @throws ForbiddenException
     * @throws UnauthorizedException
     */
    public function edit ($commentId): void
    {
        $comment = Comment::getById($commentId);

        if ($comment === null) {
            throw new ForbiddenException('Не найдено комментария');
        }

        if ($this->user === null) {
            throw new UnauthorizedException('Необходимо зайти в аккаунт');
        }

        if ($this->user->getRole() !== 'admin' and $comment->getAuthorId() != $this->user->getId()) {
            throw new ForbiddenException('Недостаточно прав!');
        }

        if(!empty($_POST)) {
            try {
                $articleId = $comment->getArticleId();
                $comment->edit($_POST);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('comments/edit.php', ['error' => $e->getMessage(), 'comment' => $comment]);
                return;
            }

            header('Location: /articles/' . $comment->getArticleId() . '#' . $comment->getId(), true, 302);
            exit();
        }

        $this->view->renderHtml('comments/edit.php', ['comment' => $comment]);
    }

    public function delete ($commentId): void
    {
        if ($this->user->getRole() !== 'admin') {
            throw new ForbiddenException('Недостаточно прав!');
        }

        $comment = Comment::getById($commentId);
        $articleId = $comment->getArticleId();
        $comment->delete();

        header('Location: /articles/' . $articleId, true, 302);
        exit();

    }
}