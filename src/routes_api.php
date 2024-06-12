<?php

return [
    '~^articles/add$~' => [\MyProject\Controllers\Api\ArticlesApiController::class, 'add'],
    '~^articles/(\d+)$~' => [\MyProject\Controllers\Api\ArticlesApiController::class, 'view'],
    '~^articles$~' => [\MyProject\Controllers\Api\ArticlesApiController::class, 'viewAll'],
    '~^articles/update/(\d+)$~' => [\MyProject\Controllers\Api\ArticlesApiController::class, 'update'],
    '~^articles/delete/(\d+)$~' => [\MyProject\Controllers\Api\ArticlesApiController::class, 'delete'],
];