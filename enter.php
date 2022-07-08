<?
require_once('./include.php');

$player_id = $player['id'];
$player_name = $player['name'];
$player_opt= $player['options'];
$player_sex = $player['sex'];
$player_pass = $player['password'];
$block = $player['block'];
$onl = $player['online'];
$drnk = $player['drunk'];
$ban_chat = $player['ban_chat'];
$cur_time=time();
$player['afk'] = $cur_time;

echo '<html>
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
</head>
';

if ($onl < $cur_time - 60)
	print "<script>alert('Связь с сервером потеряна.');</script>";
$tellto = 1;

function sendTgApi($method, $post, $die = false) {
	$token 	= getenv('TG_BOT_TOKEN');

	$client = new Guzzle\Http\Client('https://api.telegram.org/');
	$client->setDefaultOption('headers/Content-Type', 'application/x-www-form-urlencoded');
	$client->setDefaultOption('exceptions', false);

	$request 	= $client->post('/' . $token . '/' . $method, array(), $post);
	$response 	= $request->send();
	$data 		= $response->json();
	//file_put_contents(realpath(__DIR__) . '/logs/response.log', print_r($data, 1));
	if ($die) die('ok');
}

Function checkletter($text)
{
	Global $drnk, $player;
	$k = 0;
	$newtext = '';
	For ($i=0;$i<=mb_strlen($text);$i++)
	{
		$r = rand(1,40);
		if ( ($text[$i] == '-') || ($text[$i] == ' ') || ($text[$i] == '?') || ($text[$i] == '<') )
			$k = 0;
		else
			$k++;

		if ( ($drnk == 0) || ($r <  38) || ($text[$i] == " "))
		{
			if (($drnk == 0) || ($r < 36))
				$newtext = $newtext.$text[$i];
			else
				$newtext = $newtext.mb_strtoupper($text[$i]);
		}
		else
			if ($i > 7)
				$newtext .= "<font color=CC0000>?</font>";
			else
				$newtext = $newtext.$text[$i];

		if ($k > 30)
		{
			$newtext = $newtext.' ';
			$k = 0;
		}


		//print $drnk . "|";
		if ($drnk == 1)
		{

			if ($r ==  2)
				$newtext .= "<font color=CC0000>*ИК*</font>";


			$r = rand(1,250);
			if ($r == 5)
			{
				$time = date("H:i");
				$text2 = "&nbsp;Вы стали снова трезвыми.";
				$jsptext = "window.top.add(\"$time\",\"\",\"$text2\",5,\"\");";
				$player['drunk'] = 0;
				print "<script>$jsptext</script>";
			}

		}
	}
	return $newtext;
}
Function emote($text, $allow_html = false)
{
	global $online_time,$player_id,$player_name,$result;
	$SQL="select room from sw_users where id=$player_id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$room=$row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
	SQL_free_result($result);

    if (!$allow_html) {
        $text = htmlspecialchars("$text", ENT_QUOTES);
    }

	$text = checkletter($text);
	$time = date("H:i");
	$text = "parent.add(\"$time\",\"$player_name\",\"** $text ** \",6,\"\");";
	print "<script>window.top.reset();$text</script>";
	$SQL="update sw_users SET mytext=CONCAT(mytext,'$text') where online > $online_time and id <> $player_id and room=$room  and npc=0";
	SQL_do($SQL);
}
Function prtext($text)
{

	global $addn,$online_time,$player_id,$player_name,$result;
	$SQL="select room from sw_users where id=$player_id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$room=$row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
	SQL_free_result($result);
	$text = checkletter($text);
	$time = date("H:i");
	$text = "parent.add(\"$time\",\"$player_name\",\"* $text *\",8,\"\");";
	print "<script>window.top.reset();$text</script>";
	$SQL="update sw_users SET mytext=CONCAT(mytext,'$text') where online > $online_time and id <> $player_id and room=$room  and npc=0";
	SQL_do($SQL);

}

Function locprint($text)
{
	global $addn,$online_time,$player_id,$player_name,$result;
	$SQL="select room from sw_users where id=$player_id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$room=$row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
	SQL_free_result($result);
	$text = htmlspecialchars("$text", ENT_QUOTES);
	if ($text == "СТРАЖА !")
		$text = "<font color=red>СТРАЖА !</font>";
	$text = checkletter($text);
	$time = date("H:i");
	$text = "parent.add(\"$time\",\"$player_name\",\"$text \",1,\"\",\"$addn\");";
	print "<script>window.top.reset();$text</script>";
	$SQL="update sw_users SET mytext=CONCAT(mytext,'$text') where online > $online_time and id <> $player_id and room=$room  and npc=0";
	SQL_do($SQL);
}
Function cityprint($text)
{
	global $addn,$online_time,$player_id,$player_name,$result;
	$SQL="select sw_users.city,sw_city.name from sw_city inner join sw_users on sw_city.id=sw_users.city where sw_users.id=$player_id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$city_id=$row_num[0];
		$city_name=$row_num[1];
		$row_num=SQL_next_num();
	}
	if ($result)
		SQL_free_result($result);
	if ($city_name == '')
		$city_id = 0;
	$text = htmlspecialchars("$text", ENT_QUOTES);
	$text = checkletter($text);
	$time = date("H:i");
	$text = "parent.add(\"$time\",\"$player_name\",\"$text \",2,\"$city_name\",\"$addn\");";
	$m = "";
	print "<script>window.top.reset();$text</script>";
	if ($city_id == 1)
		$m = "OR (admin>0 AND admin<5 AND id <> $player_id )";
	$SQL="update sw_users SET mytext=CONCAT(mytext,'$text') where city=$city_id and online > $online_time and id <> $player_id and npc=0 $m";
	SQL_do($SQL);

}
Function magpring($text)
{
	global $online_time,$player_id,$player_name,$player_opt,$result;
	if ($player_opt & 8 )
	{
		$SQL="select sw_users.city, sw_city.name from sw_city inner join sw_users on sw_city.id=sw_users.city where sw_users.id=$player_id";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$c_id=$row_num[0];
			$city_name=$row_num[1];
			$row_num=SQL_next_num();
		}
		if ($result)
			SQL_free_result($result);
		if ($city_name == "")
			$city_name = "Без города";
		$text = htmlspecialchars("$text", ENT_QUOTES);
		$text = checkletter($text);
		$time = date("H:i");
		$text_script = "parent.add(\"$time\",\"$player_name\",\"$text \",13,\"Общий => $city_name\");";
		//print "<script>alert('Торговый канал отключён.');</script>";
		print "<script>window.top.reset();$text_script</script>";
		$SQL="update sw_users SET mytext=CONCAT(mytext,'$text_script') where online > $online_time and id <> $player_id and npc=0 and options & 8";
		SQL_do($SQL);

		//TG
		sendTgApi('sendMessage', array(
			'chat_id' 		=> getenv('TG_GROUP_ID'),
			'text'			=> '<b>[' . $city_name .'] ' . $player_name . '</b>: ' . $text,
			'parse_mode'	=> 'HTML'
		));
	}
	else
		print "<script>alert('Включите общий канал через опции в меню игры.')</script>";
	///
}

Function clanprint($text)
{
	global $addn,$online_time,$player_id,$player_name,$result;
	$SQL="select clan from sw_users where id=$player_id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$city_id=$row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
		SQL_free_result($result);
	if ($city_id > 0)
	{
		$text = htmlspecialchars("$text", ENT_QUOTES);
		$text = checkletter($text);
		$time = date("H:i");
		$text = "parent.add(\"$time\",\"$player_name\",\"$text \",7,\"Клан\",\"$addn\");";
		print "<script>window.top.reset();$text</script>";
		$SQL="update sw_users SET mytext=CONCAT(mytext,'$text') where online > $online_time and id <> $player_id and clan=$city_id  and npc=0";
		SQL_do($SQL);
	}

}
Function merprint($text)
{
	global $online_time,$player_id,$player_name,$result;
	$SQL="select city_rank,opt3,sw_position.city from sw_users left join sw_position on sw_users.city_rank=sw_position.id where sw_users.id=$player_id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$city_rank=$row_num[0];
		$opt3=$row_num[1];
		$s3=$row_num[2];
		if ($s3 == 0)
			$opt3 = 0;
		$row_num=SQL_next_num();
	}
	if ($result)
		SQL_free_result($result);

	if (($city_rank == 1) || ($opt3 == 1))
	{
		$text = htmlspecialchars("$text", ENT_QUOTES);
		$text = checkletter($text);
		$time = date("H:i");
		$text = "parent.add(\"$time\",\"$player_name\",\"$text \",9,\"Переговоры городов\");";
		print "<script>window.top.reset();$text</script>";
		$pt = '';
		$SQL="select id from sw_position where city=1 and opt3=1";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$cid=$row_num[0];
			$pt .= "or city_rank=$cid";
			$row_num=SQL_next_num();
		}
		if ($result)
			SQL_free_result($result);
		$SQL="update sw_users SET mytext=CONCAT(mytext,'$text') where online > $online_time and id <> $player_id and (city_rank=1 $pt)";
		SQL_do($SQL);
	}
}
Function mygodprint($text,$who)
{
	global $online_time,$player_id,$player_name,$result;
	$SQL="select admin from sw_users where id=$player_id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$admin=$row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
		SQL_free_result($result);
	if ($admin== 1)
	{
		$SQL="select id,name from sw_users where upper(up_name)=upper('$who')";
		$row_num=SQL_query_num($SQL);
		while ($row_num){
			$id=$row_num[0];
			$name=$row_num[1];
			$row_num=SQL_next_num();
		}
		if ($result)
			SQL_free_result($result);
		if ($name <> "")
		{
			$text = checkletter($text);
			$time = date("H:i");
			$text2 = $text;
			$text = "parent.add(\"$time\",\"\",\"$text\",11,\"$who от Бога\");";
			print "<script>window.top.reset();$text</script>";
			$text = "parent.add(\"$time\",\"\",\"$text2\",11,\"Вам от Бога\");";
			if ($id <> $player_id)
			{
				$SQL="update sw_users SET mytext=CONCAT(mytext,'$text') where online  > $online_time and id = $id  and npc=0";
				SQL_do($SQL);
			}
		}
	}
}
Function godprint($text)
{
	global $online_time,$player_id,$player_name;

	$text = htmlspecialchars("$text", ENT_QUOTES);
	$text = checkletter($text);
	$time = date("H:i:s");
	$mtext = "parent.add(\"$time\",\"$player_name\",\"$text \",10,\"Бог\");";
	print "<script>window.top.reset();$mtext</script>";
	$text = "parent.add(\"$time\",\"$player_name\",\"$text \",12,\"Богу\");";
	$SQL="update sw_users SET mytext=CONCAT(mytext,'$text') where online > $online_time and admin=1";
	SQL_do($SQL);
}
Function partyprint($text)
{
	global $addn,$online_time,$player_id,$player_name,$result;
	$SQL="select party from sw_users where id=$player_id";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$party_id=$row_num[0];
		$row_num=SQL_next_num();
	}
	if ($result)
		SQL_free_result($result);
	if ($party_id > 0)
	{
		$text = htmlspecialchars("$text", ENT_QUOTES);
		$text = checkletter($text);
		$time = date("H:i");
		$text = "parent.add(\"$time\",\"$player_name\",\"$text \",3,\"Группа\",\"$addn\");";
		print "<script>window.top.reset();$text</script>";
		if ($party_id > 0)
		{
			$SQL="update sw_users SET mytext=CONCAT(mytext,'$text') where online > $online_time and id <> $player_id and party=$party_id  and npc=0";
			SQL_do($SQL);
		}
	}

}
Function privateprint($msg,$who)
{
	global $online_time,$player_id,$player_name,$result;
	//$who = mb_strtoupper($who);
	$SQL="select id,name,tg_chat_id from sw_users where  upper(up_name)=upper('$who')";
	$row_num=SQL_query_num($SQL);
	while ($row_num){
		$id=$row_num[0];
		$name=$row_num[1];
		$chat_id=$row_num[2];
		$row_num=SQL_next_num();
	}
	if ($result)
		SQL_free_result($result);
	if ($name <> "")
	{
		$msg = htmlspecialchars("$msg", ENT_QUOTES);
		$msg = checkletter($msg);
		$time = date("H:i");
		$text = "parent.add(\"$time\",\"$player_name\",\"$msg\",4,\"$name\");";
		print "<script>window.top.reset();$text</script>";

		if ($id <> $player_id)
		{
			$SQL="update sw_users SET mytext=CONCAT(mytext,'$text') where online  > $online_time and id = $id  and npc=0";
			SQL_do($SQL);

			if (!empty($chat_id)) {
				$SQL="select sw_users.city, sw_city.name from sw_city inner join sw_users on sw_city.id=sw_users.city where sw_users.id=$player_id";
				$row_num=SQL_query_num($SQL);
				while ($row_num){
					$city=$row_num[0];
					$city_name=$row_num[1];
					$row_num=SQL_next_num();
				}
				if ($result)
					SQL_free_result($result);


				if (empty($city_name))
					$city_name = "Без города";

				sendTgApi('sendMessage', array(
					'chat_id' 		=> $chat_id,
					'text'			=> '<b>[' . $city_name .'] ' . $player_name . '</b>: ' . $msg,
					'parse_mode'	=> 'HTML'
				));
			}
		}
	}

}
function noChat()
{
	$text = "<b>Вы всем надоели, отдохните.</b>";
	$time = date("H:i");
	$text = "<script>parent.add(\"$time\",\"$player_name\",\"** $text ** \",6,\"\");window.top.reset();</script>";
	print "$text";
}

$cur_time = time();
$online_time = $cur_time-40;

$found = 0;
$SQL="select ban, level from sw_users where id=$player_id";
$row_num=SQL_query_num($SQL);
while ($row_num){
  	$found = 1;
	$ban=$row_num[0];
	$player_level = $row_num[1];
	$row_num=SQL_next_num();
}
if ($result)
	SQL_free_result($result);
if ($found == 0 || $ban > $cur_time)
	exit();

if ($load == 'block')
{
	$kick_place[1] = 'Голова';
	$kick_place[2] = 'Тело';
	$kick_place[3] = 'Руки';
	$kick_place[4] = 'Ноги';
	if ( ($kick_place[$id] <> "") && ($block <> $id) )
	{
		$player['block'] = $id;
		$SQL="update sw_users SET block=$id where id=$player_id";
		SQL_do($SQL);
		$time = date("H:i");
		print "<script>window.top.setblock($block,$id);window.top.add('$time','','* Новое место блока: <b>$kick_place[$id] </b> *',6,'');</script>";
	}
}
else
if (isset($ebar) && !empty($ebar))
	if (mb_strlen($ebar) < 400) {
		$ebar = str_replace("'","`",$ebar);
		$ebar = str_replace('"',"`",$ebar);
		$func = mb_substr($ebar, 0, 1);
		if ($func == '/') {
			if (mb_strpos($ebar, ' ') === false) {
				$sym = '';
				$comm = $ebar;
			} else {
				$sym = ' ';
				$comm = mb_substr($ebar, 0, mb_strpos($ebar, $sym));
				$param[0] = mb_substr($ebar, mb_strpos($ebar, $sym) + 1, mb_strlen($ebar) - mb_strpos($ebar, $sym));
			}
		}

			if (($comm == "/город") || (mb_strtoupper($comm) == "/CITY"))
			{
				$ebar = $param[0];
				$tellto = 2;
			}
			/*if (($ebar == "/стража") || ($ebar == "!"))
			{
				$SQL="select city,room,target from sw_users where id=$player_id";
				$row_num=SQL_query_num($SQL);
				while ($row_num){
					$city_id=$row_num[0];
					$player_room=$row_num[1];
					$target=$row_num[2];
					$row_num=SQL_next_num();
				}
				if ($result)
					SQL_free_result($result);
				if ($city_id != 0)
				{
				$itid = 0;
				$SQL="select id from sw_users where madecity=$city_id and npc=1 and lastcity<$cur_time-120 limit 0,1";
				$row_num=SQL_query_num($SQL);
				while ($row_num){
					$itid=$row_num[0];
					$row_num=SQL_next_num();
				}
				if ($result)
					SQL_free_result($result);

				if ($itid > 0)
				{
					$it_city = -1;
					$it_npc = -1;
					$SQL="select city,npc,room from sw_users where id=$target and online>$online_time";
					$row_num=SQL_query_num($SQL);
					while ($row_num){
						$it_city=$row_num[0];
						$it_npc=$row_num[1];
						$it_room=$row_num[2];
						$row_num=SQL_next_num();
					}
					if ($result)
						SQL_free_result($result);

					if ( ($it_city >= 0) && ($it_city <> $city_id) && ($it_npc == 0) && ($it_room == $player_room))
					{
						$its_city = 0;
						$SQL="select city from sw_location inner join sw_map on sw_map.location=sw_location.id where sw_map.id=$player_room";
						$row_num=SQL_query_num($SQL);
						while ($row_num){
							$its_city=$row_num[0];
							$row_num=SQL_next_num();
						}
						if ($result)
							SQL_free_result($result);
						if ($its_city == $city_id)
						{
							$ebar = "СТРАЖА !";
							$tellto = 1;
							$SQL="update sw_users set lastcity=$cur_time,room=$player_room,target=$target where id=$itid and madecity=$city_id and npc=1";
	//						print "$SQL";
							SQL_do($SQL);
						}
						else
						{
							$ebar = '';
							$time = date("H:i");
							$text = "Для того чтобы вызвать стражу необходимо находиться пределах города.";
							$text = "parent.add(\"$time\",\"$player_name\",\"$text\",6,\"$name\");";
							print "<script>$text</script>";
						}
					}
					else
					{
						$ebar = '';
						$time = date("H:i");
						$text = "Никто в комнате не нарушал закона города.";
						$text = "parent.add(\"$time\",\"$player_name\",\"$text\",6,\"$name\");";
						print "<script>$text</script>";
					}
				}
				else
					{
						$ebar = '';
						$time = date("H:i");
						if ($city_id > 0)
							$text = "Все стражники вашего города сейчас заняты и не могут вам помочь.";
						else
							$text = "Вы не можете вызывать стражу, так как не состоите не в одном из городов.";
						$text = "parent.add(\"$time\",\"$player_name\",\"$text\",6,\"$name\");";
						print "<script>$text</script>";
					}
				}
			}*/
			if (($comm == "/группа") || (mb_strtoupper($comm) == "/PARTY"))
			{
				$ebar = $param[0];
				$tellto = 3;
			}
			if (($comm == "/клан") || (mb_strtoupper($comm) == "/CLAN"))
			{
				$ebar = $param[0];
				$tellto = 4;
			}
			if (($comm == "/приват") || (mb_strtoupper($comm) == "/PRIVATE"))
			{
				$ebar = $param[0];
				$comm = mb_substr($ebar, 0, mb_strpos($ebar, " "));
				$param[0] = mb_substr($ebar, mb_strpos($ebar, " ") + 1, mb_strlen($ebar)-mb_strpos($ebar, " "));
				$ebar = $param[0];
				$tellto = 5;
			}
		if (mb_strtoupper($ebar) == "/CUR")
		{

			$ebar = "";
			$tellto = 0;
			$time = date("H:i");
			$SQL="select sw_map.name,sw_map.id from sw_map inner join sw_users on sw_users.room=sw_map.id where sw_users.id=$player_id";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$n_name=$row_num[0];
				$n_id=$row_num[1];
				$row_num=SQL_next_num();
			}
			if ($result)
				SQL_free_result($result);
			$text = "<b>Комната:</b> $n_name. <b>Номер:</b> $n_id";
			$text = "parent.add(\"$time\",\"\",\"$text\",7,\"Сервер\");";
			print "<script>window.top.reset();$text</script>";
		}

		if (mb_strtoupper($comm) == "/TESTBOT")
		{

			$tellto = 0;
			$time = date("H:i");
			$ebar = $param[0];
			$a = mb_strpos($ebar, " ");
			$param[1] = mb_substr($ebar, mb_strpos($ebar, " ") + 1, mb_strlen($ebar)-mb_strpos($ebar, " "));

			$ebar = "";
			if ($param[0]  != "")
			{
				$where = "upper(up_name)=upper('$param[0]');";

				$player_id = (integer) $player_id;
				$n_admin = -1;
				$SQL="select admin from sw_users where id=$player_id and decodepwd='$player_pass'";
				$row_num=SQL_query_num($SQL);
				while ($row_num){
					$n_admin=$row_num[0];
					$row_num=SQL_next_num();
				}
				if ($result)
					SQL_free_result($result);

				if (($n_admin == 1) || ($n_admin == 4))
 				{
					$SQL="select id, level from sw_users where $where";
					$row_num=SQL_query_num($SQL);
					while ($row_num){
						$n_id=$row_num[0];
						$n_level=$row_num[1];
						$row_num=SQL_next_num();
					}
					if ($result)
						SQL_free_result($result);

					if(isset($n_id))
					{
						$text = "<b>Проверка на бот пользователя:</b> $param[0] .";

						$SQL="update sw_users set admin_text=CONCAT(admin_text,'$time [$player_name]: $text<br>') where id=$n_id";
						SQL_do($SQL);
						if($n_level<=9)
						{
							$SQL="update sw_users set test_bot=room, room=5181 where id=$n_id";
							SQL_do($SQL);
						}
						else
						{
							$SQL="update sw_users set test_bot=room, room=5180 where id=$n_id";
							SQL_do($SQL);
						}
					}
					else
						$text = "<b>Пользователь не найден.</b>";


					$text = "parent.add(\"$time\",\"\",\"$text\",7,\"Сервер\");";
					print "<script>window.top.reset();$text</script>";

				}
			}
		}
		if (mb_strtoupper($comm) == "/HOME") {
			$player_id 	= (integer) $_SESSION['player']['id'];
			$n_admin 	= -1;
			$n_clan 	= -1;
			$ebar 		= '';

			$SQL		= "select admin, clan from sw_users where id=$player_id";
			$row_num	= SQL_query_num($SQL);
			while ($row_num){
				$n_admin = $row_num[0];
				$n_clan  = $row_num[1];
				$row_num = SQL_next_num();
			}
			if ($result) {
				SQL_free_result($result);
			}

			if ($n_admin > 0 || $n_clan == 9687722) {
				$text 	= '<b>Телепорт в резиденцию Инквизиции.</b>';
				$SQL	= "update sw_users set admin_text=CONCAT(admin_text,'$time [$player_name]: $text<br>') where id=$player_id";
				SQL_do($SQL);
				$SQL	= "update sw_users set room=5753 where id=$player_id";
				SQL_do($SQL);

				$text = "* Вас перенаправили в другую комнату. *";
				$text = "parent.add(\"$time\",\"\",\"$text\",5,\"\");";

				print "<script>window.top.reset();$text</script>";
			}
		}

		if (mb_strtoupper($comm) == "/TP")
		{
			$tellto = 0;
			$time = date("H:i");
			$ebar = $param[0];
			$a = mb_strpos($ebar, " ");

			$ebar = "";
			if (!empty($param[0])) {
				$player_id = (integer) $_SESSION['player']['id'];
				$n_admin = -1;
				$SQL="select admin from sw_users where id=$player_id";
				$row_num=SQL_query_num($SQL);
				while ($row_num){
					$n_admin=$row_num[0];
					$row_num=SQL_next_num();
				}
				if ($result) {
					SQL_free_result($result);
				}

				if ($n_admin > 0) {
					if (is_numeric($param[0])) {
						$SQL="select `name`, `id` from `sw_map` where `id` = {$param[0]}";
						$row_num=SQL_query_num($SQL);
						while ($row_num){
							$n_name=$row_num[0];
							$n_id=$row_num[1];

							$row_num=SQL_next_num();
						}
						if ($result) {
							SQL_free_result($result);
						}

						if(isset($n_id))
						{
							$text = "<b>Телепорт в комнату:</b> $n_name<b> номер:  </b>($n_id)";
							$SQL="update sw_users set admin_text=CONCAT(admin_text,'$time [$player_name]: $text<br>') where id=$player_id";
							SQL_do($SQL);
							$SQL="update sw_users set room=$n_id where id=$player_id";
							SQL_do($SQL);
						} else {
							$text = "<b>Комната не найдена.</b>";
						}
					} elseif (is_string($param[0])) {
						$where = "upper(up_name)=upper('$param[0]');";
						$SQL="select sw_map.name,sw_map.id from sw_map right join sw_users on sw_users.room=sw_map.id where $where";
						$row_num=SQL_query_num($SQL);
						while ($row_num){
							$n_name=$row_num[0];
							$n_id=$row_num[1];

							$row_num=SQL_next_num();
						}
						if ($result) {
							SQL_free_result($result);
						}

						if(isset($n_id))
						{
							$text = "<b>Телепорт к пользователю:</b> $param[0] <b>, в комнату </b>$n_name<b> номер:  </b>($n_id)";
							$SQL="update sw_users set admin_text=CONCAT(admin_text,'$time [$player_name]: $text<br>') where id=$player_id";
							SQL_do($SQL);
							$SQL="update sw_users set room=$n_id where id=$player_id";
							SQL_do($SQL);
						} else {
							$text = "<b>Пользователь не найден.</b>";
						}
					} else {
						die();
					}

					$text = "parent.add(\"$time\",\"\",\"$text\",7,\"Сервер\");";
					print "<script>window.top.reset();$text</script>";
				}
			}
		}
		if ($comm == "/отбога")
		{
			$ebar = $param[0];
			$comm = mb_substr($ebar, 0, mb_strpos($ebar, " "));
			$param[0] = mb_substr($ebar, mb_strpos($ebar, " ") + 1, mb_strlen($ebar)-mb_strpos($ebar, " "));
			$ebar = $param[0];
			$tellto = 8;
		}
		if ($comm == "/бог")
		{
			$ebar = $param[0];
			$tellto = 7;
		}
		if (($ebar == "/время") || ($ebar == "/Время")|| ($ebar == "/time")|| ($ebar == "/Time"))
		{
			$timename[11]= "Полдень"; $timename[12]= "Полдень";
			$timename[13]= "День";$timename[14]= "День";$timename[15]= "День";$timename[16]= "День";
			$timename[17]= "Вечер"; $timename[18]= "Вечер";
			$timename[19]= "Закат"; $timename[20]= "Закат";
			$timename[21]= "Сумерки"; $timename[22]= "Сумерки";
			$timename[23]= "Полночь"; $timename[0]= "Полночь";
			$timename[1]= "Ночь"; $timename[2]= "Ночь";
			$timename[3]= "Время мёртвого сна"; $timename[4]= "Время мёртвого сна";
			$timename[5]= "Восход"; $timename[6]= "Восход";
			$timename[7]= "Раннее утро"; $timename[8]= "Раннее утро";
			$timename[9]= "Утро"; $timename[10]= "Утро";
			$ebar = "";
			$time = date("H:i");
			$file = fopen("weather.dat","r");
			$H = fgets($file,10);
			$H = str_replace("\r","",$H);
			$H = str_replace("\n","",$H);
			$id = fgets($file,10);
			fclose($file);
			$SQL="select smalltext from sw_weather where id=$id";
			$row_num=SQL_query_num($SQL);
			while ($row_num){
				$text=$row_num[0];
				$row_num=SQL_next_num();
			}
			if ($result)
				SQL_free_result($result);
			$text = "<b>* $timename[$H]. $text * </b>";
			$text = "parent.add(\"$time\",\"\",\"$text\",6,\"\");";
			print "<script>window.top.reset();$text</script>";
		}
		if (($comm == "/переговоры") || ($comm == "/Переговоры"))
		{
			$ebar = $param[0];
			$tellto = 6;
		}
		if ($comm == "/общий")
		{
			$ebar = $param[0];
			$tellto = 9;
		}
		if ($ebar == "/croom")
		{
			$admin = -1;
			include('broom1.php');
			$ebar = '';
		}
        if (($comm == '/random' || $ebar == '/random') || ($comm == '/случайность' || $ebar == '/случайность'))
        {
            $ebar = $param[0];
            $tellto = 11;
        }

		$param[0] = mb_substr($ebar, mb_strpos($ebar, " ") + 1, mb_strlen($ebar)-mb_strpos($ebar, " "));

		$pos1 = mb_strpos(" ".$ebar,"/*");
		$pos2 = mb_strpos(" ".$ebar,"*/");

		if (($pos1 > 0) && ($pos1 < $pos2))
		{

			$emote = mb_substr($ebar, $pos1+1, $pos2 - $pos1-2);
			$ebar = str_replace("/*$emote*/","",$ebar);
			$emote = htmlspecialchars($emote, ENT_QUOTES);
			$addn = "$emote";
		}
		else
			$addn = "";

		if (mb_strpos(" ".$ebar, "/me") > 0)
		{
			$tellto = 10;
			$ebar = str_replace("/me",$player_name,$ebar);
		}


		if ($ebar <> "")
		{
//			if ($player_level < 1)
//			{
//				$time = date("H:i");
//				$text = 'parent.add("'.$time.'","'.$player_name.'","Вы не можете отправлять сообщения пока не достигнете 1-ого уровня",8,"");';
//				print '<script>window.top.reset();'.$text.'</script>';
//				exit();
//			}

			if ($tellto == 1)
			{
				if ( ($ebar == "=)") || ($ebar == ":)") || ($ebar == "-)"))
				{
					if ($player_sex == 1)
						emote("$player_name улыбнулся.");
					else
						emote("$player_name улыбнулась.");
				}
				else if ( ($ebar == "=(") || ($ebar == ":(") || ($ebar == "-("))
				{
					if ($player_sex == 1)
						emote("$player_name выглядит огорчённым.");
					else
						emote("$player_name выглядит огорчённой.");
				}
				else if ( ($ebar == ":D") || ($ebar == ":d"))
				{
					if ($player_sex == 1)
						emote("$player_name выглядит довольным.");
					else
						emote("$player_name выглядит довольной.");
				}
				else if ( ($ebar == ":P") || ($ebar == ":p"))
				{
					if ($player_sex == 1)
						emote("$player_name высунул язык.");
					else
						emote("$player_name высунула язык.");
				}
				else if ( ($ebar == ":o") || ($ebar == ":0") || ($ebar == ":O") || ($ebar == ":О")|| ($ebar == ":о"))
						emote("$player_name удивлённо смотрит на окружающих.");
				else if ( ($ebar == "Да") || ( $ebar == "угу") || ($ebar == "ага")|| ( $ebar == "Угу") || ($ebar == "Ага")|| ($ebar == "да") )
						emote("$player_name утвердительно кивает головой.");
				else if ( ( $ebar == "Нет") || ($ebar == "нет") || ($ebar == "Неа"))
						emote("$player_name отрицательно мотает головой.");
				else if ( ( $ebar == "Привет") || ($ebar == "привет") )
						emote("$player_name приветственно машет рукой.");
				elseif($ban_chat <= time())  {
					locprint($ebar);
				}

			}
			if(($tellto == 2 || $tellto == 3 || $tellto == 4 || $tellto == 5 || $tellto == 6 || $tellto == 7 || $tellto == 9 || $tellto == 8) && $ban_chat > time())
			{
				noChat();
			}
			else
			{
				if ($tellto == 2)
					cityprint($ebar);
				if ($tellto == 3)
					partyprint($ebar);
				if ($tellto == 4)
					clanprint($ebar);
				if ($tellto == 6)
					merprint($ebar);
				if ($tellto == 7)
					godprint($ebar);
				if ($tellto == 9)
					magpring($ebar);
				if ($tellto == 8)
					if (($comm <> "") && ($ebar <> ""))
						mygodprint($ebar,$comm);
			}

			if ($tellto == 5)
				if (($comm <> "") && ($ebar <> ""))
					privateprint($ebar,$comm);
			if ($tellto == 10)
				emote($ebar);

            if ($tellto == 11)
            {
                $roll_max = 100;
                if (intval($ebar) > 1)  // 1 default for objects (arrays, strings)
                {
                    $roll_max = intval($ebar);
                }

                $roll = rand(1, $roll_max);

                emote("Случайность (1 - $roll_max): <b>$player_name</b> загадывает число <b>$roll</b>", true);
            }
		}
	}
		print "</html>";
SQL_disconnect();
?>
