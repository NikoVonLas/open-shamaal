<?php
require_once(realpath(__DIR__) . '/mysql_tools.php');

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
    mysql_select_db(getenv('DB_DATABASE_GAME'), $sqllink);
}

function SQL_query2($SQL) {
    global $sqllink;
    if (!$sqllink) {
        SQL_connect();
    };
    $SQL = removeSleepAndBenchmark($SQL);
    return mysql_query($SQL, $sqllink);
}

function SQL_query($SQL) {
    global $sqllink,$result;

    if (!$sqllink) {
        SQL_connect();
    };

    $SQL = removeSleepAndBenchmark($SQL);
    $result = mysql_query($SQL, $sqllink);

    if ($result) {
        return mysql_fetch_assoc($result);
    }
}

function SQL_query_num($SQL) {
    global $sqllink, $result;

    if (!$sqllink) {
        SQL_connect();
    };

    $SQL = removeSleepAndBenchmark($SQL);
    $result = mysql_query($SQL, $sqllink);

    if ($result) {
        return mysql_fetch_row($result);
    }
}

function SQL_do($SQL) {
    global $player;
    $SQL = str_replace("/*", "", $SQL);
    $SQL = str_replace("//", "", $SQL);
    return SQL_do_clean($SQL);
}

function SQL_do_clean($SQL) {
    global $sqllink;
    if (!$sqllink) {
        SQL_connect();
    };
    $SQL = removeSleepAndBenchmark($SQL);
    return mysql_query($SQL, $sqllink);
}

function SQL_next_num() {
    global $result;
    if (is_bool($result)) {
        return false;
    }
    return mysql_fetch_row($result);
}

function SQL_next() {
    global $result;
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

// Migration to mysqli
$db = new SafeMysql(array(
        'host' => getenv('DB_HOST_GAME'),
        'user' => getenv('DB_USERNAME_GAME'),
        'pass' => getenv('DB_PASSWORD_GAME'),
        'db' => getenv('DB_DATABASE_GAME'),
        'charset' => 'utf8')
      );
