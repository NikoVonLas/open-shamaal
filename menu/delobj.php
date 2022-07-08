<?php
    require_once(__DIR__ . '/../include.php');

    if (empty($_GET['id'])) {
        exit();
    }

    if (empty($_GET['do'])) {
        /**
         * Подтверждение удаления предмета
         * TODO: перенести на js
         */

        $obj = $db->getRow('select `sw_stuff`.`name` from `sw_stuff` inner join `sw_obj` on `sw_stuff`.`id` = `sw_obj`.`obj` where `sw_obj`.`owner` = ?i and sw_obj.id = ?i and room = 0', $player['id'], $_GET['id']);
        if ($obj !== false) {
            echo "
                <script>
                    if (confirm('Вы действительно хотите выбросить {$obj['name']} (1 шт.)')) { 
                        document.location='/menu.php?load=delobj&do=1&id={$_GET['id']}'; 
                    }
                </script>
            ";
        }
    } else {
        /**
         * Удаление предмета
         */

        $obj = $db->getRow('select `sw_stuff`.`name`,`sw_stuff`.`stock`,`sw_obj`.`num` from `sw_stuff` inner join `sw_obj` on `sw_stuff`.`id` = `sw_obj`.`obj` where `sw_obj`.`owner` = ?i and sw_obj.id = ?i and room = 0', $player['id'], $_GET['id']);
        if ($obj !== false) {
            if (($obj['stock'] == 1) && ($obj['num'] > 1)) {
                $db->query('update `sw_obj` set `num` = `num` - 1 where `id` = ?i', $_GET['id']);
                $db->query('delete from `sw_obj` where id = ?i and num = 0', $_GET['id']);
            } else {
                $db->query('delete from `sw_obj` where id = ?i', $_GET['id']);
            }

            require(__DIR__ . '/../functions/plinfo.php');
            require(__DIR__ . '/../functions/objinfo.php');
            require(__DIR__ . '/../functions/inv.php');

            inventory($player['id']);
        }
    }
