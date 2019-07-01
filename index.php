<?php
include_once __DIR__ . '/partials/header.php';
if (isset($_SESSION['username'], $_SESSION['password'])):
    include_once __DIR__ . '/helper/common.php';
    $requests = $_SERVER['REQUEST_URI'];
    switch ($requests) {
        case '/':
            include_once __DIR__ . '/views/dashboard.php';
            break;
        case '/dashboard':
            include_once __DIR__ . '/views/dashboard.php';
            break;
        case '/servers':
            include_once __DIR__ . '/views/all_servers.php';
            break;
        case '/servers-disabled':
            include_once __DIR__ . '/views/suspended_servers.php';
            break;
        case '/servers-active':
            include_once __DIR__ . '/views/active_servers.php';
            break;
        case '/servers-usage?id='.@$_GET['id'].'&ip='.@$_GET['ip']:
            include_once __DIR__ . '/views/servers_usage.php';
            break;
        case '/users-servers?user='.@$_GET['user']:
            include_once __DIR__ . '/views/active_servers.php';
            break;
        case '/suspended-users':
            include_once __DIR__ . '/views/suspended.php';
            break;
        default:
            include_once __DIR__ . '/views/404.php';
            break;
    }
else:
    include_once __DIR__ . '/views/login.php';
endif;

include_once __DIR__ . '/partials/modals.php';
include_once __DIR__ . '/partials/footer.php';