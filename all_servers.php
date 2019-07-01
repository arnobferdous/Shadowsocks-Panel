<?php
include_once __DIR__. '/partials/header.php';
if(isset($_SESSION['username'], $_SESSION['password'])):
    include_once __DIR__. '/helper/common.php';
    include_once __DIR__. '/views/all_servers.php';
else:
    include_once __DIR__. '/views/login.php';
endif;

include_once __DIR__. '/partials/modals.php';
include_once __DIR__. '/partials/footer.php';
?>
<script src="assets/js/qrcode.min.js"></script>
<script src="assets/js/vpngate.js?v=1.1"></script>