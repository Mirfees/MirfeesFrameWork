<?php
/**
 * @var array $users
 * @var \MyProject\Models\Users\User $user
 */
?>

<?php include __DIR__ . '/../openDocument.php' ?>
<?php include __DIR__ . '/../head.php' ?>
<?php include __DIR__ . '/../header.php' ?>


<table class="table table-hover">
    <thead>
    <tr>
        <th scope="col">id</th>
        <th scope="col">Никнейм</th>
        <th scope="col">E-mail</th>
        <th scope="col">Дата создания</th>
        <th scope="col">Роль</th>
        <th scope="col">Редактировать</th>
        <th scope="col">Удалить</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($users)): ?>
        <?php foreach ($users as $user): ?>
            <tr>
                <th scope="row"><?= $user->getId() ?></th>
                <td><?= $user->getNickname() ?></td>
                <td><?= $user->getEmail() ?></td>
                <td><?= $user->getCreatedAt() ?></td>
                <td><?= $user->getRole() ?></td>
                <td><a href="articles/<?= $user->getId() ?>/edit">Редактировать</a></td>
                <td><a href="articles/<?= $user->getId() ?>/delete">Удалить</a></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
<a href="articles/add" class="btn btn-primary">+ Создать нового +</a>


<?php include __DIR__ . '/../footer.php' ?>
<?php include __DIR__ . '/../closeDocument.php' ?>
