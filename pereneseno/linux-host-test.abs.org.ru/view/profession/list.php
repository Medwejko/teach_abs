<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/system/config.php';
if (!$_SESSION['user'] or $_SESSION['user']->group->access == 2) {
	header('Location: http://staff.ska.su');
}
$page = 0;
$class = 'profession';
$collection = api::listCollection($class, $page);
?>
<h5 style="margin-top:8px;">
	<b>Профессии</b>
	<button type="button" data-obj="profession" data-toggle="tooltip" title="Добавить новую профессию" class="btn btn-outline-primary newObjBtn">Добавить профессию</button>	
</h5>
<div id="leftmonitortab">
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
				.'<td class="td-list">'.'<button type="button" class="btn btn-outline-secondary castom-menu-button editObjBtn" data-toggle="tooltip" data-placement="top" title="" data-original-title="Изменить профессию" data-obj="profession" data-id="'.$obj->id.'"><i class="material-icons">edit</i></button>'
				.'<button type="button" class="btn btn-outline-secondary castom-menu-button deleteElementBtn" data-id="'.$obj->id.'" data-obj="profession" data-toggle="tooltip" data-placement="top" title="" data-original-title="Удалить профессию"><i class="material-icons">delete_forever</i></button>'
				.'</td>'
				.'</tr>';
			};
			?>
		</tbody>
	</table>
</div>
<script>		$(function () {
			$('[data-toggle="tooltip"]').tooltip()
		})
	</script>