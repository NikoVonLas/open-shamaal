<?php
    require_once(__DIR__ . '/../include.php');

    if (empty($_GET['do'])) {
        /**
         * Выход из игры (старт таймера)
         */

        $pet = $db->getOne('select count(*) from `sw_pet` where `owner` = ?i and `active` != 2', $player['id']);
        if ($pet > 0 ) {
            $rg = "<br><br>Убедитесь, что ваше животное находится в конюшне, в противном случае оно может умереть от голода.";
        } else {
            $rg = '';
        }

        $arenas = $db->getAll('select `id`,`start_room`,`end_room` from `sw_arena` where `typ` = 1');
        foreach ($arenas as $arena) {
            if ($player['room'] >= $arena['start_room'] && $player['room'] <= $arena['end_room']) {
                echo "<script>window.top.ttext('Выход из игры','<table width=100% height=280><tr><Td align=center><b>Вы не можете выйти из игры.</b></td></tr></table>');</script>";
                exit();
            }
        }

        echo "<script>
            window.top.ttext('Выход из игры','<table width=100% height=280><tr><Td align=center><b>Выход из игры произойдёт автоматически через <span id=\"countdown\" >30</span> секунд. {$rg}</b></td></tr></table>');
            window.top.startExTimer(30); 
            ExitTimer = setTimeout('document.location=\'/menu.php?load=exit&do=1\'', 30000);
          </script>";

        $player['player_exit_time'] = time();
    } else {
        /**
         * Выход из игры (окончание таймера)
         */

        if ($player['player_exit_time'] > 0 && $curTime - $player['player_exit_time'] >= 30) {
            $db->query('update `sw_users` set `online` = ?i where id = ?i', $player['player_exit_time'] - 1, $player['id']);
            unset($_SESSION['player']);
            session_destroy();
            echo '<script>window.top.wclose();</script>';
        } else {
            echo '<script>setTimeout(function() { document.location=\'/menu.php?load=exit2\'; }, 1000)</script>';
        }
    }
