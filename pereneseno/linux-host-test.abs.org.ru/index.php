<?php
include_once 'system/config.php';

$projectAdmin = [];
if(isset($_SESSION['user']->id) AND $_SESSION['user']->group->access != 2)
{
	$class = 'task';
	if ($_SESSION['user']->group->access == 1) 
	{
		$adminID = $_SESSION['user']->id;
		$projectCol = api::projCol($adminID);
		$projectAdmin = $projectCol;
		$pagecol = api::pageProjcol($class,$projectCol);
	}
	else
	{
		$collectProj = api::collection('project');
		foreach ($collectProj as $obj) 
		{
			array_push($projectAdmin, $obj->id);
		}
		$pagecol = api::pagecol($class);
	};
	

	
	if (isset($_REQUEST['page'])) 
	{
		$page = $_REQUEST['page'];
		if ($page == 0) {
			$pagemax = $page + 5;
			$pagemin = $page - 2;
		}
		elseif ($page == 1) {
			$pagemax = $page + 4;
			$pagemin = $page - 2;
		}
		elseif ($page == 2) {
			$pagemax = $page + 3;
			$pagemin = $page - 2;
		}
		elseif ($page == $pagecol) {
			$pagemax = $page + 2;
			$pagemin = $page - 5;
		}
		elseif ($page == $pagecol - 1) {
			$pagemax = $page + 2;
			$pagemin = $page - 4;
		}
		elseif ($page == $pagecol - 2) {
			$pagemax = $page + 2;
			$pagemin = $page - 3;
		}
		elseif ($page == $pagecol - 3) {
			$pagemax = $page + 2;
			$pagemin = $page - 2;
		}
		else
		{	
			$pagemin = $page - 2;
			$pagemax = $page + 2;
		};

	}
	else
	{
		$page = 0;
		$pagemin = $page - 2;
		$pagemax = $page + 5;
	};

	if($_SESSION['user']->group->access == 0)
	{

		$collection = api::listCollection($class,$page);
	}
	else
	{
		$collection = api::listProjCollection($class,$page,$projectCol);
	};
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
		<link rel="stylesheet" href="css/dynamicSelect.css" type="text/css"/>
		<link rel="stylesheet" href="css/globalStyle.css" type="text/css"/>
		<link rel="stylesheet" href="css/print.css" type="text/css"/>
		<link rel="stylesheet" href="css/dynamicMultiselect.css" type="text/css"/>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

		<title>Панель администратора</title>

		<style type="text/css">
			.img-fluid2 
			{
				height: 125px !important;
				width: auto !important;
			}
			.nm 
			{
				margin-bottom: 0 !important;
			}
			.answer-weight-input {
				width: 100px;
			}
			.answer-text-row {
				width: 100%;
			}
		</style>
	</head>
	<body>
		<!--контейнер модального окна-->
		<div id="modalContainer"></div>
		<div class="container-fluid">
			<nav class="navbar fixed-top navbar-dark bg-dark">
				<a class="navbar-brand" href="#"><b>Панель администратора</b></a>
				<a href="exit.php">выход</a>
			</nav>
			<div class="row" style="margin-top: 65px;">
				<div class="col">
					<ul class="nav nav-tabs" id="myTab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="task-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false" data-obj="task">Назначить тест</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="task-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false" data-obj="project">Проекты</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="test-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true" data-obj="test">Тесты</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="question-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false" data-obj="question">Вопросы</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="task-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false" data-obj="subunit">Подразделения</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="result-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false" data-obj="result">Отчеты</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="user-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false" data-obj="user">Пользователи</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="settings-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false" data-obj="settings">Настройки</a>
						</li>





					</ul>
					<div class="tab-content" id="myTabContent">
						<div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
							<h5 style="margin-top:8px;">
								
								<table width="100%">
									<tr>
										<td align="left" width="150px">
											<button type="button" data-obj="task" data-toggle="tooltip" title="Добавить новую задачу" class="btn btn-outline-primary newObjBtn">Назначить тест</button>
										</td>
										<td align="right" width="300px" style="padding-right: 0px;">
											<div class="dropdown">
												<button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													Выбрать фильтр
												</button>
												<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
													<a class="dropdown-item" id="taskSearch">Поиск</a>
													<a class="dropdown-item" id="taskFilter">Фильтр по проектам</a>
												</div>
											</div>

										</td>

										<td width="500px" align="left" style="padding-left: 0px; padding-right: 0px;">
											<div id="search" style="display:none;">
												<input style="display:inline-block; width:90%; border: 1px solid rgb(128, 189, 255);" type="text" class="form-control dslt-input" id="taskList" data-class="user" data-value="0" data-properties="['id','surname','name','middlename','profession','subunit','group']"  AUTOCOMPLETE="off">
											</div>
											<div id="filter" style="border: 1px solid #007bff;">


												<select class="form-control" aria-describedby="basic-addon2" name="arrayProj" id="multiselect-custom" multiple="multiple" style="color: #007bff;">

													<?php
													$filter = api::collection('project');
													foreach ($filter as $proj) 
													{

														$check = false;
														$invis = false;
														foreach ($projarr as $projID) 
														{

															if($proj->id == $projID)
															{
																$check = true;
															};
														};
														foreach ($projectAdmin as $visible)
														{
															if($proj->id == $visible)
															{
																$invis = true;
															};
														}
														if($check)
														{
															echo '<option value="'.$proj->id.'" selected = "selected">"'.$proj->name.'"</option>';
														}
														elseif($invis) 
														{
															echo '<option value="'.$proj->id.'">"'.$proj->name.'"</option>';
														}
														else
														{
														};

													};						
													?>
												</select>
											</div>
										</td>
										<td align="left" width="160px"  style="padding-left: 0px;" id="filterBtn">
											<button type="button" data-obj="task" class="btn btn-outline-primary filterBtn" style="padding-top: 7px; padding-bottom: 7px;">Сформировать</button>
										</td>

										<td width="auto" align="right">
											<?php 
											if($pagecol != 0)
											{
												echo '<ul class="pagination float-right" id="listPag" style="margin-bottom: 0px; padding-right: 0px;">';
												for($i=0; $i<=$pagecol; $i++) 
												{
													if($i == $page)
													{
														echo '<button type="button" data-page="'.$i.'" data-class="'.$class.'" class="btn btn-outline-primary btn-pagination">'.($i+1).'</button>';
													}
													elseif($i >= $pagemin and $i <= $pagemax and $i <= $pagecol - 1)
													{
														echo '<button type="button" data-page="'.$i.'" data-class="'.$class.'" class="btn btn-primary-new btn-pagination">'.($i+1).'</button>';
													}
													elseif($i == $pagecol -1 and $page <= $pagecol - 5)
													{
														echo '<button type="button" data-page="'.$i.'" data-class="'.$class.'" class="btn btn-primary-new btn-pagination material-icons"> skip_next </button>';
													}
													elseif($i == $pagecol -1 and $page == $pagecol - 4)
													{
														echo '<button type="button" data-page="'.$i.'" data-class="'.$class.'" class="btn btn-primary-new btn-pagination">'.($i+1).'</button>';
													}
													elseif($i == 0 and $page >= 4)
													{
														echo '<button type="button" data-page="'.$i.'" data-class="'.$class.'" class="btn btn-primary-new btn-pagination material-icons"> skip_previous </button>';
													}
													elseif($i == 0 and $page == 3)
													{
														echo '<button type="button" data-page="'.$i.'" data-class="'.$class.'" class="btn btn-primary-new btn-pagination">'.($i+1).'</button>';
													};
												};
												echo '</ul>';
											}
											else
											{

											}; 
											?>
										</td>
									</tr>

								</table>
								
							</h5>
							<div id="TaskDSList" style="display:none;">
								<table class="table table-striped table-sm">
									<thead class="thead-dark">
										<tr><th>id</th><th>Дата</th><th>Название теста</th><th>Оцениваемый</th><th>Статус</th><th width="300px">Опции</th></tr>
									</thead>
									<tbody class="tds-list">
									</tbody>
								</table>
							</div>
							<div id="listColl">
								<table class="table table-striped td-list">
									<thead class="thead-dark">
										<tr><th>id</th><th>Дата</th><th>Название теста</th><th>Оцениваемый</th><th>Статус</th><th width="300px">Опции</th></tr>
									</thead>
									<tbody>
										<?php
										
										foreach ($collection as $obj) 
										{			
											echo '<tr>'
											.'<td class="td-list">'.$obj->id.'</td>'
											.'<td class="td-list">'.$obj->createdate.'</td>'
											.'<td class="td-list">'.$obj->test->name.'</td>'
											.'<td class="td-list">'.$obj->user->surname.' '.$obj->user->name.' '.$obj->user->middlename.'</td>'			
											.'<td class="td-list">';
											switch ($obj->status) 
											{
												case '0':
												echo '<span style="font-weight:bold;color:red;">Не пройден</span>';
												break;

												case '1':
												echo '<span style="font-weight:bold;color:orange;">Назначен</span>';
												break;

												case '2':
												echo '<span style="font-weight:bold;color:green;">Пройден</span>';
												break;
											};

											echo '</td>'	
											.'<td class="td-list">'.'<button type="button" class="btn btn-outline-secondary castom-menu-button statusBtn" data-obj="'.$obj->id.'" data-obj="task" data-toggle="tooltip" data-placement="top" title="" data-original-title="Статус пользователей"><i class="material-icons">list_alt</i></button>'

											.'<button type="button" class="btn btn-outline-secondary castom-menu-button bitrixBtn" data-id="'.$obj->id.'" data-obj="task" data-toggle="tooltip" data-placement="top" title="" data-original-title="Отправить задачи в Битрикс"><i class="material-icons">notification_important</i></button>'
											.'<button type="button" class="btn btn-outline-secondary castom-menu-button resultTaskBtn" data-id="'.$obj->id.'" data-test="'.$obj->test->id.'" data-toggle="tooltip" data-placement="top" title="" data-original-title="Вывести результаты"><i class="material-icons">print</i></button>'
											.'<button type="button" class="btn btn-outline-secondary editObjBtn castom-menu-button" data-toggle="tooltip" data-placement="top" title="" data-original-title="Изменить задачу" data-obj="task" data-id="'.$obj->id.'"><i class="material-icons">edit</i></button>'
											.'<button type="button" class="btn btn-outline-secondary deleteElementBtn castom-menu-button" data-id="'.$obj->id.'" data-obj="task" data-toggle="tooltip" data-placement="top" title="" data-original-title="Удалить задачу"><i class="material-icons">delete_forever</i></button>'
											.'</td>'
											.'</tr>';
										};
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		
		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<script type="text/javascript" src="js/config.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

		<script type="text/javascript" src="js/bootstrap-multiselect.js"></script>
		<script type="text/javascript" src="js/dynamicSelect.js"></script>
		
		<script type="text/javascript" src="js/dynamicSelectResult.js"></script>
		<script type="text/javascript" src="js/dynamicMultiselect.js"></script>
		<script type="text/javascript" src="js/dynamicSelectList.js"></script>
		<script type="text/javascript" src="js/dynamicSelectListUser.js"></script>
		<script type="text/javascript" src="js/dynamicSelectListTask.js"></script>
		<script type="text/javascript" src="js/dynamicSelectListTest.js"></script>
		<script type="text/javascript" src="js/dynamicSelectListQuestion.js"></script>

		<script type="text/javascript">
			function session(context, callback){
				$.ajax({
					url: 'session.php',
					type: 'POST',
					success: function (data) 
					{
						if(data != 'exit')
						{
							callback(context);
						}
						else
						{
							window.location = 'auth.php';
						};						
					}
				});			
			}
			/*---загрузка модального окна Статистики по прохождению теста пользователей----------------------------------------*/
			$(document).on('click', '.statusBtn',function(){
				session(this, function(context){
					var task = $(context).data('obj');
					$('#modalContainer').load('view/task/statusTask.php?id='+ task,function(){
						$('#newModal').modal('show');
					});		
				});	
			});
			/*----------------------------------------------------------------------------------*/			
			/*---Выбор поиска вопросов по вводу----------------------------------------*/
			$(document).on('click', '#test_serach',function(){
				var question = document.getElementById("dsl-input");
				var test = document.getElementById("test-select");
				test.style.display = "block";
				question.style.display = "none";

			});
			/*----------------------------------------------------------------------------------*/
			/*---Фильтр по задачам----------------------------------------*/
			$(document).on('click', '.filterBtn',function(){
				session(this, function(context){
					var result = $('#multiselect-custom').val();
					var obj = $('.filterBtn').data("obj");
					console.log(result);
					$('.tab-pane.fade.active.show').load('/view/' + obj + '/list.php?filter=' + result);	
				});	
			});
			/*----------------------------------------------------------------------------------*/
			/*---Пагинация----------------------------------------*/
			$(document).on('click', '.btn-pagination',function(){
				session(this, function(context){

					var page = $(context).data('page');
					var obj = $(context).data('class');
					var result = $('#multiselect-custom').val();

					if (typeof result == "undefined" || result.length == '0') {
						
						$('.tab-pane.fade.active.show').load('/view/' + obj + '/list.php?page=' + page);

					}
					else
					{
						$('.tab-pane.fade.active.show').load('/view/' + obj + '/list.php?page=' + page +'&filter=' + result);
					};

				});				
			});
			/*----------------------------------------------------------------------------------*/
			/*---загрузка модального окна нового объекта----------------------------------------*/
			$(document).on('click', '.newObjBtn',function(){
				session(this, function(context){
					var obj = $(context).data('obj');
					$('#modalContainer').load('view/' + obj + '/new.php',function(){
						$('#newModal').modal('show');
					});		
				});	
			});
			/*----------------------------------------------------------------------------------*/
			/*---загрузка модального окна нового отчета----------------------------------------*/
			$(document).on('click', '.resultBtn',function(){
				session(this, function(context){
					var result = $('#soloselect-custom').val();
					var project = $('#projectSelect').val();
					var test = $('#testSelect').val();
					console.log($('#projectSelect').val());
					console.log($('#testSelect').val());
					var obj = $(context).data('obj');
					if (result == 1) 
					{
						if (test != '') {
							$('#modalContainer').load('view/' + obj + '/new_project.php?test=' + test + '&project=' + project,function(){
								$('#newModal').modal('show');

							});
						}
						else
						{
							$('#modalContainer').load('view/' + obj + '/new_user.php?&project=' + project,function(){
								$('#newModal').modal('show');
								});
						};
					}
					else
					{
						$('#modalContainer').load('view/' + obj + '/new_date.php?test=' + test + '&project=' + project,function(){
							$('#newModal').modal('show');

						});
					}

				});			
			});
			/*----------------------------------------------------------------------------------*/
			/*---загрузка модального окна удаления объекта--------------------------------------*/
			$(document).on('click', '.deleteElementBtn',function(){
				session(this, function(context){
					var obj = $(context).data('obj');
					var id = $(context).data('id');
					$('#modalContainer').load('view/delete.php?obj=' + obj + '&id=' + id,function(){
						$('#deleteModal').modal('show');
					});
				});			
			});
			/*----------------------------------------------------------------------------------*/
			/*---Сохранение excel объекта--------------------------------------*/
			$(document).on('click', '#saveExcel',function(){
				session(this, function(context){
					var id = $(context).data('id');
					console.log('id');
					$.ajax({
						url: 'exports/save.php?id=' + id,
						dataType: "json",
						type: 'POST',
						success: function (data) 
						{
							window.location = 'exports/upload/report.xls';
						}
					});	
				});		
			});
			/*----------------------------------------------------------------------------------*/
			/*---загрузка модального окна редактирования объекта--------------------------------*/
			$(document).on('click', '.editObjBtn',function(){
				session(this, function(context){
					var id = $(context).data('id');
					var obj = $(context).data('obj');
					$('#modalContainer').load('view/' + obj + '/edit.php?id=' + id,function(){
						$('#newModal').modal('show');
					});	
				});		
			});			
			/*---загрузка модального окна Bitrix --------------------------------*/
			$(document).on('click', '.bitrixBtn',function(){
				session(this, function(context){
					var id = $(context).data('id');
					var obj = $(context).data('obj');
					$('#modalContainer').load('view/' + obj + '/dateBitrix.php?id=' + id,function(){
						$('#newModal').modal('show');
					});	
				});		
			});
			/*----------------------------------------------------------------------------------*/
			/*---Обращение к Bitrix --------------------------------*/
			$(document).on('click', '#BitrixCall',function(){
				session(this, function(context){
					var id = $('#idBitrix').val();
					var date = $('#dateBitrix').val();
					if (date != '') 
					{
						$.ajax({
							url: 'system/class/bitrix.php?id=' + id + '&date=' + date,
							dataType: "json",
							type: 'POST',
							success: function (data) 
							{
								if(data.status == 'ok')
								{

								}

							}
						});				
						$('#newModal').modal('hide');
						$('.tab-pane.fade.active.show').empty();
						$('.tab-pane.fade.active.show').load('view/task/list.php');
					}
					else
					{
						alert("Пожалуйста укажите крайний срок");
					};
				});
			});
			/*----------------------------------------------------------------------------------*/
			/*---загрузка модального окна копирования объекта--------------------------------*/
			$(document).on('click', '.copyObjBtn',function(){
				session(this, function(context){
					var id = $(context).data('id');
					var obj = $(context).data('obj');
					$('#modalContainer').load('view/' + obj + '/edit.php?id=' + id,function(){
						$('[name = "id"]').remove();
						$('#newModal').modal('show');
					});			
				});
			});
			/*----------------------------------------------------------------------------------*/
			/*---сохранение объекта-------------------------------------------------------------*/

			$(document).on('click', '#saveObjBtn',function(){
				session(this, function(context){
					window.config = {};
					var obj = $(context).data('obj');
					var ds = document.getElementsByClassName('ds-input');
					$(ds).each(function(index, obj){

						$(obj).val($(obj).data('value'));

					});
					var dm = document.getElementsByClassName('dm-input');
					$(dm).each(function(index, obj){

					});
					var formdata = $("#newForm").serializeArray();

					var data = {};


					var collection = {};
					var collection_name = "";

					var test_array = [];



					$(formdata).each(function(index,obj){


						if(obj.name.indexOf('[]') + 1) 
						{	
							console.log(obj.name);

							if(obj.value != "" && obj.name != 'test_id[]' && obj.name != 'answer_text[]' && obj.name != 'answer_weight[]')
							{
								data[obj.name] = jQuery.parseJSON(obj.value);
							};
							var delimiter = obj.name.indexOf('[');

							collection_name = obj.name.substr(0,delimiter);


							if(collection.hasOwnProperty(collection_name))
							{
								collection[collection_name].push(obj.value);
							}
							else
							{
								collection[collection_name] = [];
								collection[collection_name].push(obj.value);
							};

							console.log(collection);

						}
						else
						{
							data[obj.name] = obj.value;
						};		

					});


					if(Object.keys(collection).length > 0)
					{
						data['collection'] = collection;
					};
					if(Object.keys(test_array).length > 0)
					{
						data['test'] = test_array;
					};


					cdata = 'data=' + JSON.stringify(data);

					console.log(cdata);

					$.ajax({
						url: 'system/api.php?obj=' + obj,
						data: cdata,	
						dataType: "json",
						type: 'POST',
						success: function (result) {
							$('#newModal').modal('hide');
							$('.tab-pane.fade.active.show').load('view/' + obj + '/list.php');

						}
					});	
				});		
			});
			/*----------------------------------------------------------------------------------*/
			/*---Вывод результатов задачи-------------------------------------------------------------*/
			$(document).on('click', '.resultTaskBtn', function () {
				session(this, function(context){
					var test = $(context).data('test');
					console.log(test);
					var id = $(context).data('id');
					if (test == 307) 
					{
						var win = window.open('view/result/task_anchor.php?id=' + id, '_blank');
					}
					else if (test == 772)
					{
						var win = window.open('view/result/task_client.php?id=' + id, '_blank');
					}
					else if (test == 771)
					{
						var win = window.open('view/result/task_process.php?id=' + id, '_blank');
					}
					else if (test == 806)
					{
						var win = window.open('view/result/task_special.php?id=' + id, '_blank');
					}
					else if (test == 811)
					{
						var win = window.open('view/result/all_tasks.php?id=' + id, '_blank');
					}
					else
					{
						var win = window.open('view/result/task.php?id=' + id, '_blank');
					}
					
					win.focus();
				});
			});

			/*----------------------------------------------------------------------------------*/	
			/*---Вывод результатов задачи-------------------------------------------------------------*/
			$(document).on('click', '.previewTestBtn', function () {
				session(this, function(context){

					var id = $(context).data('id');
					
					var win = window.open('view/test/'+ id +'.html');
					
					
					win.focus();
				});
			});

			/*----------------------------------------------------------------------------------*/	
			/*---Вывод карточки пользователя-------------------------------------------------------------*/
			$(document).on('click', '.userCardBtn', function () {
				session(this, function(context){

					var id = $(context).data('id');

					var win = window.open('view/user/user_card.php?id=' + id, '_blank');
					win.focus();
				});
			});

			/*----------------------------------------------------------------------------------*/	
			/*---Вывод результатов пользователя-------------------------------------------------------------*/
			$(document).on('click', '.resultUserBtn', function () {
				session(this, function(context){
					var test = $(context).data('test');
					console.log(test);
					var id = $(context).data('id');
					var user = $(context).data('user'); 
					var win = window.open('view/result/user.php?id=' + id + '&user='+ user, '_blank');
					win.focus();
				});
			});

			/*----------------------------------------------------------------------------------*/	
			/*---Редактирование результатов пользователя-------------------------------------------------------------*/
			$(document).on('click', '.editUserResBtn', function () {
				session(this, function(context){
					var test = $(context).data('test');
					console.log(test);
					var id = $(context).data('id');
					var user = $(context).data('user'); 
					var win = window.open('view/result/user_edit.php?id=' + id + '&user='+ user, '_blank');
					win.focus();
				});
			});

			/*----------------------------------------------------------------------------------*/		
			/*---Выбор фильтра task-------------------------------------------------------------*/
			$(document).on('click', '#taskSearch', function () {
				$('#filter').css("display", "none");
				$('#filterBtn').css("display", "none");
				$('#listPag').css("display", "none");
				$('#search').css("display", "block");
			});

			$(document).on('click', '#taskFilter', function () {
				$('#filter').css("display", "block");
				$('#filterBtn').css("display", "block");
				$('#listPag').css("display", "block");
				$('#search').css("display", "none");
			});
			/*----------------------------------------------------------------------------------*/
			/*---Вывод результатов-------------------------------------------------------------*/
			$(document).on('click', '#resultTestBtn', function () {
				session(this, function(context){
					var test = $(context).data('test');
					var project = $(context).data('project');
					var user = $('#ds-user').data('value');

					var dateIn = $('#dateIn').val();
					var dateOut = $('#dateOut').val();
					if (dateIn == '' || dateOut == '') {
						alert("Введите дату");
					}
					else if (user == '')
					{
						alert("Выберите пользователя");
					}
					else
					{

						var win = window.open('view/result/test.php?test=' + test + '&project=' + project + '&user=' + user + '&dateIn=' + dateIn + '&dateOut=' + dateOut);
						win.focus();
					};
				});

			});

			/*----------------------------------------------------------------------------------*/
			/*---Вывод результатов по проектам-------------------------------------------------------------*/
			$(document).on('click', '#resultProjectBtn', function () {
				session(this, function(context){
					var test = $(context).data('test');
					var project = $(context).data('project');
					var user = $('#ds-user').data('value');

					if (user == '') {
						alert("Выберите пользователя");
					}
					else
					{

						var win = window.open('view/result/project.php?test=' + test + '&project=' + project + '&user=' + user);
						win.focus();
					};
				});

			});

			/*----------------------------------------------------------------------------------*/
						/*---Вывод результатов по Пользователям-------------------------------------------------------------*/
			$(document).on('click', '#resultsUserBtn', function () {
				session(this, function(context){
					var project = $(context).data('project');
					var user = $('#ds-user').data('value');

					if (user == '') {
						alert("Выберите пользователя");
					}
					else
					{

						var win = window.open('view/result/user_results.php?project=' + project + '&user=' + user);
						win.focus();
					};
				});

			});

			/*----------------------------------------------------------------------------------*/
			/*---добавление вопроса-------------------------------------------------------------*/
			$(document).on('click', '.addAnswerBtn',function(){
				session(this, function(context){
					$('#exampleRadios1').prop("disabled", true);
					$('#exampleRadios2').prop("checked", true);
					$('#answer-block').append('<tr><th scope="row"><input type="number" name="answer_place[]" class="form-control"></th><th scope="row"><input type="text" name="answer_text[]" class="form-control"></th><td><input type="number" name="answer_weight[]" class="form-control answer-weight-input"></td><td><button type="button" class="btn btn-outline-secondary removeAnswerBtn">-</button></td></tr>');
					$('#colanswer').val(0);
				});
			});
			/*----------------------------------------------------------------------------------*/
			/*---добавление вопроса-------------------------------------------------------------*/
			$(document).on('click', '#exampleRadios2',function(){
				session(this, function(context){
					$('.addAnswerBtn').prop("disabled", false);
					$('#colanswer').prop("disabled", true);
					$('#colanswer').val(0);
				});
			});
			/*----------------------------------------------------------------------------------*/
			/*---добавление вопроса-------------------------------------------------------------*/
			$(document).on('click', '#exampleRadios3',function(){
				session(this, function(context){
					$('.addAnswerBtn').prop("disabled", false);
					$('#colanswer').prop("disabled", false);

				});
			});
			/*----------------------------------------------------------------------------------*/
			/*---добавление вопроса-------------------------------------------------------------*/
			$(document).on('click', '#exampleRadios1',function(){
				session(this, function(context){
					$('.addAnswerBtn').prop("disabled", true);
					$('#colanswer').prop("disabled", true);
					$('#colanswer').val(0);
				});
			});
			/*----------------------------------------------------------------------------------*/
			/*---Удаление вопроса-------------------------------------------------------------*/
			$(document).on('click', '.removeAnswerBtn',function(){
				session(this, function(context){				
					$(context).closest('tr').remove()
				});
			});

			/*----------------------------------------------------------------------------------*/
			$(document).on('click', '.deleteYesBtn',function(){
				session(this, function(context){
					var obj = $(context).data('obj');
					var id = $(context).data('id');
					$.ajax({
						url: 'system/api.php?delete&obj=' + obj + '&id=' + id,
						dataType: "json",
						type: 'POST',
						success: function (data) {
							if(data.status == 'ok')
							{
								$('#deleteModal').modal('hide');
								$('.tab-pane.fade.active.show').empty();
								$('.tab-pane.fade.active.show').load('view/' + obj + '/list.php');
							}
							else if(data.status == 'error')
							{
								$('#deleteModal').modal('hide');
								alert(data.desc);
							}
							else
							{
								$('#deleteModal').modal('hide');
								alert("Ошибка, попробуйте перезагрузить страницу и попробовать еще раз.");
							};
						}
					});
				});		
			});

			$(document).ready(function() {
				$('#soloselect-custom').multiselect({
					nonSelectedText: 'Не выбраны',
					buttonWidth: '100%',
					delimiterText: '; ',
					maxHeight: 800
				});

			});


			$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
				window.history.replaceState({}, document.title, "/index.php");
				var obj = $(this).data('obj');
				$('.tab-pane.fade').empty();
				$('.tab-pane.fade.active.show').load('view/' + obj + '/list.php');
			});
			/*-----всплывающие подсказки--------*/
			$(function () {

				$('[data-toggle="tooltip"]').tooltip()
			});

			/*-----защита модалки от закрытия--------*/
			$('#newModal').modal({
				backdrop: 'static',
				keyboard: false
			});

			$('.ds-input').dynamicSelect();
			$('.dm-input').dynamicMultiselect();
			$('.dslt-input').dynamicSelectListTask();
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