<?php
    require_once(__DIR__ . '/../include.php');

    /**
     * Короткий отдых (привал)
     */

    if ($player['sleep'] == 1) {
        echo '<script>window.top.sleep(\'sleep.gif\');</script>';
        $player['sleep'] = 0;
    } else {
        $food = $db->getRow('
                select `sw_stuff`.`name`,`sw_obj`.`num`,`sw_obj`.`id` 
                from `sw_obj`
                inner join `sw_stuff` on `sw_obj`.`obj` = `sw_stuff`.`id`
                where `sw_obj`.`owner` = ?i
                    and `sw_obj`.`room` = 0 
                    and `sw_stuff`.`specif` = 2 
                limit 0,1
                ', $player['id']);

        if ($food !== false) {
            echo '<script>window.top.sleep(\'sleep2.gif\');</script>';
            $player['sleep'] = 1;

            $texts = array(
                'развел(а) костёр и приготовил себе покушать',
                'приготовил(а) себе покушать',
                'прилёг(ла) на привал'
            );

            $text = rand(0, count($texts) - 1);
            $text = "parent.add('$chatTime','{$player['name']}','<b>{$player['name']}</b> {$texts[$text]}',5,'');";

            if ($food['num'] > 1) {
                $db->query('update `sw_obj` SET `num` = `num` - 1 where `id` = ?i', $food['id']);
            } else {
                $db->query('delete from `sw_obj` where `id` = ?i', $food['id']);
            }

            echo "<script>{$text}</script>";

            $db->query('update `sw_users` 
                        set `mytext` = CONCAT(`mytext`, ?s) 
                        where `online` > ?i 
                        and `id` != ?i
                        and `room` = ?i
                        and `npc` = 0',
                $text, $onlineTime, $player['id'], $player['room']);
        } else {
            print '<script>alert(\'Пища в рюкзаке не найдена.\');</script>';
        }
    }
