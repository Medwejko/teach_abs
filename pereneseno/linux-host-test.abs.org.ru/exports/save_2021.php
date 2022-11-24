<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/system/config.php';
/*формирование данных по id*/
$collection = api::collection('result',array('task'=>$_REQUEST['id']));

$textQuestion = array();
$balQuestion = array();
$col1 = 0;
$col2 = 0;
$col3 = 0;
$col4 = 0;
$midall1 = 0;
$collall1 = 0;
$midall2 = 0;
$collall2 = 0;
$midall3 = 0;
$collall3 = 0;
$midall4 = 0;
$collall4 = 0;
foreach ($collection as $result) {

	$tususer[] = $result->tus;
	$user[] = $result->user;
	$test = $result->task->test->id;
	switch ($result->tus) {

		case '1':
		foreach ($result->task->test->question as $place) {

			foreach ($result->registr_result as $rr) {
				if ($place->id == $rr->question->id) {

					if ($rr->question->type == 0) {
						$type = 0;
						$answer = array(
							'tus' => "Cамооценка",
							'user' => $result->user,
							'answer_text' => $rr->answer_text
						);
						$textQuestion[$rr->question->text][] = $answer;

					} elseif ($rr->question->type == 3) {
						if (is_numeric($rr->answer_text)) {
							$midall1 += $rr->answer_text;
							$collall1++;
						}
						$type = 3;
						if (isset($balQuestion[$rr->question->text]['sum1'])) {
							$balQuestion[$rr->question->text][$rr->answer->text]['sum1'] += $rr->answer_text;

						} else {
							$balQuestion[$rr->question->text][$rr->answer->text]['sum1'] = $rr->answer_text;
						}

						if (isset($balQuestion[$rr->question->text][$rr->answer->text]['col1'])) {

							$balQuestion[$rr->question->text][$rr->answer->text]['col1']++;

						} else {

							$balQuestion[$rr->question->text][$rr->answer->text]['col1'] = 1;
						};

					} else {
						$answer = array(
							'tus' => "Cамооценка",
							'user' => $result->user,
							'answer_text' => $rr->answer->text
						);
						$balQuestion[$rr->question->text]['sum1'] = $rr->answer->weight;
						$balQuestion[$rr->question->text]['col1'] = 1;
					};
				};
			}
		}
		break;

		case '2':
		foreach ($result->task->test->question as $place) {
			foreach ($result->registr_result as $rr) {
				if ($place->id == $rr->question->id) {
					if ($rr->question->type == 0) {
						$type = 0;
						$answer = array(
							'tus' => "Руководитель",
							'user' => $result->user,
							'answer_text' => $rr->answer_text
						);
						$textQuestion[$rr->question->text][] = $answer;

					} elseif ($rr->question->type == 3) {
						if (is_numeric($rr->answer_text)) {
							$midall2 += $rr->answer_text;
							$collall2++;
						}
						$type = 3;

						if (isset($balQuestion[$rr->question->text][$rr->question->answer->text]['sum2'])) {
							$balQuestion[$rr->question->text][$rr->question->answer->text]['sum2'] += $rr->answer_text;

						} else {
							$balQuestion[$rr->question->text][$rr->question->answer->text]['sum2'] = $rr->answer_text;
						}

						if (isset($balQuestion[$rr->question->text][$rr->question->answer->text]['col2'])) {

							$balQuestion[$rr->question->text][$rr->question->answer->text]['col2']++;

						} else {

							$balQuestion[$rr->question->text][$rr->question->answer->text]['col2'] = 1;
						};

					} else {
						if (isset($balQuestion[$rr->question->text]['sum2'])) {
							$balQuestion[$rr->question->text]['sum2'] += $rr->answer->weight;

						} else {
							$balQuestion[$rr->question->text]['sum2'] = $rr->answer->weight;
						}
						if ($rr->answer->weight != 0) {
							if (isset($balQuestion[$rr->question->text]['col2'])) {

								$balQuestion[$rr->question->text]['col2']++;

							} else {

								$balQuestion[$rr->question->text]['col2'] = 1;
							};
						};
					};
				};
			};
		};
		break;

		case '3':
		foreach ($result->task->test->question as $place) {
			foreach ($result->registr_result as $rr) {
				if ($place->id == $rr->question->id) {
					if ($rr->question->type == 0) {
						$type = 0;
						$answer = array(
							'tus' => "Коллега",
							'user' => $result->user,
							'answer_text' => $rr->answer_text
						);
						$textQuestion[$rr->question->text][] = $answer;
					} elseif ($rr->question->type == 3) {
						if (is_numeric($rr->answer_text)) {
							$midall3 += $rr->answer_text;
							$collall3++;
						}
						$type = 3;

						if (isset($balQuestion[$rr->question->text][$rr->question->answer->text]['sum3'])) {
							$balQuestion[$rr->question->text][$rr->question->answer->text]['sum3'] += $rr->answer_text;

						} else {
							$balQuestion[$rr->question->text][$rr->question->answer->text]['sum3'] = $rr->answer_text;
						}

						if (isset($balQuestion[$rr->question->text][$rr->question->answer->text]['col3'])) {

							$balQuestion[$rr->question->text][$rr->question->answer->text]['col3']++;

						} else {

							$balQuestion[$rr->question->text][$rr->question->answer->text]['col3'] = 1;
						};

					} else {
						if (isset($balQuestion[$rr->question->text]['sum3'])) {
							$balQuestion[$rr->question->text]['sum3'] += $rr->answer->weight;

						} else {
							$balQuestion[$rr->question->text]['sum3'] = $rr->answer->weight;
						}
						if (isset($balQuestion[$rr->question->text]['col3'])) {

							$balQuestion[$rr->question->text]['col3']++;

						} else {

							$balQuestion[$rr->question->text]['col3'] = 1;
						};
					};
				};
			};
		};
		break;

		case '4':
		foreach ($result->task->test->question as $place) {
			foreach ($result->registr_result as $rr) {
				if ($place->id == $rr->question->id) {
					if ($rr->question->type == 0) {
						$type = 0;
						$answer = array(
							'tus' => "Подчиненный",
							'user' => $result->user,
							'answer_text' => $rr->answer_text
						);
						$textQuestion[$rr->question->text][] = $answer;
					} elseif ($rr->question->type == 3) {
						if (is_numeric($rr->answer_text)) {
							$midall4 += $rr->answer_text;
							$collall4++;
						}
						$type = 3;

						if (isset($balQuestion[$rr->question->text][$rr->question->answer->text]['sum4'])) {
							$balQuestion[$rr->question->text][$rr->question->answer->text]['sum4'] += $rr->answer_text;

						} else {
							$balQuestion[$rr->question->text][$rr->question->answer->text]['sum4'] = $rr->answer_text;
						}

						if (isset($balQuestion[$rr->question->text][$rr->question->answer->text]['col4'])) {

							$balQuestion[$rr->question->text][$rr->question->answer->text]['col4']++;

						} else {

							$balQuestion[$rr->question->text][$rr->question->answer->text]['col4'] = 1;
						};

					} else {
						if (isset($balQuestion[$rr->question->text]['sum4'])) {

							$balQuestion[$rr->question->text]['sum4'] += $rr->answer->weight;

						} else {

							$balQuestion[$rr->question->text]['sum4'] = $rr->answer->weight;
						}
						if (isset($balQuestion[$rr->question->text]['col4'])) {

							$balQuestion[$rr->question->text]['col4']++;

						} else {

							$balQuestion[$rr->question->text]['col4'] = 1;
						}
					};
				};
			};
		};
		break;


	};

};

/*заполнение excel*/

$header = file_get_contents('header.php');
$footer = file_get_contents('footer.php');

$user = $collection[0]->task->user->surname.' '.$collection[0]->task->user->name.' '.$collection[0]->task->user->middlename;

$test = $collection[0]->task->test->name;
$low = "<td class=xl75 width=114 style='border-top:none;border-left:none;width:86pt'>";
$middle = "<td class=xl74 width=114 style='border-top:none;border-left:none;width:86pt'>";
$hight = "<td class=xl72 width=114 style='border-top:none;border-left:none;width:86pt'>";
$awsome = "<td class=xl73 width=114 style='border-top:none;border-left:none;width:86pt'>";
$def = "<td class=xl66 width=114 style='border-top:none;border-left:none;width:86pt'>";


$user = mb_convert_encoding($user, 'cp1251');
$test = mb_convert_encoding($test, 'cp1251');
$body = "<table border=0 cellpadding=0 cellspacing=0 width=1195 style='border-collapse:
collapse;table-layout:fixed;width:898pt'>
<col width=36 style='mso-width-source:userset;mso-width-alt:1316;width:27pt'>
<col width=703 style='mso-width-source:userset;mso-width-alt:25709;width:527pt'>
<col width=114 span=4 style='mso-width-source:userset;mso-width-alt:4169;
width:86pt'>
<col width=61 span=20 style='mso-width-source:userset;mso-width-alt:2230;
width:46pt'>
<tr class=xl83 height=33 style='mso-height-source:userset;height:24.75pt'>
<td colspan=7 height=33 class=xl80 width=1195 style='border-right:.5pt solid black;
height:24.75pt;width:898pt'>Результаты оценки</td>
</tr>";

$body .= "<tr class=xl83 height=33 style='mso-height-source:userset;height:24.75pt'>
<td colspan=7 height=33 class=xl84 style='border-right:.5pt solid black;
height:24.75pt'>".$user."</td>
</tr>";


$body .= "<tr class=xl83 height=33 style='mso-height-source:userset;height:24.75pt'>
<td colspan=7 height=33 class=xl80 width=1195 style='border-right:.5pt solid black;
height:24.75pt;width:898pt'>".$test."</td>
</tr>";


$body .= "<tr class=xl83 height=33 style='mso-height-source:userset;height:24.75pt'>
<td colspan=7 height=33 class=xl85 style='border-right:.5pt solid black;
height:24.75pt'>Анализ по каждой компетенции</td>
</tr>
<tr height=55 style='mso-height-source:userset;height:41.25pt'>
<td colspan=7 height=55 class=xl79 width=1195 style='border-right:.5pt solid black;
height:41.25pt;width:898pt'>Этот раздел аналитической части отчета подробно
сравнивается оценка каждой группы опрошенных, средняя оценка, Ваша самооценка
и желаемый уровень для данной компетенции:</td>
</tr>
<tr height=43 style='mso-height-source:userset;height:32.25pt'>
<td height=43 class=xl65 width=36 style='height:32.25pt;border-top:none;
width:27pt'>&nbsp;</td>
<td class=xl66 width=703 style='border-top:none;border-left:none;width:527pt'>3,3
- 4</td>
<td colspan=5 class=xl76 width=456 style='border-right:.5pt solid black;
border-left:none;width:344pt'>желаемый уровень</td>
</tr>
<tr height=43 style='mso-height-source:userset;height:32.25pt'>
<td height=43 class=xl67 width=36 style='height:32.25pt;border-top:none;
width:27pt'>&nbsp;</td>
<td class=xl66 width=703 style='border-top:none;border-left:none;width:527pt'>2,6
-3,2</td>
<td colspan=5 class=xl76 width=456 style='border-right:.5pt solid black;
border-left:none;width:344pt'>оптимальный уровень</td>
</tr>
<tr height=43 style='mso-height-source:userset;height:32.25pt'>
<td height=43 class=xl68 width=36 style='height:32.25pt;border-top:none;
width:27pt'>&nbsp;</td>
<td class=xl66 width=703 style='border-top:none;border-left:none;width:527pt'>1,1
- 2,5</td>
<td colspan=5 class=xl76 width=456 style='border-right:.5pt solid black;
border-left:none;width:344pt'>низкий уровень</td>
</tr>
<tr height=43 style='mso-height-source:userset;height:32.25pt'>
<td height=43 class=xl69 width=36 style='height:32.25pt;border-top:none;
width:27pt'>&nbsp;</td>
<td class=xl66 width=703 style='border-top:none;border-left:none;width:527pt'>1</td>
<td colspan=5 class=xl76 width=456 style='border-right:.5pt solid black;
border-left:none;width:344pt'>отсутствует</td>
</tr>
<tr height=86 style='mso-height-source:userset;height:64.5pt'>

<td colspan=2 class=xl70 width=703 style='border-top:none;border-left:none;width:527pt'>Компетенции</td>
<td class=xl70 width=114 style='border-top:none;border-left:none;width:86pt'>Самооценка</td>
<td class=xl70 width=114 style='border-top:none;border-left:none;width:86pt'>Оценка
руководителя</td>
<td class=xl70 width=114 style='border-top:none;border-left:none;width:86pt'>Оценка
коллег</td>
<td class=xl70 width=114 style='border-top:none;border-left:none;width:86pt'>Оценка
подчиненных</td>
<td class=xl70 width=114 style='border-top:none;border-left:none;width:86pt'>Средний балл</td>
</tr>";

$sumall1 = 0;
$sumall2 = 0;
$sumall3 = 0;
$sumall4 = 0;
$midcollall = 0;
if ($collall1 > 0) {
	$sumall1 = $midall1 / $collall1;
	$sumall1 = round($sumall1, 1);
	$midcollall++;
}
if ($collall2 > 0) {
	$sumall2 = $midall2 / $collall2;
	$sumall2 = round($sumall2, 1);
	$midcollall++;
}
if ($collall3 > 0) {
	$sumall3 = $midall3 / $collall3;
	$sumall3 = round($sumall3, 1);
	$midcollall++;
}
if ($collall4 > 0) {
	$sumall4 = $midall1 / $collall1;
	$sumall4 = round($sumall4, 1);
	$midcollall++;
}

$midall = $sumall1 + $sumall2 + $sumall3 + $sumall4;
$midall = $midall / $midcollall;
$midall = round($midall, 1);
$body.="<tr height=86 style='mso-height-source:userset;height:64.5pt'>
<td colspan=2 class=xl71 width=703 style='border-top:none;border-left:none;width:527pt'>Средний балл по всем компетенциям</td>";
if ($sumall1 > 0)
{
	switch (true) {
		case $sumall1 <= 0.1:
		$body.= $def;
		break;

		case $sumall1 <= 1.1:
		$body.= $low;
		break;

		case $sumall1 <= 2.5:
		$body.= $middle;
		break;

		case $sumall1 <= 3.2:
		$body.= $hight;
		break;

		case $sumall1 <= 4:
		$body.= $hight;
		break;
		default:
		$body.= $def;
		break;

	};
	$sumall1 = number_format($sumall1, 1, ',', '');
	$body.= $sumall1 . '</td>';

}
else
{
	$body.= "<td class=xl66 width=114 style='border-top:none;border-left:none;width:86pt'>Н/Д</td>";
}

if ($sumall2 > 0)
{
	switch (true) {
		case $sumall2 <= 0.1:
		$body.= $def;
		break;

		case $sumall2 <= 1.1:
		$body.= $low;
		break;

		case $sumall2 <= 2.5:
		$body.= $middle;
		break;

		case $sumall2 <= 3.2:
		$body.= $hight;
		break;

		case $sumall2 <= 4:
		$body.= $hight;
		break;
		default:
		$body.= $def;
		break;

	};
	$sumall2 = number_format($sumall2, 1, ',', '');
	$body.= $sumall2 . '</td>';

}
else
{
	$body.= "<td class=xl66 width=114 style='border-top:none;border-left:none;width:86pt'>Н/Д</td>";
}

if ($sumall3 > 0)
{
	switch (true) {
		case $sumall3 <= 0.1:
		$body.= $def;
		break;

		case $sumall3 <= 1.1:
		$body.= $low;
		break;

		case $sumall3 <= 2.5:
		$body.= $middle;
		break;

		case $sumall3 <= 3.2:
		$body.= $hight;
		break;

		case $sumall3 <= 4:
		$body.= $hight;
		break;
		default:
		$body.= $def;
		break;

	};
	$sumall3 = number_format($sumall3, 1, ',', '');
	$body.= $sumall3 . '</td>';

}
else
{
	$body.= "<td class=xl66 width=114 style='border-top:none;border-left:none;width:86pt'>Н/Д</td>";
}

if ($sumall4 > 0)
{
	switch (true) {
		case $sumall4 <= 0.1:
		$body.= $def;
		break;

		case $sumall4 <= 1.1:
		$body.= $low;
		break;

		case $sumall4 <= 2.5:
		$body.= $middle;
		break;

		case $sumall4 <= 3.2:
		$body.= $hight;
		break;

		case $sumall4 <= 4:
		$body.= $hight;
		break;
		default:
		$body.= $def;
		break;

	};
	$sumall4 = number_format($sumall4, 1, ',', '');
	$body.= $sumall4 . '</td>';

}
else
{
	$body.= "<td class=xl66 width=114 style='border-top:none;border-left:none;width:86pt'>Н/Д</td>";
}

if ($midall > 0)
{
	switch (true) {
		case $midall <= 0.1:
		$body.= $def;
		break;

		case $midall <= 1.1:
		$body.= $low;
		break;

		case $midall <= 2.5:
		$body.= $middle;
		break;

		case $midall <= 3.2:
		$body.= $hight;
		break;

		case $midall <= 4:
		$body.= $hight;
		break;
		default:
		$body.= $def;
		break;

	};
	$midall = number_format($midall, 1, ',', '');
	$body.= $midall . '</td>';

}
else
{
	$body.= "<td class=xl66 width=114 style='border-top:none;border-left:none;width:86pt'>Н/Д</td>";
}

foreach ($balQuestion as $question => $answer) {
	$roundVal = 1;
	$sum1answecol = 0;
	$sum2answercol = 0;
	$sum3answercol = 0;
	$sum4answercol = 0;

	$sum1answersum = 0;
	$sum2answersum = 0;
	$sum3answersum = 0;
	$sum4answersum = 0;

	foreach ($answer as $answer_text => $sum) {
		if (isset($sum['sum1']) and is_numeric($sum['sum1'])) {
			$sum1answersum = $sum1answersum += $sum['sum1'];
			$sum1answecol++;
		}
		if (isset($sum['sum2']) and is_numeric($sum['sum2'])) {
			$sum2answersum = $sum2answersum += $sum['sum1'];
			$sum2answercol++;
		}
		if (isset($sum['sum3']) and is_numeric($sum['sum3'])) {
			$sum3answersum = $sum3answersum += $sum['sum1'];
			$sum3answercol++;
		}
		if (isset($sum['sum4']) and is_numeric($sum['sum4'])) {
			$sum4answersum = $sum4answersum += $sum['sum1'];
			$sum4answercol++;
		}

	}
	$mid1 = 0;
	$mid2 = 0;
	$mid3 = 0;
	$mid4 = 0;

	$sum1mid = 0;
	$sum2mid = 0;
	$sum3mid = 0;
	$sum4mid = 0;

	$midcoll = 0;
	if ($sum1answersum > 0) {
		$sum1mid = $sum1answersum / $sum1answecol;
		$sum1mid = round($sum1mid, 1);
		$mid1 = $sum1mid;
		$midcoll++;
	}
	if ($sum2answersum > 0) {
		$sum2mid = $sum2answersum / $sum2answecol;
		$sum2mid = round($sum2mid, 1);
		$mid2 = $sum2mid;
		$midcoll++;

	}
	if ($sum3answersum > 0) {
		$sum3mid = $sum3answersum / $sum3answecol;
		$sum3mid = round($sum3mid, 1);
		$mid3 = $sum3mid;
		$midcoll++;

	}
	if ($sum4answersum > 0) {
		$sum4mid = $sum4answersum / $sum4answecol;
		$sum4mid = round($sum1mid, 1);
		$mid4 = $sum4mid;
		$midcoll++;

	}
	$sum5 = $mid1 + $mid2 + $mid3 + $mid4;
	if ($midcoll > 0)
	{
		$mid5 = $sum5 / $midcoll;
		$mid5 = round($mid5, 1);

	}

	;

	$question = mb_convert_encoding($question, 'cp1251');

	$body.="<tr height=86 style='mso-height-source:userset;height:64.5pt'>
	<td colspan=2 class=xl71 width=703 style='border-top:none;border-left:none;width:527pt'>". $question ."</td>";

	if ($sum1mid > 0)
	{
		switch (true) {
			case $sum1mid <= 0.1:
			$body.= $def;
			break;

			case $sum1mid <= 1.1:
			$body.= $low;
			break;

			case $sum1mid <= 2.5:
			$body.= $middle;
			break;

			case $sum1mid <= 3.2:
			$body.= $hight;
			break;

			case $sum1mid <= 4:
			$body.= $hight;
			break;
			default:
			$body.= $def;
			break;

		};
		$sum1mid = number_format($sum1mid, 1, ',', '');
		$body.= $sum1mid . '</td>';

	}
	else
	{
		$body.= "<td class=xl66 width=114 style='border-top:none;border-left:none;width:86pt'>Н/Д</td>";
	}

	if ($sum2mid > 0)
	{
		switch (true) {
			case $sum2mid <= 0.1:
			$body.= $def;
			break;

			case $sum2mid <= 1.1:
			$body.= $low;
			break;

			case $sum2mid <= 2.5:
			$body.= $middle;
			break;

			case $sum2mid <= 3.2:
			$body.= $hight;
			break;

			case $sum2mid <= 4:
			$body.= $hight;
			break;
			default:
			$body.= $def;
			break;

		};
		$sum2mid = number_format($sum2mid, 1, ',', '');
		$body.= $sum2mid . '</td>';

	}
	else
	{
		$body.= "<td class=xl66 width=114 style='border-top:none;border-left:none;width:86pt'>Н/Д</td>";
	}
	if ($sum3mid > 0)
	{
		switch (true) {
			case $sum3mid <= 0.1:
			$body.= $def;
			break;

			case $sum3mid <= 1.1:
			$body.= $low;
			break;

			case $sum3mid <= 2.5:
			$body.= $middle;
			break;

			case $sum3mid <= 3.2:
			$body.= $hight;
			break;

			case $sum3mid <= 4:
			$body.= $hight;
			break;
			default:
			$body.= $def;
			break;

		};
		$sum3mid = number_format($sum3mid, 1, ',', '');
		$body.= $sum3mid . '</td>';

	}
	else
	{
		$body.= "<td class=xl66 width=114 style='border-top:none;border-left:none;width:86pt'>Н/Д</td>";
	}
	if ($sum4mid > 0)
	{
		switch (true) {
			case $sum4mid <= 0.1:
			$body.= $def;
			break;

			case $sum4mid <= 1.1:
			$body.= $low;
			break;

			case $sum4mid <= 2.5:
			$body.= $middle;
			break;

			case $sum4mid <= 3.2:
			$body.= $hight;
			break;

			case $sum4mid <= 4:
			$body.= $hight;
			break;
			default:
			$body.= $def;
			break;

		};
		$sum4mid = number_format($sum4mid, 1, ',', '');
		$body.= $sum4mid . '</td>';

	}
	else
	{
		$body.= "<td class=xl66 width=114 style='border-top:none;border-left:none;width:86pt'>Н/Д</td>";
	}

	if ($mid5 > 0)
	{
		switch (true) {
			case $mid5 <= 0.1:
			$body.= $def;
			break;

			case $mid5 <= 1.1:
			$body.= $low;
			break;

			case $mid5 <= 2.5:
			$body.= $middle;
			break;

			case $mid5 <= 3.2:
			$body.= $hight;
			break;

			case $mid5 <= 4:
			$body.= $hight;
			break;
			default:
			$body.= $def;
			break;

		};
		$mid5 = number_format($mid5, 1, ',', '');
		$body.= $mid5 . '</td>';

	}
	else
	{
		$body.= "<td class=xl66 width=114 style='border-top:none;border-left:none;width:86pt'>Н/Д</td>";
	}


	foreach ($answer as $answer_text => $sum) 
	{
		$roundVal = 1;

		$answer_text = mb_convert_encoding($answer_text, 'cp1251');
		$body.="<tr height=86 style='mso-height-source:userset;height:64.5pt'>
		<td colspan=2 class=xl71 width=703 style='border-top:none;border-left:none;width:527pt'>". $answer_text ."</td>";

		if(isset($sum['sum1']))
		{			
			$sum1 = $sum['sum1'];
			if (isset($sum['col1'])) 
			{
				$self = $sum1 / $sum['col1'];
				$self = round($self, 1);

			}
			else
			{
				$sum['col1'] = 0;
				$self = $sum['sum1'];
			};
			switch (true) {

				case $self <= 1.1:
				$body.= $low;
				break;

				case $self <= 2.5:
				$body.= $middle;
				break;

				case $self <= 3.2:
				$body.= $hight;
				break;

				case $self <= 4:
				$body.= $awsome;
				break;

				default:
				$body.= $def;
				break;
			};
			$self = number_format($self, 1, ',', '');

			$body.= $self .'</td>'; 
		}
		else
		{
			$sum['col1'] = 0;
			$sum['sum1'] = 0;
			$body.= "<td class=xl66 width=114 style='border-top:none;border-left:none;width:86pt'>Н/Д</td>";
		};

		if(isset($sum['sum2']))
		{			
			$sum2 = $sum['sum2'];
			if (isset($sum['col2'])) 
			{
				$boss = $sum2 / $sum['col2'];
				$boss = round($boss, 1);

			}
			else
			{
				$sum['col2'] = 0;
				$boss = $sum['sum2'];
			};
			switch (true) {

				case $boss <= 1.1:
				$body.= $low;
				break;

				case $boss <= 2.5:
				$body.= $middle;
				break;

				case $boss <= 3.2:
				$body.= $hight;
				break;

				case $boss <= 4:
				$body.= $awsome;
				break;
				default:
				$body.= $def;
				break;

			};
			$boss = number_format($boss, 1, ',', '');

			$body.= $boss .'</td>'; 
		}
		else
		{
			$sum['col2'] = 0;
			$sum['sum2'] = 0;
			$body.= "<td class=xl66 width=114 style='border-top:none;border-left:none;width:86pt'>Н/Д</td>";
		};

		if(isset($sum['sum3']))
		{			
			$sum3 = $sum['sum3'];
			if (isset($sum['col3'])) 
			{
				$subject = $sum3 / $sum['col3'];
				$subject = round($subject, 1);

			}
			else
			{
				$sum['col3'] = 0;
				$subject = $sum['sum3'];
			};
			switch (true) {

				case $subject <= 1.1:
				$body.= $low;
				break;

				case $subject <= 2.5:
				$body.= $middle;
				break;

				case $subject <= 3.2:
				$body.= $hight;
				break;

				case $subject <= 4:
				$body.= $awsome;
				break;

				default:
				$body.= $def;
				break;
			};
			$subject = number_format($subject, 1, ',', '');

			$body.= $subject .'</td>'; 
		}
		else
		{
			$sum['col3'] = 0;
			$sum['sum3'] = 0;
			$body.= "<td class=xl66 width=114 style='border-top:none;border-left:none;width:86pt'>Н/Д</td>";
		};

		if(isset($sum['sum4']))
		{			
			$sum4 = $sum['sum4'];
			if (isset($sum['col4'])) 
			{
				$colleague = $sum4 / $sum['col4'];
				$colleague = round($subject, 1);

			}
			else
			{
				$sum['col4'] = 0;
				$colleague = $sum['sum4'];
			};
			switch (true) {

				case $colleague <= 1.1:
				$body.= $low;
				break;

				case $colleague <= 2.5:
				$body.= $middle;
				break;

				case $colleague <= 3.2:
				$body.= $hight;
				break;

				case $colleague <= 4:
				$body.= $awsome;
				break;

				default:
				$body.= $def;
				break;
			};
			$colleague = number_format($subject, 1, ',', '');

			$body.= $colleague .'</td>'; 
		}
		else
		{
			$sum['col4'] = 0;
			$sum['sum4'] = 0;
			$body.= "<td class=xl66 width=114 style='border-top:none;border-left:none;width:86pt'>Н/Д</td>";
		};


		$midcol = $sum['col1']+$sum['col2']+$sum['col3']+$sum['col4'];
		$midding = $sum['sum1']+$sum['sum2']+$sum['sum3']+$sum['sum4'];
		if ($midcol != 0) 
		{
			$midResult = $midding / $midcol;
			$midResult = round($midResult, 1);

		}
		else
		{
			$midResult = 0;
		}
		switch (true) {

			case $midResult <= 1.1:
			$body.= $low;
			break;

			case $midResult <= 2.5:
			$body.= $middle;
			break;

			case $midResult <= 3.2:
			$body.= $hight;
			break;

			case $midResult <= 4:
			$body.= $awsome;
			break;

			default:
			$body.= $def;
			break;
		};
		$midResult = number_format($midResult, 1, ',', '');

		$body.= $midResult .'</td>'; 
		$body.="</tr>";

	};
}




$document = $header.$body.$footer;

	// Если это файл и он равен удаляемому ... 
try {
	if((is_file("upload/report_2021.xls"))) 
	{ 
		unlink("upload/report_2021.xls"); 
		if(!file_exists("upload/report_2021.xls"))
		{
			echo 'file is delete';
			file_put_contents('upload/report_2021.xls', $document);
			echo json_encode(array('status'=>'ok'));
		}; 
	}
	else
	{
		echo 'file not found';
		file_put_contents('upload/report_2021.xls', $document);
		echo json_encode(array('status'=>'ok'));
	}; 
} catch (Exception $e) {
	echo '<pre>';
	print_r($e);
	echo '</pre>';
	echo json_encode(array('status'=>'error'));	
};


?>