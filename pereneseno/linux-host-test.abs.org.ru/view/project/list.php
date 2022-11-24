<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/system/config.php';
if (!$_SESSION['user'] or $_SESSION['user']->group->access == 2) {
	header('Location: http://staff.ska.su');
}
$class = 'project';

if ($_SESSION['user']->group->access == 1) 
{
	$collection = [];
	$projectCol = api::projCol($_SESSION['user']->id);
	$collectionFull = api::collection($class);
	foreach ($projectCol as $projId) 
	{
		foreach ($collectionFull as $projobj) 
		{
			if ($projId == $projobj->id) 
			{
				array_push($collection, $projobj);
			};
		}
	}
	$pagecol = 0;
}
else
{
	if (isset($_REQUEST['page'])) 
	{
		$pagecol = api::pagecol($class);
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
			$pagemax = 0;
			$pagemin = $page - 6;
		}
		elseif ($page == $pagecol - 1) {
			$pagemax = $page + 1;
			$pagemin = $page - 5;
		}
		elseif ($page == $pagecol - 2) {
			$pagemax = $page + 2;
			$pagemin = $page - 4;
		}
		elseif ($page == $pagecol - 3) {
			$pagemax = $page + 2;
			$pagemin = $page - 3;
		}
		else
		{	
			$pagemin = $page - 2;
			$pagemax = $page + 2;
		};

	}
	else
	{
		$pagecol = api::pagecol($class);
		$page = 0;
		$pagemin = $page - 2;
		$pagemax = $page + 5;
	};
	$collection = api::listCollection($class, $page);

};

?>
<h5 style="margin-top:8px;">
	<table width="100%">
		<tr>
			<td align="left" width="160px">
				<button type="button" data-obj="project" data-toggle="tooltip" title="Создать новый проект" class="btn btn-outline-primary newObjBtn">Добавить проект</button>	
			</td>
			<td width="65%" align="center"><b style="display:inline-block;">Поиск</b>
				<input style="display:inline-block; width:90%; border: 1px solid rgb(128, 189, 255);" type="text" class="form-control dsl-input" id="dsl-input" data-class="project" data-value="0" data-properties="['id','name']"  AUTOCOMPLETE="off">
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

<div id="ds-list" style="display:none;">
	<table class="table table-striped table-sm td-list">
		<thead class="thead-dark">
			<tr><th>id</th><th>Название</th><th width="150px">Опции</th></tr>
		</thead>
		<tbody class="tbds-list">
		</tbody>
	</table>
</div>

<div id="listColl">
	<table class="table table-striped table-sm td-list">
		<thead class="thead-dark">
			<tr><th>id</th><th>Название</th><th width="150px">Опции</th></tr>
		</thead>
		<tbody>
			<?php
			foreach ($collection as $obj) 
			{
				
				
				echo '<tr>'
				.'<td class="td-list">'.$obj->id.'</td>'
				.'<td class="td-list">'.$obj->name.'</td>'
				.'<td class="td-list">'.'<button type="button" class="btn btn-outline-secondary editObjBtn castom-menu-button" data-toggle="tooltip" data-placement="top" title="" data-original-title="Изменить проект" data-obj="project" data-id="'.$obj->id.'"><i class="material-icons">edit</i></button>'
				.'<button type="button" class="btn btn-outline-secondary deleteElementBtn castom-menu-button" data-id="'.$obj->id.'" data-obj="project" data-toggle="tooltip" data-placement="top" title="" data-original-title="Удалить проект"><i class="material-icons">delete_forever</i></button>'
				.'</td>'
				.'</tr>';
			};
			?>
		</tbody>
	</table>
</div>
<script>	
	$('.dsl-input').dynamicSelectList();

	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	});


</script>