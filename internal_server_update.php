<?php
include('./mysqlconfig.php');

$cur_time = time();
$internal_server_update_secure_key = getenv('SERVER_UPDATE_KEY');

include('server.php');
