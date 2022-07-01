<?php
require_once('./include.php');
$pack = 0;
$info = "";
$userDir = "/img/obraz/";
$SQL = "select pack,pic,sex,topic from sw_users where id={$player_id}";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    $pack = $row_num[0];
    $pic = $row_num[1];
    $sex = $row_num[2];
    $topic = $row_num[3];
    $row_num = sql_next_num( );
}
if ( $result )
{
    SQL_free_result( $result );
}
if ( $topic != "" )
{
    $pic = $topic;
    $menu = "Проверяется";
}
if ( !isset( $page ) )
{
    $page = 1;
}
if ( $pack & 1 && $action == "setplus" && file_exists( "../img/obraz/{$pict}" ) )
{
    $a = explode('/', $pict);
    $b = substr($pict, 0, 5);

    if (((count($a) == 1 && $b == 'obraz') || (count($a) == 2 && $a[0] == $player['user_id'])) && file_exists("../img/obraz/{$pict}")) {
        $pic = $pict;
        $SQL = "update sw_users SET pic='{$pic}',topic='' where id={$player_id}";
        sql_do( $SQL );
    }
    
}
if ( $action == "setnormal" )
{
    $a = substr( $pict, strlen($pict) - 6, 6);
    if ( file_exists( "../img/obraz/{$pict}" ) && $a == "fr.gif" )
    {
        $pic = $pict;
        $SQL = "update sw_users SET pic='{$pic}',topic='' where id={$player_id}";
        sql_do( $SQL );
    }
}
if ( $pic == "" )
{
    $pic = "obraz/no_obraz.gif";
}
else
{
    $pic = "obraz/".$pic;
}
if ( !isset( $show ) )
{
    $show = 0;
}
$text = "<form action=menu.php method=post target=menu><table cellpadding=0 cellspacing=0 width=100%><input type=hidden name=load value={$load}><tr><td>Выбрать образ из:&nbsp;</td><td align=right><select name=show><option value=0 sel0>Стандартных</option><option value=1  sel1>Дополнительных</option><option value=2 sel2>Своих образов</option></select> <input type=submit value=Показать style=margin-right:10px></td></tr></table></form>";
$text = str_replace( "sel{$show}", "SELECTED", $text );
if ( $show == 1 )
{
    $sx = '';
    if ($sex == 1) {
        $max_page = 50;
    } else {
        $max_page = 35;
        $sx = 'w';
    }

    $page_html = '';
    for ($i = 0; $i < $max_page; $i += 6) { 
        $from = $i + 1;
        $to = ($i + 6 > $max_page - 1) ? $max_page - 1 : ($i + 6);
        if ($to == 0) {
            $to = 1;
        }

        if ($from == $to) {
            $page_text = $to;
        } else {
            $page_text = "{$from}-{$to}";
        }

        if ($from == $page) {
            $page_html .= "|<b>{$page_text}</b>|";
        } else {
            $page_html .= "|<a href=menu.php?load={$load}&page={$from}&show={$show} class=menu target=menu>{$page_text}</a>|";
        }
    }

    $info .= "<br><div align=center>{$page_html}</div><br><table cellpadding=0 width=100%><tr>";

    $from = $page;
    $to = $page + 6;
    for ($i=$from; $i < $to; $i++) { 
        if (!file_exists("../img/obraz/obraz{$i}{$sx}.gif")) {
            continue;
        }

        $imagehw = getimagesize("../img/obraz/obraz{$i}{$sx}.gif");
        $i_x = round( $imagehw[0] / 2 );
        $i_y = round( $imagehw[1] / 2 );
        $mc = '';

        if ($pack & 1) {
            $mc = "<a href=menu.php?load={$load}&action=setplus&show={$show}&page={$page}&pict=obraz{$i}{$sx}.gif class=menu target=menu>Выбрать</a>";
        }
        $info .= "<td align=center><img src=/img/obraz/obraz{$i}{$sx}.gif width={$i_x} height={$i_y}><br><br>{$mc}</td>";
    }

    $info .= '</table>';
    if ($pack & 1) {
        print "";
    } else {
        $info .= "<div align=center>У вас нет доступа к этим образам.</div>";
    }
}
else if ( $show == 2 )
{
    $SQL = "select user_id,filename from sw_avatars where verified=1 and user_id={$player['user_id']}";
    $row_num = sql_query_num( $SQL );
    $avatars = array();
    while ( $row_num ) {
        $avatars[] = array(
            'user_id'  => $row_num[0],
            'filename' => $row_num[1]
        );
        $row_num = sql_next_num( );
    }

    $max_page = count($avatars) + 1;

    if ($max_page > 1)
    {
        $info = '';
        $page_html = '';
        for ($i = 0; $i < $max_page; $i += 6) { 
            $from = $i + 1;
            $to = ($i + 6 > $max_page - 1) ? $max_page - 1 : ($i + 6);
            if ($to == 0) {
                $to = 1;
            }

            if ($from == $to) {
                $page_text = $to;
            } else {
                $page_text = "{$from}-{$to}";
            }

            if ($from == $page) {
                $page_html .= "|<b>{$page_text}</b>|";
            } else {
                $page_html .= "|<a href=menu.php?load={$load}&page={$from}&show={$show} class=menu target=menu>{$page_text}</a>|";
            }
        }

        $info .= "<br><div align=center>{$page_html}</div><br><table cellpadding=0 width=100%><tr>";

        $from = $page;
        $to = $page + 6;
        for ($i=$from; $i < $to; $i++) {
            if (!file_exists("../img/obraz/{$avatars[$i - 1]['user_id']}/{$avatars[$i - 1]['filename']}") || $avatars[$i - 1]['filename'] == null) {
                continue;
            }

            $imagehw = getimagesize("../img/obraz/{$avatars[$i - 1]['user_id']}/{$avatars[$i - 1]['filename']}");
            $i_x = round( $imagehw[0] / 2 );
            $i_y = round( $imagehw[1] / 2 );
            $mc = '';

            if ($pack & 1) {
                $mc = "<a href=menu.php?load={$load}&action=setplus&show={$show}&page={$page}&pict={$avatars[$i - 1]['user_id']}%2F{$avatars[$i - 1]['filename']} class=menu target=menu>Выбрать</a>";
            }
            $info .= "<td align=center><img src=/img/obraz/{$avatars[$i - 1]['user_id']}/{$avatars[$i - 1]['filename']} width={$i_x} height={$i_y}><br><br>{$mc}</td>";
        }

        $info .= '</table>';
        if ($pack & 1) {
            print "";
        } else {
            $info .= "<div align=center>У вас нет доступа к этим образам.</div>";
        }
    } else {
        $info = "<table width=100% height=200><tr><td align=center>У вас нет загруженых образов.<br> Загрузка образа доступна в личном кабинете, если хотябы один из ваших персонажей имеет дополнительный игровой пакет.</td></tr></table>";
    }

    if ( $server == 2 ) {
        print "<script>document.location = '/maingame/menu.php?load={$load}&action={$action}&show={$show}';</script>";
        sql_disconnect( );
        exit( );
    }
}
else
{
    $sx = "";
    if ( $sex == 1 )
    {
        $max_page = 6;
    }
    else
    {
        $max_page = 6;
        $sx = "w";
    }
    $p = "";
    $i = 1;
    for ( ; $i < $max_page; $i = $i + 5 )
    {
        $e = $i + 5;
        if ( $max_page < $e )
        {
            $e = $max_page;
        }
        if ( $i == $page )
        {
            $p .= "|<b>{$i}-{$e}</b>|";
        }
        else
        {
            $p .= "|<a href=menu.php?load={$load}&page={$i} class=menu target=menu>{$i}-{$e}</a>|";
        }
    }
    $info .= "<br><div align=center>{$p}</div><br><table cellpadding=0 width=100%>";
    $k = ( $page - 1 ) / 5 + 1;
    $info .= "<tr>";
    $i = 1;
    for ( ; $i <= 6; ++$i )
    {
        $n = ( $k - 1 ) * 5 + $i;
        if ( file_exists( "../img/obraz/obraz".$n.$sx."fr.gif" ) )
        {
            $imagehw = getimagesize( "../img/obraz/obraz".$n.$sx."fr.gif" );
            $i_x = round( $imagehw[0] / 2 );
            $i_y = round( $imagehw[1] / 2 );
            $info .= "<td align=center><img src=/img/obraz/obraz".$n.$sx."fr.gif width={$i_x} height={$i_y}><br><br><a href=menu.php?load={$load}&action=setnormal&page={$page}&pict=obraz".$n.$sx."fr.gif class=menu target=menu>Выбрать</a></td>";
            continue;
            break;
        }
    }
    $info .= "</table>";
}
print "<script>top.settop('Выбор образа');top.obraz('',`{$pic}`,`{$menu}`,`{$text}`,`{$info}`,1);</script>";
?>
