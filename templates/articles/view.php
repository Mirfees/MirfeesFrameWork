<?php include __DIR__ . '/../header.php'; ?>
    <h1><?= $article->getName() ?></h1>
    <p><?= $article->getText() ?></p>
    <p>Автор: <?php echo $article->getAuthor()->getNickname();  ?></p>


    <?php if (!empty($user)): ?>
    <form action="/articles/<?= $article->getId() ?>/comments" method="post">
        <label for="commentText">Оставить комментарий</label><br>
        <textarea name="commentText" id="text" rows="10" cols="80"><?= $_POST['commentText'] ?? '' ?></textarea><br>
        <br>
        <input type="submit" value="Отправить комментарий">
    </form>
        <?php if ($user->getRole() === 'admin'): ?>
        <p>
            <a href="<?= $article->getId() . '/edit'?>">Редактировать статью</a>
        </p>
        <?php endif; ?>
    <?php elseif (empty($user)): ?>
    <a href="/users/login">Войдите в аккаунт, чтобы комментировать</a>
    <?php endif; ?>

    <?php if(!empty($comments)): ?>
        <p class="comments">
            <?php foreach ($comments as $comment): ?>
                <?php $author = $comment->getAuthor(); ?>
                <p class="comment-container">
                    <strong class="name"><?= $author->getNickName(); ?></strong><br>
                    <strong class="date"><?= $comment->getPublicationDate(); ?></strong><br>
                    <p><?= $comment->getCommentText(); ?></p>
                </p>
            <?php endforeach; ?>
        </p>
    <?php endif; ?>
<?php include __DIR__ . '/../footer.php'; ?>