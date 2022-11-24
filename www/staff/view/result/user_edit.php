
<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/system/config.php';
if (!$_SESSION['user'] or $_SESSION['user']->group->access == 2) {
	header('Location: http://staff.ska.su');
}
$collection = api::collection('result',array('task'=>$_REQUEST['id'], 'user'=>$_REQUEST['user']));
$userColl = api::collection('user',array('id'=>$_REQUEST['user']));
$user = $userColl[0];
$textQuestion = array();
$balQuestion = array();
$idQuestion = array();
$type = 1;

foreach ($collection as $result) 
{
	$resultId = $result->id;
	$test = $result->task->test->id;
	

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
			$idQuestion[] = $rr->question->id;
		}
		else
		{
			$type = 1;
			if(isset($rr->answer->weight))
			{

				$balQuestion[$rr->question->text]['sum1'] = $rr->answer->weight;
				$idQuestion[] = $rr->question->id;
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
	</style>
</head>
<body>
	<?php
	if ($type == 0)
	{
		?>
		<input type="hidden" id="type" value="0">
		<div class="container-fluid">

			<h4><b><?php echo $collection[0]->task->test->name;?></b></h4>

			<h5 style="float: right;" class="btn btn-outline-secondary no-print"  onclick="window.print();">Печать</h5>
			<h5 style="float: right;" class="btn btn-outline-secondary no-print saveUserResBtn" data-user="<?php echo $_REQUEST['user'];?>" data-result="<?php echo $resultId;?>">Сохранить</h5>
			<h5 sy>Оцениваемый: <?php echo $collection[0]->task->user->surname.' '.$collection[0]->task->user->name.' '.$collection[0]->task->user->middlename;?></h5>
			<img src="../../png/Logo.jpg" height="50%" width="250px" alt="СКА">
			<br>
			<hr>
			<!--вопросы со свободным ответом-->
			<?php
			if(count($textQuestion)>0)
			{

				?>
				<table class="table table-bordered">
					<tbody>
						<tr></tr>
						<?php
						$i=1;
						foreach ($textQuestion as $question => $answers) 
						{
							$k = $i - 1;
							main::printr($k);
							echo '<tr><td width="50%" colspan="2"><b>'.$question.'</b></td>';
							foreach ($answers as $data) 
							{
								foreach ($idQuestion as $key => $value) 
								{
									if ($key == $k) 
									{
										main::printr($k);
										echo '<td colspan="2"><input type="text" class="user_result" data-id="'.$value.'" value="'.$data['answer_text'].'"></td></tr>';
									};
								};
								
							};
							$i++;
						};
						?>
					</tbody>
				</table>
				<?php
			};
			?>
		</div>

		<?php
	}
	else
	{
		?>

		<input type="hidden" id="type" value="1">
		<div class="container-fluid" >
			<h5 style="float: right;" class="btn btn-outline-secondary no-print"  onclick="window.print();">Печать</h5>
			<h5 style="float: right;" class="btn btn-outline-secondary no-print saveUserResBtn" data-user="<?php echo $_REQUEST['user'];?>" data-result="<?php echo $resultId;?>">Сохранить</h5>
			<h3 align="center"><b>Результаты прохождения тестирования пользователем <?php echo $user->surname.' '.$user->name.' с позиции ';
			switch ($collection[0]->tus) {
				case '1':
				echo 'самооценки';
				break;
				
				case '2':
				echo 'руководителя';
				break;
				
				case '3':
				echo 'коллеги';
				break;
				
				case '4':
				echo 'подчиненного';
				break;

			};

			?></b></h3>
			<h3 align="center"><b>Оцениваемый <?php echo $collection[0]->task->user->surname.' '.$collection[0]->task->user->name.' '.$collection[0]->task->user->middlename;?></b></h3>
			<h3 align="center"><b><?php echo $collection[0]->task->test->name;?></b></h3>
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
					<tr><th>№ п/п</th><th>Компетенции</th><th>Оценка</th></tr>
				</thead>
				<tbody>
					<?php


					$i=1;

					foreach ($balQuestion as $question => $sum) 
					{
						$k = $i - 1;
						echo '<tr><td>'.$i.'</td><td>'.$question.'</td>';
						if(isset($sum['sum1']))
						{			
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


							};
							foreach ($idQuestion as $key => $value) {
								if ($key == $k) {
									main::printr($k);
									echo '<input class="user_result" data-id="'.$value.'"value="'.$sum['sum1'].'"></td>';
								};
							};

						}
						else
						{
							foreach ($idQuestion as $key => $value) {
								if ($key == $k) {
									echo '<input class="user_result" data-id="'.$value.'"value="Нет результатов"></td>';
								};
							};

						};
						$i++;
					};
					?>
				</tbody>
			</table>



		</div>

		<?php

	};
	?>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script type="text/javascript">
		/*---Сохранение отредактированных результатов пользователя-------------------------------------------------------------*/
		$(document).on('click', '.saveUserResBtn', function () {
			var type = $('#type').val();
			console.log(type);
			var result = $(this).data('result');
			var user = $(this).data('user');
			var collection = [];
			var quest = {};
			var ds = document.getElementsByClassName('user_result');
			var i = 0;
			if (type == 1) 
			{
				$(ds).each(function(index, obj){
					if ($(obj).val() >= 5) {
						alert("Введено некорретное значение. Оцените от 1 до 4");
						i = 1;
					}
					else
					{
						quest.question = $(obj).data('id');
						quest.answer = $(obj).val();
						collection.push(quest);
						quest = {};
					}

				});
			}
			else
			{
				$(ds).each(function(index, obj){
					quest.question = $(obj).data('id');
					quest.answer_text = $(obj).val();
					collection.push(quest);
					quest = {};
				});
			}
			if (i == 0) {
				console.log(collection);
				cdata = 'data=' + JSON.stringify(collection);
				console.log(cdata);
				$.ajax({
					url: '/../system/api.php?result=' + result +'&user=' + user, 
					data: cdata,	
					dataType: "json",
					type: 'POST',
					success: function (result) {



					}
				});	
				//location.reload();
			};

		});

		/*----------------------------------------------------------------------------------*/	

	</script>
</body>
</html>