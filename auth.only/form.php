<?php

$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];   
$password = $_POST['password']; 
$password2 = $_POST['password_again'];

if (empty($name) || empty($phone) || empty($email) || empty($password) || empty($password2)){
    die("Заполните все поля");
}

if ($password !== $password2) {
    die("Пароли должны совпадать");
}

$mysqli = require __DIR__ . "/db.php";

$sql = "INSERT INTO user (name, phone, email, password)
        VALUES (?, ?, ?, ?)";
$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
    die("SQL error " . $mysqli->error);
}

$stmt->bind_param("ssss", $_POST["name"], $_POST["phone"], $_POST["email"], $_POST["password"]);

$sql = sprintf("SELECT * FROM user
                WHERE name = '%s'", $mysqli->real_escape_string($_POST["name"]));
$result = $mysqli->query($sql);
$user_name = $result->fetch_assoc();

$sql = sprintf("SELECT * FROM user
                WHERE phone = '%s'", $mysqli->real_escape_string($_POST["phone"]));
$result = $mysqli->query($sql);
$user_phone = $result->fetch_assoc();

$sql = sprintf("SELECT * FROM user
                WHERE email = '%s'", $mysqli->real_escape_string($_POST["email"]));
$result = $mysqli->query($sql);
$user_email = $result->fetch_assoc();

print_r($user);

if ($stmt->execute()) {
    header("Location: success_signup.html");
    exit();
} else {
    if (isset($user_name) && !empty($user_name)){
        echo "Пользователь с таким именем уже существует";
    } else if (isset($user_phone) && !empty($user_phone)) {
        die("Такой номер телефона уже есть!");
    } else if (isset($user_email) && !empty($user_email)) {
        die("Такая почта уже есть!");
    }
}