<?php

/**
 * Process server adding requests made by Ajax Call
 */

session_start();
include_once __DIR__.'/../helper/common.php';

if( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
    if($_SESSION['username'] === $username && $_SESSION['password'] === $password) {
        if( $_SESSION['csrf_token_session'] === $_POST['csrf_token'] ){
            $data = [
                'server_name'   =>  substr(filter_var($_POST['serverName'], FILTER_SANITIZE_STRING),0,40),
                'fqdn'          =>  $_POST['fqdn'],
                'ip'            =>  $_POST['ip'],
                'created_at'    =>  time()
            ];

            $file = file_get_contents(__DIR__ . '/../data/servers.json');
            $jsonP = json_decode($file);
            $json = (array)json_decode($file);
            $cnt = count($json);
            if($cnt === 0) {
                $new_index = 0;
            }
            else {
                $last_index = array_keys($json)[$cnt - 1];
                $new_index = $last_index + 1;
            }
            $jsonP->{$new_index} = $data;
            file_put_contents(__DIR__ . '/../data/servers.json', json_encode($jsonP));
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            $_SESSION['error_session_expired'] = 'Session expired, refresh you page and try again';
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
    } else {
        echo 'You are not logged in';
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
}