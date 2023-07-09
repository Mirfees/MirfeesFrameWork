<?php

namespace MyProject\Models\Articles;

use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Models\Users\User;
use MyProject\Models\ActiveRecordEntity\ActiveRecordEntity;
use MyProject\Services\Db;

class Article extends ActiveRecordEntity
{
    /** @var string */
    protected $name;

    /** @var string */
    protected $text;

    /** @var int */
    protected $authorId;

    /** @var string */
    protected $createdAt;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    protected static function getTableName(): string
    {
        return 'articles';
    }

    public function getAuthorId(): int
    {
        return (int) $this->authorId;
    }

    public function setAuthor(User $author)
    {
        $this->authorId = $author->id;
    }

    public function getAuthor(): User
    {
        return User::getById($this->authorId);
    }

    public static function createFromArray(array $fields, User $author): Article
    {
        extract($fields);

        if(empty($name)) {
            throw new InvalidArgumentException('Не передано название статьи');
        }

        if(empty($text)) {
            throw new InvalidArgumentException('Не передан текст статьи');
        }

        $article = new Article();

        $article->setAuthor($author);
        $article->setName($name);
        $article->setText($text);

        $article->save();

        return $article;
    }

    public function updateFromArray(array $fields): Article
    {
        extract($fields);

        if (empty($name)) {
            throw new InvalidArgumentException('Не передано название статьи');
        }

        if (empty($text)) {
            throw new InvalidArgumentException('Не передан текст статьи');
        }

        $this->setName($name);
        $this->setText($text);

        $this->save();

        return $this;
    }
}