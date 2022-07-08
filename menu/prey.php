<?php
    require_once(__DIR__ . '/../include.php');

    /**
     * Прописаться в усыпальнице
     */

    $room = $db->getRow('select `name`,`owner_id`,`owner_typ` from `sw_map` where `id` = ?i', $player['room']);
    $tomb = $db->getOne('select count(*) from `sw_object` where `what` = ?s and id = ?i', 'prey', $player['room']);
    if ($player['resp_room'] == $player['room']) {
        echo "<script>alert('Данная комната уже является вашей точкой появления после смерти.');</script>";
    } elseif ($tomb > 0) {
        if (
            ($room['owner_id'] == $player['id'] && $room['owner_typ'] == 0) ||
            ($room['owner_id'] == $player['clan'] && $room['owner_typ'] == 1) ||
            ) {
            $text = "window.top.add('{$chatTime}','','* Ваша точка появления после смерти изменена. *',5,'');";
            echo "<script>{$text}</script>";
            $db->query('update `sw_users` set `resp_room` = ?i where id = ?i', $player['room'], $player['id']);
            echo $player['room'];
        } else {
            echo '<script>alert(\'Вы не можете здесь прописаться.\');</script>';
        }
    } else {
        echo '<script>alert(\'Вы не можете здесь прописаться.\');</script>';
    }