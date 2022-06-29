<?php
function addparametr()
{
    global $param,$player_id,$race_str,$race_dex,$race_int,$race_wis,$race_con,$result;
    $param = (integer) $param;
    $p=array();
    $p[1] = 'str';
    $p[2] = 'dex';
    $p[3] = 'intt';
    $p[4] = 'wis';
    $p[5] = 'con';
    $par = $p[$param];
    if ($par <> '') {
        $SQL="select h_up from sw_users where id=$player_id";
        $row_num=SQL_query_num($SQL);
        while ($row_num) {
            $h_up=$row_num[0];
            $row_num=SQL_next_num();
        }
        if ($result) {
            SQL_free_result($result);
        }
        if ($h_up > 0) {
            $h_up--;
            $SQL="UPDATE sw_users SET $par=$par+1,h_up=$h_up where id=$player_id";
            SQL_do($SQL);
            getinfo($player_id);
        }
    }
}

function removeparametr()
{
    global $param,$player_id,$race_str,$race_dex,$race_int,$race_wis,$race_con,$result;
    $param = (integer) $param;
    $p = array(
        1 => 'str',
        2 => 'dex',
        3 => 'intt',
        4 => 'wis',
        5 => 'con'
    );
    $p_need = array(
        1 => 'need_str',
        2 => 'need_dex',
        3 => 'need_int',
        4 => 'need_wis',
        5 => 'need_con'
    );
    $par = $p[$param];
    $need_par = $p_need[$param];
    if ($par <> '') {
        $SQL="select h_down,str,dex,intt,wis,con from sw_users where id=$player_id";
        $row_num=SQL_query_num($SQL);
        while ($row_num) {
            $h_down=$row_num[0];
            $pl_stats = array(
                1 => $row_num[1],
                2 => $row_num[2],
                3 => $row_num[3],
                4 => $row_num[4],
                5 => $row_num[5]
            );
            $row_num=SQL_next_num();
        }
        if ($result) {
            SQL_free_result($result);
        }
        $pl_stat = $pl_stats[$param] - 1;
        if ($h_down > 0) {
            $h_down--;
            $SQL="UPDATE sw_users SET $par=$par-1,h_down=$h_down,h_up=h_up+1 where id=$player_id";
            SQL_do($SQL);
            $SQL="UPDATE `sw_obj` AS `so` LEFT JOIN `sw_stuff` AS `ss` ON `so`.`obj` = `ss`.`id` SET `so`.`active` = 0 WHERE `ss`.`$need_par` > $pl_stat WHERE `so`.`owner` = $player_id";
            SQL_do($SQL);
            getinfo($player_id);
        }
    }
}
