<?php

$connection = mysqli_connect('127.0.0.1', 'root', 'root', 'users');

if ($connection == false) {
    echo 'no connetion';
    echo mysqli_connect_error();
    exit();
}

session_start();