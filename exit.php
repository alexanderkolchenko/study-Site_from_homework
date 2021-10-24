<?php
    session_start();
    unset($_COOKIE[session_name()]);
    unset($_COOKIE[session_id()]);
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
?>