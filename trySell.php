<?php

$query = mysqli_query($connection, "UPDATE `users` SET `money` = `money` + $price WHERE `email` = '$user'");

if (mysqli_affected_rows($connection) <= 0) {
    $responce = [
        "status" => false,
        "message" => "недостаточно средств"
    ];
    echo json_encode($responce);
    exit;
} else {
    //удаление записи если осталось О
    $qS = mysqli_query($connection, "SELECT `quantity` FROM `user_stocks` WHERE `email` = '$user' AND `ticker` = '$ticker'");
    $qS = mysqli_fetch_array($qS);
    $qS  = $qS['quantity'];
    if (!$qS) {
        mysqli_query($connection, "DELETE FROM `user_stocks` WHERE `email` = '$user' AND `ticker` = '$ticker'");
        $resp = [
            "status" => true,
            "isset" => false,
            "ticker" => $ticker,
            "quantity" => $quantity
        ];
        echo json_encode($resp);
        exit;
    }
    $resp = [
        "status" => true,
        "ticker" => $ticker,
        "quantity" => $quantity
    ];
    echo json_encode($resp);
    exit;
}
