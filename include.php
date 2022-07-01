<?php
    require_once(realpath(__DIR__) . '/vendor/autoload.php');

    $dotenv = new Dotenv\Dotenv(realpath(__DIR__));
    $dotenv->load();

    require_once(realpath(__DIR__) . '/mysqlconfig.php');

    session_start();

    header( "Content-type: text/html; charset=utf-8" );

    error_reporting(E_ALL);
    if ((bool) getenv('GAME_DEBUG') === true) {
        ini_set('display_errors', true);
        ini_set('log_errors', true);
        ini_set('max_execution_time', 120);
        set_time_limit(120);
    } else {
        ini_set('display_errors', false);
        ini_set('log_errors', false);
    }

    if  (empty($_SESSION['player'])) {
        $player_sql = SQL_query('SELECT * FROM `sw_users` WHERE `id` = 420572');
        $object = new stdClass();
        foreach ($player_sql as $name => $value) {
            $name = strtolower(trim($name));
            if (!empty($name)) {
                $object->$name = $value;
            }
        }
        $player = $object;
        $race_con = array(0, 10, 8, 11, 12, 13);
        $race_wis = array(0, 10, 11, 11, 7, 8);
        $player_max_hp 		=  round((6 + ($player->con + $race_con[$player->race]) / 2) * 7) + round((($player->con + $race_con[$player->race]) / 2 - 1) * $player->level * 2.5) + $player->level * 8;
        $player_max_mana 	=  ($player->wis + $race_wis[$player->race]) * 8 + round(($player->wis + $player->wis + $race_wis[$player->race]) * $player->level / 2);

        $player_room = SQL_query("select * from sw_map where id={$player->room}");

        $player_arr = array(
            'maxhp' 		=> $player_max_hp,
            'maxmana' 		=> $player_max_mana,
            'chp' 			=> ($player->chp > $player_max_hp) ? $player_max_hp : $player->chp,
            'cmana' 		=> ($player->cmana > $player_max_mana) ? $player_max_mana : $player->cmana,
            'effect' 		=> '',
            'balance' 		=> 0,
            'drinkbalance' 	=> 0,
            'reboot' 		=> 0,
            'text' 			=> '',
            'target_id' 	=> '',
            'target_level' 	=> '',
            'target_name' 	=> '',
            'users' 		=> '',
            'sleep' 		=> 0,
            'show' 			=> 0,
            'online' 		=> time(),
            'afk' 			=> time(),
            'lastUpdateTime'=> time(),
            'regen'         => $player_room['regen']
        );
        $_SESSION['player'] = array_merge($player_sql, $player_arr);
    }

    $player = &$_SESSION['player'];
    if (empty($player['id'])) {
        exit();
    }

    $put_gold = empty($_GET['put_gold']) ? '' : $_GET['put_gold'];
    $player_legs = empty($_GET['player_legs']) ? '' : $_GET['player_legs'];
    $action = empty($_GET['action']) ? '' : $_GET['action'];
    $effect = empty($_GET['effect']) ? '' : $_GET['effect'];
    $obj_id = empty($_GET['obj_id']) ? '' : $_GET['obj_id'];
    $load = empty($_GET['load']) ? '' : $_GET['load'];
    $count = empty($_GET['count']) ? '' : $_GET['count'];
    $show = empty($_GET['show']) ? '' : $_GET['show'];
    $act = empty($_GET['act']) ? '' : $_GET['act'];
    $dir = empty($_GET['dir']) ? 0 : $_GET['dir'];
    $ran = empty($_GET['ran']) ? '' : $_GET['ran'];
    $bln = empty($_GET['bln']) ? '' : $_GET['bln'];
    $leg = empty($_GET['leg']) ? '' : $_GET['leg'];
    $no = empty($_GET['no']) ? '' : $_GET['no'];
    $do = empty($_GET['do']) ? '' : $_GET['do'];
    $id = empty($_GET['id']) ? '' : $_GET['id'];
