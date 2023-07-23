<?php
/**
 * @var array $comments
 * @var \MyProject\Models\Comments\Comment $comment
 */
?>

<?php include __DIR__ . '/../openDocument.php' ?>
<?php include __DIR__ . '/../head.php' ?>
<?php include __DIR__ . '/../header.php' ?>


<table class="table table-hover">
    <thead>
    <tr>
        <th scope="col">id</th>
        <th scope="col">Содержание</th>
        <th scope="col">Дата создания</th>
        <th scope="col">Id Автора</th>
        <th scope="col">Id Статьи</th>
        <th scope="col">Редактировать</th>
        <th scope="col">Удалить</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($comments)): ?>
        <?php foreach ($comments as $comment): ?>
            <tr>
                <th scope="row"><?= $comment->getId() ?></th>
                <td><?= strip_tags(substr($comment->getCommentText(), 0, 50) . '...')?></td>
                <td><?= $comment->getPublicationDate() ?></td>
                <td><?= $comment->getAuthorId() ?></td>
                <td><?= $comment->getArticleId() ?></td>
                <td><a href="comments/<?= $comment->getId() ?>/edit">Редактировать</a></td>
                <td><a href="/comments/<?= $comment->getId() ?>/delete">Удалить</a></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>


<?php include __DIR__ . '/../footer.php' ?>
<?php include __DIR__ . '/../closeDocument.php' ?>
