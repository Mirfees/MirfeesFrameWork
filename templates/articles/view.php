<?php include __DIR__ . '/../header.php'; ?>
    <h1><?= $article->getName() ?></h1>
    <p><?= $article->getText() ?></p>
    <p>Автор: <?php echo $article->getAuthor()->getNickname();  ?></p>
    <?php if (!empty($user)): ?>
        <?php if ($user->getRole() === 'admin'): ?>
        <p>
            <a href="<?= $article->getId() . '/edit'?>">Редактировать статью</a>
        </p>
        <?php endif; ?>
    <?php endif; ?>
<?php include __DIR__ . '/../footer.php'; ?>