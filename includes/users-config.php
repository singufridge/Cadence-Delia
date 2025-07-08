#!/usr/bin/php-cgi
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'dbh.php';
    require_once 'functions.php';

    $username = htmlspecialchars($_POST['user']);
    $pwd = htmlspecialchars($_POST['pwd']);

    if (isset($_POST['adminCheck'])) {$admin = 1;} else {$admin = NULL;}

    if (uidExists($conn, $username) !== false) {
        header('location: ../admin_users.php?error=usertaken');
        exit();
    }

    createUser($conn, $username, $pwd, $admin);
    header('location: ../admin_users.php?error=none');

} else {
    header('location: ../home.php');
    exit();
};