<?
function checkvar($name)
{
	global $result,$var_count,$vr_name,$vr_value,$res2;
	$res = 0;
	$res2 = -1;
	for ($k=1;$k<=$var_count;$k++)
	{
		
		if ($vr_name[$k] == $name)
		{
			$res = $vr_value[$k];
			$res2 = $vr_value[$k];
			break;
		}
	}
	return $res;
}

function checkvar_is_daily($name, $needed_value, $is_daily = false) {
    if (!$is_daily) {
        return false;
    }

    global $var_count,$vr_name,$vr_value,$vr_set_date;
    for ($k=1;$k<=$var_count;$k++)
    {
        if ($vr_name[$k] == $name)
        {
            if ($vr_set_date[$k])
            {
                // На случай если ежедневная часть квеста доступна только с 3-ого этапа, например
                if ($needed_value < $vr_value[$k])
                {
                    return strtotime(date("Y-m-d", time())) > strtotime($vr_set_date[$k]);
                }
            }
        }
    }

    return false;
}
if ( !session_is_registered("player")) {exit();}
$player_id = (integer) $player_id;
$player_room = (integer)$player_room;
//$step = (integer) $step;

$what = "";
$SQL="select sw_object.pic,sw_object.dat,sw_object.owner as owner_id,sw_object.owner_city,what,text,room,str,race,gold,bag_q,city,level from sw_object inner join sw_users on sw_object.id=sw_users.room where sw_users.id=$player_id and what='kvest'";
$row_num=SQL_query_num($SQL);
while ($row_num){
	$obj_pic=$row_num[0];
	$obj_dat=$row_num[1];
	$owner_id=$row_num[2];
	$owner_city=$row_num[3];
	$what=$row_num[4];
	$text=$row_num[5];
	$player_room=$row_num[6];
	$str=$row_num[7];
	$race=$row_num[8];
	$gold=$row_num[9];
	$bag_q=$row_num[10];
	$city=$row_num[11];
	$level=$row_num[12];
	$row_num=SQL_next_num();
}
if ($result)
	SQL_free_result($result);

if ($what == "kvest")
{
	if (!isset($step))
	{
		$SQL="select sw_kvest.id from sw_kvest left join sw_kvest_ans on sw_kvest.id=sw_kvest_ans.parent where sw_kvest.fid=$player_room order by sw_kvest.id,sw_kvest_ans.id limit 0,1";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$step = $row_num[0];
			$row_num=SQL_next_num();
		}
		if ($result)
		SQL_free_result($result);
		//print "-$SQL-";
	}
//	print "test";
	if ($step <> 0)
	{
		$i = 1;
		$k = 0;
		$do = 0;
		$last = 0;
		$menu = "&nbsp;&nbsp;&nbsp;&nbsp;<b>Варианты</b><br>";
		
		$obj = "";
		$obj_num ="";
		$obj_oid = "";
		$vr_name = "";
		$vr_value = "";
        $vr_set_date = "";
		$pets = "";
		
		$SQL="select obj,num,id from sw_obj where owner=$player_id and room=0";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$obj = $row_num[0];
			$obj_num[$obj] = $row_num[1];
			$obj_oid[$obj]= $row_num[2];
			$row_num=SQL_next_num();
		}
		if ($result)
		SQL_free_result($result);
		$var_count=0;
		$SQL="select var_name,var_value,set_date from sw_var where owner=$player_id";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$var_count++;
			$vr_name[$var_count] = $row_num[0];
			$vr_value[$var_count] = $row_num[1];
            $vr_set_date[$var_count] = $row_num[2];
			$row_num=SQL_next_num();
		}
		if ($result)
		SQL_free_result($result);
	
		$SQL= 'select type.id, pet.id from sw_pet as pet join sw_pettype as type on pet.name = type.name where pet.active != 2 and pet.owner='.$player_id;
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$pet_type = $row_num[0];
			$pet_id = $row_num[1];
			if (!isset($pets[$pet_type]))
			{
				$pets[$pet_type] = array($pet_id);
			}
			else
			{
				array_push($pets[$pet_type], $pet_id);
			}
			$row_num=SQL_next_num();
		}
		if ($result)
		SQL_free_result($result);
	
	unset($pet_id);
	unset($pet_type);

		$ok_go = 1;
//menu.php?load=kvest&step=61
		$step = (integer) $step;
		$SQL="select sw_kvest.id,sw_kvest.text,sw_kvest.give_exp,sw_kvest.give_money,sw_kvest.give_room,sw_kvest.give_obj,sw_kvest.give_objnum,sw_kvest.get_obj,sw_kvest.get_objnum,sw_kvest_ans.id as ansid,sw_kvest_ans.text as anstext,sw_kvest_ans.goto as ansgoto,sw_kvest_ans.need_level,sw_kvest_ans.need_gold,sw_kvest_ans.need_obj,sw_kvest_ans.need_objnum,sw_kvest.var_name,sw_kvest.var_value,sw_kvest_ans.var_name as var_name2,sw_kvest_ans.var_value as var_value2,sw_kvest.need_var_name,sw_kvest.need_var_value, sw_kvest.get_pettype, sw_kvest.get_petcount, sw_kvest.give_pettype, sw_kvest.give_petcount,sw_kvest_ans.need_pettype,sw_kvest_ans.need_petcount, sw_kvest.is_daily, sw_kvest_ans.is_daily as is_daily_ans from sw_kvest left join sw_kvest_ans on sw_kvest.id=sw_kvest_ans.parent where sw_kvest.fid=$player_room and sw_kvest.id=$step order by sw_kvest.id,sw_kvest_ans.id";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$talk_id = $row_num[0];
			$talk_text = $row_num[1];
			$give_exp = $row_num[2];
			$give_money = $row_num[3];
			$give_room = $row_num[4];
			$give_obj = $row_num[5];
			$give_objnum = $row_num[6];
			$get_obj = $row_num[7];
			$get_objnum = $row_num[8];
			$kv_talk_ans_id = $row_num[9];
			$kv_talk_ans_text = $row_num[10];
			$kv_talk_ans_goto = $row_num[11];
			$need_level = $row_num[12];
			$need_gold = $row_num[13];
			$need_obj = $row_num[14];
			$need_objnum = $row_num[15];
			$var = $row_num[16];
			$var_value = $row_num[17];
			$var2 = $row_num[18];
			$var_value2 = $row_num[19];
			$need_var = $row_num[20];
			$need_var_value = $row_num[21];
			$get_pettype = $row_num[22];
			$get_petcount = $row_num[23];
			$give_pettype = $row_num[24];
			$give_petcount = $row_num[25];
			$need_pettype = $row_num[26];
			$need_petcount = $row_num[27];
            $is_daily = $row_num[28];
            $is_daily_ans = $row_num[29];
//			print "if ( (($need_var == ) || (checkvar($need_var) == $need_var_value)) && (($get_obj == 0) || ($obj_num[$get_obj] >= $get_objnum)|| ( ($obj_num[$get_obj] > 0) && ($get_objnum == 99) )))";
//if ( ((Kv1 == ) || (checkvar(Kv1) == 4)) && ((299 == 0) || ( >= 1)|| ( ( > 0) && (1 == 99) )))if ( ((Kv1 == ) || (checkvar(Kv1) == 4)) && ((299 == 0) || ( >= 1)|| ( ( > 0) && (1 == 99) )))-
			if ( (($need_var == '') || (checkvar($need_var) == $need_var_value) || checkvar_is_daily($need_var, $need_var_value, $is_daily)) && (($get_obj == 0) || ($obj_num[$get_obj] >= $get_objnum)|| ( ($obj_num[$get_obj] > 0) && ($get_objnum == 99) )))
			{
//				print "ok";
				if ($last <> $talk_id)
				{
					$talk_text = str_replace("\r\n","<br>",$talk_text);
					$talk_text2 = "<table width=99% align=center height=200><tr><td height=20><b>Текст:</b></td></tr><tr><td valign=top><table width=95% align=center><tr><td><div align=justify>$talk_text</div></td></tr></table></td></tr></table>";
					$last = $talk_id;
					$doby = "";
					if ($give_exp <> 0)
					{
						$time = date("H:i");
						if ($give_exp > 0)
							$mtext = "<b>* Опыт +$give_exp *</b>";
						else
							$mtext = "<b>* Опыт $give_exp *</b>";
						$jsptext = "top.add(\"$time\",\"\",\"$mtext\",8,\"\");";
						$doby .=  ",exp=GREATEST(0, exp+$give_exp)";
						print "<script>$jsptext</script>";
					}
					
					if ($give_money <> 0)
					{
						if ($gold + $give_money < 0)
							$ok_go = 0;
						
						if ($get_objnum == 99)
							$give_money = $obj_num[$get_obj] * $give_money;
						//print "$obj_num[$get_obj]-";
						$time = date("H:i");
						
						if ($give_money > 0)
							$mtext = "* Вам было передано $give_money золотых.*";
						else
						{
							$giv_money = abs($give_money);
							$mtext = "* Вы передали $giv_money золотых.*";
						}
						$jsptext = "top.add(\"$time\",\"\",\"$mtext\",5,\"\");";
						$doby .=  ",gold=GREATEST(0, gold+$give_money)";
						if ($give_money > 0)
						{
							$SQL="INSERT INTO sw_logs (OWNER, DT, TYPE, GOLD, EXP, TEXT) VALUES ('".$player_id."', NOW(), 'QUEST', '$give_money', 0, 'Quest gold. $talk_text')";
							SQL_do($SQL);
						}

						print "<script>$jsptext</script>";
					}
					
					
				}
				
				if ($kv_talk_ans_text <> '')
				if (($gold >= $need_gold) && ($need_level <= $level))
					if (($need_obj == 0) || ($obj_num[$need_obj] >= $need_objnum) || ( ($need_objnum == 99) && ($obj_num[$need_obj] > 0)  ))
						if ($need_pettype == 0 || count($pets[$need_pettype]) >= $need_petcount)
							if (($var2 == '') || (checkvar($var2) == $var_value2) || checkvar_is_daily($var2, $var_value2, $is_daily_ans))
								if	($need_obj != 0 || $need_pettype != 0)
									$menu .= "<br><a href=# onclick=\"if (confirm(\'Вы действительно хотите совершить это действие ?\') ) { top.frames[\'menu\'].document.location = \'menu.php?load=$load&step=$kv_talk_ans_goto\';} \" class=menu2><b class=har>» $kv_talk_ans_text</b></a>";
								else
									$menu .= "<br><a href=menu.php?load=$load&step=$kv_talk_ans_goto target=menu class=menu2><b class=har>» $kv_talk_ans_text</b></a>";
			}				
			$row_num=SQL_next_num();
		}
		if ($result)
			SQL_free_result($result);
		//print "past";
		if ($doby <> "")
		{
			$doby = substr($doby,1,strlen($doby) - 1);
			$SQL="UPDATE sw_users SET $doby $and where id=$player_id";
			SQL_do($SQL);
		}
		if ( (($need_var == '') || (checkvar($need_var) == $need_var_value) || checkvar_is_daily($need_var, $need_var_value, $is_daily)) && (($get_obj == 0) || ($obj_num[$get_obj] >= $get_objnum) || ( ($get_objnum == 99) && ($obj_num[$get_obj] > 0) ) ))
		{
//			print "ok";
			if ($var <> '')
			{
				
				$a = checkvar($var);
				if ($res2 == -1)
				{
					$SQL="insert into sw_var (owner,var_name,var_value,set_date) values ($player_id,'$var',$var_value, '".date("Y-m-d")."')";
					SQL_do($SQL);
//					print "$SQL";
				}
				else
				{
					$SQL="update sw_var set var_value=$var_value, set_date='".date("Y-m-d")."' where owner=$player_id and var_name='$var'";
					SQL_do($SQL);
	//				print "$SQL";
				}
				//print "$SQL";
			}
			if ($get_obj <> 0)
			{
				if ($ok_go == 1)
				{
					if ($obj_oid[$get_obj] > 0)
					{
						if ($get_objnum == 99)
							if ($obj_num[$get_obj] > 0)
								$get_objnum = $obj_num[$get_obj];
						if ($obj_num[$get_obj] - $get_objnum > 0)
							$SQL="UPDATE sw_obj SET num=num-$get_objnum where id=$obj_oid[$get_obj]";
						else
							$SQL="delete from sw_obj where id=$obj_oid[$get_obj]";
						SQL_do($SQL);
						$mtext = "* Вы передали предмет персонажу.*";
						$jsptext = "top.add(\"$time\",\"\",\"$mtext\",5,\"\");";
						
						print "<script>$jsptext</script>";
					}
					else
						$ok_go = 0;
				}
			}
			if ($get_pettype <> 0)
			{
				if ($ok_go == 1)
				{
					if (isset($pets[$get_pettype]) && count($pets[$get_pettype]) >= $get_petcount)
					{
						$pets_to_take = array_slice($pets[$get_pettype], 0, $get_petcount);
						
						$ids_to_delete = implode(',', $pets_to_take);
						
						$SQL = "delete from sw_pet where id in ($ids_to_delete) and owner=$player_id";
						//print "<script>alert(\"$SQL\");</script>";
						SQL_do($SQL);
						
						if ($get_petcount > 1)
						{
							$mtext = "* Вы передали животных персонажу.*";
						}
						else 
						{
							$mtext = "* Вы передали животное персонажу.*";
						}
						$jsptext = "top.add(\"$time\",\"\",\"$mtext\",5,\"\");";
						
						print "<script>$jsptext</script>";
					}
					else
					{
						$ok_go = 0;
					}
				}
			}
			if ($give_obj <> 0) 
			{
				if ($ok_go == 1)
				{
					if ($give_objnum == 99)
							$give_objnum = $obj_num[$get_obj];
	
					$n = copyobj($give_obj,$player_id,$give_objnum);
					$mtext = "* Вам был передан предмет - $ob_f_name.*";
					$jsptext = "top.add(\"$time\",\"\",\"$mtext\",5,\"\");";
					
					print "<script>$jsptext</script>";
				}
			}
			if ($give_pettype <> 0) 
			{
				if ($ok_go == 1)
				{
					if ($give_petcount > 0)
					{
						$SQL = "select name,food,str,pic,min_speed,max_speed,id,loyalty,price,selling from sw_pettype where id={$give_pettype}";
						$row_num = sql_query_num( $SQL );
						while ( $row_num )
						{
							$h_name = $row_num[0];
							$h_food = $row_num[1];
							$h_str = $row_num[2];
							$h_pic = $row_num[3];
							$h_min_speed = $row_num[4];
							$h_max_speed = $row_num[5];
							$h_id = $row_num[6];
							$h_loyalty = $row_num[7];
							$h_price = $row_num[8];
							$h_selling = $row_num[9];
							$row_num = sql_next_num( );
						}
						if ( $result )
						{
							SQL_free_result( $result );
						}

						$SQL = "insert into sw_pet (name,owner,food,max_food,str,max_str,min_speed,max_speed,loyalty,pic,active,selling) values ";
						for ($i = 1; $i < $give_petcount; $i++)
						{
							$SQL .= "('{$h_name}',{$player_id},{$h_food},{$h_food},{$h_str},{$h_str},{$h_min_speed},{$h_max_speed},{$h_loyalty},'{$h_pic}',1,{$h_selling}),";
						}
						$SQL .= "('{$h_name}',{$player_id},{$h_food},{$h_food},{$h_str},{$h_str},{$h_min_speed},{$h_max_speed},{$h_loyalty},'{$h_pic}',1,{$h_selling});";
						
						sql_do( $SQL );
						
						if ($give_petcount > 1)
						{
							$mtext = "* Вам было передано несколько животных '$h_name'.*";
						}
						else
						{
							$mtext = "* Вам было передано животное '$h_name'.*";
						}
						$jsptext = "top.add(\"$time\",\"\",\"$mtext\",5,\"\");";
					
						print "<script>$jsptext</script>";
					}
				}
			}
			if ($give_room <> 0)
			{
				if ($ok_go == 1)
				{
					$time = date("H:i");
					$mtext = "* Вас перенаправили в другую комнату. *";
					$jsptext = "top.add(\"$time\",\"\",\"$mtext\",5,\"\");";
					
					$SQL="UPDATE sw_users SET room=$give_room where id=$player_id";
					SQL_do($SQL);
					print "<script>$jsptext</script>";
					//getinfo($player_id);
				}
			}
		}
		
		print "<script>top.settop('Разговор');top.city('$city_name','npc/$obj_pic','$menu','Разговор $text','$talk_text2');</script>";
	}
	else
	{
			include("functions/plinfo.php");
			include("functions/objinfo.php");
			getinfo($player_id);
	}
}
else
print "<script>alert('Функция недоступна.')</script>";
?>
