<?php
    require_once(realpath(__DIR__) . '/vendor/autoload.php');

    $dotenv = new Dotenv\Dotenv(realpath(__DIR__));
    $dotenv->load();

    session_start();

    require_once('./mysqlconfig.php');

    $cur_time = time();
    $internal_server_update_secure_key = getenv('SERVER_UPDATE_KEY');

    require_once('server.php');
