<?php
require_once('../include.php');
function checkletter( $text )
{
    $k = 0;
    $newtext = "";
    $i = 0;
    for ( ; $i <= strlen( $text ); ++$i )
    {
        if ( $text[$i] == "-" || $text[$i] == " " || $text[$i] == "?" || $text[$i] == chr( 60 ) )
        {
            $k = 0;
        }
        else
        {
            ++$k;
        }
        $newtext = $newtext.$text[$i];
        if ( 15 < $k )
        {
            $newtext = $newtext." ";
            $k = 0;
        }
    }
    return $newtext;
}

echo "<meta content=\"text/html; charset=utf-8\" http-equiv=\"Content-Type\">\r\n";
print "<LINK REL=STYLESHEET TYPE=\"TEXT/CSS\" HREF=\"../style.css\" TITLE=\"STYLE\"> ";

$player_id = $player['id'];
$player_name = $player['name'];
$cur_time = time( );
$SQL = "select sw_users.clan,sw_users.clan_rank,sw_position.opt2 from sw_position right join sw_users on sw_position.id=sw_users.clan_rank where sw_users.id={$player_id} and clan={$city_id}";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    $cityz = $row_num[0];
    $city_rank = $row_num[1];
    $allow = $row_num[2];
    $row_num = sql_next_num( );
}
if ( $result )
{
    SQL_free_result( $result );
}
if ( $city_rank == 1 )
{
    $allow = 1;
}

print "<table cellpadding=2 width=100%>
        <tr>
            <td>
                <form action=/script/clannews.php method=post>
                    <div align='center'>
                        <input type=hidden name=city_id value={$city_id}>
                        Содержимое:&nbsp;<input name=\"news_filter\" value=\"{$news_filter}\">
                        &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                        Отправитель:&nbsp;<input name=\"news_filter_sender\" value=\"{$news_filter_sender}\"><br />
                        <input type=\"submit\" value='Найти'>
                    </div>
                </form>
            </td>
        </tr>
        <tr>
            <td>";

if ( $allow == 1 )
{
    print "<div align=center>| <a href=/script/clannews.php?do=add&city_id={$city_id} class=menu><b>Добавить новость</b></a> |</div>";
}
if ( $city_id != $cityz )
{
    $sear = "and sw_game_news.typ=0";
}
else
{
    $sear = "";
}
if ( $do == "new" && $allow == 1 )
{
    if ( 1500 < strlen( $text ) )
    {
        $text = substr( $text, 0, 1500 );
    }
    if ( $typ != 1 )
    {
        $typ = 0;
    }
    $SQL = "insert into sw_game_news (who,dat,tim,text,typ,city,owner) values ('{$player_name}',NOW(),NOW(),'{$text}',{$typ},0,{$city_id})";
    sql_do( $SQL );
}
if ( $do == "del" && $allow == 1 )
{
    $SQL = "delete from sw_game_news where owner={$city_id} and city=0 and id={$id}";
    sql_do( $SQL );
}

if (!isset($news_filter))
{
    $news_filter = '';
}
else if ($news_filter != '')
{
    $sear .= "and text like '%$news_filter%'";
}

if (!isset($news_filter_sender))
{
    $news_filter_sender = '';
}
else if ($news_filter_sender != '')
{
    $sear .= "and who like '%$news_filter_sender%'";
}

$SQL = "select count(*) as num from sw_game_news where owner={$city_id} and city=0 {$sear}";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    $count = $row_num[0];
    $row_num = sql_next_num( );
}
print "</table>";
if ( $result )
{
    SQL_free_result( $result );
}
if ( !isset( $page ) )
{
    $page = 0;
}

$p = "";
$i = 0;
for ( ; $i < $count; $i = $i + 30 )
{
    $e = $i + 29;
    if ( $count < $e )
    {
        $e = $count;
    }
    if ( $i == $page )
    {
        $p .= "|<b>{$i}-{$e}</b>|";
    }
    else
    {
        $p .= "|<a href=/script/clannews.php?page={$i}&city_id={$city_id}&news_filter={$news_filter}&news_filter_sender=$news_filter_sender class=menu>{$i}-{$e}</a>|";
    }
}
print "<div align=center>{$p}</div>";
print "<table width=90% align=center bgcolor=7C8A9D cellspacing=1 cellpadding=3>";
if ( $do == "add" && $allow == 1 )
{
    print "<form action=/script/clannews.php method=post>
            <input type=hidden name=do value=new>
            <input type=hidden name=city_id value={$city_id}>
            <tr bgcolor=D7DBDF>
                <td>
                    <table width=100%>
                        <tr>
                            <td colspan=2 align=center>
                                <textarea cols=47 rows=4 name=text></textarea><br>
                                <table cellpadding=0 cellspacing=2>
                                    <tr>
                                        <td>
                                            <input type=checkbox name=typ value=1>
                                        </td>
                                        <td> - Только для клана</td>
                                    </tr>
                                </table>
                                <div align=center><input type=submit value='Отослать (1500 - символов)'></div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
           </form>";
}
$i = 0;
$SQL = "select id,who,dat,tim,text,typ from sw_game_news where owner={$city_id} and city=0 {$sear} order by dat desc,tim desc limit {$page},30";
$row_num = sql_query_num( $SQL );
while ( $row_num )
{
    $id = $row_num[0];
    $who = $row_num[1];
    $date = $row_num[2];
    $tim = $row_num[3];
    $text = $row_num[4];
    $typ = $row_num[5];
    $text = htmlspecialchars( "{$text}", ENT_QUOTES );
    $text = str_replace( "\r", "<br>", $text );
    $text = str_replace( "\r", "<br>", $text );
    ++$i;
    if ( $i % 2 == 1 )
    {
        $c = "D7DBDF";
    }
    else
    {
        $c = "E7EBEF";
    }
    $temp[0] = "Новость для всех";
    $temp[1] = "Новость для клана";
    if ( $allow == 1 )
    {
        $del = "<b>» <a href=/script/clannews.php?do=del&id={$id}&city_id={$city_id} class=menu>Удалить</b>";
    }
    else
    {
        $del = "";
    }
    print "<tr bgcolor={$c}><td><table width=100%><tr><td><b>Дата</b>: {$date}</td><td align=right><b>Отправитель</b>: {$who}</td></tr><tr><td colspan=2>{$text}<br>";
    print "<table width=100%><tr><td><b>» {$temp[$typ]}</b></td><td align=right>{$del}</td></tr></table>";
    print "</td></tr></table></td></tr>";
    $row_num = sql_next_num( );
}
if ( $result )
{
    SQL_free_result( $result );
}
if ( $i == 0 )
{
    print "<tr bgcolor=D7DBDF><td align=center>Новых новостей нет.</td></tr>";
}
print "</table>";
print "</table>";
sql_disconnect( );
?>
