<?php
    require_once(__DIR__ . '/../include.php');

    if (!empty($_GET['t_id']) && $player['target_id'] != $_GET['t_id']) {
        $target = $db->getRow('select `level`,`name` from `sw_users` where id = ?i', $_GET['t_id']);
        if ($target !== false) {
            $player['target_id'] = $_GET['t_id'];
            $player['target_level'] = $target['level'];
            $player['target_name'] = $target['name'];
            print "<script>window.top.settarget('{$target['name']}','{$target['level']}');</script>";
        }
    }