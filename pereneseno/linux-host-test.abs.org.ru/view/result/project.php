<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/system/config.php';
if (!$_SESSION['user'] or $_SESSION['user']->group->access == 2) {
	header('Location: http://staff.ska.su');
}
date_default_timezone_set('UTC');

$testArr = explode(",", $_REQUEST['test']);
$projectArr = explode(",", $_REQUEST['project']);

$task = [];
$count = 0;
foreach ($projectArr as $project) {
	foreach ($testArr as $test) {
		if ($project <= 13 ) 
		{

			$task['tumb1'][$project][$test] = api::collection('project_result',array('test'=>$test, 'project'=>$project, 'user' =>$_REQUEST['user']));
			
		}
		else
		{
			$task['tumb2'][$project][$test] = api::collection('task',array('test'=>$test, 'project'=>$project, 'status' => 2, 'user' =>$_REQUEST['user']));
			
		};
	};
	
};


$balQuestion = array();
$projectName = array();
$user = $_REQUEST['user'];
if (isset($task['tumb1']))
{
	foreach ($task['tumb1'] as $project) 
	{
		
		
		$count++;
		foreach ($project as $test) {

			if (count($test) > 0) {

				foreach ($test as $value) 
				{
					$user = $value->user;
					$projectName[$value->project->name] = 0;
					switch ($value->tus) 
					{

						case '1':
						$balQuestion[$value->question->text][$value->project->name]['sum1'] = $value->point;
						break;

						case '2':
						if(isset($balQuestion[$value->question->text][$value->project->name]['sum2']))
						{
							$balQuestion[$value->question->text][$value->project->name]['sum2'] += $value->point;

						}
						else
						{
							$balQuestion[$value->question->text][$value->project->name]['sum2'] = $value->point;
						}
						if(isset($balQuestion[$value->question->text][$value->project->name]['col2']))
						{

							$balQuestion[$value->question->text][$value->project->name]['col2'] ++;

						}
						else
						{

							$balQuestion[$value->question->text][$value->project->name]['col2'] = 1;
						}
						break;

						case '3':
						if(isset($balQuestion[$value->question->text][$value->project->name]['sum3']))
						{
							$balQuestion[$value->question->text][$value->project->name]['sum3'] += $value->point;

						}
						else
						{
							$balQuestion[$value->question->text][$value->project->name]['sum3'] = $value->point;
						}
						if(isset($balQuestion[$value->question->text][$value->project->name]['col3']))
						{

							$balQuestion[$value->question->text][$value->project->name]['col3'] ++;

						}
						else
						{

							$balQuestion[$value->question->text][$value->project->name]['col3'] = 1;
						}
						break;

						case '4':
						if(isset($balQuestion[$value->question->text][$value->project->name]['sum4']))
						{

							$balQuestion[$value->question->text][$value->project->name]['sum4'] += $value->point;

						}
						else
						{

							$balQuestion[$value->question->text][$value->project->name]['sum4'] = $value->point;
						}
						if(isset($balQuestion[$value->question->text][$value->project->name]['col4']))
						{

							$balQuestion[$value->question->text][$value->project->name]['col4'] ++;

						}
						else
						{

							$balQuestion[$value->question->text][$value->project->name]['col4'] = 1;
						}
						break;
					};
				};
			};
		};
		
	};
};
if (isset($task['tumb2']))
{
	foreach ($task['tumb2'] as $project) 
	{
		
		

		$count++;
		foreach ($project as $test) {

			if (count($test) > 0) {

				foreach ($test as $value) 
				{
					$user = $value->user;
					$projectName[$value->project->name] = 0;
					$result = api::collection('result',array('task'=>$value->id));

					foreach ($result as $res) {
						switch ($res->tus) {
							case '1':

							foreach ($res->registr_result as $rr) 
							{
								$balQuestion[$rr->question->text][$value->project->name]['sum1'] = $rr->answer->weight;
							};


							break;

							case '2':

							foreach ($res->registr_result as $rr) 
							{



								if(isset($balQuestion[$rr->question->text][$value->project->name]['sum2']))
								{
									$balQuestion[$rr->question->text][$value->project->name]['sum2'] += $rr->answer->weight;

								}
								else
								{
									$balQuestion[$rr->question->text][$value->project->name]['sum2'] = $rr->answer->weight;
								}
								if(isset($balQuestion[$rr->question->text][$value->project->name]['col2']))
								{
									$balQuestion[$rr->question->text][$value->project->name]['col2'] ++;

								}
								else
								{
									$balQuestion[$rr->question->text][$value->project->name]['col2'] = 1;
								}

							};
							break;

							case '3':
							foreach ($res->registr_result as $rr) 
							{


								if(isset($balQuestion[$rr->question->text][$value->project->name]['sum3']))
								{
									$balQuestion[$rr->question->text][$value->project->name]['sum3'] += $rr->answer->weight;

								}
								else
								{
									$balQuestion[$rr->question->text][$value->project->name]['sum3'] = $rr->answer->weight;
								}

								if(isset($balQuestion[$rr->question->text][$value->project->name]['col3']))
								{
									$balQuestion[$rr->question->text][$value->project->name]['col3'] ++;

								}
								else
								{
									$balQuestion[$rr->question->text][$value->project->name]['col3'] = 1;
								}

							};
							break;


							case '4':
							foreach ($res->registr_result as $rr) 
							{

								if(isset($balQuestion[$rr->question->text][$value->project->name]['sum4']))
								{
									$balQuestion[$rr->question->text][$value->project->name]['sum4'] += $rr->answer->weight;

								}
								else
								{
									$balQuestion[$rr->question->text][$value->project->name]['sum4'] = $rr->answer->weight;
								}

								if(isset($balQuestion[$rr->question->text][$value->project->name]['col4']))
								{
									$balQuestion[$rr->question->text][$value->project->name]['col4'] ++;

								}
								else
								{
									$balQuestion[$rr->question->text][$value->project->name]['col4'] = 1;
								}

							};
							break;


						};

					};
				};
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
		<h3 align="center"><b><?php echo $user->surname.' '.$user->name.' '.$user->middlename;?></b></h3>
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


				foreach ($projectName as $key => $value) 
				{

					echo '<th>'. $key .'</th>';

				}; 
				foreach ($projectName as $key => $value) 
				{
					echo '<th>'. $key .'</th>';

				}; 
				foreach ($projectName as $key => $value) 
				{
					echo '<th>'. $key .'</th>';

				}; 
				foreach ($projectName as $key => $value) 
				{
					echo '<th>'. $key .'</th>';
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

								default:
								echo '<td>';
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
							$sum2 = $sum['sum2'];
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
					};
					foreach ($taskKey as $taskDate => $sum) {
						if(isset($sum['sum3']))
						{		
							$sum3 = $sum['sum3'];	
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
					};
					foreach ($taskKey as $taskDate => $sum) {
						if(isset($sum['sum4']))
						{			
							$sum4 = $sum['sum4'];
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
					};
					$i++;
				};
				?>
			</tbody>
		</table>


	</div>
</body>
</html>
