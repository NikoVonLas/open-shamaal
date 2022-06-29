<?
session_start();
define('DEBUG', false);
error_reporting(E_ALL);

if(DEBUG) {
    ini_set('display_errors', true);
    ini_set('log_errors', true);
} else {
    ini_set('display_errors', false);
    ini_set('log_errors', false);
}

header('Content-type: text/html; charset=utf-8');
if (!isset($player['style'])) {
?>
	<!DOCTYPE html>
	<html>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<title>Shamaal World</title>
		<b>Сессия потеряна.</b><br><br>
		Эта ошибка может возникнуть при:<br>
		1) Открытии игры из нестандартных окон браузера (Например: при открытии Internet Explorer не через стандартное окно браузера. Для решения проблемы попробуйте зайти через стандартное окно браузера.)<br>
		2) Отсутствии связи с сервером в связи с его недавней перезагрузкой.<br>
	</html>
<?php
	exit();
}
?>
<!DOCTYPE html>
<html class="h-100">
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
	<meta name="viewport" content="widivh=device-widivh, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://shamaal-world.ru/css/app.css?v=4">
    <script src="https://shamaal-world.ru/js/app.js?v=4"></script>

    <title>Shamaal World</title>
    <script>
        player_id = <?=$player['id']; ?>;
        player_name = '<?=$player['name']; ?>';
        server = <?=(($player['server'] != 1) ? 0 : $player['server']); ?>;
        var ignor = new Array();
        ignor[0] = 1;
        <?php
            for ($i = 1; $i <= 12; ++$i) {
                if (!empty($player['ignor' . $i])) {
                    ?>
                    ignor[<?php echo $i; ?>] = '<?=$player['ignor' . $i]; ?>';
                <?php
                }
            }
        ?>
    </script>
    <!--<script src="https://shamaal-world.ru/maingame/main.js?131" charset="utf-8"></script>-->
	<style>
        body {
			height: 100%;
		}
		.w-20 {
			width: 20%;
		}
		.h-24 {
			height: 24px;
		}
		#info,
		#mtop {
			height: 380px
		}
		#main {
			overflow-x: hidden;
		}
		#mobile-menu {
			position: fixed;
			bottom: 0;
			height: 20vw;
		}
        #topmenu {
            background: rgb(185, 201, 217);
            border: 1px solid gray;
            border-width: 0 0 1px;
        }
        #topmenu .menu-top {
            display: inline-block;
            border: 1px solid gray;
            border-width: 0 1px 0 0;
        }
        #topmenu .menu-top .menu-btn {
            font-weight: 600;
            cursor: pointer;
            padding: 0 1rem;
            font-size: 0.7rem;
        }
        .content.game {
            font-size: 0.7rem;
        }
        .content.game .card-header {

        }
    </style>
    <body>
        <div id="tooltip"></div>
	    <div id="main" class="row h-100 p-0 m-0">
	    	<div id="mtop"class="d-none d-lg-block col-12 col-lg-8 p-0 m-0">
		    	<div id="topmenu">
                    <div class="dropdown menu-top" role="tablist">
                        <span class="menu-btn dropdown-toggle" id="dropdownInfo" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?=$player['name'];?>
                        </span>
                        <div class="dropdown-menu" aria-labelledby="dropdownInfo">
                            <button class="dropdown-item" type="button">
                                <img src="/img/i.gif">
                                <a id="tab-home-tab" href="#tab-info" data-toggle="tab" role="tab" aria-controls="tab-info" aria-selected="true">Информация</a>
                            </button>
                            <button class="dropdown-item" type="button">
                                <img src="/img/bag.gif">
                                <a id="tab-inventory-tab" href="#tab-inventory" data-toggle="tab" role="tab" aria-controls="tab-inventory" aria-selected="false">Инвентарь</a>
                            </button>
                            <button class="dropdown-item" type="button">
                                <img src="/img/zak.gif">
                                <a id="tab-spells-tab" href="#tab-spells" data-toggle="tab" role="tab" aria-controls="tab-spells" aria-selected="false">Заклинания</a>
                            </button>
                            <button class="dropdown-item" type="button">
                                <img src="/img/at.gif">
                                <a id="tab-actions-tab" href="#tab-actions" data-toggle="tab" role="tab" aria-controls="tab-actions" aria-selected="false">Действия</a>
                            </button>
                        </div>
                    </div>
                    <div class="dropdown menu-top" role="tablist">
                        <span class="menu-btn dropdown-toggle" id="dropdownSoc" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Общество
                        </span>
                        <div class="dropdown-menu" aria-labelledby="dropdownSoc">
                            <button class="dropdown-item" type="button">
                                <img src="/img/city.gif">
                                <a href="menu.php?load=city" class="menu2" target="menu">Город</a>
                            </button>
                            <button class="dropdown-item" type="button">
                                <img src="/img/city.gif">
                                <a href="menu.php?load=clan" class="menu2" target="menu">Клан</a>
                            </button>
                            <button class="dropdown-item" type="button">
                                <img src="/img/party.gif">
                                <a href="menu.php?load=party" class="menu2" target="menu">Группа</a>
                            </button>
                        </div>
                    </div>
                    <div class="dropdown menu-top" role="tablist">
                        <span class="menu-btn dropdown-toggle" id="dropdownOpt" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Опции
                        </span>
                        <div class="dropdown-menu" aria-labelledby="dropdownOpt">
                            <button class="dropdown-item" type="button">
                                <img src="/img/opt.gif">
                                <a href="menu.php?load=opt" class="menu2" target="menu">Настройки</a>
                            </button>
                            <button class="dropdown-item" type="button">
                                <img src="/img/opt.gif">
                                <a href="menu.php?load=ignor" class="menu2" target="menu">Игнорирование</a>
                            </button>
                            <button class="dropdown-item" type="button">
                                <img src="/img/opt.gif">
                                <a href="menu.php?load=obraz" class="menu2" target="menu">Выбор образа</a>
                            </button>
                        </div>
                    </div>
                    <div class="dropdown menu-top" role="tablist">
                        <span class="menu-btn dropdown-toggle" type="button" id="dropdownOpt" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Функции
                        </span>
                        <div id="functions-dropdown" class="dropdown-menu" aria-labelledby="dropdownOpt">
                        </div>
                    </div>
                </div>
                <div class="tab-content" id="mainTabs">
                    <div class="tab-pane fade show active" id="tab-info" role="tabpanel" aria-labelledby="tab-info-tab">
                        <div class="row">
                            <div class="col-12 col-lg-4">
                                <div class="card content game">
                                    <div class="card-body striped p-0">
                                        <div class="row m-0 p-0">
                                            <div class="col-6">Уровень:</div>
                                            <div id="level" class="col-6 text-right">1</div>
                                        </div>
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-6">Опыт:</div>
                                            <div id="exp" class="col-6 text-right">0/100</div>
                                        </div>
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-6">Золота:</div>
                                            <div id="gold" class="col-6 text-right">0</div>
                                        </div>
                                        <div id="city-modal_wrapper" class="row mb-0 ml-0 mr-0">
                                            <div class="col-6">Город:</div>
                                            <div id="city-modal" class="col-6 text-right">Без города</div>
                                        </div>
                                        <div id="city-rank-modal_wrapper" class="row mb-0 ml-0 mr-0">
                                            <div class="col-6">Должность:</div>
                                            <div id="city-rank-modal" class="col-6 text-right">Отсутствует</div>
                                        </div>
                                        <div id="clan-modal_wrapper" class="row mb-0 ml-0 mr-0">
                                            <div class="col-6">Клан:</div>
                                            <div id="clan-modal" class="col-6 text-right">Без клана</div>
                                        </div>
                                    </div>
                                    <div class="card-header text-center p-0">:: Нывыки ::</div>
                                    <div class="card-body striped p-0">
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-8">Уроков:</div>
                                            <div id="skills" class="col-4 text-right">0</div>
                                        </div>
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-8">Увеличений:</div>
                                            <div id="stats" class="col-4 text-right">0</div>
                                        </div>
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-8 pl-3">» Сила:</div>
                                            <div id="stats" class="col-4 text-right">0</div>
                                        </div>
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-8 pl-3">» Подвижность:</div>
                                            <div id="stats" class="col-4 text-right">0</div>
                                        </div>
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-8 pl-3">» Интеллект:</div>
                                            <div id="stats" class="col-4 text-right">0</div>
                                        </div>
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-8 pl-3">» Мудрость:</div>
                                            <div id="stats" class="col-4 text-right">0</div>
                                        </div>
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-8 pl-3">» Телосложение:</div>
                                            <div id="stats" class="col-4 text-right">0</div>
                                        </div>
                                    </div>
                                    <div class="card-header text-center p-0">:: Статистика ::</div>
                                    <div class="card-body striped p-0">
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-8">Топ активности:</div>
                                            <div id="active-top" class="col-4 text-right">-</div>
                                        </div>
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-8">Топ арены:</div>
                                            <div id="arena-top" class="col-4 text-right">-</div>
                                        </div>
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-8">Топ убийц:</div>
                                            <div id="kills-top" class="col-4 text-right">-</div>
                                        </div>
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-8">PVE топ:</div>
                                            <div id="pve-top" class="col-4 text-right">-</div>
                                        </div>
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-sm-6">Время жизни:</div>
                                            <div id="lifetime" class="col-sm-6 text-sm-right">1 минута</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="card content game">
                                    <div class="card-header text-center p-0">:: Мирные умения ::</div>
                                    <div class="card-body striped p-0">
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-8">Травология:</div>
                                            <div id="skills" class="col-4 text-right">0</div>
                                        </div>
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-8">Столярное дело:</div>
                                            <div id="stats" class="col-4 text-right">0</div>
                                        </div>
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-8">Лесничество:</div>
                                            <div id="stats" class="col-4 text-right">0</div>
                                        </div>
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-8">Ювелирное дело:</div>
                                            <div id="stats" class="col-4 text-right">0</div>
                                        </div>
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-8">Ткачество:</div>
                                            <div id="stats" class="col-4 text-right">0</div>
                                        </div>
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-8">Оружейное дело:</div>
                                            <div id="stats" class="col-4 text-right">0</div>
                                        </div>
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-8">Бронник:</div>
                                            <div id="stats" class="col-4 text-right">0</div>
                                        </div>
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-8">Горное дело:</div>
                                            <div id="stats" class="col-4 text-right">0</div>
                                        </div>
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-8">Алхимия:</div>
                                            <div id="stats" class="col-4 text-right">0</div>
                                        </div>
                                    </div>
                                    <div class="card-header text-center p-0">:: Боевые умения ::</div>
                                    <div class="card-body striped p-0">
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-8">Владение молотом:</div>
                                            <div id="active-top" class="col-4 text-right">0</div>
                                        </div>
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-8">Топором:</div>
                                            <div id="arena-top" class="col-4 text-right">0</div>
                                        </div>
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-8">Мечом:</div>
                                            <div id="kills-top" class="col-4 text-right">0</div>
                                        </div>
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-8">Посохом:</div>
                                            <div id="pve-top" class="col-4 text-right">0</div>
                                        </div>
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-sm-6">Кинжалом:</div>
                                            <div id="lifetime" class="col-sm-6 text-sm-right">0</div>
                                        </div>
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-sm-6">Луком:</div>
                                            <div id="lifetime" class="col-sm-6 text-sm-right">0</div>
                                        </div>
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-sm-6">Монашество:</div>
                                            <div id="lifetime" class="col-sm-6 text-sm-right">0</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="card content game">
                                    <div class="card-header text-center p-0">:: Вспомогательные умения ::</div>
                                    <div class="card-body striped p-0">
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-8">Выживание:</div>
                                            <div id="active-top" class="col-4 text-right">0</div>
                                        </div>
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-8">Анатомия:</div>
                                            <div id="arena-top" class="col-4 text-right">0</div>
                                        </div>
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-8">Мистицизм:</div>
                                            <div id="kills-top" class="col-4 text-right">0</div>
                                        </div>
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-8">Военное дело:</div>
                                            <div id="pve-top" class="col-4 text-right">0</div>
                                        </div>
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-8">Телепатия:</div>
                                            <div id="pve-top" class="col-4 text-right">0</div>
                                        </div>
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-8">Шаманство:</div>
                                            <div id="pve-top" class="col-4 text-right">0</div>
                                        </div>
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-8">Руны:</div>
                                            <div id="pve-top" class="col-4 text-right">0</div>
                                        </div>
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-8">Скрытность:</div>
                                            <div id="pve-top" class="col-4 text-right">0</div>
                                        </div>
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-8">Охотничье дело:</div>
                                            <div id="pve-top" class="col-4 text-right">0</div>
                                        </div>
                                    </div>
                                    <div class="card-header text-center p-0">:: Магические умения ::</div>
                                    <div class="card-body striped p-0">
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-8">Магия Воздуха:</div>
                                            <div id="skills" class="col-4 text-right">0</div>
                                        </div>
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-8">Тела:</div>
                                            <div id="stats" class="col-4 text-right">0</div>
                                        </div>
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-8">Земли:</div>
                                            <div id="stats" class="col-4 text-right">0</div>
                                        </div>
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-8">Воды:</div>
                                            <div id="stats" class="col-4 text-right">0</div>
                                        </div>
                                        <div class="row mb-0 ml-0 mr-0">
                                            <div class="col-8">Огня:</div>
                                            <div id="stats" class="col-4 text-right">0</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-inventory" role="tabpanel" aria-labelledby="tab-inventory-tab">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="card content">
                                    <div class="card-body row character">
                                        <div class="col-3">
                                            <div class="row">
                                                <div class="col-12 slot mini">
                                                    <img src="/img/stuff/noamulet.gif">
                                                </div>
                                                <div class="col-6 slot mini double">
                                                    <img src="/img/stuff/noring.gif">
                                                </div>
                                                <div class="col-6 slot mini double">
                                                    <img src="/img/stuff/noring.gif">
                                                </div>
                                                <div class="col-12 slot">
                                                    <img src="/img/stuff/nobody.gif">
                                                </div>
                                                <div class="col-12 slot">
                                                    <img src="/img/stuff/nosword.gif">
                                                </div>
                                                <div class="col-12 slot">
                                                    <img src="/img/stuff/noglove.gif">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 ava-slot-wrapper">
                                            <div>
                                                <img src="/img/obraz/no_obraz.gif">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="row">
                                                <div class="col-12 slot">
                                                    <img src="/img/stuff/nohelmet.gif">
                                                </div>
                                                <div class="col-12 slot">
                                                    <img src="/img/stuff/nocloak.gif">
                                                </div>
                                                <div class="col-12 slot">
                                                    <img src="/img/stuff/noshield.gif">
                                                </div>
                                                <div class="col-12 slot">
                                                    <img src="/img/stuff/nolegs.gif">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-8">

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-spells" role="tabpanel" aria-labelledby="tab-spells-tab">...</div>
                    <div class="tab-pane fade" id="tab-actions" role="tabpanel" aria-labelledby="tab-actions-tab">...</div>
                </div>
                <!--<script src="navigation.js"></script>-->
            </div>
		    <div id="info" class="order-1 order-lg-2 col-12 col-lg-4 p-0 m-0 p-0 m-0">
		    	<iframe name="info" src="https://shamaal-world.ru/maingame/info0.php" class="w-100 h-100" marginwidivh="0" marginheight="0" scrolling="no" frameborder="0" seamless></iframe>
		    </div>
		    <div class="order-3 order-lg-3 col-12 col-lg-8 p-0 m-0 h-100">
		    	<div class="row h-24">
		    		<div class="col-12 h-24">
		    			<iframe id="mbar" name="mbar" src="https://shamaal-world.ru/maingame/bar0.php" class="w-100" height="24" frameborder="0" scrolling="no" noresize="" marginwidivh="0" marginheight="0" seamless></iframe>
		    		</div>
		    	</div>
		    	<div class="row h-100">
		    		<div class="col-12">
		    			<iframe name="talk" src="https://shamaal-world.ru/maingame/talk0.php" class="w-100 h-100" marginwidivh="0" marginheight="0" scrolling="auto" frameborder="0" seamless></iframe>
		    		</div>
		    	</div>
		    </div>
		    <div class="order-2 order-lg-4 col-12 col-lg-4 p-0 m-0 h-100">
				<div class="row h-24">
		    		<div class="col-12 h-24">
		    			<iframe name="look" src="https://shamaal-world.ru/maingame/look0.php" class="h-100 w-100" height="24" marginwidivh="0" marginheight="0" scrolling="no" frameborder="0" seamless></iframe>
		    		</div>
		    	</div>
		    	<div class="row h-100">
		    		<div class="col-12">
		    			<iframe name="users" src="https://shamaal-world.ru/maingame/users0.php" class="h-100 w-100" marginwidivh="0" marginheight="0" scrolling="auto" frameborder="0" seamless></iframe>
		    		</div>
		    	</div>
	    	</div>
			<div id="mobile-menu" class="order-4 order-lg-4 col-12 col-lg-4 d-block d-lg-none p-0 m-0">
				<button class="btn btn-primary float-left h-100 w-20 m-0 p-0">Инфо</button>
				<button class="btn btn-primary float-left h-100 w-20 m-0 p-0">Инв</button>
				<button class="btn btn-primary float-left h-100 w-20 m-0 p-0">Карта</button>
				<button class="btn btn-primary float-left h-100 w-20 m-0 p-0">Атака</button>
				<button class="btn btn-primary float-left h-100 w-20 m-0 p-0">Чат</button>
			</div>
	    	<div>
	    		<iframe name="ref" src="https://shamaal-world.ru/maingame/ref.php" class="d-none" marginwid="" th="0" marginheight="0" scrolling="no" frameborder="0" seamless></iframe>
	    		<iframe name="menu" src="https://shamaal-world.ru/maingame/menu.php" class="d-none"marginwidivh="0" marginheight="0" scrolling="no" frameborder="0"></iframe>
	    		<iframe name="enter" src="https://shamaal-world.ru/maingame/enter.php" class="d-none" marginwidivh="0" marginheight="0" scrolling="no" frameborder="0"></iframe>
	    		<iframe name="emap" src="https://shamaal-world.ru/maingame/map.php" class="d-none" marginwidivh="0" marginheight="0" scrolling="no" frameborder="0"></iframe>
	    	</div>
	    </div>
    </body>
</html>
