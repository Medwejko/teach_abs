<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/system/config.php';
if (!$_SESSION['user'] or $_SESSION['user']->group->access == 2) {
	header('Location: http://staff.ska.su');
}

if (isset($_REQUEST['filter'])) 
{

	$test = new test(array('id'=>$_REQUEST['filter']));
	$collection = $test->question;
}
else
{
	$class = 'question';
	$option = array();
	$filter = array('subunit'=>$_SESSION['user']->subunit->id);
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

	if($_SESSION['user']->group->access == 0)
	{
		$collection = api::listCollection($class, $page);
	}
	else
	{
		$collection = api::listCollection($class, $page);
	};
};


?>
<h5 style="margin-top:8px;">
	<table width="100%">
		<tr>
			<td align="left" width="160px">
				<button type="button" data-obj="question" data-toggle="tooltip" title="Создать новый вопрос" class="btn btn-outline-primary newObjBtn">Добавить вопрос</button>	
			</td>
			<td align="right" width="300px" style="padding-right: 0px;">
				<div style="border: 1px solid #007bff;">
					<select class="form-control" aria-describedby="basic-addon2" name="filterType" id="soloselect-custom">
						<option value="1">Фильтр по тестам</option>
					</select>
				</div>
			</td>
			<td width="500px" align="left" style="padding-left: 0px; padding-right: 0px;">
				<div style="border: 1px solid #007bff;">
					<select class="form-control" aria-describedby="basic-addon2" name="arrayProj" id="multiselect-custom" multiple="multiple" style="color: #007bff;">

						<?php
						$filter = api::collection('test');
						foreach ($filter as $test) 
						{
							echo '<option value="'.$test->id.'">"'.$test->name.'"</option>';

						};						
						?>
					</select>
				</div>
			</td>
			<td align="left" width="160px"  style="padding-left: 0px;">
				<button type="button" data-obj="question" class="btn btn-outline-primary filterBtn" style="padding-top: 7px; padding-bottom: 7px;">Сформировать</button>
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
			<tr><th>id</th><th>Текст</th><th width="200px">Опции</th></tr>
		</thead>
		<tbody class="tbds-list">
			
		</tbody>
	</table>
</div>
<div id="listColl">
	<table class="table table-striped table-sm td-list">
		<thead class="thead-dark">
			<tr><th>id</th><th>Текст</th><th width="200px">Опции</th></tr>
		</thead>
		<tbody>
			<?php
			foreach ($collection as $obj) 
			{
				
				echo '<tr>'
				.'<td class="td-list">'.$obj->id.'</td>'
				.'<td class="td-list">'.$obj->text.'</td>'	
				.'<td class="td-list">'.'<button type="button" class="btn btn-outline-secondary editObjBtn castom-menu-button" data-toggle="tooltip" data-placement="top" title="" data-original-title="Изменить вопрос" data-obj="question" data-id="'.$obj->id.'"><i class="material-icons">edit</i></button>'
				.'<button type="button" class="btn btn-outline-secondary copyObjBtn castom-menu-button" data-toggle="tooltip" data-placement="top" title="" data-original-title="Копировать вопрос" data-obj="question" data-id="'.$obj->id.'"><i class="material-icons">file_copy</i></button>'
				.'<button type="button" class="btn btn-outline-secondary deleteElementBtn castom-menu-button" data-id="'.$obj->id.'" data-obj="question" data-toggle="tooltip" data-placement="top" title="" data-original-title="Удалить вопрос"><i class="material-icons">delete_forever</i></button>'
				.'</td>'
				.'</tr>';
			};
			?>
		</tbody>
	</table>
</div>
<script>	
	$('.dsl-input').dynamicSelectListQuestion();
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	});

	$(document).ready(function() {
		$('#multiselect-custom').multiselect({
			nonSelectedText: 'Не выбраны',
			buttonWidth: '500px',
			delimiterText: '; ',
			maxHeight: 800
		});

	});
</script>