<link rel="stylesheet" href="/css/globalStyle.css" type="text/css"/>
<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/system/config.php';
if (!$_SESSION['user'] or $_SESSION['user']->group->access == 2) {
	header('Location: http://staff.ska.su');
}
	$collection = api::collection('result',array('task'=>$_REQUEST['id']));

	$textQuestion = array();
	$balQuestion = array();
	$col1 = 0;
	$col2 = 0;
	$col3 = 0;
	$col4 = 0;
	$type = 1;
	foreach ($collection as $result) 
	{

		$test = $result->task->test->id;
		main::printr($result->tus);
		switch ($result->tus) {
			case '1':
			$col1++;
			foreach ($result->registr_result as $rr) 
			{
				if($rr->question->type == 0)
				{
					$type = 0;
					$answer = array(
						'tus' => "Cамооценка",
						'user' => $result->user,
						'answer_text' => $rr->answer_text
					);
					$textQuestion[$rr->question->text][] = $answer;
				}
				else
				{
					$type = 1;
					if(isset($rr->answer->weight))
					{

						$balQuestion[$rr->question->text]['sum1'] = $rr->answer->weight;
					}					

				};
			};

			
			break;

			case '2':

			$col2 ++;
			foreach ($result->registr_result as $rr) 
			{
				
				if($rr->question->type == 0)
				{
					$type = 0;
					$answer = array(
						'tus' => "Руководитель",
						'user' => $result->user,
						'answer_text' => $rr->answer_text
					);
					$textQuestion[$rr->question->text][] = $answer;
				}
				else
				{
					$type = 1;
					if(isset($rr->answer->weight))
					{
						if(isset($balQuestion[$rr->question->text]['sum2']))
						{
							$balQuestion[$rr->question->text]['sum2'] += $rr->answer->weight;

						}
						else
						{
							$balQuestion[$rr->question->text]['sum2'] = $rr->answer->weight;
						}
					}
					else
					{
						$balQuestion[$rr->question->text]['sum2'] = 'Нет результатов';
					};
				};
			};
			break;

			case '3':
			$col3 ++;
			foreach ($result->registr_result as $rr) 
			{
				
				if($rr->question->type == 0)
				{
					$type = 0;
					$answer = array(
						'tus' => "Коллега",
						'user' => $result->user,
						'answer_text' => $rr->answer_text
					);
					$textQuestion[$rr->question->text][] = $answer;
				}
				else
				{
					$type = 1;
					if(isset($rr->answer->weight))
					{
						if(isset($balQuestion[$rr->question->text]['sum3']))
						{
							$balQuestion[$rr->question->text]['sum3'] += $rr->answer->weight;

						}
						else
						{
							$balQuestion[$rr->question->text]['sum3'] = $rr->answer->weight;
						}
					}
					else
					{
						$balQuestion[$rr->question->text]['sum3'] = 'Нет результатов';
					};
				};
			};
			break;
			

			case '4':
			$col4 ++;
			foreach ($result->registr_result as $rr) 
			{
				
				if($rr->question->type == 0)
				{
					$type = 0;
					$answer = array(
						'tus' => "Подчиненный",
						'user' => $result->user,
						'answer_text' => $rr->answer_text
					);
					$textQuestion[$rr->question->text][] = $answer;
				}
				else
				{
					$type = 1;
					if(isset($rr->answer->weight))
					{
						if(isset($balQuestion[$rr->question->text]['sum4']))
						{
							$balQuestion[$rr->question->text]['sum4'] += $rr->answer->weight;

						}
						else
						{
							$balQuestion[$rr->question->text]['sum4'] = $rr->answer->weight;
						}
					}
					else
					{
						$balQuestion[$rr->question->text]['sum4'] = 'Нет результатов';
					};
				};
			};
			break;


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
			<h5 style="float: right;" class="btn btn-outline-secondary no-print setExcel" id="setExcel" data-id="<?php echo $_REQUEST['id'];?>">Excel</h5>
			<h5 style="float: right; display:none;" class="btn btn-outline-secondary no-print saveExcel" id="saveExcel">Скачать Excel</h5>
			<h3 align="center"><b style="text-align: center;">Результаты оценки</b></h3>
			<h3 align="center"><b style="text-align: center;"><?php echo $collection[0]->task->user->surname.' '.$collection[0]->task->user->name.' '.$collection[0]->task->user->middlename;?></b></h3>
			<h3 align="center"><b style="text-align: center;"><?php echo $collection[0]->task->test->name;?></b></h3>

			

			<!--вопросы со средним баллом-->
			<hr>


			<table>
				<thead style="background-color: #86cfda;">
					<tr><th>№ п/п</th><th>Компетенции</th><th>Да</th><th>Нет</th></tr>
				</thead>
				<tbody>
					<?php


					$i=1;
					foreach ($balQuestion as $question => $sum) 
					{

						echo '<tr><td>'.$i.'</td><td>'.$question.'</td>';
						if(isset($sum['sum1']))
						{			
							$sum1 = $sum['sum1'];
							switch (true) 
							{

								case $sum['sum1'] == 0:
								echo '<td></td><td>0</td>';
								break;

								case $sum['sum1'] == 1:
								echo '<td>1</td><td></td>';
								break;

								default:
								echo '<td></td><td></td>';
								break;

							};
							
						}
						else
						{
							echo '<td>Нет результатов</td><td></td>';
						};
						$i++;
					};
					?>
				</tbody>
			</table>
		</div>
	</body>
	</html>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
	/*---Создание excel отчета--------------------------------------*/
	$(document).on('click', '#setExcel',function(){
		var id = $(this).data('id');

		$.ajax({
			url: '/exports/save_process.php?id=' + id,
			dataType: "json",
			type: 'POST',
			success: function (data) 
			{

			}

		});		
		$('#saveExcel').css("display", "block");
		location.reload.bind(location);

	});
	/*----------------------------------------------------------------------------------*/
	/*---Создание excel отчета--------------------------------------*/
	$(document).on('click', '#setExcelText',function(){
		var id = $(this).data('id');

		$.ajax({
			url: '/exports/save_text.php?id=' + id,
			dataType: "json",
			type: 'POST',
			success: function (data) 
			{

			}

		});		
		$('#saveExcelText').css("display", "block");
		location.reload.bind(location);

	});
	/*----------------------------------------------------------------------------------*/
	/*---сохранение excel отчета--------------------------------------*/
	$(document).on('click', '#saveExcel',function(){


		window.location = '/exports/upload/report_process.xls';
		$('#saveExcel').css("display", "none");
		location.reload.bind(location);
	});
	/*----------------------------------------------------------------------------------*/
	/*---сохранение excel отчета--------------------------------------*/
	$(document).on('click', '#saveExcelText',function(){


		window.location = '/exports/upload/report_text.xls';
		$('#saveExcelText').css("display", "none");
		location.reload.bind(location);
	});
	/*----------------------------------------------------------------------------------*/
</script>