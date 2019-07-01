<div class="page-header">
    <p class="text-center text-danger">
        <?php
        echo @$_SESSION['error_server']; unset($_SESSION['error_server']);
        echo @$_SESSION['error_session_expired']; unset($_SESSION['error_session_expired']);
        ?>
    </p>
    <div class="row">
        <div class="col-6">
            <h1 id="tables">All suspended users</h1>
            <small>Active users will be able to use the full VPN features.</small>
            <p>&nbsp;</p>
        </div>
        <div class="col-6 text-right pt-4">
            <a href="/" class="btn btn-outline-primary btn-link text-primary font-weight-bold">Active users</a>
        </div>
    </div>
</div>
<table class="table table-hover">
    <thead>
    <tr>
        <th scope="col">Full Name</th>
        <th scope="col">Email</th>
        <th scope="col">Phone</th>
        <th scope="col">Type</th>
        <th scope="col">Server</th>
        <th scope="col">Created at</th>
        <th scope="col">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $data = json_decode(file_get_contents(__DIR__.'/../data/users.json'));
    foreach($data as $key => $user):
        $sid = array_keys((array)$user->servers)[count((array)$user->servers) - 1];
        $server = $user->servers->{$sid};

        if($user->servers->{$sid}->status === 'inactive'):
            $server_count = count((array) $user->servers);
            ?>
            <tr class="table-light">
                <th scope="row"><?php echo $user->full_name; ?></th>
                <td><?php echo $user->email; ?></td>
                <td><?php echo $user->phone_number; ?></td>
                <td><?php echo ucfirst($user->type); ?></td>
                <?php if($server_count > 1 ): ?>
                    <td>Using <?php echo $server_count; ?> servers</td>
                    <td><?php echo date('D M d, Y @ h:m a',$user->created_at) ?></td>
                    <td>
                        <a href="/servers-active?user=<?php echo $key; ?>" class="btn btn-block btn-sm btn-success text-white">View Servers</a>
                    </td>
                <?php else:
                    $credentials = json_encode([
                        'server' =>  $server->server,
                        'port' =>  $server->port,
                        'method' =>  $server->method,
                        'password' =>  $server->password
                    ]);
                    ?>
                    <td><?php echo $server->server.'<br />('.$server->server_name.')'; ?></td>
                    <td><?php echo date('D M d, Y @ h:m a', $server->created_at); ?></td>
                    <td>
                        <button type="button" class="btn btn-sm btn-success text-white" onclick="getQRCode(this.value, this.name)" href="::javascript" name="<?php echo $server->server_name; ?>" value="<?php echo $server->sslink; ?>" data-backdrop="static" data-keyboard="false">QR</button>
                        <button type="button" class="btn btn-sm btn-dark text-white" href="::javascript" data-backdrop="static" data-keyboard="false" value="<?php echo $server->sslink.'#'.$server->server_name;?>" onclick="sslink(this.value)">SS</button>
                        <button type="button" class="btn btn-sm btn-info text-white" href="::javascript" data-backdrop="static" data-keyboard="false" value='<?php echo $credentials; ?>' onclick="getCredentials(this.value)">Credentials</button>
                        <button type="button" class="btn btn-sm btn-warning text-white" href="::javascript" name="<?php echo $key;  ?>" value="<?php echo $sid; ?>" onclick="restoreUser(this.name, this.value)">Restore</button>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endif; endforeach; ?>
    </tbody>
</table>