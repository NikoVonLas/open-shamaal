<?php
    require_once(__DIR__ . '/../include.php');

    /**
     * Попрыгать у ёлки
     */

    $textq = array(
        'прыгает вокруг Ёлки',
        'приплясывает',
        'бросается танцевать возле Ёлки',
        'целует окружающих и заводит хоровод',
        'радостно улыбается поглядывая на Ёлку',
        'натянул(а) маску зайчика',
        'пьет за здоровье окружающих',
        'раздает окружающим подарки',
        'нетрезвой походкой обходит Ёлку по кругу',
        'напевает себе под нос песенку про зайцев',
        'напевает себе под нос песенку про Ёлочку',
        'напевает себе под нос песенку про Деда Мороза',
        'пытается оторвать бороду у Деда Мороза',
        'катается с горки'
    );

    $r = rand(0, count($textq) - 1);
    $text = "<b>{$player['name']}</b> {$textq[$r]}";

    $time = date('H:i');
    $jsptext = "window.top.add('{$time}','',{$text},5,'');";
    echo "<script>{$jsptext}</script>";

    $db->query('update `sw_users` set `mytext` = CONCAT(mytext, ?s) where `online` > ?i and `room` = ?i and `id` != ?i and npc = 0', $jsptext, $online_time, $player['room']['id'], $player['id']);