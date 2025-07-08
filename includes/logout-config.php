#!/usr/bin/php-cgi
<?php
session_start();
session_unset();
session_destroy();

header("Location: ../home.php");
die();