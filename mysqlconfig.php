<?php
require_once('./mysql_tools.php');

$sqllink = 0;
$result = 0;

function getmicrotime()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

function SQL_connect() {
    global $sqllink;
    $sqllink = mysql_connect(getenv('DB_HOST_GAME'), getenv('DB_USERNAME_GAME'), getenv('DB_PASSWORD_GAME')) or die("Could not connect");
    mysql_set_charset('utf8', $sqllink);
}

function SQL_query2($SQL) {
    global $sqllink,$result;

    if (!$sqllink) {
        SQL_connect();
    };

    $SQL = SQL_escape($SQL);
    $result = mysql_query(removeSleepAndBenchmark($SQL), $sqllink);
    return $result;
}

function SQL_query($SQL) {
    global $sqllink,$result;

    if (!$sqllink) {
        SQL_connect();
    };

    $SQL = SQL_escape($SQL);
    $result = mysql_db_query(getenv('DB_DATABASE_GAME'), removeSleepAndBenchmark($SQL), $sqllink);
    if ($result) {
        return mysql_fetch_assoc($result);
    }
}

function SQL_query_num($SQL) {
    global $sqllink, $result;

    if (!$sqllink) {
        SQL_connect();
    };

    $SQL = SQL_escape($SQL);
    $result = mysql_db_query(getenv('DB_DATABASE_GAME'), removeSleepAndBenchmark($SQL), $sqllink);
    if ($result) {
        return mysql_fetch_row($result);
    }
}

function SQL_do($SQL) {
    global $sqllink, $result, $player;
    $player_id = $player['id'];

    $SQL = str_replace("/*", "", $SQL);
    $SQL = str_replace("//", "", $SQL);
    return SQL_do_clean($SQL);
}

function SQL_do_clean($SQL) {
    global $sqllink, $result, $player;

    if (!$sqllink) {
        SQL_connect();
    };

    $SQL = SQL_escape($SQL);
    return mysql_db_query(getenv('DB_DATABASE_GAME'), removeSleepAndBenchmark($SQL), $sqllink);
}

function SQL_next_num() {
    global $sqllink, $result;

    if (is_bool($result)) {
        return false;
    }
    return mysql_fetch_row($result);
}

function SQL_next() {
    global $sqllink, $result;
    return mysql_fetch_assoc($result);
}

function SQL_disconnect() {
    global $sqllink;
    if ($sqllink) {
        mysql_close($sqllink);
    };
}

function SQL_error() {
    global $sqllink;
    return mysql_error($sqllink);
}

function SQL_free_result($result) {
    if (is_resource($result)) {
        mysql_free_result($result);
    }
}

function SQL_escape($string) {
    global $sqllink;

    if (!$sqllink) {
        SQL_connect();
    };

    return mysql_real_escape_string($string, $sqllink);
}