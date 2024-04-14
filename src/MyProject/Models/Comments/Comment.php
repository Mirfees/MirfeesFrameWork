<?php

namespace MyProject\Models\Comments;

use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Exceptions\UnauthorizedException;
use MyProject\Models\ActiveRecordEntity\ActiveRecordEntity;
use MyProject\Models\Users\User;
use MyProject\Services\Db;
use function MongoDB\Driver\Monitoring\addSubscriber;

class Comment extends ActiveRecordEntity
{

    /** @var int */
    protected $authorId;

    /** @var int */
    protected $articleId;

    /** @var string */
    protected $commentText;

    /** @var string */
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

    public function getAuthor(): ?User
    {
        return $user = User::getById($this->getAuthorId());
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

    public static function add(array $fields, User $author, $articleId)
    {
        extract($fields);

        if($commentText === '') {
            throw new InvalidArgumentException('Текст не введен');
        }

        $comment = new Comment();

        $comment->setCommentText($commentText);
        $comment->setArticleId($articleId);
        $comment->setAuthorId($author->getId());

        $comment->save();

        $comment->setPublicationDate(Comment::findOneByColumn('id', $comment->getId())->getPublicationDate());
    }

    public function edit(array $fields)
    {
        extract($fields);

        if ($text === '') {
            throw new InvalidArgumentException('Не введен текст комментария');
        }

        $this->setCommentText($text);

        $this->save();

        return $this;
    }

    public static function getAllComments(int $articleId): array
    {
        $db = Db::getInstance();

        return $allComments = $db->query('SELECT * FROM ' . self::getTableName() . ' WHERE article_id=:article_id;', ['article_id' => $articleId], self::class);
    }

    protected static function getTableName(): string
    {
        return 'comments';
    }
}
