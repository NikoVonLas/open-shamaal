<?php
    require_once('../include.php');

    if ($player['sleep'] == 1) {
        $sl = '<a href="/menu.php?load=sleep" target="menu"><img src="/img/sleep2.gif" width="31" height="19" id="sleep" alt="Подняться с земли"></a>';
    } else {
        $sl = '<a href="/menu.php?load=sleep" target="menu"><img src="/img/sleep.gif" width="31" height="19" id="sleep" alt="Сесть отдохнуть"></a>';
    }
    $H = date('H');
    $i = date('i');
    $s = date('s');

    echo <<<EOT
        <html>
            <head>
                <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
                <link rel="stylesheet" type="text/css" href="/style.css">
                <link rel="stylesheet" type="text/css" href="/maingame/shake/csshake.min.css">
            </head>
            <title>Shamaal World</title>
            
            <table class="blue" cellpadding="0" cellspacing="1" width="100%" height="100%">
                <form action="/enter.php" method="post" target="enter" name="F" autocomplete="off">
                    <tr>
                        <td class="bluetop">
                            <table cellpadding="0" cellspacing="0" width=99%>
                                <tr>
                                    <td class="gal">
                                        <table cellspacing="0" cellpadding="0" width="100%" height="1">
                                            <tr>
                                                <td></td>
                                            </tr>
                                        </table>
                                        <img src="/img/mbarf.gif" width="11" height="10" border="0" alt="Ввод текста.">
                                    </td>
                                    <td>
                                        <table class="chat-row" cellspacing="0" cellpadding="0" width="100%">
                                            <tr>
                                                <td>
                                                    <img src="/img/ct.gif" width="20" height="19" alt="Канал города" style="cursor:hand" onclick="window.top.textenter('/город');">
                                                    <img src="/img/cl.gif" width="20" height="19" alt="Канал клана" onclick="window.top.textenter('/клан');" style="cursor:hand">
                                                    <img src="/img/to.gif" width="20" height="19" alt="Общий канал" onclick="window.top.textenter('/общий');" style="cursor:hand">
                                                    <img src="/img/gr.gif" width="20" onclick="window.top.textenter('/группа');" height="19" alt="Канал группы" " style="cursor:hand">
                                                </td>
                                                <td>
                                                    <input style="display:none" type="text" name="fakeusernameremembered" autocomplete="off" value=""/>
                                                    <input style="display:none" type="password" name="fakepasswordremembered"  autocomplete="off" value=""/>
                                                    <input type="text" name="ebar" size="35" style="max-width:500px;" maxlength="250" class="enter" id="ebar" autocomplete="off" onkeydown="if (event.keyCode == 13) { this.form.submit(); return false; }">
                                                </td>
                                                <td>
                                                    <img src="/img/go.gif" width="31" height="19" alt="Отправить сообщение" onclick="document.F.submit();" style="cursor:hand">
                                                    <img src="/img/err.gif" width="31" height="19" alt="Удалить текст чата" onclick="window.top.clearchat();" style="cursor:hand">
                                                    <img src="/img/attack.gif" width="31" height="19" alt="Перейти в список боевых действий" onclick="window.top.gotoskills(0);" style="cursor:hand">
                                                    {$sl} 
                                                    <img src="/img/trade.gif" width="31" height="19" alt="Передача вещей" onclick="window.top.frames['menu'].document.location = '/menu.php?load=trade&action=addtrade';" style="cursor:hand">
                                                </td>
                                                <td width="100%" id="clock" align="right"></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </form>
            </table>
            <script>
                function resbar(){
                    ie = (document.all);
                    w = (ie) ? document.body.clientWidth : window.innerWidth;
                    if (w > 400) {
                        newsize = (w - 350) / 6;
                        if (newsize != document.getElementById('ebar').size) {
                            document.getElementById('ebar').size = newsize;
                        }
                    }
                }
                var my_date = new Date();
                var hour = my_date.getHours();
                var minute = my_date.getMinutes();
                var second = my_date.getSeconds();
                var Shour = {$H} - hour;
                var Sminute = {$i} - minute;
                var Ssecond = {$s} - second;
                window.onresize = resbar;
                resbar();
            </script>
            <script src="/clock.js">
                window.top.frames['enter'].window.document.F.ebar.focus();
            </script>
        </html> 
EOT;
