<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . '/system/config.php';
if (!$_SESSION['user'] or $_SESSION['user']->group->access == 2) {
	header('Location: http://staff.ska.su');
}

$users = api::collection('user', array('id' =>$_REQUEST['user']));
?>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
	integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
	crossorigin="anonymous">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
	integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr"
	crossorigin="anonymous">



	<title>Отчет</title>
	<style>
		@page { margin: 8mm; }
		@media print {
			.no-print, .no-print * {
				display: none !important;

			}
		}
		hr { page-break-before: always; }
		table, th, td {
			border: 1px solid #ddd;
			padding: .0rem;

		}

	</style>
</head>
<body>

	<div class="container-fluid">


		<h5 style="float: right;" class="btn btn-outline-secondary no-print" onclick="window.print();">Печать</h5>

		<?php
		function calculate_age($birthday) {
			$birthday_timestamp = strtotime($birthday);
			$age = date('Y') - date('Y', $birthday_timestamp);
			if (date('md', $birthday_timestamp) > date('md')) {
				$age--;
			}
			return $age;
		}
		foreach ($users as $obj ) {
			$user = [];
			$tususer = [];
			$textQuestion = [];
			$balQuestion = [];
			date_default_timezone_set('Europe/Moscow');
			$currentdate = date("Y-m-d");
			$currdate= date('Y');
			$currdatem= date('m');
			$birthdaydate= date('Y-m-d',strtotime($obj->birthday));
			$employdate= date('Y',strtotime($obj->employ));

			$employdatem= date('m',strtotime($obj->employ));
			$employm = $currdatem - $employdatem;
			$employ = $currdate - $employdate;


			$currdated = date('d');
			$employdated = date ('d', strtotime($obj->employ));
			$employd = $currdated - $employdated;
			if ($employd < 0) {
				$employm --;
			}
			if ($employm < 0) 
			{
				$employm = $employm + 12;
				$employ = $employ - 1;
			};
			$collection = api::collection('user');

			$boss_name = "Не назначен";
			$functionBoss_name = "Не назначен";
			foreach ($collection as $user_obj) 
			{
				if ($obj->boss == $user_obj->id) 
				{
					$boss_name = $user_obj->surname.' '.$user_obj->name.' '.$user_obj->middlename;
					$boss = $user_obj->id;
				}
				elseif ($obj->functionBoss == $user_obj->id) 
				{
					$functionBoss_name = $user_obj->surname.' '.$user_obj->name.' '.$user_obj->middlename;
					$functionBoss = $user_obj->id;
				};
			};  
			$results = [];
			$balls = [];

			$tasks = api::collection('task', array('user' => $obj->id, 'project' => $_REQUEST['project']));
			foreach ($tasks as $task) {
				$check = false;
				foreach ($task->registr_task as $rt)
				{
					if($rt->status == 1)
					{
						$check = true;
					};
				};

				if($check)
				{
					$results[] = api::collection('result',array('task' => $task->id));
				}
			}






			foreach ($results as $key => $res) {
				$collall4[$key] = 0;
				$collall1[$key] = 0;
				$collall2[$key] = 0;
				$collall3[$key] = 0;
				$midall1[$key] = 0;
				$midall2[$key] = 0;
				$midall3[$key] = 0;
				$midall4[$key] = 0;
				foreach ($res as $result) {
					$type[$key] = 1;
					$tususer[$key][] = $result->tus;
					$user[$key][] = $result->user;
					$test[$key] = $result->task->test->id;


					switch ($result->tus) {

						case '1':
						foreach ($result->task->test->question as $place) {

							foreach ($result->registr_result as $rr) {
								if ($place->id == $rr->question->id) {

									if ($rr->question->type == 0) {
										$type[$key] = 0;
										$answer = array(
											'tus' => "Cамооценка",
											'user' => $result->user,
											'answer_text' => $rr->answer_text
										);
										$textQuestion[$key][$rr->question->text][] = $answer;

									} elseif ($rr->question->type == 3) {
										if (is_numeric($rr->answer_text)) {
											$midall1[$key] += $rr->answer_text;
											$collall1[$key]++;
										}
										$type[$key] = 3;
										if (isset($balQuestion[$key][$result->task->test->id][$rr->question->text]['sum1'])) {
											$balQuestion[$key][$result->task->test->id][$rr->question->text][$rr->answer->text]['sum1'] += $rr->answer_text;

										} else {
											$balQuestion[$key][$result->task->test->id][$rr->question->text][$rr->answer->text]['sum1'] = $rr->answer_text;
										}

										if (isset($balQuestion[$key][$result->task->test->id][$rr->question->text][$rr->answer->text]['col1'])) {

											$balQuestion[$key][$result->task->test->id][$rr->question->text][$rr->answer->text]['col1']++;

										} else {

											$balQuestion[$key][$result->task->test->id][$rr->question->text][$rr->answer->text]['col1'] = 1;
										};

									} else {
										$answer = array(
											'tus' => "Cамооценка",
											'user' => $result->user,
											'answer_text' => $rr->answer->text
										);
										$balQuestion[$key][$result->task->test->id][$rr->question->text]['sum1'] = $rr->answer->weight;
										$balQuestion[$key][$result->task->test->id][$rr->question->text]['col1'] = 1;
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
										$type[$key] = 0;
										$answer = array(
											'tus' => "Руководитель",
											'user' => $result->user,
											'answer_text' => $rr->answer_text
										);
										$textQuestion[$key][$rr->question->text][] = $answer;

									} elseif ($rr->question->type == 3) {
										if (is_numeric($rr->answer_text)) {

											$midall2[$key] += $rr->answer_text;
											$collall2[$key]++;

										}
										$type[$key] = 3;

										if (isset($balQuestion[$key][$result->task->test->id][$rr->question->text][$rr->answer->text]['sum2'])) {
											$balQuestion[$key][$result->task->test->id][$rr->question->text][$rr->answer->text]['sum2'] += $rr->answer_text;

										} else {
											$balQuestion[$key][$result->task->test->id][$rr->question->text][$rr->answer->text]['sum2'] = $rr->answer_text;
										}

										if (isset($balQuestion[$key][$result->task->test->id][$rr->question->text][$rr->answer->text]['col2'])) {

											$balQuestion[$key][$result->task->test->id][$rr->question->text][$rr->answer->text]['col2']++;

										} else {

											$balQuestion[$key][$result->task->test->id][$rr->question->text][$rr->answer->text]['col2'] = 1;
										};

									} else {
										if (isset($balQuestion[$key][$result->task->test->id][$rr->question->text]['sum2'])) {
											$balQuestion[$key][$result->task->test->id][$rr->question->text]['sum2'] += $rr->answer->weight;

										} else {
											$balQuestion[$key][$result->task->test->id][$rr->question->text]['sum2'] = $rr->answer->weight;
										}
										if ($rr->answer->weight != 0) {
											if (isset($balQuestion[$key][$result->task->test->id][$rr->question->text]['col2'])) {

												$balQuestion[$key][$result->task->test->id][$rr->question->text]['col2']++;

											} else {

												$balQuestion[$key][$result->task->test->id][$rr->question->text]['col2'] = 1;
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
										$type[$key] = 0;
										$answer = array(
											'tus' => "Коллега",
											'user' => $result->user,
											'answer_text' => $rr->answer_text
										);
										$textQuestion[$key][$rr->question->text][] = $answer;
									} elseif ($rr->question->type == 3) {
										if (is_numeric($rr->answer_text)) {
											$midall3[$key] += $rr->answer_text;
											$collall3[$key]++;

										}
										$type[$key] = 3;

										if (isset($balQuestion[$key][$result->task->test->id][$rr->question->text][$rr->answer->text]['sum3'])) {
											$balQuestion[$key][$result->task->test->id][$rr->question->text][$rr->answer->text]['sum3'] += $rr->answer_text;

										} else {
											$balQuestion[$key][$result->task->test->id][$rr->question->text][$rr->answer->text]['sum3'] = $rr->answer_text;
										}

										if (isset($balQuestion[$key][$result->task->test->id][$rr->question->text][$rr->answer->text]['col3'])) {

											$balQuestion[$key][$result->task->test->id][$rr->question->text][$rr->answer->text]['col3']++;

										} else {

											$balQuestion[$key][$result->task->test->id][$rr->question->text][$rr->answer->text]['col3'] = 1;
										};

									} else {
										if (isset($balQuestion[$key][$result->task->test->id][$rr->question->text]['sum3'])) {
											$balQuestion[$key][$result->task->test->id][$rr->question->text]['sum3'] += $rr->answer->weight;

										} else {
											$balQuestion[$key][$result->task->test->id][$rr->question->text]['sum3'] = $rr->answer->weight;
										}
										if (isset($balQuestion[$key][$result->task->test->id][$rr->question->text]['col3'])) {

											$balQuestion[$key][$result->task->test->id][$rr->question->text]['col3']++;

										} else {

											$balQuestion[$key][$result->task->test->id][$rr->question->text]['col3'] = 1;
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
										$type[$key] = 0;
										$answer = array(
											'tus' => "Подчиненный",
											'user' => $result->user,
											'answer_text' => $rr->answer_text
										);
										$textQuestion[$key][$rr->question->text][] = $answer;
									} elseif ($rr->question->type == 3) {
										if (is_numeric($rr->answer_text)) {
											$midall4[$key] += $rr->answer_text;
											$collall4[$key]++;

										}
										$type[$key] = 3;

										if (isset($balQuestion[$key][$result->task->test->id][$rr->question->text][$rr->answer->text]['sum4'])) {
											$balQuestion[$key][$result->task->test->id][$rr->question->text][$rr->answer->text]['sum4'] += $rr->answer_text;

										} else {
											$balQuestion[$key][$result->task->test->id][$rr->question->text][$rr->answer->text]['sum4'] = $rr->answer_text;
										}

										if (isset($balQuestion[$key][$result->task->test->id][$rr->question->text][$rr->answer->text]['col4'])) {

											$balQuestion[$key][$result->task->test->id][$rr->question->text][$rr->answer->text]['col4']++;

										} else {

											$balQuestion[$key][$result->task->test->id][$rr->question->text][$rr->answer->text]['col4'] = 1;
										};

									} else {
										if (isset($balQuestion[$key][$result->task->test->id][$rr->question->text]['sum4'])) {

											$balQuestion[$key][$result->task->test->id][$rr->question->text]['sum4'] += $rr->answer->weight;

										} else {

											$balQuestion[$key][$result->task->test->id][$rr->question->text]['sum4'] = $rr->answer->weight;
										}
										if (isset($balQuestion[$key][$result->task->test->id][$rr->question->text]['col4'])) {

											$balQuestion[$key][$result->task->test->id][$rr->question->text]['col4']++;

										} else {

											$balQuestion[$key][$result->task->test->id][$rr->question->text]['col4'] = 1;
										}
									};
								};
							};
						};
						break;


					};

				};

			}
			if (isset($results['0'])) {
    # code...

				echo '<table class="table table-bordered">
				<tbody>
				<tr>
				<td colspan="2" style="text-align: center;"><b>Индивидуальное представление для оценки</b></td>
				</tr>
				<tr>
				<td colspan="2" style="text-align: center;"><b>'.$obj->surname . ' ' . $obj->name . ' ' . $obj->middlename.'</b></td>
				</tr>
				<tr>
				<td>Подразделение:</td>
				<td style="width: 800px;">'.$obj->subunit->name.'</td>
				</tr>
				<tr>
				<td>Должность:</td>
				<td>'.$obj->profession.'</td>
				</tr>
				<tr>
				<td>Возраст:</td>
				<td>'.calculate_age($birthdaydate).' лет</td>
				</tr>
				<tr>
				<td colspan="1">Стаж работы в организации</td>
				<td>'.$employ .' года ' .$employm .' месяцев</td>
				</tr>

				<tr>
				<td>Предыдущие должности, даты перевода</td>
				<td>'.$obj->exEmploy.'</td>
				</tr>
				<tr>
				<tr>
				<td colspan="1">Образование (что и когда закончил; специальность; квалификация, год окончания):</td>
				<td>'.$obj->education.'</td>
				</tr>
				<tr>
				<td colspan="1">Дополнительное обучение:</td>
				<td>'.$obj->secondEducation.'</td>
				</tr>
				<td>Непосредственный руководитель</td>
				<td>'.$boss_name.'</td>
				</tr>
				<tr>
				<td>Функциональный (или вышестоящий) руководитель</td>
				<td>'.$functionBoss_name.'</td>
				</tr>
				<tr>
				<td colspan="1">Cостоит в кадровом резерве:</td>
				<td>';
				$reservColl = api::reservCollection($_REQUEST['user']);
				if (count($reservColl) > 0) {
					foreach ($reservColl['user'] as $userres) {
						if ($userres->id != $_REQUEST['user']) {
							echo $userres->surname . ' ' . $userres->name . ' ' . $userres->middlename . '<br>';
						}

					}

				}
				echo '</td>
				</tr>
				<tr>
				<td colspan="1">Имеет в кадровом резерве:</td>
				<td>';

				if (count($reservColl) > 0) {
					foreach ($reservColl['reserv'] as $userres) {
						if ($userres->id != $_REQUEST['user']) {
							echo $userres->surname . ' ' . $userres->name . ' ' . $userres->middlename . '<br>';
						}

					}

				}
				echo '</td>
				</tr>
				<tr>
				<td colspan="1">Задачи, поставленные на предыдущей оценке. Статус их выполнения (в конкретных фактических результатах):</td>
				<td>'.$obj->taskAssessment.'</td>
				</tr>
				<tr>
				<td colspan="1">Результаты предыдущей оценки (основные выводы):</td>
				<td>'.$obj->resultAssessment.'</td>
				</tr>   </tbody>
				</table>';
				echo '<hr><br style="page-break-after: always">';
			}

			foreach ($results as $key => $res) {

				if ($type[$key] == 3) {
					foreach ($balQuestion[$key] as $test) {
						echo '<h6 align="center"><b>'.$obj->surname.' '.$obj->name.' '.$obj->middlename.'</b></h6>';

						echo '<h5 align="center">Анализ по каждой компетенции</h5>
						<h6 align="center">Этот раздел аналитической части отчета подробно сравнивается оценка каждой группы опрошенных,
						средняя оценка, Ваша самооценка и желаемый уровень для данной компетенции:</h6>
						<table style="width: 100%; padding: .0rem;">
						<tr align="center">
						<td style="background-color: RGB(0, 176, 80);">&nbsp;</td>
						<td>3,3 - 4</td>
						<td>желаемый уровень</td>
						</tr>

						<tr align="center">
						<td style="background-color: RGB(255, 255, 0);">&nbsp;</td>
						<td>2,6 -3,2</td>
						<td>оптимальный уровень</td>
						</tr>
						<tr align="center">
						<td style="background-color: RGB(255, 0, 0);">&nbsp;</td>
						<td>1,1 - 2,5</td>
						<td>низкий уровень</td>
						</tr>
						<tr align="center">
						<td style="background-color: RGB(0, 0, 0); color: #fff;">&nbsp;</td>
						<td>1</td>
						<td>отсутствует</td>
						</tr>

						</table>';

						echo '<table style="padding: .75rem;>
						<thead style="background-color: #86cfda;">
						<tr>
						<th>Компетенции</th>
						<th width="90px" style="text-align: center; font-size: 9pt;">Самооценка</th>
						<th width="90px" style="text-align: center; font-size: 9pt;">Руководитель</th>						
						<th width="90px" style="text-align: center; font-size: 9pt;">Коллега</th>';
						
						if ($collall4[$key] != 0) {
							echo '<th width="90px" style="text-align: center; font-size: 9pt;">Подчиненный</th>';
						};
						echo '<th width="90px" style="text-align: center; font-size: 9pt;">Средний бал</th>
						</tr>
						</thead>
						<tbody>';
						$i[$key] = 1;

						echo '<tr class="table-info">
						<td><b>Средний балл по всем компетенциям<b></td>';

						$sumall1 = 0;
						$sumall2 = 0;
						$sumall3 = 0;
						$sumall4 = 0;
						$midcollall = 0;
						main::printr($collall2[$key]);

						if ($collall1[$key] > 0) {
							$sumall1 = $midall1[$key] / $collall1[$key];
							$sumall1 = round($sumall1, 1);

							$midcollall++;
						}
						if ($collall2[$key] > 0) {
							main::printr($collall2);

							$sumall2 = $midall2[$key] / $collall2[$key];
							$sumall2 = round($sumall2, 1);
							$midcollall++;
						}
						if ($collall3[$key] > 0) {
							$sumall3 = $midall3[$key] / $collall3[$key];
							$sumall3 = round($sumall3, 1);
							$midcollall++;
						}
						if ($collall4[$key] > 0) {
							$sumall4 = $midall4[$key] / $collall4[$key];
							$sumall4 = round($sumall4, 1);
							$midcollall++;
						}
						$midall = $sumall1 + $sumall2 + $sumall3 + $sumall4;
						$midall = $midall / $midcollall;
						$midall = round($midall, 1);

						switch (true) {
							case $sumall1 <= 0.1:
							echo '<td>';
							break;

							case $sumall1 <= 1.1:
							echo '<td style="background-color: RGB(0, 0, 0); color: #fff;">';
							break;

							case $sumall1 <= 2.5:
							echo '<td style="background-color: RGB(255, 0, 0);">';
							break;

							case $sumall1 <= 3.2:
							echo '<td style="background-color: RGB(255, 255, 0);">';
							break;

							case $sumall1 <= 4:
							echo '<td style="background-color: RGB(0, 176, 80);">';
							break;
							default:
							echo '<td>';
							break;

						};
						echo $sumall1 . '</td>';
						switch (true) {
							case $sumall2 <= 0.1:
							echo '<td>';
							break;

							case $sumall2 <= 1.1:
							echo '<td style="background-color: RGB(0, 0, 0); color: #fff;">';
							break;

							case $sumall2 <= 2.5:
							echo '<td style="background-color: RGB(255, 0, 0);">';
							break;

							case $sumall2 <= 3.2:
							echo '<td style="background-color: RGB(255, 255, 0);">';
							break;

							case $sumall2 <= 4:
							echo '<td style="background-color: RGB(0, 176, 80);">';
							break;
							default:
							echo '<td>';
							break;

						};
						echo $sumall2 . '</td>';
						switch (true) {
							case $sumall3 <= 0.1:
							echo '<td>';
							break;

							case $sumall3 <= 1.1:
							echo '<td style="background-color: RGB(0, 0, 0); color: #fff;">';
							break;

							case $sumall3 <= 2.5:
							echo '<td style="background-color: RGB(255, 0, 0);">';
							break;

							case $sumall3 <= 3.2:
							echo '<td style="background-color: RGB(255, 255, 0);">';
							break;

							case $sumall3 <= 4:
							echo '<td style="background-color: RGB(0, 176, 80);">';
							break;
							default:
							echo '<td>';
							break;

						};
						echo $sumall3 . '</td>';
						if ($collall4[$key] != 0) {

							switch (true) {
								case $sumall4 <= 0.1:
								echo '<td>';
								break;

								case $sumall4 <= 1.1:
								echo '<td style="background-color: RGB(0, 0, 0); color: #fff;">';
								break;

								case $sumall4 <= 2.5:
								echo '<td style="background-color: RGB(255, 0, 0);">';
								break;

								case $sumall4 <= 3.2:
								echo '<td style="background-color: RGB(255, 255, 0);">';
								break;

								case $sumall4 <= 4:
								echo '<td style="background-color: RGB(0, 176, 80);">';
								break;
								default:
								echo '<td>';
								break;

							};
						};
						echo $sumall4 . '</td>';
						switch (true) {
							case $midall <= 0.1:
							echo '<td>';
							break;

							case $midall <= 1.1:
							echo '<td style="background-color: RGB(0, 0, 0); color: #fff;">';
							break;

							case $midall <= 2.5:
							echo '<td style="background-color: RGB(255, 0, 0);">';
							break;

							case $midall <= 3.2:
							echo '<td style="background-color: RGB(255, 255, 0);">';
							break;

							case $midall <= 4:
							echo '<td style="background-color: RGB(0, 176, 80);">';
							break;
							default:
							echo '<td>';
							break;

						};
						echo $midall . '</td></tr>';


						foreach ($test as $question => $answer) {

							$sum1answercol = 0;
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
									$sum1answercol+= $sum['col1'];
								}
								if (isset($sum['sum2']) and is_numeric($sum['sum2'])) {
									$sum2answersum += $sum['sum2'];
									$sum2answercol+= $sum['col2'];
								}
								if (isset($sum['sum3']) and is_numeric($sum['sum3'])) {
									$sum3answersum += $sum['sum3'];
									$sum3answercol+= $sum['col3'];
								}
								if (isset($sum['sum4']) and is_numeric($sum['sum4'])) {
									$sum4answersum += $sum['sum4'];
									$sum4answercol+= $sum['col4'];
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
								$sum1mid = $sum1answersum / $sum1answercol;
								$sum1mid = round($sum1mid, 1, PHP_ROUND_HALF_ODD);
								$mid1 = $sum1mid;
								$midcoll++;
							}
							if ($sum2answersum > 0) {
								$sum2mid = $sum2answersum / $sum2answercol;
								$sum2mid = round($sum2mid, 1, PHP_ROUND_HALF_ODD);
								$mid2 = $sum2mid;
								$midcoll++;

							}
							if ($sum3answersum > 0) {
								$sum3mid = $sum3answersum / $sum3answercol;
								$sum3mid = round($sum3mid, 1, PHP_ROUND_HALF_ODD);
								$mid3 = $sum3mid;
								$midcoll++;

							}
							if ($sum4answersum > 0) {
								$sum4mid = $sum4answersum / $sum4answercol;
								$sum4mid = round($sum4mid, 1, PHP_ROUND_HALF_ODD);
								$mid4 = $sum4mid;
								$midcoll++;

							}
							$sum5 = $mid1 + $mid2 + $mid3 + $mid4;
							if ($midcoll != 0) {
								$mid5 = $sum5 / $midcoll;
								$mid5 = round($mid5, 1, PHP_ROUND_HALF_ODD);
							} else {
								$mid5 = 0;
							};
							$i++;
							echo '<tr class="question_tr" data-id="'.$i[$key].'" data-view="hide"><td style="font-size: large;">' . $question . '</td>';

							switch (true) {
								case $sum1mid <= 0.1:
								echo '<td>';
								break;

								case $sum1mid <= 1.1:
								echo '<td style="background-color: RGB(0, 0, 0); color: #fff;">';
								break;

								case $sum1mid <= 2.5:
								echo '<td style="background-color: RGB(255, 0, 0);">';
								break;

								case $sum1mid <= 3.2:
								echo '<td style="background-color: RGB(255, 255, 0);">';
								break;

								case $sum1mid <= 4:
								echo '<td style="background-color: RGB(0, 176, 80);">';
								break;
								default:
								echo '<td>';
								break;

							};
							echo $sum1mid . '</td>';
							switch (true) {
								case $sum2mid <= 0.1:
								echo '<td>';
								break;

								case $sum2mid <= 1.1:
								echo '<td style="background-color: RGB(0, 0, 0); color: #fff;">';
								break;

								case $sum2mid <= 2.5:
								echo '<td style="background-color: RGB(255, 0, 0);">';
								break;

								case $sum2mid <= 3.2:
								echo '<td style="background-color: RGB(255, 255, 0);">';
								break;

								case $sum2mid <= 4:
								echo '<td style="background-color: RGB(0, 176, 80);">';
								break;
								default:
								echo '<td>';
								break;

							};
							echo $sum2mid . '</td>';
							switch (true) {
								case $sum3mid <= 0.1:
								echo '<td>';
								break;

								case $sum3mid <= 1.1:
								echo '<td style="background-color: RGB(0, 0, 0); color: #fff;">';
								break;

								case $sum3mid <= 2.5:
								echo '<td style="background-color: RGB(255, 0, 0);">';
								break;

								case $sum3mid <= 3.2:
								echo '<td style="background-color: RGB(255, 255, 0);">';
								break;

								case $sum3mid <= 4:
								echo '<td style="background-color: RGB(0, 176, 80);">';
								break;
								default:
								echo '<td>';
								break;

							};
							echo $sum3mid . '</td>';
							if ($collall4[$key] != 0) {
								switch (true) {
									case $sum4mid <= 0.1:
									echo '<td>';
									break;

									case $sum4mid <= 1.1:
									echo '<td style="background-color: RGB(0, 0, 0); color: #fff;">';
									break;

									case $sum4mid <= 2.5:
									echo '<td style="background-color: RGB(255, 0, 0);">';
									break;

									case $sum4mid <= 3.2:
									echo '<td style="background-color: RGB(255, 255, 0);">';
									break;

									case $sum4mid <= 4:
									echo '<td style="background-color: RGB(0, 176, 80);">';
									break;
									default:
									echo '<td>';
									break;

								};
								echo $sum4mid . '</td>';
							};
							switch (true) {
								case $mid5 <= 0.1:
								echo '<td>';
								break;

								case $mid5 <= 1.1:
								echo '<td style="background-color: RGB(0, 0, 0); color: #fff;">';
								break;

								case $mid5 <= 2.5:
								echo '<td style="background-color: RGB(255, 0, 0);">';
								break;

								case $mid5 <= 3.2:
								echo '<td style="background-color: RGB(255, 255, 0);">';
								break;

								case $mid5 <= 4:
								echo '<td style="background-color: RGB(0, 176, 80);">';
								break;
								default:
								echo '<td>';
								break;

							};
							echo $mid5 . '</td></tr>';

							foreach ($answer as $answer_text => $sum) {
								echo '<tr class="answer_'.$i[$key].'" style="display:none;"><td>' . $answer_text . '</td>';
								if (isset($sum['sum1']) and is_numeric($sum['sum1'])) {

									$sum1 = $sum['sum1'];
									if (isset($sum['col1'])) {
										$self = $sum1 / $sum['col1'];
										$self = round($self, 1);
									} else {
										$sum['col1'] = 0;
										$self = $sum['sum1'];
									};
									switch (true) {

										case $self <= 1.1:
										echo '<td style="background-color: RGB(0, 0, 0); color: #fff;">';
										break;

										case $self <= 2.5:
										echo '<td style="background-color: RGB(255, 0, 0);">';
										break;

										case $self <= 3.2:
										echo '<td style="background-color: RGB(255, 255, 0);">';
										break;

										case $self <= 4:
										echo '<td style="background-color: RGB(0, 176, 80);">';
										break;
										default:
										echo '<td>';
										break;

									};
									echo $self . '</td>';
								} else {
									$sum['col1'] = 0;
									$sum['sum1'] = 0;
									echo '<td>Н/Д</td>';
								};

								if (isset($sum['sum2'])) {
									$sum2 = $sum['sum2'];
									if (isset($sum['col2'])) {
										$boss = $sum2 / $sum['col2'];
										$boss = round($boss, 1);
									} else {
										$sum['col2'] = 0;
										$boss = $sum['sum2'];
									};
									switch (true) {

										case $boss <= 1.1:
										echo '<td style="background-color: RGB(0, 0, 0); color: #fff;">';
										break;

										case $boss <= 2.5:
										echo '<td style="background-color: RGB(255, 0, 0);">';
										break;

										case $boss <= 3.2:
										echo '<td style="background-color: RGB(255, 255, 0);">';
										break;

										case $boss <= 4:
										echo '<td style="background-color: RGB(0, 176, 80);">';
										break;
										default:
										echo '<td>';
										break;

									};
									echo $boss . '</td>';
								} else {
									$sum['col2'] = 0;
									$sum['sum2'] = 0;
									echo '<td>Н/Д</td>';
								};

								if (isset($sum['sum3'])) {
									$sum3 = $sum['sum3'];
									if (isset($sum['col3'])) {
										$subject = $sum3 / $sum['col3'];
										$subject = round($subject, 1);
									} else {
										$sum['col3'] = 0;
										$subject = $sum['sum3'];
									};
									switch (true) {

										case $subject <= 1.1:
										echo '<td style="background-color: RGB(0, 0, 0); color: #fff;">';
										break;

										case $subject <= 2.5:
										echo '<td style="background-color: RGB(255, 0, 0);">';
										break;

										case $subject <= 3.2:
										echo '<td style="background-color: RGB(255, 255, 0);">';
										break;

										case $subject <= 4:
										echo '<td style="background-color: RGB(0, 176, 80);">';
										break;

										default:
										echo '<td>';
										break;
									};
									echo $subject . '</td>';
								} else {
									$sum['col3'] = 0;
									$sum['sum3'] = 0;
									echo '<td>Н/Д</td>';
								};

								if (isset($sum['sum4'])) {
									$sum4 = $sum['sum4'];
									if (isset($sum['col4'])) {
										$colleague = $sum4 / $sum['col4'];
										$colleague = round($colleague, 1);
									} else {
										$sum['col4'] = 0;
										$colleague = $sum['sum4'];
									};
									switch (true) {

										case $colleague <= 1.1:
										echo '<td style="background-color: RGB(0, 0, 0); color: #fff;">';
										break;

										case $colleague <= 2.5:
										echo '<td style="background-color: RGB(255, 0, 0);">';
										break;

										case $colleague <= 3.2:
										echo '<td style="background-color: RGB(255, 255, 0);">';
										break;

										case $colleague <= 4:
										echo '<td style="background-color: RGB(0, 176, 80);">';
										break;
										default:
										echo '<td>';
										break;

									};
									echo $colleague . '</td>';
								} else {
									$sum['col4'] = 0;
									$sum['sum4'] = 0;
									echo '<td>Н/Д</td>';
								};
								$midcol = $sum['col1'] + $sum['col2'] + $sum['col3'] + $sum['col4'];
								$midding = $sum['sum1'] + $sum['sum2'] + $sum['sum3'] + $sum['sum4'];
								if ($midcol != 0) {
									$midResult = $midding / $midcol;
									$midResult = round($midResult, 1);
								} else {
									$midResult = 0;
								}
								switch (true) {

									case $midResult <= 1.1:
									echo '<td style="background-color: RGB(0, 0, 0); color: #fff;">';
									break;

									case $midResult <= 2.5:
									echo '<td style="background-color: RGB(255, 0, 0);">';
									break;

									case $midResult <= 3.2:
									echo '<td style="background-color: RGB(255, 255, 0);">';
									break;

									case $midResult <= 4:
									echo '<td style="background-color: RGB(0, 176, 80);">';
									break;

									default:
									echo '<td>';
									break;
								};
								echo $midResult . '</td>';
							}

						}




						echo' </tbody>
						</table>';
						echo '<hr><br style="page-break-after: always">';

					}
				}
			}
			foreach ($results as $key => $res) {

				if ($type[$key] == 1) {
					foreach ($balQuestion[$key] as $test) {
						echo '<h6 align="center"><b>'.$obj->surname.' '.$obj->name.' '.$obj->middlename.'</b></h6>';

						echo '<h5 align="center">Анализ по каждой компетенции</h5>
						<h6 align="center">Этот раздел аналитической части отчета подробно сравнивается оценка каждой группы опрошенных,
						средняя оценка, Ваша самооценка и желаемый уровень для данной компетенции:</h6>
						<table style="width: 100%; padding: .0rem;">
						<tr align="center">
						<td style="background-color: RGB(0, 176, 80);">&nbsp;</td>
						<td>3,3 - 4</td>
						<td>желаемый уровень</td>
						</tr>

						<tr align="center">
						<td style="background-color: RGB(255, 255, 0);">&nbsp;</td>
						<td>2,6 -3,2</td>
						<td>оптимальный уровень</td>
						</tr>
						<tr align="center">
						<td style="background-color: RGB(255, 0, 0);">&nbsp;</td>
						<td>1,1 - 2,5</td>
						<td>низкий уровень</td>
						</tr>
						<tr align="center">
						<td style="background-color: RGB(0, 0, 0); color: #fff;">&nbsp;</td>
						<td>1</td>
						<td>отсутствует</td>
						</tr>

						</table>';

						echo '<table style="padding: .75rem;>
						<thead style="background-color: #86cfda;">
						<tr>
						<th>№</th>
						<th>Компетенции</th>
						<th width="90px" style="text-align: center; font-size: 9pt;">Самооценка</th>
						<th width="90px" style="text-align: center; font-size: 9pt;">Руководитель</th>
						<th width="90px" style="text-align: center; font-size: 9pt;">Коллега</th>
						<th width="90px" style="text-align: center; font-size: 9pt;">Подчиненный</th>
						<th width="90px" style="text-align: center; font-size: 9pt;">Средний бал</th>
						</tr>
						</thead>
						<tbody>';
						$i[$key] = 1;
						foreach ($test as $question => $sum) {
							echo '<tr><td>' . $i[$key] . '</td><td>' . $question . '</td>';
							if (isset($sum['sum1'])) {

								$sum1 = $sum['sum1'];
								if (isset($sum['col1'])) {
									$self = $sum1 / $sum['col1'];
									$self = round($self, 1);
								} else {
									$sum['col1'] = 0;
									$self = $sum['sum1'];
								};
								switch (true) {

									case $self <= 1.1:
									echo '<td style="background-color: RGB(0, 0, 0); text-align: center; color: #fff;">';
									break;

									case $self <= 2.5:
									echo '<td style="background-color: RGB(255, 0, 0); text-align: center">';
									break;

									case $self <= 3.2:
									echo '<td style="background-color: RGB(255, 255, 0); text-align: center">';
									break;

									case $self <= 4:
									echo '<td style="background-color: RGB(0, 176, 80); text-align: center">';
									break;
									default:
									echo '<td>';
									break;

								};
								echo $self . '</td>';
							} else {
								$sum['col1'] = 0;
								$sum['sum1'] = 0;
								echo '<td style="text-align: center;"> -</td>';
							};

							if (isset($sum['sum2'])) {
								$sum2 = $sum['sum2'];
								if (isset($sum['col2'])) {
									$boss = $sum2 / $sum['col2'];
									$boss = round($boss, 1);
								} else {
									$sum['col2'] = 0;
									$boss = $sum['sum2'];
								};
								switch (true) {

									case $boss <= 1.1:
									echo '<td style="background-color: RGB(0, 0, 0); color: #fff; text-align: center;">';
									break;

									case $boss <= 2.5:
									echo '<td style="background-color: RGB(255, 0, 0); text-align: center;">';
									break;

									case $boss <= 3.2:
									echo '<td style="background-color: RGB(255, 255, 0); text-align: center;">';
									break;

									case $boss <= 4:
									echo '<td style="background-color: RGB(0, 176, 80); text-align: center;">';
									break;
									default:
									echo '<td>';
									break;

								};
								echo $boss . '</td>';
							} else {
								$sum['col2'] = 0;
								$sum['sum2'] = 0;
								echo '<td style="text-align: center;"> -</td>';
							};

							if (isset($sum['sum3'])) {
								$sum3 = $sum['sum3'];
								if (isset($sum['col3'])) {
									$subject = $sum3 / $sum['col3'];
									$subject = round($subject, 1);
								} else {
									$sum['col3'] = 0;
									$subject = $sum['sum3'];
								};
								switch (true) {

									case $subject <= 1.1:
									echo '<td style="background-color: RGB(0, 0, 0); text-align: center; color: #fff;">';
									break;

									case $subject <= 2.5:
									echo '<td style="background-color: RGB(255, 0, 0); text-align: center;">';
									break;

									case $subject <= 3.2:
									echo '<td style="background-color: RGB(255, 255, 0); text-align: center;">';
									break;

									case $subject <= 4:
									echo '<td style="background-color: RGB(0, 176, 80); text-align: center;">';
									break;

									default:
									echo '<td>';
									break;
								};
								echo $subject . '</td>';
							} else {
								$sum['col3'] = 0;
								$sum['sum3'] = 0;
								echo '<td style="text-align: center;"> -</td>';
							};

							if (isset($sum['sum4'])) {
								$sum4 = $sum['sum4'];
								if (isset($sum['col4'])) {
									$colleague = $sum4 / $sum['col4'];
									$colleague = round($colleague, 1);
								} else {
									$sum['col4'] = 0;
									$colleague = $sum['sum4'];
								};
								switch (true) {

									case $colleague <= 1.1:
									echo '<td style="background-color: RGB(0, 0, 0); color: #fff; text-align: center;">';
									break;

									case $colleague <= 2.5:
									echo '<td style="background-color: RGB(255, 0, 0); text-align: center;">';
									break;

									case $colleague <= 3.2:
									echo '<td style="background-color: RGB(255, 255, 0); text-align: center;">';
									break;

									case $colleague <= 4:
									echo '<td style="background-color: RGB(0, 176, 80); text-align: center;">';
									break;
									default:
									echo '<td>';
									break;

								};
								echo $colleague . '</td>';
							} else {
								$sum['col4'] = 0;
								$sum['sum4'] = 0;
								echo '<td style="text-align: center;"> -</td>';
							};
							$midcol = $sum['col1'] + $sum['col2'] + $sum['col3'] + $sum['col4'];
							$midding = $sum['sum1'] + $sum['sum2'] + $sum['sum3'] + $sum['sum4'];
							if ($midcol != 0) {
								$midResult = $midding / $midcol;
								$midResult = round($midResult, 1);
							} else {
								$midResult = 0;
							}
							switch (true) {

								case $midResult <= 1.1:
								echo '<td style="background-color: RGB(0, 0, 0); color: #fff; text-align: center;">';
								break;

								case $midResult <= 2.5:
								echo '<td style="background-color: RGB(255, 0, 0); text-align: center;">';
								break;

								case $midResult <= 3.2:
								echo '<td style="background-color: RGB(255, 255, 0); text-align: center;">';
								break;

								case $midResult <= 4:
								echo '<td style="background-color: RGB(0, 176, 80); text-align: center;">';
								break;

								default:
								echo '<td style="text-align: center;">';
								break;
							};
							echo $midResult . '</td>';

							$i[$key]++;
						}
						echo' </tbody>
						</table>';
						echo '<hr><br style="page-break-after: always">';

					}
				}
			}

			foreach ($results as $key => $res) {
				if ($type[$key] == 0) {

					echo '<table class="table table-bordered">
					<tbody>
					<tr><td colspan="3" style="text-align: center;"><b>'. $res[0]->task->test->name.'</b></td></tr>';
					echo '<tr><td>Оцениваемый: '.$res[0]->task->user->surname.' '.$res[0]->task->user->name.' '.$res[0]->task->user->middlename.'</td>';
					foreach ($user[$key] as $keyuser => $answerUser) {
						foreach ($tususer[$key] as $keytus => $tus) {
							if ($keyuser == $keytus) {
								switch ($tus) {
									case '1':
									echo '<td> Самооценка</td>';
									break;

									case '2':
									echo '<td> Руководитель '.$answerUser->surname.' '.$answerUser->name.' '.$answerUser->middlename.'</td>';
									break;
									case '3':
									echo '<td> Коллега '.$answerUser->surname.' '.$answerUser->name.' '.$answerUser->middlename.'</td>';
									break;
									case '4':
									echo '<td> Подчиненный '.$answerUser->surname.' '.$answerUser->name.' '.$answerUser->middlename.'</td>';
									break;
								}
							}
						}
					};
					echo '</tr>';
					foreach ($textQuestion[$key] as $question => $answers) {
						echo '<tr><td width="50%" ><b>' . $question . '</b></td>';
						foreach ($answers as $data) {
							echo '<td>' . $data['answer_text'] . '</td>';
						}
						echo '</tr>';
					};

					echo' </tbody>
					</table>';
					echo '<hr><br style="page-break-after: always">';

				}
			}

		}

		?>
	</div>

</body>
</html>
