<?php
    require_once(realpath(__DIR__) . '/vendor/autoload.php');

    ini_set('max_execution_time', 600);
    set_time_limit(600);

    $dotenv = new Dotenv\Dotenv(realpath(__DIR__));
    $dotenv->load();

    session_start();

    header( "Content-type: text/html; charset=utf-8" );

    error_reporting(E_ALL);

    if ((bool) getenv('GAME_DEBUG') === true) {
        ini_set('display_errors', true);
        ini_set('log_errors', true);
    } else {
        ini_set('display_errors', false);
        ini_set('log_errors', false);
    }

    require_once(realpath(__DIR__) . '/mysqlconfig.php');
    require_once(realpath(__DIR__) . '/racecfg.php');

    /**
     * После перехода на более новую версию PHP (минимум 5.4)
     * TODO: Поставить библиотеку и редактировать пол и падежи
     */
    // $langHelper = new morphos\Russian\RussianLanguage;


    if  (empty($_SESSION['player'])) {
        $player_sql = $db->getRow('select * from `sw_users` where `id` = ?i', 420572);
        $object = new stdClass();
        foreach ($player_sql as $name => $value) {
            $name = strtolower(trim($name));
            if (!empty($name)) {
                $object->$name = $value;
            }
        }
        $player = $object;

        $player_max_hp =  round((6 + ($player->con + $races[$player->race]['con']) / 2) * 7) + round((($player->con + $races[$player->race]['con']) / 2 - 1) * $player->level * 2.5) + $player->level * 8;
        $player_max_mana = ($player->wis + $races[$player->race]['wis']) * 8 + round(($player->wis + $player->wis + $races[$player->race]['wis']) * $player->level / 2);

        $player_room = $db->getRow('select * from sw_map where `id` = ?i', $player->room);

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
            'leg'           => 0,
            'regen'         => $player_room['regen'],
            'room_obj'      => $player_room
        );
        $_SESSION['player'] = array_merge($player_sql, $player_arr);
    }

    $player = &$_SESSION['player'];
    if (empty($player['id'])) {
        exit();
    }

    $skill_id = empty($_GET['skill_id']) ? '' : $_GET['skill_id'];
    $put_gold = empty($_GET['put_gold']) ? '' : $_GET['put_gold'];
    $player_legs = empty($_GET['player_legs']) ? '' : $_GET['player_legs'];
    $action = empty($_GET['action']) ? '' : $_GET['action'];
    $kickto = empty($_GET['kickto']) ? '' : $_GET['kickto'];
    $t_name = empty($_GET['t_name']) ? '' : $_GET['t_name'];
    $effect = empty($_GET['effect']) ? '' : $_GET['effect'];
    $obj_id = empty($_GET['obj_id']) ? '' : $_GET['obj_id'];
    $count = empty($_GET['count']) ? '' : $_GET['count'];
    $kwho = empty($_GET['kwho']) ? '' : $_GET['kwho'];
    $t_id = empty($_GET['t_id']) ? '' : $_GET['t_id'];
    $load = empty($_GET['load']) ? '' : $_GET['load'];
    $show = empty($_GET['show']) ? '' : $_GET['show'];
    $act = empty($_GET['act']) ? '' : $_GET['act'];
    $dir = empty($_GET['dir']) ? 0 : $_GET['dir'];
    $ran = empty($_GET['ran']) ? '' : $_GET['ran'];
    $bln = empty($_GET['bln']) ? '' : $_GET['bln'];
    $num = empty($_GET['num']) ? '' : $_GET['num'];
    $no = empty($_GET['no']) ? '' : $_GET['no'];
    $do = empty($_GET['do']) ? '' : $_GET['do'];
    $id = empty($_GET['id']) ? '' : $_GET['id'];

    $chatTime = date('H:i');
    $curTime = time();
    $onlineTime = $curTime - 30;