<?php
    require_once(__DIR__ . '/../include.php');

    /**
     * Выписаться из усыпальницы
     */

    if ($player['city'] == 0) {
        $cityTomb = 135;
    } else {
        $cityTomb = $db->getRow('select `dead_room` from `sw_city` where `id` = ?i', $player['city']);
        $cityTomb = $cityTomb['dead_room'];
    }

    $tomb = $db->getOne('select count(*) from `sw_object` where `what` = ?s and id = ?i', 'prey', $player['room']);
    if ($tomb > 0) {
        if ($player['resp_room'] == $player['room']) {
            $text = "window.top.add('{$chatTime}','','* Ваша точка появления после смерти изменена. *',5,'');";
            echo "<script>{$text}</script>";
            $db->query('update `sw_users` set `resp_room` = ?i where id = ?i', $cityTomb, $player['id']);
        } else {
            print '<script>alert(\'Вы не можете выписаться из этой комнаты, так как не прописаны в ней.\');</script>';
        }
    } else {
        echo '<script>alert(\'Вы не можете отсюда выписаться.\');</script>';
    }