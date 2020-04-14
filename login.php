<?php
/*
setcookie('login', $login, 0, '/');
setcookie('password', $password, 0, '/');
if (!empty($_COOKIE)) {
    require __DIR__ . '/auth.php';
    if (isset($_COOKIE['login'])) {
        $login = $_COOKIE['login'];
    } else {
        // присваиваем $login значение '' если $_COOKIE['login'] равен NULL
        $login = '';
    }
    if (isset($_COOKIE['password'])) {
        $password = $_COOKIE['password'];
    } else {
        // присваиваем $password значение '' если $_COOKIE['password'] равен NULL
        $password = '';
    }

    $password = $_COOKIE['password'];
    if (checkAuth($login, $password)) {

        header('Location: /autorization/index.php');
    } else {
        $error = 'Ошибка авторизации';
    }
}
*/
/* Версия прошлой копипасты:

require __DIR__ . '/auth.php';
if (isset($_COOKIE['login'])) {
    $login = $_COOKIE['login'];
} else {
    // присваиваем $login значение '' если $_COOKIE['login'] равен NULL
    $login = '';
}
if (isset($_COOKIE['password'])) {
    $password = $_COOKIE['password'];
} else {
    // присваиваем $password значение '' если $_COOKIE['password'] равен NULL
    $password = '';
}

if (checkAuth($login, $password)) {
    header('Location: /index.php');
}
*/
/* Изначальная версия из поста:
*/
if (!empty($_POST)) {
    require __DIR__ . '/auth.php';

    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';

    if (checkAuth($login, $password)) {
        setcookie('login', $login, 0, '/');
        setcookie('password', $password, 0, '/');
        header('Location: /index.php');
    } else {
        $error = 'Ошибка авторизации';
    }
}

if (!empty($_COOKIE)) {
    require __DIR__ . '/auth.php';
    if (isset($_COOKIE['login'])) {
        $login = $_COOKIE['login'];
    } else {
        // присваиваем $login значение '' если $_COOKIE['login'] равен NULL
        $login = '';
    }
    if (isset($_COOKIE['password'])) {
        $password = $_COOKIE['password'];
    } else {
        // присваиваем $password значение '' если $_COOKIE['password'] равен NULL
        $password = '';
    }

    $password = $_COOKIE['password'];
    if (checkAuth($login, $password)) {
        header('Location: /index.php');
    }
}
?>
<html>
<head>
    <title>Форма авторизации</title>
</head>
<body>

<?php if (isset($error)): ?>
<span style="color: red;">
    <?= $error ?>
</span>
<?php endif; ?>


<form action="/login.php" method="post">
    <label for="login">Имя пользователя: </label><input type="text" name="login" id="login">
    <br>
    <label for="password">Пароль: </label><input type="password" name="password" id="password">
    <br>
    <input type="submit" value="Войти">
</form>


</body>
</html>