<?php
    include("./vendor/autoload.php");
    include("./mysqlconfig.php");

    $dotenv = new Dotenv\Dotenv(realpath(__DIR__));
    $dotenv->load();

    if ($_GET['key'] != getenv('TG_BOT_SECRET')) {
        die('');
    }

    $rest_json = file_get_contents("php://input");
    $update = json_decode($rest_json, true);
    //file_put_contents(realpath(__DIR__) . '/logs/post.log', print_r($update, 1));
    if (empty($update['message']) || $update['message']['from']['username'] == 'shamaal_bot') {
        die('');
    }

    $user_id = $update['message']['from']['id'];
    if ($update['message']['chat']['type'] == 'group') {
        $SQL = "select name, telegram_username, ban_chat from sw_users where sw_users.telegram_id = $user_id";
        $row_num = SQL_query_num($SQL);
        while ($row_num) {
            $player_name = $row_num[0];
            $username = $row_num[1];
            $ban_chat = $row_num[2];
            $row_num = SQL_next_num();
        }

        if (empty($player_name) || $ban_chat > time()) {
            sendTgApi('deleteMessage', array(
                'chat_id'       => $update['message']['chat']['id'],
                'message_id'    => $update['message']['message_id']
            ), true);
        }

        $tg_username = mb_strtolower($update['message']['from']['username']);
        if ($username !== $tg_username) {
            $SQL="update sw_users set telegram_username = \"$tg_username\" where telegram_id = $user_id";
            SQL_do($SQL);
        }
        /*  Бот может редактировать только свои сообщения, хотел чтоб автоматически ник и город подставлялись,
            но это возможно, только если сделать, чтоб все сообщения отправлялись в чат от имени бота, что неудобно.
        $request = $client->post('/' . $token . '/editMessageText', array(), array(
            'chat_id'       => $update['message']['chat']['id'],
            'message_id'    => $update['message']['message_id'],
            'text'          => $msg,
            'parse_mode'    => 'Markdown'
        ));
        */
        parseTgUpdate($update);
    } else {
        parseTgUpdate($update);
    }
    SQL_disconnect();

    function parseTgUpdate($update)
    {
		$group_chat_id 	= getenv('TG_GROUP_ID');
        $chat_id    	= $update['message']['chat']['id'];
        $chat_type  	= $update['message']['chat']['type'];
        $user_id    	= $update['message']['from']['id'];

        $text = $update['message']['text'];
        if (mb_stripos($text, '/start') !== false) {
            if ($chat_type == 'group') {
				//file_put_contents(realpath(__DIR__) . '/logs/group_id.log', print_r($update['message']['chat'], 1));
                sendTgApi('sendMessage', array(
                    'chat_id'               => $chat_id,
                    'text'                  => 'Пожалуйста, напишите в личку бота.',
                    'parse_mode'            => 'HTML',
                    'reply_to_message_id'   => $update['message']['message_id']
                ), true);
            }
            //file_put_contents(realpath(__DIR__) . '/logs/start.log', print_r(json_encode($update), 1));
            sendTgApi('sendMessage', array(
                'chat_id'       => $chat_id,
                'text'          => 'Отправьте мне ваш токен.',
                'parse_mode'    => 'HTML'
            ));
        } elseif (mb_stripos($text, '/reset') !== false) {
            $SQL="update sw_users set telegram_chat_token = NULL, telegram_id = NULL, telegram_username = NULL where telegram_id = $user_id";
            SQL_do($SQL);

            $msg = array(
                'chat_id'       => $chat_id,
                'text'          => 'Токен сброшен. Зайдите в игру, чтобы узнать новый токен, а после - наберите команду /start в личку бота.',
                'parse_mode'    => 'HTML'
            );
            if ($chat_type == 'group') {
                $msg['reply_to_message_id'] = $update['message']['message_id'];
            }
            sendTgApi('sendMessage', $msg);
        } elseif (mb_stripos($text, '/whois') !== false && !empty($update['message']['entities'])) {
            $user_id = $update['message']['from']['id'];
            foreach ($update['message']['entities'] as $entity) {
                if ($entity['type'] == 'mention') {
					$user_id = mb_substr($text, $entity['offset'] + 1, $entity['length']);
					//file_put_contents(realpath(__DIR__) . '/logs/sql.log', print_r($entity, 1));
                }
				if ($entity['type'] == 'text_mention') {
					$user_id = $entity['user']['id'];
				}
            }

            $SQL = "select sw_city.name, sw_users.name from sw_users left join sw_city on sw_city.id = sw_users.city where sw_users.telegram_id = \"$user_id\" OR sw_users.telegram_username = \"$user_id\"";
            $row_num=SQL_query_num($SQL);

            if (empty($row_num)) {
                $msg = array(
                    'chat_id'       => $chat_id,
                    'text'          => 'Игрок не найден.',
                    'parse_mode'    => 'HTML'
                );
                if ($chat_type == 'group') {
                    $msg['reply_to_message_id'] = $update['message']['message_id'];
                }
                sendTgApi('sendMessage', $msg, true);
            }

            while ($row_num) {
                $city_name = $row_num[0];
                $player_name = $row_num[1];
                $row_num = SQL_next_num();
            }

            if (empty($city_name)) {
                $city_name = 'Без города';
            }
            $msg = array(
                'chat_id'       => $chat_id,
                'text'          => '<b>[' . $city_name . '] ' . $player_name . '</b>',
                'parse_mode'    => 'HTML'
            );
            if ($chat_type == 'group') {
                $msg['reply_to_message_id'] = $update['message']['message_id'];
            }
            sendTgApi('sendMessage', $msg);
        } elseif (mb_stripos($text, 'tg_') !== false) {
            if ($chat_type == 'group') {
                sendTgApi('deleteMessage', array(
                    'chat_id'       => $chat_id,
                    'message_id'    => $update['message']['message_id']
                ), true);
                sendTgApi('sendMessage', array(
                    'chat_id'       => $chat_id,
                    'text'          => '<b>Пожалуйста, отправляйте токен в личку бота!</b>',
                    'parse_mode'    => 'HTML'
                ), true);
            }
            $SQL = "select telegram_id, ban from sw_users where telegram_chat_token = \"$text\"";
            $row_num = SQL_query_num($SQL);

            if (empty($row_num)) {
                sendTgApi('sendMessage', array(
                    'chat_id'       => $chat_id,
                    'text'          => '<b>Такого токена не существует!</b>',
                    'parse_mode'    => 'HTML'
                ), true);
            }

            while ($row_num) {
                $tg_id = $row_num[0];
                $ban = $row_num[1];
                $row_num = SQL_next_num();
            }

            if (!empty($tg_id)) {
                sendTgApi('sendMessage', array(
                    'chat_id'       => $chat_id,
                    'text'          => '<b>Этот токен уже привязан!</b>',
                    'parse_mode'    => 'HTML'
                ), true);
            }
            if (!empty($ban)) {
                sendTgApi('sendMessage', array(
                    'chat_id'       => $chat_id,
                    'text'          => '<b>Вы забанены в игре!</b>',
                    'parse_mode'    => 'HTML'
                ), true);
            }

            $tg_username = mb_strtolower($update['message']['from']['username']);
            $SQL="update sw_users set telegram_id = $user_id, telegram_username = \"$tg_username\", tg_chat_id = \"$chat_id\" where telegram_chat_token = \"$text\"";
            SQL_do($SQL);

			$link = sendTgApi('exportChatInviteLink', array(
				'chat_id'=> $group_chat_id
			));
			//file_put_contents(realpath(__DIR__) . '/logs/link.log', print_r($link, 1));
			$chat = sendTgApi('getChat', array(
				'chat_id'=> $group_chat_id
			));
			//file_put_contents(realpath(__DIR__) . '/logs/chat.log', print_r($chat, 1));
			sendTgApi('sendMessage', array(
                'chat_id'       => $chat_id,
                'text'          => "Токен установлен, чтобы начать общение - перейдите в <a href=\"{$chat['invite_link']}\">общий чат</a>.",
                'parse_mode'    => 'HTML'
            ));
        } else {
            if ($chat_type == 'group') {
                $SQL="select sw_users.city, sw_city.name, sw_users.name, sw_users.ban_chat from sw_users left join sw_city on sw_city.id=sw_users.city where sw_users.telegram_id = $user_id";
                $row_num=SQL_query_num($SQL);
                while ($row_num) {
                    $c_id=$row_num[0];
                    $city_name=$row_num[1];
                    $player_name=$row_num[2];
                    $ban_chat=$row_num[3];
                    $row_num=SQL_next_num();
                }

                if ($ban_chat < time()) {
                    if (empty($city_name)) {
                        $city_name = "Без города";
                    }

                    $time = date("H:i");
                    $text = htmlspecialchars("$text", ENT_QUOTES);
                    $text_script = "parent.add(\"$time\",\"$player_name\",\"$text \",13,\"Tg => $city_name\");";

                    $cur_time = time();
                    $online_time = $cur_time - 3600;

                    $SQL="update sw_users SET mytext=CONCAT(mytext,'$text_script') where online > $online_time and npc=0 and options & 8";
                    SQL_do($SQL);

					$tg_username = mb_strtolower($update['message']['from']['username']);
					$SQL="update sw_users SET telegram_username=\"$tg_username\" where telegram_id = $user_id";
                    SQL_do($SQL);
                }
            } elseif (!empty($update['message']['reply_to_message']) && !empty($update['message']['reply_to_message']['text']) && !empty($update['message']['text'])) {
				preg_match('/\[.+\] (?<username>[^:]+):/', $update['message']['reply_to_message']['text'], $matches);

				if (!empty($matches['username'])) {
					$chat_id = $update['message']['chat']['id'];
					$SQL = "select name, ban_chat from sw_users where sw_users.tg_chat_id = $chat_id";
			        $row_num = SQL_query_num($SQL);
			        while ($row_num) {
			            $player_name = $row_num[0];
			            $ban_chat = $row_num[2];
			            $row_num = SQL_next_num();
			        }

			        if (empty($player_name) || $ban_chat > time()) {
			            sendTgApi('deleteMessage', array(
			                'chat_id'       => $update['message']['chat']['id'],
			                'message_id'    => $update['message']['message_id']
			            ), true);
			        } else {
						$who = $matches['username'];
						$SQL="select id, name from sw_users where upper(up_name)=upper('$who')";
						$row_num=SQL_query_num($SQL);
						while ($row_num){
							$id=$row_num[0];
							$name=$row_num[1];
							$row_num=SQL_next_num();
						}
						if ($result)
							SQL_free_result($result);


						if (!empty($name)) {
							$msg = $update['message']['text'];
							$msg = htmlspecialchars("$msg", ENT_QUOTES);
							$time = date("H:i");
							$text = "parent.add(\"$time\",\"$player_name\",\"$msg\",4,\"$name\");";

							$SQL="update sw_users SET mytext=CONCAT(mytext,'$text') where id = $id and npc=0";
							SQL_do($SQL);
						}
					}
				}
            }
        }
        echo 'ok';
    }

	function sendTgApi($method, $post, $die = false)
    {
        $token  = getenv('TG_BOT_TOKEN');

        $client = new Guzzle\Http\Client('https://api.telegram.org/');
        $client->setDefaultOption('headers/Content-Type', 'application/x-www-form-urlencoded');
        $client->setDefaultOption('exceptions', false);

        $request    = $client->post('/' . $token . '/' . $method, array(), $post);
        $response   = $request->send();
        $data       = $response->json();
        //file_put_contents(realpath(__DIR__) . '/logs/response.log', print_r($data, 1));
        if ($die) {
            die('ok');
        }
		return $data['ok'] ? $data['result'] : false;
    }
