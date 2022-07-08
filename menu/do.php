<?php
    require_once(__DIR__ . '/../include.php');

    if (empty($_GET['action'])) {
        print "<script charset=utf-8>";
        include(__DIR__ . '/../war_skills.php');

        /**
         * Эликсиры
         */
        $links = '<table align="center" cellpadding="1" cellspacing="0">';
        $elixirs = $db->getAll('select `sw_stuff`.`name`, `sw_obj`.`id`, `sw_obj`.`num` from `sw_obj` inner join `sw_stuff` on `sw_obj`.`obj` = `sw_stuff`.`id` where `owner` = ?i and `room` = 0 and `sw_stuff`.`specif` = 5', $player['id']);
        foreach ($elixirs as $elixir) {
            $links .= "
                    <tr>
                        <td id=\"objfull{$elixir['id']}\">
                            <a href=\"/menu.php?load=useobj&obj_id={$elixir['id']}\" target=\"menu\" class=\"menu\">
                                <span class=\"skillname\"><b>{$elixir['name']}</b></span> 
                            </a>
                        </td>
                        <td id=\"objfull2{$elixir['id']}\" class=\"skillname\">
                            <b>
                                - <span id=\"objnum{$elixir['id']}\" class=\"skillname\">{$elixir['num']}</span>
                            </b>
                        </td>
                    </tr>";
        }
        $links .= "</table>";
        $links = json_encode($links);

        echo "window.top.dowarskills({$player['block']},{$links});</script>";
    }