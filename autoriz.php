<?php
//session_start();
require "connection.php";


if (isset($_POST['email']) && ($_POST['email'] != "") and ($_POST['password'] != "")) {
    $email = $_POST['email'];
    $password = $_POST['password']; 

    $query = "SELECT * FROM `users` WHERE `email`= '$email' AND `password`= '$password'";

    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
    $count = mysqli_num_rows($result);
    if ($count == 1) {
       $_SESSION["email"] = $email;
        $resp = [
            "status" => true,
        ];
        echo json_encode($resp);
        exit;
    } else {
        $_SESSION["message"] = "неверный логин или пароль";
        $resp = [
            "status" => false,
            "message" => "неверный логин или пароль"
        ];
        echo json_encode($resp);
        exit;
    }
}
/* if (isset($_SESSION['email'])) {
    $_SESSION['email'] = $email;
}
 */
