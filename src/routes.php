<?php
return [
    '~^articles/(\d+)$~' => [\MyProject\Controllers\ArticlesController::class, 'view'],
    '~^users/register$~' => [\MyProject\Controllers\UsersController::class, 'signUp'],
    '~^users/(\d+)/activate/(.+)$~' => [\MyProject\Controllers\UsersController::class, 'activate'],
    '~^articles/(\d+)/comments$~' => [\MyProject\Controllers\CommentsController::class, 'add'],
    '~^comments/(\d+)/edit$~' => [\MyProject\Controllers\CommentsController::class, 'edit'],
    '~^comments/(\d+)/delete~' => [\MyProject\Controllers\CommentsController::class, 'delete'],
    '~^users/login$~' => [\MyProject\Controllers\UsersController::class, 'login'],
    '~^users/logout$~' => [\MyProject\Controllers\UsersController::class, 'logout'],
    '~^$~' => [\MyProject\Controllers\MainController::class, 'main'],
    //Adminer
    '~^adminer$~' => [\MyProject\Controllers\MainController::class, 'mainAdminer'],
    '~^adminer/articles$~' => [\MyProject\Controllers\ArticlesController::class, 'viewAllArticlesAdminer'],
    '~^adminer/articles/(\d+)/delete$~' => [\MyProject\Controllers\ArticlesController::class, 'delete'],
    '~^adminer/articles/(\d+)/edit$~' => [\MyProject\Controllers\ArticlesController::class, 'edit'],
    '~^adminer/articles/add$~' => [\MyProject\Controllers\ArticlesController::class, 'add'],
    '~^adminer/comments/(\d+)/edit$~' => [\MyProject\Controllers\CommentsController::class, 'editAdminer'],
    '~^adminer/comments$~' => [\MyProject\Controllers\CommentsController::class, 'viewAllCommentsAdminer'],
    '~^adminer/users$~' => [\MyProject\Controllers\UsersController::class, 'viewAllUsersAdminer'],
    //REST API
    '~^api/articles$~' => [\MyProject\Controllers\ArticlesController::class, 'APIarticlesView'],
];