<?php

session_start();

if (isset($_SESSION["user_id"])) {
    $mysqli = require __DIR__ . "/db.php";

    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Главная</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Главная</h1>

    <?php if (isset($user)): ?>
    <p>Вы вошли как <i><?= htmlspecialchars($user["name"]); ?></i></p>
    <p><a href="profile.php">Профиль</a></p>
    <p><a href="logout.php">Выйти</a></p>
    <?php else: ?>
        <p><a href="login.php">ВХОД</a></p>
        <p><a href="register.html">Зарегистрироваться</a></p>
    <?php endif; ?>
</body>
</html>