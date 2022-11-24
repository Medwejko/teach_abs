<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/system/config.php';
if (!$_SESSION['user'] or $_SESSION['user']->group->access == 2) {
	header('Location: http://staff.ska.su');
}
$class = 'task';
$projarr = [];
$projectAdmin = [];
if (isset($_REQUEST['filter'])) {

	if ($_SESSION['user']->group->access == 1) 
	{
		$adminID = $_SESSION['user']->id;
		$projectAdmin = api::projCol($adminID);
	}
	else
	{
		$collectProj = api::collection('project');
		foreach ($collectProj as $obj) 
		{
			array_push($projectAdmin, $obj->id);
		};

	};
	$projectCol = explode(",", $_REQUEST['filter']);
	$projarr = $projectCol;
	$pagecol = api::pageProjcol($class,$projectCol);
	main::printr($pagecol);
}
else
{
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
		};
		$pagecol = api::pagecol($class);

	};
};

main::printr($projectAdmin);


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

if (isset($_REQUEST['filter'])) 
{
	$collection = api::listProjCollection($class,$page,$projectCol);
}
else
{
	if($_SESSION['user']->group->access == 0)
	{

		$collection = api::listCollection($class,$page);
	}
	else
	{
		$collection = api::listProjCollection($class,$page,$projectCol);
	};
};


?>

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
	<table class="table table-sm table-striped td-list">
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

				.'<td class="td-list">'.'<button type="button" class="btn btn-outline-secondary castom-menu-button statusBtn" data-obj="'.$obj->id.'" data-toggle="tooltip" data-placement="top" title="" data-original-title="Статус пользователей"><i class="material-icons">list_alt</i></button>'

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
<script>		
	$(document).ready(function() {
		$('#soloselect-custom').multiselect({
			nonSelectedText: 'Не выбраны',
			buttonWidth: '100%',
			delimiterText: '; ',
			maxHeight: 800
		});

	});

	$(document).ready(function() {
		$('#multiselect-custom').multiselect({
			nonSelectedText: 'Не выбраны',
			buttonWidth: '500px',
			delimiterText: '; ',
			maxHeight: 800
		});

	});

	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	})

	$('.dslt-input').dynamicSelectListTask();

</script>
