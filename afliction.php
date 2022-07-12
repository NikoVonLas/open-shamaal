<?
$count = 0;
$npc_aff = '';
$player_do = '';
if ($npc_aff_bleed_time[$npccount] > $cur_time) //
{

 $dmg = -round($npc_maxhp[$npccount]*0.03);
 $text= "[<b>$npc_name[$npccount]</b>, жизни <font class=dmg>$dmg</font>]&nbsp;<i><b>$npc_name[$npccount]</b> истекает кровью.</i>";
 $ptext .= "window.top.add(\"$time\",\"\",\"$text\",5,\"\");";
 $npchp += $dmg;
}

if ($npc_aff_tree[$npccount] > $cur_time) //
{
 
 $dmg = -round($npc_maxhp[$npccount]*0.05); 
 $text= "[<b>$npc_name[$npccount]</b>, жизни <font class=dmg>$dmg</font>]&nbsp;<i>Разгневанный <b>лес</b> наносит урон обидчику.</i>";
 $ptext .= "window.top.add(\"$time\",\"\",\"$text\",5,\"\");";
 $npchp += $dmg;
// print "|test|";
}

// openscript();
//$player_do
?>
