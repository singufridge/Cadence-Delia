#!/usr/bin/php-cgi
<?php
$conn = new mysqli("sandcastle.cosc.brocku.ca", "jl23th", "7876683", "jl23th");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}