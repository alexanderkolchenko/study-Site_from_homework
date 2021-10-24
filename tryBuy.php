<?php
mysqli_query($connection, "UPDATE `users` SET `money` = `money` - '$price' WHERE `email` = '$user'");

if (mysqli_affected_rows($connection) <= 0) {
    $responce = [
        "status" => false,
        "message" => "недостаточно средств"
    ];
    echo json_encode($responce);
    exit;
} else {
    $resp = [
        "status" => true,
        "ticker" => $ticker,
        "quantity" => $quantity,
        "newstock" => true
    ];
    echo json_encode($resp);
    exit;
}








