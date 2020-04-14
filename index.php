<?php
require __DIR__ . '/auth.php';
$login = getUserLogin();
?>
<html>
<head>
    <title>Главная страница</title>
</head>
<body>
<?php if ($login === null): ?>
    <a href="/login.php">Авторизуйтесь</a>
<?php else: ?>
    Добро пожаловать, <?= $login ?>
    <br>
    <a href="/logout.php">Выйти</a>

    <div id="links">
        <a href="/upload.php">Загрузить фото</a><br>
        <a href="/feedback.php">Обратная связь</a><br>
    </div>

    <div id="photos">
        <?php
        $files = scandir(__DIR__ . '/uploads');
        $links = [];
        foreach ($files as $fileName) {
            if ($fileName === '.' || $fileName === '..') {
                continue;
            }
            $links[] = 'http://autorizewithcookies/uploads/' . $fileName;
        }

        foreach ($links as $link):?>
            <a href="<?= $link ?>"> <img src="<?= $link ?>" height="80px"></a>
        <?php endforeach; ?>
    </div>

<?php endif; ?>
</body>
</html>