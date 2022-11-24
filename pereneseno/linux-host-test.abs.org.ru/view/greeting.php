<?php
include_once '../system/config.php';
main::printr($_SESSION['task']->registr_task);
	foreach ($_SESSION['task']->registr_task as $registr_task) {
		if ($registr_task->user->id == $_SESSION['user']->id) {
			$timer = $registr_task->timer;
		}
	}
	date_default_timezone_set('Europe/Moscow');
	$currentdate = date("H:i:s");
	main::printr($currentdate);
?>
<div class="modal fade bd-example-modal-lg" id="newModal" tabindex="-1" role="dialog" aria-labelledby="testModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<table class="table table-striped">
				<thead class="thead-dark">
					<tr><td align="center">Приветствие</td></tr>
				</thead>
				<tbody>
					<td align="center"><?php echo $_SESSION['task']->test->greeting;?></td>
				</tbody>
			</table>
			<button type="button" class="btn btn-outline-secondary start-task" data-timer="<?php echo $timer?>" data-id="<?php echo $_SESSION['task']->id;?>">Пройти тест</button>
		</div>
	</div>
</div>
<script>

	/*-----защита модалки от закрытия--------*/
	$('#newModal').modal({
		backdrop: 'static',
		keyboard: false
	});
</script>