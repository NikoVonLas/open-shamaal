<?php
    require_once('./include.php');

    echo <<<EOT
    <html>
        <head>
            <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
            <script type="text/javascript" src="/assets/js/jquery.min.js"></script>
            <script type="text/javascript" src="/assets/js/jquery.cookie.js"></script>
            <link rel="stylesheet" type="text/css" href="/assets/css/csshake.min.css">
        </head>
        <title>Shamaal World</title>
        <script>
            player_id = {$player['id']};
            player_name = '{$player['name']}';
            var ignor = new Array();
            ignor[0] = '1';
        </script>
        <script src="/assets/js/main.js?v2.1" charset=utf-8></script>
        <frameset rows="349,24,*,1" cols="*,248" framespacing="0"  frameborder="0" framespacing="0">
            <frame name="mtop" src="/frames/top.php" id="mtop" frameborder="0" scrolling="no" noresize marginwidth="0" marginheight="0">
            <frame name="info" src="/frames/info.php" marginwidth="0" marginheight="0" scrolling="no" frameborder="0">
            <frame name="mbar" src="/frames/bar.php" frameborder="0" scrolling="No" noresize marginwidth="0" marginheight="0">
            <frame name="look" src="/frames/look.php" marginwidth="0" marginheight="0" scrolling="no" frameborder="0">
            <frame name="talk" src="/frames/talk.php" marginwidth="0" marginheight="0" scrolling="auto" frameborder="0">
            <frame name="users" src="/frames/users.php" marginwidth="0" marginheight="0" scrolling="auto" frameborder="0">
            <frame name="ref" src="ref.php" marginwidth="0" marginheight="0" scrolling="no" frameborder="0">
            <frameset  cols="33%,33%,*" framespacing="0">
                <frame name="menu" src="/menu.php" marginwidth="0" marginheight="0" scrolling="no" frameborder="0">
                <frame name="enter" src="/enter.php" marginwidth="0" marginheight="0" scrolling="no" frameborder="0">
                <frame name="emap" src="/map.php" marginwidth="0" marginheight="0" scrolling="no" frameborder="0">
            </frameset>
        </frameset>
    </html>
EOT;
