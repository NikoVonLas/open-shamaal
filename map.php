<?
	require_once('./include.php');

	$passwd_hidden = "T13D@";
	include('functions.php');
	include("racecfg.php");

	$script = 0;
	$player_room = getroom($player['id']);
	echo <<<EOT
		<html>
			<head>
				<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
			</head>
EOT;
	include('ref_map.php');
    echo '</script>';
	echo '</html>';
	SQL_disconnect();
