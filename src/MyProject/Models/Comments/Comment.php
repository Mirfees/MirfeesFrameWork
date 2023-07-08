<?php

namespace MyProject\Models\Comments;

use MyProject\Models\Users\User;

class Comment
{
    private $text;
    private $author;

    public function __construct(string $text, User $author)
    {
        $this->text = $text;
        $this->author = $author;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }
}
