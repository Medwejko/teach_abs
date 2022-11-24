<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/system/config.php';
if (!$_SESSION['user'] or $_SESSION['user']->group->access == 2) {
	header('Location: http://staff.ska.su');
}
date_default_timezone_set('UTC');

if ($_REQUEST['project'] <= 13 ) 
{
	$task = api::collection('project_result',array('test'=>$_REQUEST['test'], 'project'=>$_REQUEST['project'], 'user' =>$_REQUEST['user']));
	$tumb = 1;
}
else
{
	$task = api::collection('task',array('test'=>$_REQUEST['test'], 'project'=>$_REQUEST['project'], 'status' => 2, 'user' =>$_REQUEST['user']));
	$tumb = 2;
};

$user = $_REQUEST['user'];
$time = 'T23:59:59';
$dateIn = $_REQUEST['dateIn'];
$dateOut = $_REQUEST['dateOut'];
$dateIn .= $time;
$dateOut .= $time;


if ($tumb == 2) 
{
	$count = 0;
	$balQuestion = array();
	foreach ($task as $key => $value) 
	{

		if ($value->createdate >= $dateIn and $value->createdate <= $dateOut)
		{

			$count++;

			$col2 = 0;
			$col3 = 0;
			$col4 = 0;


			$result = api::collection('result',array('task'=>$value->id));

			foreach ($result as $res) {
				$taskDate = date('Y-m-d' ,strtotime ($value->createdate));
				switch ($res->tus) {
					case '1':
					foreach ($res->registr_result as $rr) 
					{
						$balQuestion[$rr->question->text][$taskDate]['sum1'] = $rr->answer->weight;
					};


					break;

					case '2':

					$col2 ++;
					foreach ($res->registr_result as $rr) 
					{



						if(isset($balQuestion[$rr->question->text][$taskDate]['sum2']))
						{
							$balQuestion[$rr->question->text][$taskDate]['sum2'] += $rr->answer->weight;

						}
						else
						{
							$balQuestion[$rr->question->text][$taskDate]['sum2'] = $rr->answer->weight;
						}


					};
					break;

					case '3':
					$col3 ++;
					foreach ($res->registr_result as $rr) 
					{


						if(isset($balQuestion[$rr->question->text][$taskDate]['sum3']))
						{
							$balQuestion[$rr->question->text][$taskDate]['sum3'] += $rr->answer->weight;

						}
						else
						{
							$balQuestion[$rr->question->text][$taskDate]['sum3'] = $rr->answer->weight;
						}

						if(isset($balQuestion[$rr->question->text][$taskDate]['col3']))
						{
							$balQuestion[$rr->question->text][$taskDate]['col3'] ++;

						}
						else
						{
							$balQuestion[$rr->question->text][$taskDate]['col3'] = 1;
						}

					};
					break;


					case '4':
					$col4 ++;
					foreach ($res->registr_result as $rr) 
					{

						if(isset($balQuestion[$rr->question->text][$taskDate]['sum4']))
						{
							$balQuestion[$rr->question->text][$taskDate]['sum4'] += $rr->answer->weight;

						}
						else
						{
							$balQuestion[$rr->question->text][$taskDate]['sum4'] = $rr->answer->weight;
						}

						if(isset($balQuestion[$rr->question->text][$taskDate]['col4']))
						{
							$balQuestion[$rr->question->text][$taskDate]['col4'] ++;

						}
						else
						{
							$balQuestion[$rr->question->text][$taskDate]['col4'] = 1;
						}

					};
					break;


				};

			};

		};

	};
	?>
	<!Doctype html>
	<html>
	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

		<title>Отчет</title>
		<style>
			@media print
			{    
				.no-print, .no-print *
				{
					display: none !important;
				}
			}

			table, th, td {
				border: 1px solid #ddd;
				padding: .75rem;

			}
		</style>
	</head>
	<body>

		<div class="container-fluid" >
			<h5 style="float: right;" class="btn btn-outline-secondary no-print"  onclick="window.print();">Печать</h5>
			<h3 align="center"><b>Результаты оценки</b></h3>
			<h3 align="center"><b><?php echo $task[0]->user->surname.' '.$task[0]->user->name.' '.$task[0]->user->middlename;?></b></h3>

			<h3 align="center"><b>Для теста <?php echo $task[0]->test->name;?></b></h3>
			<h3 align="center"><b>В рамках проекта <?php echo $task[0]->project->name;?></b></h3>
			<h3 align="center"><b><?php echo 'C '. $_REQUEST['dateIn'] . ' по ' . $_REQUEST['dateOut'];?></b></h3>
			<h5 style="float: left;">Анализ по каждой компетенции</h5>
			<h6 style="float: left;">Этот раздел аналитической части отчета подробно сравнивается оценка каждой группы опрошенных, средняя оценка, Ваша самооценка и желаемый уровень для данной компетенции:</h6>

			<table style="width: 100%;">
				<tr align="center"><td class="table-success"></td><td>3,3 - 4</td><td>желаемый уровень</td></tr>
				<tr align="center"><td class="table-warning"></td><td>2,6 -3,2</td><td>оптимальный уровень</td></tr>
				<tr align="center"><td class="table-danger"></td><td>1 - 2,5 </td><td>низкий уровень</td></tr>
				<tr align="center"><td class="table-dark"></td><td>1</td><td>отсутствует</td></tr>
			</table>

			<!--вопросы со средним баллом-->
			<hr>


			<table>
				<thead style="background-color: #86cfda;">
					<tr><th rowspan="2">№ п/п</th><th rowspan="2">Компетенции</th><th colspan="<?php echo $count;?>">Самооценка</th><th colspan="<?php echo $count;?>">Оценка руководителя</th><th colspan="<?php echo $count;?>">Оценка коллег</th><th colspan="<?php echo $count;?>">Оценка подчиненных</th></tr>
					<tr><?php 


					foreach ($task as $value) 
					{
						if ($value->createdate >= $dateIn and $value->createdate <= $dateOut)
						{ 
							echo '<th>'. date('Y-m-d' ,strtotime ($value->createdate)) .'</th>';
						};
					}; 
					foreach ($task as $value) 
					{
						if ($value->createdate >= $dateIn and $value->createdate <= $dateOut)
						{ 
							echo '<th>'. date('Y-m-d' ,strtotime ($value->createdate)) .'</th>';
						};

					}; 
					foreach ($task as $value) 
					{
						if ($value->createdate >= $dateIn and $value->createdate <= $dateOut)
						{ 
							echo '<th>'. date('Y-m-d' ,strtotime ($value->createdate)) .'</th>';
						};

					}; 
					foreach ($task as $value) 
					{
						if ($value->createdate >= $dateIn and $value->createdate <= $dateOut)
						{ 
							echo '<th>'. date('Y-m-d' ,strtotime ($value->createdate)) .'</th>';
						};

					}; 
					?></tr>
				</thead>
				<tbody>
					<?php



					$i=1;


					foreach ($balQuestion as $question => $taskKey) 
					{

						echo '<tr><td>'.$i.'</td><td>'.$question.'</td>';
						foreach ($taskKey as $taskDate => $sum) {


							if(isset($sum['sum1']))
							{		

								$self = $sum['sum1'];

								switch (true) {

									case $self <= 1:
									echo '<td class="table-dark">';
									break;

									case $self <= 2.5:
									echo '<td class="table-danger">';
									break;

									case $self <= 3.2:
									echo '<td class="table-warning">';
									break;

									case $self <= 4:
									echo '<td class="table-success">';
									break;


								};
								echo $self.'</td>'; 
							}
							else
							{
								echo '<td>Нет результатов</td>';
							};

						};
						foreach ($taskKey as $taskDate => $sum) {
							if(isset($sum['sum2']))
							{			
								$boss = $sum['sum2'] / $sum['col2'];
								$boss = round($boss, 2);

								switch (true) {

									case $boss <= 1:
									echo '<td class="table-dark">';
									break;

									case $boss <= 2.5:
									echo '<td class="table-danger">';
									break;

									case $boss <= 3.2:
									echo '<td class="table-warning">';
									break;

									case $boss <= 4:
									echo '<td class="table-success">';
									break;


								};
								echo $boss.'</td>'; 
							}
							else
							{
								echo '<td>Нет результатов</td>';
							};
						};
						foreach ($taskKey as $taskDate => $sum) {
							if(isset($sum['sum3']))
							{			
								$subject = $sum['sum3'] / $sum['col3'];
								$subject = round($subject, 2);
								switch (true) {

									case $subject <= 1:
									echo '<td class="table-dark">';
									break;

									case $subject <= 2.5:
									echo '<td class="table-danger">';
									break;

									case $subject <= 3.2:
									echo '<td class="table-warning">';
									break;

									case $subject <= 4:
									echo '<td class="table-success">';
									break;


								};
								echo $subject.'</td>'; 
							}
							else
							{
								echo '<td>Нет результатов</td>';
							};
						};
						foreach ($taskKey as $taskDate => $sum) {
							if(isset($sum['sum4']))
							{			
								$colleague = $sum['sum4'] / $sum['col4'];
								$colleague = round($colleague, 2);
								switch (true) {

									case $colleague <= 1:
									echo '<td class="table-dark">';
									break;

									case $colleague <= 2.5:
									echo '<td class="table-danger">';
									break;

									case $colleague <= 3.2:
									echo '<td class="table-warning">';
									break;

									case $colleague <= 4:
									echo '<td class="table-success">';
									break;


								};
								echo $colleague.'</td>'; 
							}
							else
							{
								echo '<td>Нет результатов</td>';
							};
						};
						$i++;
					};
					?>
				</tbody>
			</table>


		</div>
	</body>
	</html>
	<?php
}
else
{
	$count = 0;
	$col2 = 0;
	$col3 = 0;
	$col4 = 0;
	$balQuestion = array();
	foreach ($task as $key => $value) 
	{
		$user = $value->user;
		$test = $value->test;
		$project = $value->project;
		switch ($value->tus) 
		{

			case '1':
			$balQuestion[$value->question->text]['sum1'] = $value->point;
			break;

			case '2':
			if(isset($balQuestion[$value->question->text]['sum2']))
			{
				$col2++;
				$balQuestion[$value->question->text]['sum2'] += $value->point;

			}
			else
			{
				$col2 = 1;
				$balQuestion[$value->question->text]['sum2'] = $value->point;
			}
			break;

			case '3':
			if(isset($balQuestion[$value->question->text]['sum3']))
			{
				$col3++;
				$balQuestion[$value->question->text]['sum3'] += $value->point;

			}
			else
			{
				$col3 = 1;
				$balQuestion[$value->question->text]['sum3'] = $value->point;
			}
			break;

			case '4':
			if(isset($balQuestion[$value->question->text]['sum4']))
			{
				$col4++;
				$balQuestion[$value->question->text]['sum4'] += $value->point;

			}
			else
			{
				$col4 = 1;
				$balQuestion[$value->question->text]['sum4'] = $value->point;
			}
			break;
		}
	};

	?>
	<html>
	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

		<title>Отчет</title>
		<style>
			@media print
			{    
				.no-print, .no-print *
				{
					display: none !important;
				}
			}

			table, th, td {
				border: 1px solid #ddd;
				padding: .75rem;

			}
		</style>
	</head>
	<body>

		<div class="container-fluid" >
			<h5 style="float: right;" class="btn btn-outline-secondary no-print"  onclick="window.print();">Печать</h5>
			<h5 style="float: right;" class="btn btn-outline-secondary no-print setExcel" id="setExcel" data-id="<?php echo $_REQUEST['id'];?>">Excel</h5>
			<h5 style="float: right; display:none;" class="btn btn-outline-secondary no-print saveExcel" id="saveExcel">Скачать Excel</h5>
			<h3 align="center"><b>Результаты оценки</b></h3>
			<h3 align="center"><b><?php echo $user->surname.' '.$user->name.' '.$user->middlename;?></b></h3>
			<h3 align="center"><b><?php echo $test->name;?></b></h3>
			<h5 align="center">Анализ по каждой компетенции</h5><br/>
			<h6 align="center">Этот раздел аналитической части отчета подробно сравнивается оценка каждой группы опрошенных, средняя оценка, Ваша самооценка и желаемый уровень для данной компетенции:</h6>

			<table style="width: 100%;">
				<tr align="center"><td class="table-success"></td><td>3,3 - 4</td><td>желаемый уровень</td></tr>
				<tr align="center"><td class="table-warning"></td><td>2,6 -3,2</td><td>оптимальный уровень</td></tr>
				<tr align="center"><td class="table-danger"></td><td>1 - 2,5 </td><td>низкий уровень</td></tr>
				<tr align="center"><td class="table-dark"></td><td>1</td><td>отсутствует</td></tr>
			</table>

			<!--вопросы со средним баллом-->
			<hr>


			<table>
				<thead style="background-color: #86cfda;">
					<tr><th>№ п/п</th><th>Компетенции</th><th>Самооценка</th><th>Оценка руководителя</th><th>Оценка коллег</th><th>Оценка подчиненных</th><th>Средний бал</th></tr>
				</thead>
				<tbody>
					<?php


					$i=1;
					foreach ($balQuestion as $question => $sum) 
					{

						echo '<tr><td>'.$i.'</td><td>'.$question.'</td>';

						if(isset($sum['sum1']))
						{			
							main::printr($sum['sum1']);
							$sum1 = $sum['sum1'];
							switch (true) {

								case $sum['sum1'] <= 1:
								echo '<td class="table-dark">';
								break;

								case $sum['sum1'] <= 2.5:
								echo '<td class="table-danger">';
								break;

								case $sum['sum1'] <= 3.2:
								echo '<td class="table-warning">';
								break;

								case $sum['sum1'] <= 4:
								echo '<td class="table-success">';
								break;

								default:
								echo '<td>';
								break;

							};
							echo $sum['sum1'].'</td>'; 
						}
						else
						{
							echo '<td>Нет результатов</td>';
						};

						if(isset($sum['sum2']))
						{			
							$sum2 = $sum['sum2'];
							$boss = $sum['sum2'] / $col2;
							$boss = round($boss, 1);

							switch (true) {

								case $boss <= 1:
								echo '<td class="table-dark">';
								break;

								case $boss <= 2.5:
								echo '<td class="table-danger">';
								break;

								case $boss <= 3.2:
								echo '<td class="table-warning">';
								break;

								case $boss <= 4:
								echo '<td class="table-success">';
								break;
								default:
								echo '<td>';
								break;

							};
							echo $boss.'</td>'; 
						}
						else
						{
							echo '<td>Нет результатов</td>';
						};

						if(isset($sum['sum3']))
						{			
							$sum3 = $sum['sum3'];
							$subject = $sum['sum3'] / $col3;
							$subject = round($subject, 1);
							switch (true) {

								case $subject <= 1:
								echo '<td class="table-dark">';
								break;

								case $subject <= 2.5:
								echo '<td class="table-danger">';
								break;

								case $subject <= 3.2:
								echo '<td class="table-warning">';
								break;

								case $subject <= 4:
								echo '<td class="table-success">';
								break;
								default:
								echo '<td>';
								break;

							};
							echo $subject.'</td>'; 
						}
						else
						{
							echo '<td>Нет результатов</td>';
						};

						if(isset($sum['sum4']))
						{			
							$sum4 = $sum['sum4'];
							$colleague = $sum['sum4'] / $col4;
							$colleague = round($colleague, 1);
							switch (true) {

								case $colleague <= 1:
								echo '<td class="table-dark">';
								break;

								case $colleague <= 2.5:
								echo '<td class="table-danger">';
								break;

								case $colleague <= 3.2:
								echo '<td class="table-warning">';
								break;

								case $colleague <= 4:
								echo '<td class="table-success">';
								break;
								default:
								echo '<td>';
								break;

							};
							echo $colleague.'</td>'; 
						}
						else
						{
							echo '<td>Нет результатов</td>';
						};
						$midcol = $col2+$col3+$col4+$col1;
						$midding = $sum1+$sum2+$sum3+$sum4;
						$midResult = $midding / $midcol;
						$midResult = round($midResult, 1);
						switch (true) {

							case $midResult <= 1:
							echo '<td class="table-dark">';
							break;

							case $midResult <= 2.5:
							echo '<td class="table-danger">';
							break;

							case $midResult <= 3.2:
							echo '<td class="table-warning">';
							break;

							case $midResult <= 4:
							echo '<td class="table-success">';
							break;
							default:
							echo '<td>';
							break;

						};
						echo $midResult.'</td></tr>'; 

						$i++;
					};
					?>
				</tbody>
			</table>



		</div>
	</body>
	</html>
	<?php
};

?>



