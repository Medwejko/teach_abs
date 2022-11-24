
<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/system/config.php';
if (!$_SESSION['user'] or $_SESSION['user']->group->access == 2) {
	header('Location: http://staff.ska.su');
}
	$collection = api::collection('result',array('task'=>$_REQUEST['id']));

	$balQuestion = array();
	foreach ($collection as $result) 
	{

		$test = $result->task->test->id;

		foreach ($result->registr_result as $rr) 
		{


			array_push($balQuestion, $rr->answer->weight);

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
			<h5 style="float: right;" class="btn btn-outline-secondary no-print setExcel" id="setExcelAnchor" data-id="<?php echo $_REQUEST['id'];?>">Excel</h5>
			<h5 style="float: right; display:none;" class="btn btn-outline-secondary no-print saveExcel" id="saveExcelAnchor">Скачать Excel</h5>
			<h3 align="center"><b>Результаты оценки</b></h3>
			<h3 align="center"><b><?php echo $collection[0]->task->user->surname.' '.$collection[0]->task->user->name.' '.$collection[0]->task->user->middlename;?></b></h3>

			<!--вопросы со средним баллом-->
			<hr>


			<table>
				<thead style="background-color: #86cfda;">
					<tr><th>№ п/п</th><th>Компетенции</th><th>Балл по вопросу</th><th>Балл по вопросу</th><th>Балл по вопросу</th><th>Балл по вопросу</th><th>Балл по вопросу</th><th>Общая сумма баллов</th></tr>
				</thead>
				<tbody>
					<tr><td>1</td><td>Профессиональная компетентность</td><td><?php echo $balQuestion['0'];?></td><td><?php echo $balQuestion['1'];?></td><td><?php echo $balQuestion['2'];?></td><td><?php echo $balQuestion['3'];?></td><td><?php echo $balQuestion['4'];?></td><td><?php echo $balQuestion['0']+$balQuestion['1']+$balQuestion['2']+$balQuestion['3']+$balQuestion['4'];?></td></tr>

					<tr><td>2</td><td>Менеджмент</td><td><?php echo $balQuestion['5'];?></td><td><?php echo $balQuestion['6'];?></td><td><?php echo $balQuestion['7'];?></td><td><?php echo $balQuestion['8'];?></td><td><?php echo $balQuestion['9'];?></td><td><?php echo $balQuestion['5']+$balQuestion['6']+$balQuestion['7']+$balQuestion['8']+$balQuestion['9'];?></td></tr>

					<tr><td>3</td><td>Автономия (независимость)</td><td><?php echo $balQuestion['10'];?></td><td><?php echo $balQuestion['11'];?></td><td><?php echo $balQuestion['12'];?></td><td><?php echo $balQuestion['13'];?></td><td><?php echo $balQuestion['14'];?></td><td><?php echo $balQuestion['10']+$balQuestion['11']+$balQuestion['12']+$balQuestion['13']+$balQuestion['14'];?></td></tr>

					<tr><td>4</td><td>Стабильность работы</td><td><?php echo $balQuestion['15'];?></td><td><?php echo $balQuestion['16'];?></td><td><?php echo $balQuestion['17'];?></td><td></td><td></td><td><?php echo $balQuestion['15']+$balQuestion['16']+$balQuestion['17'];?></td></tr>

					<tr><td>5</td><td>Стабильность места жительства</td><td><?php echo $balQuestion['18'];?></td><td><?php echo $balQuestion['19'];?></td><td><?php echo $balQuestion['20'];?></td><td></td><td></td><td><?php echo $balQuestion['18']+$balQuestion['19']+$balQuestion['20'];?></td></tr>

					<tr><td>6</td><td>Служение</td><td><?php echo $balQuestion['21']?></td><td><?php echo $balQuestion['22']?></td><td><?php echo $balQuestion['23']?></td><td><?php echo $balQuestion['24']?></td><td><?php echo $balQuestion['25']?></td><td><?php echo $balQuestion['21']+$balQuestion['22']+$balQuestion['23']+$balQuestion['24']+$balQuestion['25'];?></td></tr>

					<tr><td>7</td><td>Вызов</td><td><?php echo $balQuestion['26'];?></td><td><?php echo $balQuestion['27'];?></td><td><?php echo $balQuestion['28'];?></td><td><?php echo $balQuestion['29'];?></td><td><?php echo $balQuestion['30'];?></td><td><?php echo $balQuestion['26']+$balQuestion['27']+$balQuestion['28']+$balQuestion['29']+$balQuestion['30']?></td></tr>

					<tr><td>8</td><td>Интеграция стилей жизни</td><td><?php echo $balQuestion['31'];?></td><td><?php echo $balQuestion['32'];?></td><td><?php echo $balQuestion['33'];?></td><td><?php echo $balQuestion['34'];?></td><td><?php echo $balQuestion['35'];?></td><td><?php echo $balQuestion['31']+$balQuestion['32']+$balQuestion['33']+$balQuestion['34']+$balQuestion['35'];?></td></tr>

					<tr><td>9</td><td>Предпринимательство</td><td><?php echo $balQuestion['36'];?></td><td><?php echo $balQuestion['37'];?></td><td><?php echo $balQuestion['38'];?></td><td><?php echo $balQuestion['39'];?></td><td><?php echo $balQuestion['40'];?></td><td><?php echo $balQuestion['36']+$balQuestion['37']+$balQuestion['38']+$balQuestion['39']+$balQuestion['40'];?></td></tr>

				</tbody>
			</table>



		</div>
	</body>
	</html>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
	/*---Создание excel отчета--------------------------------------*/
	$(document).on('click', '#setExcelAnchor',function(){
		var id = $(this).data('id');

		$.ajax({
			url: '/exports/save_anchor.php?id=' + id,
			dataType: "json",
			type: 'POST',
			success: function (data) 
			{

			}

		});		
		$('#saveExcelAnchor').css("display", "block");
		location.reload.bind(location);

	});
	/*----------------------------------------------------------------------------------*/
	/*---сохранение excel отчета--------------------------------------*/
	$(document).on('click', '#saveExcelAnchor',function(){


		window.location = '/exports/upload/report_anchor.xls';
		$('#saveExcelAnchor').css("display", "none");
		location.reload.bind(location);
	});
	/*----------------------------------------------------------------------------------*/
</script>