<?php

if(session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__.'/../helper/common.php';

if( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
    if ($_POST['username'] === $username && $_POST['password'] === $password) {
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        $_SESSION['csrf_token_session'] = generateRandomString(60);

        header('Location: /dashboard');
    } else {
        $_SESSION['error'] = 'Wrong credentials, try again!';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}