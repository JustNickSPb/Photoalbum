<?php
require __DIR__ . '/auth.php';
$login = getUserLogin();

if ($login !== null && !empty($_FILES['attachment'])) {
    $file = $_FILES['attachment'];

    // собираем путь до нового файла - папка uploads в текущей директории
    // в качестве имени оставляем исходное файла имя во время загрузки в браузере
    $srcFileName = $file['name'];
    $newFilePath = __DIR__ . '/uploads/' . $srcFileName;

    //Обрабатываем ошибки:
    if ($file['size'] > 8 * 1024 * 1024) {
        $error = 'Файл слишком большой!';
    } elseif ($file['error'] == UPLOAD_ERR_INI_SIZE) {
        $error = 'Я то согласен, что файл небольшой, а вот сервер считает иначе <br> Обратитесь к администратору сервера!';
    } elseif ($file['error'] == UPLOAD_ERR_PARTIAL) {
        $error = 'В процессе передачи часть файла потерялась! Попробуйте еще раз...';
    } elseif ($file['error'] == UPLOAD_ERR_NO_FILE) {
        $error = 'Не удалось загрузить файл. Он точно есть там, откуда Вы его грузите?';
    } elseif ($file['error'] == UPLOAD_ERR_NO_TMP_DIR) {
        $error = 'Не вижу временную папку для загрузки. С сервером и правами доступа все ок?';
    } elseif ($file['error'] == UPLOAD_ERR_CANT_WRITE) {
        $error = 'Не получилось записать файл на сервер. С сервером и правами доступа все ок?';
    } elseif ($file['error'] == UPLOAD_ERR_EXTENSION) {
        $error = 'Веб-мастер добаловался с расширениями PHP, какое-то из них мешает загрузить файл :(';
    } elseif (file_exists($newFilePath)) {
        $error = 'Файл с таким именем уже существует';
    } elseif (!move_uploaded_file($file['tmp_name'], $newFilePath)) {
        $error = 'Ошибка при загрузке файла';
    } else {
        $result = 'http://myproject.loc/uploads/' . $srcFileName;
        header('Location: /index.php');
    }
    $allowedExtensions = ['jpg', 'png', 'gif'];
    $extension = pathinfo($srcFileName, PATHINFO_EXTENSION);
    if (!in_array($extension, $allowedExtensions)) {
        $error = 'Загрузка файлов с таким расширением запрещена!';
    }
    $size = getimagesize($newFilePath);
    if ($size[0] > 1280 or $size[1] > 720) {
        $error = 'Разрешено загружать картинки размером не более чем 1280х720.<br>Проверьте размер загружаемой картинки и попробуйте еще раз';
    }
}


?>
<html>
<head>
    <title>Загрузка файла</title>
</head>
<body>
<?php if ($login === null): ?>
    <a href="/login.php">Авторизуйтесь</a>
<?php else: ?>
Добро пожаловать, <?= $login ?> |
<a href="/logout.php">Выйти</a>
<br>
<?php endif; ?>
<?php if (!empty($error)): ?>
    <?= $error ?>
<?php elseif (!empty($result)): ?>
    <?= $result ?>
<?php endif; ?>
<br>
<form action="/upload.php" method="post" enctype="multipart/form-data">
    <input type="file" name="attachment">
    <input type="submit">
</form>
</body>
</html>