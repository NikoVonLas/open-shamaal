<?


$race_name[1] ='Человек';
$race_str[1] = 10;
$race_dex[1] = 10;
$race_int[1] = 10;
$race_wis[1] = 10;
$race_con[1] = 10;
$race_hp[1] = 1;
$race_mana[1] = 1;
$race_exp[1] = -0.05;
$race_bal[1] = 15;

$race_name[2] ='Эльф';
$race_str[2] = 8;
$race_dex[2] = 12;
$race_int[2] = 11;
$race_wis[2] = 11;
$race_con[2] = 8;
$race_hp[2] = 1;
$race_mana[2] = 1;
$race_exp[2] = 0;
$race_dex_bonus[2] = 1;
$race_bonus[2][1] = -10; // All
$race_bonus[2][2] = -10; // Fire
$race_bonus[2][3] = 0; // Water
$race_bonus[2][4] = 0; // Earth
$race_bonus[2][5] = 0; // Water
$race_bal[2] = 15;

$race_name[3] ='Гном';
$race_str[3] = 10;
$race_dex[3] = 8;
$race_int[3] = 10;
$race_wis[3] = 11;
$race_con[3] = 11;
$race_hp[3] = 2;
$race_mana[3] = 1;
$race_exp[3] = 0.05;
$race_bonus[3][2] = 10;
$race_bonus[3][3] = 10;
$race_bonus[3][4] = 10;
$race_bonus[3][5] = 10;

$race_name[4] ='Орк';
$race_str[4] = 12;
$race_dex[4] = 11;
$race_int[4] = 8;
$race_wis[4] = 7;
$race_con[4] = 12;
$race_hp[4] = 1;
$race_mana[4] = 1;
$race_exp[4] = 0.05;
$race_bonus[4][2] = -10;
$race_bonus[4][3] = -10;
$race_bonus[4][4] = -10;
$race_bonus[4][5] = -10;
$race_bleed[4] = 1;

$race_name[5] ='Тролль';
$race_str[5] = 13;
$race_dex[5] = 8;
$race_int[5] = 8;
$race_wis[5] = 8;
$race_con[5] = 13;
$race_hp[5] = 2;
$race_mana[5] = 1;
$race_exp[5] = 0;
$race_bonus[5][2] = 8;
$race_bonus[5][3] = 8;
$race_bonus[5][4] = 8;
$race_bonus[5][5] = 8;

$races = array(
	array(
		'name'  => 'Призрак'
	),
	array(
		'name'  => 'Человек',
		'str'   => 10,
		'dex'   => 10,
		'int'   => 10,
		'wis'   => 10,
		'con'   => 10,
		'hp'    => 1,
		'mana'  => 1,
		'bonuses' => array(
			'exp'   => -0.05,
			'bal'   => 15,
			'dex'   => 0,
			'bleed' => 0,
			'phys'  => 0,
			'fire'  => 0,
			'water' => 0,
			'earth' => 0,
			'air'   => 0,
		)
	),
	array(
		'name'  => 'Эльф',
		'str'   => 8,
		'dex'   => 12,
		'int'   => 11,
		'wis'   => 11,
		'con'   => 8,
		'hp'    => 1,
		'mana'  => 1,
		'bonuses' => array(
			'exp'   => 0,
			'bal'   => 15,
			'dex'   => 2,
			'bleed' => 0,
			'phys'  => -10,
			'fire'  => -10,
			'water' => 0,
			'earth' => 0,
			'air'   => 0
		)
	),
	array(
		'name'  => 'Гном',
		'str'   => 10,
		'dex'   => 8,
		'int'   => 10,
		'wis'   => 11,
		'con'   => 11,
		'hp'    => 2,
		'mana'  => 1,
		'bonuses' => array(
			'exp'   => 0.05,
			'bal'   => 0,
			'dex'   => 0,
			'bleed' => 0,
			'phys'  => 0,
			'fire'  => 10,
			'water' => 10,
			'earth' => 10,
			'air'   => 10,
		)
	),
	array(
		'name'  => 'Орк',
		'str'   => 12,
		'dex'   => 11,
		'int'   => 8,
		'wis'   => 7,
		'con'   => 12,
		'hp'    => 1,
		'mana'  => 1,
		'bonuses' => array(
			'exp'   => 0.05,
			'bal'   => 0,
			'dex'   => 0,
			'bleed' => 1,
			'phys'  => 0,
			'fire'  => -10,
			'water' => -10,
			'earth' => -10,
			'air'   => -10,
		)
	),
	array(
		'name'  => 'Тролль',
		'str'   => 13,
		'dex'   => 8,
		'int'   => 8,
		'wis'   => 8,
		'con'   => 13,
		'hp'    => 2,
		'mana'  => 1,
		'bonuses' => array(
			'exp'   => 0,
			'bal'   => 0,
			'dex'   => 0,
			'bleed' => 1,
			'phys'  => 0,
			'fire'  => 8,
			'water' => 8,
			'earth' => 8,
			'air'   => 8,
		)
	),
);

function exptolevel($level,$race)
{
	global $race_exp;
	$level++;

	return round(($level*$level*5+$level*40)*(1+$race_exp[$race]));
}
