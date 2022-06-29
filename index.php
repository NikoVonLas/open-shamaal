<?php
    require_once('./vendor/autoload.php');

    $dotenv = new Dotenv\Dotenv(realpath(__DIR__));
    $dotenv->load();

    session_start();

    header('Content-type: text/html; charset=utf-8');

    error_reporting(E_ALL);
    if (getenv('GAME_DEBUG') === true) {
        ini_set('display_errors', true);
        ini_set('log_errors', true);
    } else {
        ini_set('display_errors', false);
        ini_set('log_errors', false);
    }

    $player = $_SESSION['player'];
    if (!isset($player['style'])) {
        print "
                    <html>
                        <head>
                            <meta content=\"text/html; charset=utf-8\" http-equiv=\"Content-Type\">
                        </head>
                        <title>Shamaal World</title>
                        <b>Сессия потеряна.</b>
                        <br><br>
                        Эта ошибка может возникнуть при:<br>
                        1) Открытии игры из нестандартных окон браузера (Например: при открытии Internet Explorer не через стандартное окно браузера. Для решения проблемы попробуйте зайти через стандартное окно браузера.)<br>
                        2) Отсутствии связи с сервером в связи с его недавней перезагрузкой.<br>
                    </html>
                ";
        exit();
    }

    $style = $player['style'];
    $player_name = $player['name'];

    $style = (integer) $style;
    echo <<<EOT
    <html>
        <head>
            <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
            <script type="text/javascript" src="jquery.min.js"></script>
            <script type="text/javascript" src="jquery.cookie.js"></script>
            <link rel="stylesheet" type="text/css" href="/maingame/shake/csshake.min.css">
        </head>
        <title>Shamaal World</title>
        <script>
            player_id = ${player['id']};
            player_name = '${player_name}';
            var ignor = new Array();
            ignor[0] = '1';
        </script>
        <script src="main.js?v2.1" charset=utf-8></script>
        <frameset rows="349,24,*,1" cols="*,248" framespacing=0  frameborder=0 framespacing=0>
            <frame name="mtop" src="top0.php" id="mtop" frameborder="0" scrolling="No" noresize marginwidth="0" marginheight="0">
            <frame name="info" src="info0.php" marginwidth="0" marginheight="0" scrolling=No frameborder="0">
            <frame name="mbar" src="bar0.php" frameborder="0" scrolling="No" noresize marginwidth="0" marginheight="0">
            <frame name="look" src="look0.php" marginwidth="0" marginheight="0" scrolling=No frameborder="0">
            <frame name="talk" src="talk0.php" marginwidth="0" marginheight="0" scrolling=auto frameborder="0">
            <frame name="users" src="users0.php" marginwidth="0" marginheight="0" scrolling="auto" frameborder="0">
            <frame name="ref" src="ref.php" marginwidth="0" marginheight="0" scrolling=No frameborder="0">
            <frameset  cols="33%,33%,*" framespacing=0>
                <frame name="menu" src="menu.php" marginwidth="0" marginheight="0" scrolling=No frameborder="0">
                <frame name="enter" src="enter.php" marginwidth="0" marginheight="0" scrolling=No frameborder="0">
                <frame name="emap" src="map.php" marginwidth="0" marginheight="0" scrolling=No frameborder="0">
            </frameset>
        </frameset>
    </html>
EOT;
