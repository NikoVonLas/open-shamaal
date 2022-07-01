<?php
    require_once('../include.php');

    $per_hp = round($player['chp'] / $player['maxhp'] * 100);
    $per_mana = round($player['cmana'] / $player['maxmana'] * 100);
    if (empty($player['target_name'])) {
        $player['target_name'] = 'Не выбрана';
    }
    $per_ahp = 100 - $per_hp;
    $per_amana = 100 - $per_mana;
    $targetString = $player['target_name'];
    if (!empty($player['target_level'])) {
        $targetString .= "&nbsp;{$player['target_level']}&nbsp;ур";
    }

    echo <<<EOT
        <html>
            <head>
                <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
                <link rel="stylesheet" type="text/css" href="/style.css">
                <link rel="stylesheet" type="text/css" href="/maingame/shake/csshake.min.css">
            </head>
            <title>Shamaal World</title>
            
            <div id="stooltipmsg" class="stooltip">
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
            
            <table cellspacing="0" cellpadding="0" border="0" height="20" width="100%">
                <tr>
                    <td bgcolor="B9C9D9" width="1">
                        <table class="blue" cellspacing="0" cellpadding="0" height="100%" width="1">
                            <tr>
                                <td></td>
                            </tr>
                        </table>
                    </td>
                    <td bgcolor="B9C9D9">
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td class="har">
                                    <b>
                                        &nbsp;»&nbsp;Цель:&nbsp;
                                        <span id="mytarget" color="005500" class="har"> 
                                            {$targetString}
                                        </span>
                                    </b>
                                </td>
                                <td width="35" align="left">
                                    <a href="/menu.php?load=exit" target=menu>
                                        <img src="/img/exit.gif" width="32" height="18"  alt="Выход из игры">
                                    </a>
                                </td>
                            </tr>
                        </table>   
                    </td>
                </tr>
            </table>     
            <table class="blue" cellpadding="0" cellspacing="1" width="100%" height="330">
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
                                    <img src="/img/mbarf.gif" width="11" height="10" border="0" alt="В этом разделе для передвижения по карте необходимо нажать на нужную вам локацию.">
                                </td>
                                <td>
                                    <table cellpadding="1" cellspacing="0">
                                        <tr>
                                            <td>
                                                <span id="maploc"></span>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                   </td>
                </tr>
                <tr>
                    <td class="mainb" height="170" align="center" bgcolor="FFFFFF">
                        <table bgcolor="EBF1F7" width="100%" height="170" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="center" id="map">Загрузка...</td>
                            </tr>
                        </table>
                    </td>
                </tr>
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
                                    <img src="/img/mbarf.gif" width="11" height="10" border="0" alt="Здесь отображается вся информация о состоянии вашего персонажа.">
                                </td>
                                <td>Состояние персонажа</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="mainb" height="60">
                        <table cellpadding="0" cellspacing="0" align="center" width="98%">
                            <tr>
                                <td class="har" width="25">Жизни</td>
                                <td align="center" width="120">
                                    <img src="/img/game/HPl.gif" width="7" height="12">
                                    <img src="/img/game/HP1.gif" width="{$per_hp}" height="12" id="hp1">
                                    <img src="/img/game/HP.gif" width="{$per_ahp}" height="12" id="hp2">
                                    <img src="/img/game/HPr.gif" width="7" height="12">
                                </td>
                                <td class="har" id="hpscore">
                                    {$player['chp']}/{$player['maxhp']}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" height="2"></td>
                            </tr>
                            <tr>
                                <td class="har">Энергия</td>
                                <td align="center" width="120">
                                    <img src="/img/game/HPl.gif" width="7" height="12">
                                    <img src="/img/game/HP3.gif" width={$per_mana} height="12" id="mana1">
                                    <img src="/img/game/HP.gif" width={$per_amana} height="12" id="mana2">
                                    <img src="/img/game/HPr.gif" width="7" height="12">
                                </td>
                                <td class="har" id="manascore">
                                    {$player['cmana']}/{$player['maxmana']}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" height="2"></td>
                            </tr>
                            <tr>
                                <td class="har">Баланс</td>
                                <td align="center" width="120">
                                    <img src="/img/game/HPl.gif" width="7" height="12">
                                    <img src="/img/game/HP2.gif" width="1" height="12" id="bal1">
                                    <img src="/img/game/HP.gif" width="99" height="12" id="bal2">
                                    <img src="/img/game/HPr.gif" width="7" height="12">
                                </td
                                ><td class="har" id="bal">Есть</td>
                            </tr>
                            <tr>
                                <td colspan="3" height="2"></td>
                            </tr>
                            <tr>
                                <td class="har">Эликсиры</td>
                                <td align="center" width="120">
                                    <img src="/img/game/HPl.gif" width="7" height="12">
                                    <img src="/img/game/HP2.gif" width="1" height="12" id="dbal1">
                                    <img src="/img/game/HP.gif" width="99" height="12" id="dbal2">
                                    <img src="/img/game/HPr.gif" width="7" height="12">
                                </td>
                                <td class="har" id="dbal">Есть</td>
                            </tr>
                        </table>
                    </td>
                </tr>
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
                                    <img src="/img/mbarf.gif" width="11" height="10" border="0" alt="В этом окне отображаются все эффекты, действующие на вас в настоящее время.">
                                </td>
                                <td>Эффекты</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="mainb">
                        <table cellpadding="0" cellspacing="0" width="99%" align="center">
                            <tr>
                                <td id="effect"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <script type="text/javascript" src="/stooltip.js"></script>
        </html> 
EOT;
