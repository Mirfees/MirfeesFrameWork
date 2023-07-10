<?php
/**
 * @var \MyProject\Models\Users\User $user
 */
?>
<!DOCTYPE html>
<html lang="ru">
<?php include 'head.php' ?>
<body>

<table class="layout">
    <tr>
        <td colspan="2" class="header">
            Мой блог
        </td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: right">
            <?= !empty($user) ? 'Привет, ' . $user->getNickname() . '<a href="/users/logout"> Выйти</a>' : '<a href="/users/login">Войти</a>' . '|' . '<a href="/users/register">Зарегистрироваться</a>'?>
        </td>
    </tr>
    <tr>
        <td>