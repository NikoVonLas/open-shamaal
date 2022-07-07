<?php
require_once('../include.php');

if ($player['server'] != 1) {
    $player['server'] = 0;
}

$pl_ignor = array();
for ($i = 1 ; $i <= 12; ++$i ) {
    if (!empty($player["ignor{$i}"])) {
        $pl_ignor[] = $player["ignor{$i}"];
    }
}
$pl_ignor = json_encode($pl_ignor);

echo <<<EOT
        <html>
            <head>
                <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
                <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
                <link rel="stylesheet" type="text/css" href="/assets/css/csshake.min.css">
            </head>
            <title>Shamaal World</title>
            
            <div id="stooltipmsg" class="stooltip">
                <div id="stooltip_e1"></div><div id="stooltip_e2"></div><div id="stooltip_e3"></div><div id="stooltip_e4"></div>
                <div id="stooltip_e5">  
                    <div id="stooltip_e6">
                        <div id="stooltiptext" style="padding: 0; margin: 0;"></div>
                    </div>
                </div>
            </div>
    
            <table cellspacing="0" cellpadding="0" border="0" height="20" width="100%">
                <tr>
                    <td width="537" bgcolor="#849BAD">&nbsp;</td>
                    <td bgcolor="#B9C9D9">
                        <img width="0">
                    </td>
                </tr>
            </table>
            
            <table class="blue" cellpadding="0" cellspacing="1" width="101%" height="340">
                <tr>
                    <td class="bluetop">
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="gal">
                                    <table cellspacing="0" cellpadding="0" width="100%" height="1">
                                        <tr>
                                            <td></td>
                                        </tr>
                                    </table>
                                    <img src="/assets/img/mbarf.gif" width="11" height="10" border="0" alt="Одно из главных окон игры, отображает все настройки и параметры вашего персонажа.">
                                </td>
                                <td id="topname">
                                    Загрузка информации... 
                                </td>
                            </tr>
                        </table>  
                    </td>
                </tr>
                <tr>
                    <td class=mainb id=toptext valign="top"></td>
                </tr>  
            </table>
            
            <script type="text/javascript" src="/assets/js/jquery.min.js"></script>
            <script type="text/javascript" src="/assets/js/stooltip.js"></script>
            <script>
                plname = '{$player['name']}';
                server = {$player['server']};
                var ignor = [];
                ignor[0] = '1';
                window.top.ignor = JSON.parse('{$pl_ignor}');
            </script>
            <script src="/assets/js/navigation.js"></script>         
        </html> 
EOT;
