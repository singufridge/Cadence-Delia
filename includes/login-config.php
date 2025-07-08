#!/usr/bin/php-cgi
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'dbh.php';
    require_once 'functions.php';

    $username = htmlspecialchars($_POST['user']);
    $pwd = htmlspecialchars($_POST['pwd']);

    loginUser($conn, $username, $pwd);
} else {
    header('location: ../login.php');
    exit();
};