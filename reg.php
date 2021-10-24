<?php
//session_start();
require "connection.php";


if (isset($_POST['email']) && ($_POST['email'] !== "") && isset($_POST['password']) && ($_POST['password'] !== "") && isset($_POST['login']) && ($_POST['login'] !== "")) {

    $login = $_POST['login'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    //проверка на совпадение
    $check_login = mysqli_query($connection, "SELECT * FROM `users` WHERE `login` = '$login'");
    if (mysqli_num_rows($check_login) > 0) {
        $resp = [
            "status" => false,
            "message" => "Такой логин уже существует",
        ];

        echo json_encode($resp);
        die();
    }

    $check_email = mysqli_query($connection, "SELECT * FROM `users` WHERE `email` = '$email'");
    if (mysqli_num_rows($check_email) > 0) {
        $resp = [
            "status" => false,
            "message" => "Такой email уже существует",
        ];

        echo json_encode($resp);
        die();
    }


    $query = "INSERT INTO `users` (`user_id`, `email`, `login`, `password`, `money`) VALUES (NULL, '$email', '$login', '$password', '0')";
    $result = mysqli_query($connection, $query);

    if ($result == 1) {
        $_SESSION["email"] = $email;
   
        $resp = [
            "status" => true,
        ];
        echo json_encode($resp);
    } else {
        $resp = [
            "status" => false,
            "message" => "Ошибка регистрации"
        ];

        echo json_encode($resp);
    }
    if (isset($_SESSION['email'])) {
        $_SESSION['email'] = $email;
    }
}
