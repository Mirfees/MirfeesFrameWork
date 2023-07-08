<?php

namespace MyProject\Controllers;

use MyProject\Models\Users\User;
use MyProject\Models\Users\UsersAuthService;
use MyProject\View\View;

class AbstractController
{
    protected $view;

    protected $user;

    public function __construct()
    {
        $this->user = UsersAuthService::getUserByToken();
        $this->view = new View(__DIR__ . '/../../../templates');
        $this->view->setVars('user', $this->user);
    }
}