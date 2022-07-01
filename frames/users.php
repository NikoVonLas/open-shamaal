<?php
    require_once('../include.php');

    $oldUsersScript = '';
    if ($player['users'] != "") {
        $oldUsersScript = "
                <script>
                    top.setchan({$show});
                    top.du('');
                    {$player['users']};
                    top.fu(0,0);
                </script>
        ";
    }
    $player['show'] = 0;

    echo <<<EOT
    <html>
        <head>
            <title>Shamaal World</title>
            <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
            <link rel="stylesheet" type="text/css" href="style.css" title="style">
            <link rel="stylesheet" type="text/css" href="/maingame/shake/csshake.min.css">
        </head>
        <body>
            <div id="stooltipmsg" class="stooltip" style="left:160px; max-width: 160px;">
                <div id="stooltip_e1"></div>
                <div id="stooltip_e2"></div>
                <div id="stooltip_e3"></div>
                <div id="stooltip_e4"></div>
                <div id="stooltip_e5">  
                    <div id="stooltip_e6">
                        <div id="stooltiptext" style="padding: 0; margin: 0;"></div>
                    </div>
                </div>
            </div>
            <script type="text/javascript" src="stooltip.js"></script>
            <script type="text/javascript" src="jquery.min.js"></script>
            <table cellpadding="0" cellspacing="0" width="100%" height="100%">
                <tr>
                    <td width="1" height="100%" bgcolor="#8898AF">
                        <img width=1>
                    </td>
                    <td class="mainb" width="100%" valign="top">
                        <table width=92%" align="center">
                            <tr>
                                <td height="20">
                                    <table cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td>
                                                <b>»</b>&nbsp;Список&nbsp;игроков
                                            </td>
                                            <td>
                                                &nbsp;<a href="map.php?dir=-1" target="emap">
                                                    <img src="pic/game/ref.gif">
                                                </a>&nbsp;
                                            </td>
                                            <td>:</td>
                                        </tr>
                                    </table>
                                    <font id="n_id"></font>
                                </td>
                            </tr>
                        </table>
                        <table width="95%" align="center">
                            <tr>
                                <td width="12"></td>
                                <td width="40"> 
                                    <div id="mute" width="18" style="float:left;"></div>
                                    <a href="../fullinfo.php?name={$player['name']}" target="_blank">
                                        <img src="pic/game/info.gif" width="13" height="13">
                                    </a>
                                </td>
                                <td width="18"></td>
                                <td width="18">
                                    <img src="pic/game/attack.gif" width="15" height="15">
                                </td>
                                <td width="20">
                                    [<a onclick="top.textenter('/приват {$player['name']}';);" style="cursor:hand"><span color="00237B"><b>П</b></span></a>]
                                </td>
                                <td class="usergood">
                                    <a onclick="top.entertext('{$player['name']}')"; style="cursor:hand">{$player['name']}</a>&nbsp;
                                    <span id="myclantext" class="userclan"></span>
                                </td>
                            </tr>
                        </table>
                        <table width="95%" align="center" cellpadding="0" cellpadding="0">
                            <tr>
                                <td id="userlist">
                                    <span id="zagr">Загрузка...</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            {$oldUsersScript}
        </body>
    </html>
EOT;
