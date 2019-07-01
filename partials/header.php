<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Shadowsocks management panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="<?php echo base64_encode('https://www.vpngate.app'); ?>">
    <link rel="stylesheet" href="/assets/css/bootstrap.css" media="screen">
    <link rel="stylesheet" href="/assets/css/custom.min.css">
</head>
<body>
<div class="navbar navbar-expand-lg fixed-top navbar-dark bg-primary">
    <div class="container">
        <a href="/" class="navbar-brand">Shadowsocks CP</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <?php if(isset($_SESSION['username'], $_SESSION['password'])): ?>
            <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item mr-1">
                    <a href="/servers" class="btn btn-dark">All servers</a>
                </li>
                <li class="nav-item">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addUser">Add new user</button>
                </li>
                <li class="nav-item ml-1">
                    <a class="btn btn-warning text-white" href="/includes/logout.php">Logout</a>
                </li>
            </ul>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="container">