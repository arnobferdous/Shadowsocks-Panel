<?php
$data = json_decode(file_get_contents(__DIR__.'/../data/users.json'));
if(isset($_GET['user'])):
    $user = $data->{$_GET['user']};
    if(!empty($user)):
        $servers = $user->servers;
?>
<div class="page-header">
    <p class="text-center text-danger">
        <?php
        echo @$_SESSION['error_server']; unset($_SESSION['error_server']);
        echo @$_SESSION['error_session_expired']; unset($_SESSION['error_session_expired']);
        ?>
    </p>
    <div class="row">
        <div class="col-6">
            <h1 id="tables">All active servers of <u><?php echo $user->full_name; ?></u></h1>
            <small>All active servers for the user is listed here.</small>
            <p>&nbsp;</p>
        </div>
        <div class="col-6 text-right pt-4">
            <a href="/dashboard" class="btn btn-outline-primary btn-link text-primary font-weight-bold">All active users</a>
            <a href="/servers-disabled?user=<?php echo $_GET['user']; ?>" class="btn btn-outline-warning btn-link text-warning font-weight-bold">Disabled servers</a>
        </div>
    </div>
</div>
<table class="table table-hover">
    <thead>
    <tr>
        <th scope="col">Server</th>
        <th scope="col">Port</th>
        <th scope="col">Password</th>
        <th scope="col">Created at</th>
        <th scope="col">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach($servers as $key => $server):
        if($server->status === 'active'): ?>
            <tr class="table-light">
                <td><?php echo $server->server_name; ?><br /><?php echo $server->server; ?></td>
                <td><?php echo $server->port; ?></td>
                <td><?php echo $server->password; ?></td>
                <?php
                    $credentials = json_encode([
                        'server' =>  $server->server,
                        'port' =>  $server->port,
                        'method' =>  $server->method,
                        'password' =>  $server->password
                    ]);
                ?>
                <td><?php echo date('D M d, Y @ h:m a', $server->created_at); ?></td>
                <td>
                    <button type="button" class="btn btn-sm btn-success text-white" onclick="getQRCode(this.value, this.name)" href="::javascript" name="<?php echo $server->server_name; ?>" value="<?php echo $server->sslink; ?>" data-backdrop="static" data-keyboard="false">QR</button>
                    <button type="button" class="btn btn-sm btn-dark text-white" href="::javascript" data-backdrop="static" data-keyboard="false" value="<?php echo $server->sslink.'#'.$server->server_name;?>" onclick="sslink(this.value)">SS</button>
                    <button type="button" class="btn btn-sm btn-info text-white" href="::javascript" data-backdrop="static" data-keyboard="false" value='<?php echo $credentials; ?>' onclick="getCredentials(this.value)">Credentials</button>
                    <button type="button" class="btn btn-sm btn-warning text-white" href="::javascript" name="<?php echo $_GET['user']; ?>" value="<?php echo $key; ?>" onclick="suspendUser(this.name, this.value)">Suspend</button>
                </td>
            </tr>
        <?php endif; endforeach; ?>
    </tbody>
</table>
<?php
        else:
            header('Location: /');
        endif;
    else:
        header('Location: /');
    endif;
?>