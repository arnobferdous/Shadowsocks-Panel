<?php

include_once __DIR__.'/../vendor/autoload.php';
include_once __DIR__.'/../helper/common.php';

use prodigyview\network\Socket;
use prodigyview\system\Security;

if(isset($_GET['ip'])) {
    Security::init();
    $socket_auth = array(
        'username'  =>  $socket_user,
        'password'  =>  $socket_pass,
        'stats'     =>  TRUE,
    );
    $socket = new Socket($_GET['ip'], 8650, array('connect' => true));
    $message = Security::encrypt(json_encode($socket_auth));
    $response = $socket->send($message);
    $response = json_decode(Security::decrypt($response));
    $socket->close();
}
?>
<div class="page-header">
    <div class="row">
        <div class="col-6">
            <h2 id="tables">Data usage for <strong><?php echo $_GET['ip']; ?></strong></h2>
            <small>All active servers for the user is listed here.</small>
            <p>&nbsp;</p>
        </div>
        <div class="col-6 text-right pt-4">
            <a href="/dashboard" class="btn btn-outline-primary btn-link text-primary font-weight-bold">All active users</a>
            <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#addServer">Add new server</button>
        </div>
    </div>
</div>
<table class="table table-hover text-center">
    <thead>
    <tr>
        <th scope="col">Listening Port</th>
        <th scope="col">Data Usage</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach($response as $using): ?>
        <tr class="table-light">
            <td><?php echo $using->port; ?></td>
            <td><?php echo formatBytes($using->data); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
