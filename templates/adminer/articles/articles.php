<?php
/**
 * @var array $articles
 * @var \MyProject\Models\Articles\Article $article
 */
?>

<?php include __DIR__ . '/../openDocument.php' ?>
<?php include __DIR__ . '/../head.php' ?>
<?php include __DIR__ . '/../header.php' ?>


<table class="table table-hover">
    <thead>
    <tr>
        <th scope="col">id</th>
        <th scope="col">Название</th>
        <th scope="col">Содержание</th>
        <th scope="col">Дата создания</th>
        <th scope="col">Id Автора</th>
        <th scope="col">Редактировать</th>
        <th scope="col">Удалить</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($articles)): ?>
        <?php foreach ($articles as $article): ?>
            <tr>
                <th scope="row"><?= $article->getId() ?></th>
                <td><?= $article->getName() ?></td>
                <td><?= strip_tags(substr($article->getText(), 0, 50) . '...')?></td>
                <td><?= $article->getCreatedAt() ?></td>
                <td><?= $article->getAuthorId() ?></td>
                <td><a href="articles/<?= $article->getId() ?>/edit">Редактировать</a></td>
                <td><a href="articles/<?= $article->getId() ?>/delete">Удалить</a></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
<a href="articles/add" class="btn btn-primary">+ Создать новую +</a>


<?php include __DIR__ . '/../footer.php' ?>
<?php include __DIR__ . '/../closeDocument.php' ?>
