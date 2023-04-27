<?php
$is_invalid = false;
$mysqli = require __DIR__ . "/db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $sql = sprintf("SELECT * FROM user
                    WHERE email = '%s' OR name = '%s'",
                    $mysqli->real_escape_string($_POST["name_email"]),
                    $mysqli->real_escape_string($_POST["name_email"]));
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();

    if ($user) {
        if ($_POST['password'] == $user['password']) {
            echo "Вы вошли как " . $user['name'];
            
            session_start();
            $_SESSION["user_id"] = $user["id"];

            header("Location: index.php");
            exit;
        } else {
            $is_invalid = true;
        }
    } else {
        $is_invalid = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>ВХОД</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</head>
<body>
    <h1>ВХОД</h1>

    <?php if ($is_invalid): ?>
        <em>неудачная попытка</em>
    <?php endif; ?>

    <form method="POST">
        <div>
            <label for="name_email">Почта/логин</label>
            <input type="text" id="name_email" name="name_email">
        </div>
        <div>
            <label for="password">Пароль</label>
            <input type="password" id="password" name="password">
        </div>
        <div class="g-recaptcha" data-sitekey="6LfnFL4lAAAAACxOp-54sjVkpwSbjtvQdePHqg3J"></div>
        <button type="submit" id="login" name="login">ВХОД</button>
    </form>
    <p><a href="register.html">Зарегистрироваться</a></p>
</body>
</html>

<script>
    $(document).on('click', '#login', function() {
        var response = grecaptcha.getResponse();
        if (response.length == 0) {
            alert("Докажите что вы не Робот!");
            return false;
        }
    });
</script>