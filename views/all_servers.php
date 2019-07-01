<?php
$data = file_get_contents(__DIR__.'/../data/servers.json');
$servers = json_decode($data);
?>
<div class="page-header">
    <div class="row">
        <div class="col-6">
            <h1 id="tables">All active servers</h1>
            <small>All active servers for the user is listed here.</small>
            <p>&nbsp;</p>
        </div>
        <div class="col-6 text-right pt-4">
            <a href="/dashboard" class="btn btn-outline-primary btn-link text-primary font-weight-bold">All active users</a>
            <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#addServer">Add new server</button>
        </div>
    </div>
</div>
<table class="table table-hover">
    <thead>
    <tr>
        <th scope="col">Server Name</th>
        <th scope="col">IP</th>
        <th scope="col">FQDN</th>
        <th scope="col">Created at</th>
        <th scope="col">Actions</th>
    </tr>
    </thead>
    <tbody>
        <?php
        foreach($servers as $key => $server): ?>
            <tr class="table-light">
                <td><?php echo $server->server_name; ?></td>
                <td><?php echo $server->ip; ?></td>
                <td><?php echo $server->fqdn; ?></td>
                <td><?php echo date('D M d, Y @ h:m a', $server->created_at); ?></td>
                <td><a href="/servers-usage?id=<?php echo $key; ?>&ip=<?php echo $server->ip; ?>" class="btn btn-small btn-success">View usage</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>