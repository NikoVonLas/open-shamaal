<?php
    require_once('../include.php');

    if ($player['show'] == 0) {
        $location = '<b>Локация</b>';
    } else {
        $location = '<a href="/menu.php?load=c_user&to=0" class="menu" target="menu">Локация</a>';
    }

    if ($player['show'] == 1) {
        $city = '<b>Город</b>';
    } else {
        $city = '<a href="/menu.php?load=c_user&to=1" class="menu" target="menu">Город</a>';
    }

    if ($player['show'] == 2) {
        $world = '<b>Мир</b>';
    } else {
        $world = '<a href="/menu.php?load=c_user&to=2" class="menu" target="menu">Мир</a>';
    }

    echo <<<EOT
    <html>
        <head>
            <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
            <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
            <link rel="stylesheet" type="text/css" href="/assets/css/csshake.min.css">
        </head>
        <title>Shamaal World</title>

        <table class="blue" cellpadding="0" cellspacing="0" width="100%" height="100%">
            <tr>
                <td>
                    <table cellpadding="0" cellspacing="1" width="100%">
                        <tr class="blue">
                            <td class="bluetop" width="40%">
                                <table cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td class="gal">
                                            <table cellspacing=\"0\" cellpadding=\"0\" width="100%" height="1">
                                                <tr>
                                                    <td></td>
                                                </tr>
                                            </table>
                                            <img src="/assets/img/mbarf.gif" width="11" height="10" border="0" alt="Отображать персонажей находяшиеся в вашей локации.">
                                        </td>
                                        <td id="usr0">
                                            {$location}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td class="bluetop" width="34%">
                                <table cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td class="gal">
                                            <table cellspacing=\"0\" cellpadding=\"0\" width="100%" height="1">
                                                <tr>
                                                    <td></td>
                                                </tr>
                                            </table>
                                            <img src="/assets/img/mbarf.gif" width="11" height="10" border="0" alt="Отображать персонажей находяшиеся в вашем городе.">
                                        </td>
                                        <td id="usr1">
                                            {$city}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td class="bluetop">
                                <table cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td class="gal">
                                            <table cellspacing=\"0\" cellpadding=\"0\" width="100%" height="1">
                                                <tr>
                                                    <td></td>
                                                </tr>
                                            </table>
                                            <img src="/assets/img/mbarf.gif" width="11" height="10" border="0" alt="Отображать всех персонажей, находящихся в игре.">
                                        </td>
                                        <td id="usr2">
                                            {$world}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </html>
EOT;
