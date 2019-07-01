<?php

/**
 * Accepts requests made by Ajax call
 * uid = User ID, the port belongs to for that server.
 * sid = Servers data set index number of that user.
 */

include_once __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/../helper/common.php';

use prodigyview\network\Socket;
use prodigyview\system\Security;

if (($_SERVER['REQUEST_METHOD'] === 'POST') && isset($_POST['uid'], $_POST['sid'])) {
    $file = file_get_contents(__DIR__ . '/../data/users.json');
    $jsonP = json_decode($file);
    $jsonP->{$_POST['uid']}->servers->{$_POST['sid']}->status = 'active';

    file_put_contents(__DIR__ . '/../data/users.json', json_encode($jsonP));

    try {
        $socket_auth = array(
            'username' => $socket_user,
            'password' => $socket_pass,
            'port' => $jsonP->{$_POST['uid']}->servers->{$_POST['sid']}->port,
            'port_pass' => $jsonP->{$_POST['uid']}->servers->{$_POST['sid']}->password
        );

        Security::init();
        $socket = new Socket($jsonP->{$_POST['uid']}->servers->{$_POST['sid']}->server, 8650, array('connect' => true));
        $message = Security::encrypt(json_encode($socket_auth));
        $socket->send($message);

    } catch (Exception $e) {
        return error_log('Process restore: '.$e->getMessage(),3, __DIR__.'/../data/error.log');
    }
    return 'Successfully updated';
}