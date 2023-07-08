<?php
if(!empty($_POST['text'])) {
    date_default_timezone_set('UTC');
    $date = date('l jS \of F Y h:i:s A');
    $text = $_POST['text'];
    $handle = fopen(__DIR__ . '\\private\\feedback.txt', 'a+');
    fputs($handle, $date . PHP_EOL);
    fputs($handle, $text . PHP_EOL);
    fclose($handle);
}
?>

<html>
<head>
    <title>Обратная связь</title>
</head>
<body>
<div style="text-align: center">
    <h1>Форма обратной связи</h1>
    <form action="feedback.php" method="post">
        <label for="text">Введите ваш текст:</label><br>
        <textarea name="text" id="text" cols="55" rows="5"></textarea><br>
        <input type="submit" value="Отправить">
    </form>
</div>
</body>
</html>