<?php
    require_once(realpath(__DIR__) . '/vendor/autoload.php');

    $dotenv = new Dotenv\Dotenv(realpath(__DIR__));
    $dotenv->load();

    session_start();

    header( "Content-type: text/html; charset=utf-8" );

    error_reporting(E_ALL);
    if (getenv('GAME_DEBUG') === true) {
        ini_set('display_errors', true);
        ini_set('log_errors', true);
    } else {
        ini_set('display_errors', false);
        ini_set('log_errors', false);
    }

    $player = $_SESSION['player'];

    if (empty($player['id'])) {
        exit();
    }

    include('./mysqlconfig.php');
