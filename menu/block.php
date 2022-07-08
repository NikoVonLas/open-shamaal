<?php
    require_once(__DIR__ . '/../include.php');

    $kick_place = array(
        'Без блока',
        'Голова',
        'Тело',
        'Руки',
        'Ноги'
    );

    if (!empty($_GET['id']) && !empty($kick_place[$_GET['id']]) && $player['block'] != $_GET['id']) {
        $player['block'] = $_GET['id'];
        $db->query('update `sw_users` SET `block` = ?i where `id` = ?i', $_GET['id'], $player['id']);
        echo "<script>
            window.top.setblock({$block},{$_GET['id']});
            window.top.add('{$chatTime}','','* Новое место блока: <b>{$kick_place[$_GET['id']]} </b> *',6,'');
        </script>";
    }