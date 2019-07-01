<?php

/**
 * @noinspection UnusedFunctionResultInspection
 * Process server suspend request made by Ajax Call
 */

include_once __DIR__.'/../vendor/autoload.php';
include_once __DIR__.'/../helper/common.php';

use prodigyview\network\Socket;
use prodigyview\system\Security;

if(isset($_POST['uid'], $_POST['sid']) && ($_SERVER['REQUEST_METHOD'] === 'POST')) {
    $file = file_get_contents(__DIR__ . '/../data/users.json');
    $jsonP = json_decode($file);
    $jsonP->{$_POST['uid']}->servers->{$_POST['sid']}->status = 'inactive';

    file_put_contents(__DIR__ . '/../data/users.json', json_encode($jsonP));

    try {
        $socket_auth = array(
            'username' => $socket_user,
            'password' => $socket_pass,
            'port'     => $jsonP->{$_POST['uid']}->servers->{$_POST['sid']}->port,
        );

        Security::init();
        $socket = new Socket($jsonP->{$_POST['uid']}->servers->{$_POST['sid']}->server, 8650, array('connect' => true));
        $message = Security::encrypt(json_encode($socket_auth));
        $socket->send($message);

    } catch (Exception $e) {}

    return 'Successfully updated';
}