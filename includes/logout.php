<?php

session_start();

unset($_SESSION['username'], $_SESSION['password'], $_SESSION['csrf_token_session']);
session_destroy();

header('Location: /index.php');