<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/system/config.php';
if (!$_SESSION['user'] or $_SESSION['user']->group->access == 2) {
	header('Location: http://staff.ska.su');
}
$page = 0;
$class = 'test';
$collection = api::collection($class);
?>
<div class="modal fade bd-example-modal-lg" id="newModal" tabindex="-1" role="dialog" aria-labelledby="taskModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="taskModalLabel">Сформировать отчет</h5>
					
			</div>
			<div class="modal-body">
				<form id="newForm">
					<style type="text/css">
						.input-group-text-question {
							width: 175px;
						}
					</style>
					
					<div class="input-group mb-3" style="border: 1px solid #ced4da; border-radius: .25rem;">
						<div class="input-group-prepend">
							<span class="input-group-text input-group-text-question" id="basic-addon2">Имя пользователя</span>
						</div>
						<input type="text" class="form-control ds-input" name="user" id="ds-user" data-class="user" data-value="0" data-properties="['name','surname','profession']" autocomplete="off"><div style="display:none" id="ds-user-block" class="ds-block"><table id="ds-user-table" class="table table-sm ds-table table-hover"></table></div>
					</div>
					
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary " data-toggle="tooltip" title="Закрыть текущее окно" data-dismiss="modal">Закрыть</button>
				<button type="button" class="btn btn-primary" data-toggle="tooltip" title="Вывести отчет" data-test="<?php echo $_REQUEST['test'];?>" data-project="<?php echo $_REQUEST['project'];?>" data-obj="test" id="resultProjectBtn">Вывести отчет</button>
			</div>
		</div>
	</div>
</div>

<script>	
	$('.ds-input').dynamicSelectResult();
	$(function () {

		$('[data-toggle="tooltip"]').tooltip()
	});
</script>