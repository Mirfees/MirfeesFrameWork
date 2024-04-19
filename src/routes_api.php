<?php

return [
    '~^articles/(\d+)$~' => [\MyProject\Controllers\Api\ArticlesApiController::class, 'view'],
    '~^articles$~' => [\MyProject\Controllers\Api\ArticlesApiController::class, 'viewAll'],
    '~^articles/add$~' => [\MyProject\Controllers\Api\ArticlesApiController::class, 'add'],
];