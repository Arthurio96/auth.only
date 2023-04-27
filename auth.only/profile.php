<?php

session_start();

if (isset($_SESSION["user_id"])) {
    $mysqli = require __DIR__ . "/db.php";

    if (isset($_POST['update_profile'])) {
        if (isset($_POST['name']) && !empty($_POST['name'])) {
            echo "Имя изменено<br>";
            $sql = "UPDATE user SET
                    user.name = '{$_POST["name"]}'
                    WHERE id = {$_SESSION["user_id"]}";

            $mysqli->query($sql);
        }
    
        if (isset($_POST['phone']) && !empty($_POST['phone'])) {
            echo "Телефон изменен<br>";
            $sql = "UPDATE user SET
                    user.phone = '{$_POST["phone"]}'
                    WHERE id = {$_SESSION["user_id"]}";
            $mysqli->query($sql);
        }
    
        if (isset($_POST['email']) && !empty($_POST['email'])) {
            echo "email изменен<br>";
            $sql = "UPDATE user SET
                    user.email = '{$_POST["email"]}'
                    WHERE id = {$_SESSION["user_id"]}";

            $mysqli->query($sql);
        }
    
        if (isset($_POST['password']) && !empty($_POST['password'])) {
            echo "пароль изменен<br>";
            $sql = "UPDATE user SET
                    user.password = '{$_POST["password"]}'
                    WHERE id = {$_SESSION["user_id"]}";

            $mysqli->query($sql);
        }
    }

    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}";
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();

    echo "<p>Ваше имя: " . $user['name'] . "</p>";
    echo "<p>Ваше email: " . $user['email'] . "</p>";
    echo "<p>Ваш телефон: " . $user['phone'] . "</p>";

} else {
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Профиль</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <p><a href="logout.php">Выйти</a></p>
    <h1>Изменить данные</h1>
    <form method="POST">
        <div>
            <label for="name">Ник/имя</label>
            <input type="text" id="name" name="name">
        </div>
        <div>
            <label for="phone">Телефон</label>
            <input type="text" id="phone" name="phone">
        </div>
        <div>
            <label for="email">Почта</label>
            <input type="email" id="email" name="email">
        </div>
        <div>
            <label for="password">Пароль</label>
            <input type="password" id="password" name="password">
        </div>

        <button type="submit" name="update_profile">Изменить</button>
    </form>
</body>
</html>