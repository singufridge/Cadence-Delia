#!/usr/bin/php-cgi
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'dbh.php';
    require_once 'functions.php';

    $username = htmlspecialchars($_POST['user']);
    $pwd = htmlspecialchars($_POST['pwd']);
    $admin = NULL;

    if (uidExists($conn, $username) !== false) {
        header('location: ../signup.php?error=usertaken');
        exit();
    }

    createUser($conn, $username, $pwd, $admin);
    header('location: ../signup.php?error=none');

} else {
    header('location: ../signup.php');
    exit();
};