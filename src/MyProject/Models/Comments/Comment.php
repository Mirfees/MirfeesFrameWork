<?php

namespace MyProject\Models\Comments;

use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Exceptions\UnauthorizedException;
use MyProject\Models\ActiveRecordEntity\ActiveRecordEntity;
use MyProject\Models\Users\User;
use MyProject\Services\Db;

class Comment extends ActiveRecordEntity
{
    protected $authorId;

    protected $articleId;

    protected $commentText;

    protected $publicationDate;

    /**
     * @return mixed
     */
    public function getAuthorId()
    {
        return $this->authorId;
    }

    /**
     * @return mixed
     */
    public function getArticleId()
    {
        return $this->articleId;
    }

    /**
     * @return mixed
     */
    public function getCommentText()
    {
        return $this->commentText;
    }

    /**
     * @return mixed
     */
    public function getPublicationDate()
    {
        return $this->publicationDate;
    }

    /**
     * @param mixed $authorId
     */
    public function setAuthorId(int $authorId): void
    {
        $this->authorId = $authorId;
    }

    /**
     * @param mixed $articleId
     */
    public function setArticleId(int $articleId): void
    {
        $this->articleId = $articleId;
    }

    /**
     * @param mixed $commentText
     */
    public function setCommentText(string $commentText): void
    {
        $this->commentText = $commentText;
    }

    /**
     * @param mixed $publicationDate
     */
    public function setPublicationDate($publicationDate): void
    {
        $this->publicationDate = $publicationDate;
    }

    public static function addComment(string $commentText, User $author, $articleId)
    {
        if($commentText === '') {
            throw new InvalidArgumentException('Текст не введен');
        }

        $comment = new Comment();

        $comment->setCommentText($commentText);
        $comment->setArticleId($articleId);
        $comment->setAuthorId($author->getId());

        $comment->save();

        $comment->setPublicationDate(Comment::findOneByColumn('id', $comment->getId())->getPublicationDate());
        var_dump($comment);

    }

    public static function getAllComments()
    {
        //TODO: Создать метод, который возвращает все комментарии, которые были написаны для статьи
    }

    protected static function getTableName(): string
    {
        return 'comments';
    }
}
