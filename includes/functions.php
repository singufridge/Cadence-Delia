#!/usr/bin/php-cgi
<?php

function uidExists($conn, $username) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($row = $result->fetch_assoc()) { //if row exists for the user
        return $row;
    } else {
        $result = false;
        return $result;
    }
    $stmt->close();
}

function createUser($conn, $username, $pwd, $admin) {
    $stmt = $conn->prepare("INSERT INTO users (username, pwd, user_admin) VALUES (?, ?, ?)");

    $pwdShift = caesarCipher($pwd, 3);

    $stmt->bind_param("ssi", $username, $pwdShift, $admin);
    $stmt->execute();
    $stmt->close();
}

function caesarCipher($text, $shift) { //function to encrypt passwords
    $result = "";
    $shift = $shift % 26;

    for ($i = 0; $i < strlen($text); $i++) {
        $char = $text[$i];
        // Check if the character is a letter
        if (ctype_alpha($char)) {
            $asciiOffset = ctype_upper($char) ? 65 : 97;
            $newChar = chr((ord($char) + $shift - $asciiOffset) % 26+ $asciiOffset);
            $result .= $newChar;
        } else {
            // If it's not a letter, leave it as is
            $result .= $char;
        }
    }
    return $result;
}

function caesarDecipher($text, $shift) { //and de-encrypt them
    $result = "";
    $shift = $shift % 26;

    for ($i = 0; $i < strlen($text); $i++) {
        $char = $text[$i];
        if (ctype_alpha($char)) {
            $asciiOffset = ctype_upper($char) ? 65 : 97;
            $newChar = chr((ord($char) - $shift - $asciiOffset + 26) % 26 + $asciiOffset);
            $result .= $newChar;
        } else {
            $result .= $char;
        }
    }
    return $result;
}

function loginUser($conn, $username, $pwd) {
    $uidExists = uidExists($conn, $username); //$uidExists will return the whole $row for the selected uid

    if ($uidExists === false) {
        header('location: ../login.php?error=usernull');
        exit();
    }

    $pwdShift = $uidExists['pwd']; //can get data from $row
    $checkPwd = caesarDecipher($pwdShift, 3);

    if ($checkPwd == $pwd) {
        session_start();

        $_SESSION['uid'] = $uidExists['user_id'];
        $_SESSION['username'] = $uidExists['username'];
        if ($uidExists['user_admin'] !== NULL) {
            $_SESSION['admin'] = $uidExists['user_admin'];
        }

        header('location: ../home.php?sync=');
    } else {
        header('location: ../login.php?error=wrongpwd');
        exit();
    }
}