﻿<?
require_once('skill.php');

$opera = 0;

$SQL="select typ from sw_obj inner join sw_stuff on sw_obj.obj=sw_stuff.id where sw_obj.owner=$player_id and room=0 and sw_stuff.obj_place=4 and sw_obj.active=1";
$row_num=SQL_query_num($SQL);
while ($row_num){
	$weptyp=$row_num[0];
	$row_num=SQL_next_num();
}
if (!empty($result))
	SQL_free_result($result);

if ($weptyp == "")
	$weptyp = 0;

$SkillText = "";
$ltyp = 0;

//if ($player_name == "Brayth")
//{
	if ($opera == 0)
		//print "window.top.createtop(-1,'Стандартные способности');"; //- Новогодние скилы
        print "window.top.createtop(0,'Стандартные способности');";
//}
//else {
//    if ($opera == 0)
//        print "window.top.createtop(0,'Стандартные способности');";
//}
	
$ltyp = "";

$count = 0;
$SQL="select name from sw_magic where owner=$player_id";
$row_num=SQL_query_num($SQL);
while ($row_num){
	$count++;
	$scroll_name[$count] = $row_num[0];
	$row_num=SQL_next_num();
}
if ($result)
SQL_free_result($result);
$tm = 0;
$SQL="select sw_skills.id,sw_skills.name,sw_player_skills.percent,sw_skills.typ from sw_skills inner join sw_player_skills on sw_skills.id=sw_player_skills.id_skill where sw_player_skills.id_player=$player_id and sw_skills.typ<>0 order by typ,id";
$row_num=SQL_query_num($SQL);
while ($row_num){
	$id=$row_num[0];
	$s_name=$row_num[1];
	$percent=$row_num[2];
	$typ=$row_num[3];
	if (empty($game_skill_num[$id])) {
		$row_num=SQL_next_num();
		continue;
	}
	if (empty($game_skill_name[$id])) {
		$game_skill_name[$id] = 'Неизвестный скилл';
	}
	if (empty($game_skill_wep[$id])) {
		$game_skill_wep[$id] = 'Без оружия';
	}

	for ($i=1;$i<=$game_skill_num[$id];$i++)
	{
		$was = 0;
		if ( ($id >16) && ($id <22) )
			for ($k = 1;$k <= $count;$k++)
			{
				if ($scroll_name[$k] == $game_skill_name[$id][$i])
				{
					$was = 1;
					break;
				}
			}
		
		if ( ( ($id <=16) || ($id >=22) ) || ($was == 1) )
		{
			$forceShow = false;
			if ($game_skill_wep[$id] == 1 && $weptyp == 20)
				$forceShow = true;
			if ($game_skill_wep[$id] == 2 && $weptyp == 21)
				$forceShow = true;
			if ($game_skill_wep[$id] == 3 && $weptyp == 22)
				$forceShow = true;
			if ($game_skill_wep[$id] == 5 && $weptyp == 23)
				$forceShow = true;
			if ($game_skill_wep[$id] == 7 && $weptyp == 24)
				$forceShow = true;
			if ($game_skill_wep[$id] == 4 && $weptyp >= 20 && $weptyp <= 24)
				$forceShow = true;
			if ( $forceShow || (($weptyp == $game_skill_wep[$id]) || ($game_skill_wep[$id] == 0)  || (($was == 1) && ($weptyp == $game_skill_wep[$id]))) || ( ($weptyp == 0) && ($game_skill_wep[$id] == 6)) )
			{
				if ($percent >= $game_skill_percent[$id][1])
				if (($s_name <> $ltyp) )
				{
					print "window.top.endtop();window.top.createtop($id,'$s_name');";
					$ltyp = $s_name;
				}
			
			
				$type = $game_skill_type[$id][$i];
				$name = $game_skill_name[$id][$i];
				if ($percent >= $game_skill_percent[$id][$i])
				print "window.top.mains($type,'$name',$id,$i);";
			}
		}
	}
	$row_num=SQL_next_num();
}
if ($ltyp <> 0)
	if ($opera == 0)
		print "window.top.endtop();";
if ($result)
	SQL_free_result($result);
?>
