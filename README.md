[Note] Everything screwed and messed up here. But it works! This repository is under high development mode. Try at your own risk.

Shadowsocks Manager
===================
This portal enables to create and manage shadowsocks servers, nodes and users directly from web application. To make it work properly, below snippet has to be saved on a file including repositories <strong>VENDOR</strong> directory.
  * Copy code snippets
  * Save to a file
  * On server, run `` /usr/bin/php server.php & `` (Assuming that, you saved code snippets in <strong>server.php </strong> file.)
```php
<?php
include_once __DIR_ . '/vendor/autoload.php';

use prodigyview\system\Security;
use prodigyview\network\Socket;

$my_current_ip = exec("ifconfig | grep -Eo 'inet (addr:)?([0-9]*\.){3}[0-9]*' | grep -Eo '([0-9]*\.){3}[0-9]*' | grep -v '127.0.0.1'");

$server = new Socket($my_current_ip, 8650, array(
	'bind' => true,
	'listen' => true
));
echo "Server initiated... \n";

$server->startServer('', function($message) {

	Security::init();
	$message = Security::decrypt($message);

	$data = json_decode($message, true);

	if($data['username'] === 'arnob' && $data['password'] === '123123'){
		if( isset($data['port']) && isset($data['password']) && !isset($data['port_pass'])):
		        $file = file_get_contents("/etc/shadowsocks.json");
		        $json = json_decode($file);
		        unset($json->port_password->{$data['port']});
		        file_put_contents("/etc/shadowsocks.json", json_encode($json));
			shell_exec("/etc/init.d/shadowsocks restart");
			$response = 'Succeed';
		elseif(isset($data['port_pass'])):
			$file = file_get_contents("/etc/shadowsocks.json");
                        $json = json_decode($file);
                        $json->port_password->{$data['port']} = $data['port_pass'];
                        file_put_contents("/etc/shadowsocks.json", json_encode($json));
                        shell_exec("/etc/init.d/shadowsocks restart");
                        $response = 'Succeed';
		else:
			$file = file_get_contents("/etc/shadowsocks.json");
                        $json = json_decode($file);
                        $json_p_a = (array)$json->port_password;
                        $cnt = count($json_p_a);
                        $last_index = array_keys($json_p_a)[$cnt - 1];
                        $new_index = $last_index + 1;

                        $password = generateRandomString(40);
                        $json->port_password->{$new_index} = $password;
                        file_put_contents("/etc/shadowsocks.json", json_encode($json));
                        shell_exec("/etc/init.d/shadowsocks restart");
                        $portnpass = array(
                                'port'     => $new_index,
                                'password' => $password
                        );
                        $response = $portnpass;
		endif;
	} else {
		$response = array('status' => 'error', 'message' => 'Unauthenticated!');
	}

	$response =json_encode($response);
	return Security::encrypt($response);

}, 'closure');


function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
```

Port Statistics 
========================
To enable server to record port statistics, do the followings on server:

*  `apt-get update`
*  `apt-get install python-pip`
*  `pip install portstat`
*  Copy the source code from `portstat/portstat.py`
*  Clear everything Paste it into this file: `/usr/local/lib/python2.7/dist-packages/portstat/portstat.py`
*  Save and exit from file
*  `nano /etc/rc.local` : copy and paste the below snippet
```bash
    /sbin/iptables -N PORTSTAT
    /sbin/iptables -A INPUT -j PORTSTAT
    /sbin/iptables -A OUTPUT -j PORTSTAT
    /bin/bash /etc/portstat.rules
    exit 0
```
*  Install MySQL and Create a database with general credentials:
   ``` User: root, Pass: password, Database: portstat ```
*  Install python mysql.connection `pip install mysql.connector`
*  `nano /etc/portstat.conf` and paste the below snippet: **[Don't forget to define PORT Range]**
    ``` 
    [shadowsocks]
    Port=9000-9200
    Webhook=shadowsocks
    ```
*  Run `/usr/local/bin/portstat -s` to synchronize the port ranges. [This might execute if port range changes]    
*  Add this into cron: `* * * * * /usr/local/bin/portstat -u`
*  Reboot machine


Port Statistics [Caution]
==========================
If execution of `/usr/local/bin/portstat -s or portstat -u` gives `target ... something` error then manually execute bellow snippets one by one:

*  `/sbin/iptables -N PORTSTAT`
*  `/sbin/iptables -A INPUT -j PORTSTAT`
*  `/sbin/iptables -A OUTPUT -j PORTSTAT`
*  `/bin/bash /etc/portstat.rules`
