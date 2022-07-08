<?php
    require_once(__DIR__ . '/../include.php');

    if (empty($_GET['do']) || empty($_GET['id']) {
        exit();
    }

    if ($_GET['do'] == 'del') {
        $db->query('delete from `sw_magic` where `owner` = ?i and `id` = ?i', $player['id'], $_GET['id']);
    } elseif ($_GET['do'] == 'add') {
        $scroll = $db->getRow('
            select `sw_stuff`.`name`
            from `sw_obj` 
                inner join `sw_stuff` on `sw_obj`.`obj` = `sw_stuff`.`id`
            where `sw_obj`.`owner` = ?i 
                and `sw_obj`.`room` = 0 
                and `sw_stuff`.`specif` = 1 
                and `sw_obj`.`id` = ?i
        ', $player['id'], $_GET['id']);

        if ($scroll !== false) {
            $playerScrolls = $db->getOne('select count(*) from `sw_magic` where `owner` = ?i and name = ?s', $player['id'], $scroll['name']);
            if ($playerScrolls > 0) {
                echo '<script>alert(\'Такое заклинание уже есть в книге.\');</script>';
            } else {
                $playerAllScrolls = $db->getOne('select count(*) from `sw_magic` where `owner` = ?i', $player['id']);
                if ($playerAllScrolls >= round(($player['wis'] + $races[$player['race']]['wis']) / 2)) {
                    $db->query('insert into `sw_magic` (owner,name) values (?i, ?s)', $player['id'], $scroll['name']);
                    $db->query('delete from sw_obj where id = ?i', $scroll['id']);

                    echo "<script>
                        window.top.delbook({$scroll['id']},'right');
                        window.top.addbook({$db->insertId()},'{$scroll['name']}','left');
                    </script>";
                } else {
                    echo '<script>alert(\'У вас не хватает мудрости для обучения этому заклинанию.\');</script>';
                }
            }
        }
    }
