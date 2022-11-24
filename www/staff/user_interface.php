<?php
include_once 'system/config.php';
if(isset($_SESSION['user']->id))
{
	$taskCollection = api::taskCollection($_SESSION['user']->id,0);

	?>
	<!doctype html>
	<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
		<link rel="icon" type="image/png" sizes="32x32" href="png/logo 32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="png/logo 16x16.png">

		<!-- Include the plugin's CSS and JS: -->
		<link rel="stylesheet" href="css/bootstrap-multiselect.css" type="text/css"/>

		<title>Пользовательский интерфейс</title>


	</head>

	<body>
		<!--контейнер модального окна-->
		<div id="modalContainer"></div>
		<div class="container-fluid">

			<nav class="navbar fixed-top navbar-dark bg-dark">
				<a class="navbar-brand" href="#"><b><?php echo '<td>'.$_SESSION['user']->surname.' '.$_SESSION['user']->name.' '.$_SESSION['user']->middlename.'</td>';?></b></a>
				<a href="exit.php">выход</a>
			</nav>

			<h5 style="margin-top:70px;">
				<b>Выберите тест для прохождения</b>

			</h5>
			<table class="table table-striped">
				<thead class="thead-dark" style="width: 1000px">
					<tr><th>Название теста</th><th>ФИО пользователя</th><th>Опции</th></tr>
				</thead>
				<tbody>
					<?php

					foreach ($taskCollection as $task)
					{

						echo
						'<tr>'
						.'<td>'.$task->test->name.'</td>'
						.'<td>'.$task->user->surname.' '.$task->user->name.' '.$task->user->middlename.'</td>'
						.'<td>'
						.'<button type="button" class="btn btn-outline-secondary start-greeting" data-id="'.$task->id.'">Пройти тест</button>'
						.'</td>'
						.'</tr>';
					};
					?>
				</tbody>
			</table>

		</div>
		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<script type="text/javascript" src="js/bootstrap-multiselect.js"></script>
		<?php
		if (isset($_REQUEST['task'])) {
			$taskb = $_REQUEST['task'];

			unset($_REQUEST['task']);
			?>
			<script type="text/javascript">
				$( document ).ready(function() {
					var id = <?php echo $taskb;?>;
					$.ajax({
						url: 'system/app.php?query=StartTask&id=' + id,
						dataType: "json",
						type: 'POST',
						success: function (data) {

							if(data.status == 'ok')
							{
								$('#modalContainer').load('view/greeting.php',function(){
									$('#newModal').modal('show');
								})
							}
							else if (data.status == 'error')
							{
								alert(data.desc);
							}
							else
							{
								alert('ошибка');
							};
						}
					});				
				});
			</script>
			<?php
		}
		?>
		<script type="text/javascript">
			/*---загрузка модального окна приветствия----------------------------------*/
			$(document).on('click', '.start-greeting',function(){
				$('.start-task').prop("disabled", true);
				var id = $(this).data('id');
				$.ajax({
					url: 'system/app.php?query=StartTask&id=' + id,
					dataType: "json",
					type: 'POST',
					success: function (data) {

						if(data.status == 'ok')
						{
							$('#modalContainer').load('view/greeting.php',function(){
								$('#newModal').modal('show');
							})
						}
						else if (data.status == 'error')
						{
							alert(data.desc);
						}
						else
						{
							alert('ошибка');
						};
					}
				});				
			});			





			/*---загрузка модального окна для прохождения теста----------------------------------*/
			$(document).on('click', '.start-task',function(){
				$('.start-task').prop("disabled", true);
				var id = $(this).data('id');
				$.ajax({
					url: 'system/app.php?query=StartTask&id=' + id,
					dataType: "json",
					type: 'POST',
					success: function (data) {

						if(data.status == 'ok')
						{
							$('#newModal').modal('hide');
							$('#newModal').on('hidden.bs.modal', function (e) {
								$('#modalContainer').load('view/runTask.php',function(){
									$('#newModal').modal('show');
								});			
							});
						}
						else if (data.status == 'error')
						{
							alert(data.desc);
						}
						else
						{
							alert('ошибка');
						};
					}
				});
			}).dblclick(function(){
				console.log('Dblclick');
			});			



			/*$('#modalContainer').load('view/user_answers.php?id=' + id,function(){
				$('#newModal').modal('show');
			});*/			

			/*---таймер----------------------------------*/
			$(document).on('click', '.start-task',function(){
				var obj = $(this).data('timer');
				console.log(obj);
				var i = 0;
				function timer(obj)
				{
					var obj = document.getElementById('HTimer');
					var millisec = $(obj).val();
					millisec = millisec-1000;
					$('#HTimer').val(millisec);
					$('#FTimer').val(millisec);
					console.log(millisec);
					$( "#timer" ).data("seconds", millisec);
					var seconds = (millisec / 1000).toFixed(0);
					var minutes = Math.floor(seconds / 60);
					var hours = "";
					if (minutes > 59) {
						hours = Math.floor(minutes / 60);
						hours = (hours >= 10) ? hours : "0" + hours;
						minutes = minutes - (hours * 60);
						minutes = (minutes >= 10) ? minutes : "0" + minutes;
					}

					seconds = Math.floor(seconds % 60);
					seconds = (seconds >= 10) ? seconds : "0" + seconds;
					if (hours != "") 
					{
						document.getElementById("timer").innerHTML = hours + ":" + minutes + ":" + seconds;
					}
					else
					{
						document.getElementById("timer").innerHTML = minutes + ":" + seconds;
					};
					
					if (millisec == 0 && i == 0) {
						i = 1;
						$.ajax({
							url: 'system/app.php?query=endTask',
							dataType: "json",
							type: 'POST',
							success: function (data) {
								if(data.status == 'ok')
								{
									$('#newModal').modal('hide');
									$('#newModal').on('hidden.bs.modal', function (e) {
										$('#modalContainer').load('view/runTask.php',function(){
											$('#newModal').modal('show');
										});			
									});						
								}
								else if (data.status == 'error')
								{
									alert(data.desc);
								}
								else
								{
									alert('ошибка');
								};
							}
						});			
					}
					
				}

				setInterval (timer,1000);
			});
			/*----------------------------------------------------------------------------------*/

			/*----------------------------------------------------------------------------------*/
			$(document).on('click', '#setAnswerBtn',function(){
				//$('#setAnswerBtn').prop("disabled", true);
				var check = false;
				var colcheck = 0;
				var col = $("#col").val();

				$(".chek-radio").each(function(index, obj)
				{
					if($(obj).is(':checked')) {check = true;};
				});

				$(".chek-text").each(function(index, obj)
				{
					if($(obj).val() != '') {check = true;};
				});

				$(".chek-checkbox").each(function(index, obj)
				{
					if($(obj).is(':checked')) {colcheck++;};
				});

				$(".custom-select").each(function(index, obj)
				{
					if($(obj).val() != '0') {check = true;}
					else{check = false;};
				});

				if (col != 0) 
				{
					if (colcheck  <= col && colcheck != 0) 
					{
						check = true;
					}
					else if(!check)
					{
						alert('Максимальное количество ответов не может быть больше ' + col);
					}
				}
				if (check)
				{
					var formdata = $("#newForm").serializeArray();
					console.log(formdata);

					$.ajax({
						url: 'system/app.php?query=addResultData',
						data: formdata,
						dataType: "json",
						type: 'POST',
						success: function (data) {
							if(data.status == 'ok')
							{
								$('#newModal').modal('hide');
								$('#newModal').on('hidden.bs.modal', function (e) {
									$('#modalContainer').load('view/runTask.php',function(){
										$('#newModal').modal('show');
									});			
								});						
							}
							else if (data.status == 'error')
							{
								alert(data.desc);
							}
							else
							{
								alert('ошибка');
							};
						}
					});
				}
				else
				{
					$('#setAnswerBtn').prop("disabled", false);
					alert('Пожалуйста выберите ответ');
				};

			})
			/*----------------------------------------------------------------------------------*/
			/*----------------------------------------------------------------------------------*/
			$(document).on('click', '#updateAnswerBtn',function(){
				$('#updateAnswerBtn').prop("disabled", true);
				var check = false;

				$(".chek-radio").each(function(index, obj)
				{
					if($(obj).is(':checked')) {check = true;};
				});

				$(".chek-text").each(function(index, obj)
				{
					if($(obj).val() != '') {check = true;};
				});

				$(".chek-checkbox").each(function(index, obj)
				{
					if($(obj).is(':checked')) {check = true;};
				});

				if (check)
				{
					
					$.ajax({
						url: 'system/app.php?query=updateResultData',
						data: formdata,
						dataType: "json",
						type: 'POST',
						success: function (data) {
							if(data.status == 'ok')
							{
								$('#newModal').modal('hide');
								$('#newModal').on('hidden.bs.modal', function (e) {
									$('#modalContainer').load('view/runTask.php',function(){
										$('#newModal').modal('show');
									});			
								});						
							}
							else if (data.status == 'error')
							{
								alert(data.desc);
							}
							else
							{
								alert('ошибка');
							};
						}
					});			
				}
				else
				{
					$('#setAnswerBtn').prop("disabled", false);
					alert('Пожалуйста выберите ответ');
				};
			})
			/*----------------------------------------------------------------------------------*/
			/*----------------------------------------------------------------------------------*/
			$(document).on('click', '#closeBtn',function(){
				$('#closeBtn').prop("disabled", true);

				window.close();
			});

			/*----------------------------------------------------------------------------------*/
			$(document).on('click', '.btn-editAnswer',function(){
				var id = $(this).data('id');
				var answer = $(this).data('answer');
				var question = $(this).data('question');
				var position = $(this).data('position');
				$('#newModal').modal('hide');
				$('#newModal').on('hidden.bs.modal', function (e) {
					$('#modalContainer').load('view/editAnswer.php?id=' + id + '&answer=' + answer + '&question=' + question + '&position=' + position,function(){
						$('#newModal').modal('show');
					});			
				});						

			});
			/*-----всплывающие подсказки--------*/
			$(function () {
				$('[data-toggle="tooltip"]').tooltip()
			});

		</script>
	</body>
	</html>
	<?php
}
else
{
	header('Location: auth.php');
};
?>