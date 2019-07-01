<?php
/**
 * Process user add request made by Ajax Call
 * @noinspection JsonDecodeUsageInspection
 */

session_start();

include_once __DIR__.'/../vendor/autoload.php';
include_once __DIR__.'/../helper/common.php';

use prodigyview\network\Socket;
use prodigyview\system\Security;

if( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
    if($_SESSION['username'] === $username && $_SESSION['password'] === $password) {
        if( $_SESSION['csrf_token_session'] === $_POST['csrf_token'] ){

            if( $_POST['server'] === 'all' ):

                $data = [
                    'full_name' =>  $_POST['full_name'],
                    'email' =>  $_POST['email'],
                    'phone_number' =>  $_POST['phone_number'],
                    'type' =>  $_POST['type'],
                    'servers' =>  new stdClass(),
                    'created_at' =>  time(),
                    'status' => 'active'
                ];

                $file = file_get_contents(__DIR__ . '/../data/users.json');
                $jsonP = json_decode($file);
                $json = (array) json_decode($file);
                $cnt = count($json);

                if($cnt === 0) {
                    $new_index = 0;
                }
                else {
                    $last_index = array_keys($json)[$cnt - 1];
                    $new_index = $last_index + 1;
                }

                $jsonP->{$new_index} = $data;
                file_put_contents(__DIR__ . '/../data/users.json', json_encode($jsonP));

                $file = file_get_contents(__DIR__ . '/../data/servers.json');
                $jsonS = json_decode($file);

                $sid = 0; $all_servers = []; $downservers = [];

                foreach ($jsonS as $key => $server ) {
                    $ip = filter_var($server->ip, FILTER_VALIDATE_IP);
                    try{
                        Security::init();
                        $socket_auth = array('username' => $socket_user,'password' => $socket_pass);
                        $socket = new Socket($ip, 8650, array('connect' => true));
                        $message = Security::encrypt(json_encode($socket_auth));
                        $response = $socket->send($message);
                        $response = json_decode(Security::decrypt($response));
                        $socket->close();
                    } catch (Exception $e) {}

                    $ss = 'ss://'.base64_encode("chacha20:{$response->password}@{$server->ip}:{$response->port}");

                    $all_servers = [
                        $sid    =>  [
                            'server' =>  $server->ip,
                            'server_name' =>  $server->server_name,
                            'port' =>  $response->port,
                            'password' =>  $response->password,
                            'method' => 'chacha20',
                            'sslink' =>  $ss,
                            'created_at' =>  time(),
                            'status' => 'active'
                        ]
                    ];

                    $file = file_get_contents(__DIR__ . '/../data/users.json');
                    $jsonP = json_decode($file);
                    $jsonP->{$new_index}->servers->{$sid} = $all_servers[$sid];
                    file_put_contents(__DIR__ . '/../data/users.json', json_encode($jsonP));
                    $sid++;
                }
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            else:
                $server = explode('|',$_POST['server']);
                $server_ip = $server[0];
                $server_name = $server[1];

                try {
                    $socket_auth = array('username' => $socket_user,'password' => $socket_pass);
                    Security::init();
                    $socket = new Socket($server_ip, 8650, array('connect' => true));
                    $message = Security::encrypt(json_encode($socket_auth));
                    $response = $socket->send($message);
                    $response = json_decode(Security::decrypt($response));
                    $socket->close();

                    $ss = 'ss://'.base64_encode("chacha20:{$response->password}@{$server_ip}:{$response->port}");

                    $data = [
                        'full_name' =>  $_POST['full_name'],
                        'email' =>  $_POST['email'],
                        'phone_number' =>  $_POST['phone_number'],
                        'type' =>  $_POST['type'],
                        'servers' =>  new stdClass(),
                        'created_at' =>  time(),
                        'status' => 'active'
                    ];

                    $file = file_get_contents(__DIR__ . '/../data/users.json');
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
                    file_put_contents(__DIR__ . '/../data/users.json', json_encode($jsonP));

                    $all_servers = [
                        0    =>  [
                            'server' =>  $server_ip,
                            'server_name' =>  $server_name,
                            'port' =>  $response->port,
                            'password' =>  $response->password,
                            'method' => 'chacha20',
                            'sslink' =>  $ss,
                            'created_at' =>  time(),
                            'status' => 'active'
                        ]
                    ];

                    $file = file_get_contents(__DIR__ . '/../data/users.json');
                    $jsonP = json_decode($file);
                    $jsonP->{$new_index}->servers->{0} = $all_servers[0];
                    file_put_contents(__DIR__ . '/../data/users.json', json_encode($jsonP));
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                } catch(Exception $e){
                    $_SESSION['error_server'] = 'Something went wrong. Check, if socket is running on server <b>' .$server_ip. '</b>';
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                }
            endif;
        } else {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    } else {
        die('You are not logged in!');
    }
}