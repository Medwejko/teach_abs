<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/system/config.php';
if (!$_SESSION['user'] or $_SESSION['user']->group->access == 2) {
	header('Location: http://staff.ska.su');
}
$collection = api::collection('registr_task',array('task' => $_REQUEST['id']));
?>
<!----назначить тест----->
<div class="modal fade bd-example-modal-lg" id="newModal" tabindex="-1" role="dialog" aria-labelledby="taskModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="taskModalLabel"><?php echo $collection['0']->task->test->name.' - '. $collection['0']->task->user->surname.' '.$collection['0']->task->user->name;?></h5>
			</div>
			<div>
				<table class="table table-striped td-list">
					<thead class="thead-dark">
						<tr><th>Пользователь</th><th>Позиция</th><th>Статус</th><th width="150px">Опции</th></tr>
					</thead>
					<tbody>
						<?php
						foreach ($collection as $obj) 
						{			

							echo '<tr><td class="td-list">'.$obj->user->surname.' '.$obj->user->name.' '.$obj->user->profession.'</td><td class="td-list">';
							switch ($obj->tus) 
							{
								case '1':
								echo '<span>Самооценка</span>';
								break;

								case '2':
								echo '<span>Руководитель</span>';
								break;

								case '3':
								echo '<span>Коллега</span>';
								break;

								case '4':
								echo '<span>Подчиненный</span>';
								break;

							};
							echo '</td><td class="td-list">';
							switch ($obj->status) 
							{
								case '0':
								echo '<span style="font-weight:bold;color:red;">Не пройден</span>';
								break;

								case '1':
								echo '<span style="font-weight:bold;color:green;">Пройден</span>';
								break;

							};
							echo '</td><td><button type="button" class="btn btn-outline-secondary castom-menu-button resultUserBtn" data-id="'.$obj->task->id.'" data-user="'.$obj->user->id.'" data-obj="test" data-toggle="tooltip" data-placement="top" title="" data-original-title="Вывести результаты"><i class="material-icons">print</i></button>';
							if ($_SESSION['user']->group->access == 0) {
								echo '<button type="button" class="btn btn-outline-secondary editUserResBtn castom-menu-button" data-toggle="tooltip" data-placement="top" title="" data-original-title="Изменить задачу" data-obj="task" data-id="'.$obj->task->id.'" data-user="'.$obj->user->id.'"><i class="material-icons">edit</i></button></td></tr>';
							}
							else
							{
								echo '</td></tr>';
							};


						};
						?>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-toggle="tooltip" title="Закрыть текущее окно" data-dismiss="modal">Закрыть</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('#multiselect-custom1').multiselect({
			nonSelectedText: 'Не выбраны',
			buttonWidth: '550px',
			delimiterText: '; ',
			maxHeight: 800
		});

	});
	$(document).ready(function() {
		$('#multiselect-custom2').multiselect({
			nonSelectedText: 'Не выбраны',
			buttonWidth: '550px',
			delimiterText: '; ',
			maxHeight: 800
		});

	});
	$(document).ready(function() {
		$('#multiselect-custom3').multiselect({
			nonSelectedText: 'Не выбраны',
			buttonWidth: '550px',
			delimiterText: '; ',
			maxHeight: 800
		});

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
</script>