<?php
session_start( );
header( "Content-type: text/html; charset=utf-8" );
if ( !isset( $player['id'] ) )
{
    exit( );
}
$player_name = $player['name'];
$old_users = $player['users'];
$ban_chat = $player['ban_chat'];
$player['show'] = 0;
$show = 0;
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
        <table cellpadding=0 cellspacing=0 width=100% height=100%>
            <tr>
                <td width="1" height="100%" bgcolor="#8898AF">
                    <img width=1>
                </td>
                <td class=mainb width=100% valign=top>
                    <table width=92%" align=center>
                        <tr>
                            <td height=20>
                                <table cellpadding=0 cellspacing=0>
                                    <tr>
                                        <td>
                                            <b>»</b> Список игроков
                                        </td>
                                        <td>
                                            &nbsp;<a href=map.php?dir=-1 target=emap><img src=pic/game/ref.gif></a>&nbsp;
                                        </td>
                                        <td>:</td>
                                    </tr>
                                </table>
                                <font id=n_id></font>
                            </td>
                        </tr>
                    </table>
                    <table width=95% align=center>
                        <tr>\r\n\t\t\t\t
                            <td width=12> </td>
                            <td width=40> 
                                <div id=mute width=18 style=\"float:left;\"></div>
                                <a href="../fullinfo.php?name=${player_name}" target="_blank">
                                    <img src="pic/game/info.gif" width=13 height=13>
                                </a>
                            </td>
                            <td width=18> 
                            </td>
                            <td width=18>
                                <img src="pic/game/attack.gif" width=15 height=15>
                            </td>
                            <td width=20>
                                [<a onclick="top.textenter('/приват ${player_name}';);" style=cursor:hand><font color=00237B><b>П</b></font></a>]
                            </td>
                            <td class=usergood>
                                <a onclick=top.entertext("${player_name}"); style=cursor:hand>${player_name}</a>&nbsp;
                                <font id=myclantext class=userclan></font>
                            </td>
                        </tr>
                    </table>
                    <table width=95% align=center cellpadding=0 cellpadding=0>
                        <tr>
                            <td id=userlist>
                                <font id=zagr>Загрузка...</font>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
EOT;

if ( $old_users != "" ) {
    echo <<<EOT
        <script>
            top.setchan(${show});
            top.du('');
            ${old_users};
            top.fu(0,0);
        </script>    
EOT;
}
echo <<<EOT
    </body>
</html>
EOT;
