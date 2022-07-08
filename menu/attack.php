<?php
    require_once(__DIR__ . '/../include.php');
    require(__DIR__ . '/../functions/copyobj.php');

    if ($player['sleep'] == 0) {
        if (!empty($_GET['kwho']) && $_GET['kwho'] == 1) {
            $target_id = $player['id'];
            $target_name = $player['name'];
        }

        $player_name = $player['name'];
        $player_id = $player['id'];
        $npc_kick = 0;
        $skillRow = $db->getRow('
            select `id_skill`,`sw_player_skills`.`percent` as `per`,`sw_skills`.`percent` as `per2`
            from `sw_player_skills` 
                inner join `sw_skills` on `sw_player_skills`.`id_skill` = `sw_skills`.`id`
            where (`id_skill` = ?i or id_skill = 9 or id_skill = 22 or id_skill = 14) 
                and `id_player` = ?i
        ', $_GET['skill_id'], $player['id']);

        if ($skillRow !== false) {
            /**
             * TODO: названия переменных сменить на массивы, при переделке инклюженых файлов
             */
            $s_id       = $skillRow['id_skill'];
            $skill      = $skillRow['per'];
            $s_skillall = $skillRow['per2'];
            $s_skill = round($skill / $s_skillall * 100);

            if ($s_id == 22) {
                $anatomy = $s_skill;
            } elseif ($s_id == 9) {
                $bodydeff = $s_skill;
            } elseif ($s_id == 14) {
                $posoh_skill = $s_skill;
            }

            require(__DIR__ . '/../skill.php');

            if ($_GET['skill_id'] == 0) {
                $skill = 1;
            }

            if (isset($_GET['skill_id']) && isset($_GET['num']) && ($skill_id == 0 || $game_skill_percent[$skill_id][$num] <= $skill)) {
                print "<script>";
                require(__DIR__ . '/../do_dmg.php');
                print "</script>";
            }
        }
    } else {
        print '<script>alert(\'Вы сейчас отдыхаете и поэтому не можете ничего делать.\');</script>';
    }