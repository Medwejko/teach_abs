	<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'/system/config.php';
	if (!$_SESSION['user'] or $_SESSION['user']->group->access == 2) {
	header('Location: http://staff.ska.su');
}
	//$_REQUEST['id']
	$obj = new subunit(array('id'=>$_REQUEST['id']));
	?>
	<!----Subunit----->
	<div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="SubunitModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="subunitModalLabel">Изменить подразделение</h5>

				</div>
				<div class="modal-body">
					<form id="newForm">
						<style type="text/css">
							.input-group-text-question {
								width: 140px;
							}
						</style>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon1">Название</span>
							</div>
							<input type="text" class="form-control" aria-describedby="basic-addon1"  name="name" id="subunit_name" value="<?php echo $obj->name;?>">
						</div>
						
						<input type="hidden" name="id" value="<?php echo $obj->id;?>">
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-toggle="tooltip" title="Закрыть текущее окно" data-dismiss="modal">Закрыть</button>
					<button type="button" class="btn btn-primary" data-toggle="tooltip" title="Сохранить изменения" data-obj="subunit" id="saveObjBtn">Сохранить</button>
				</div>
			</div>
		</div>
	</div>
	<script>
		/*-----всплывающие подсказки--------*/
		$(function () {
			$('[data-toggle="tooltip"]').tooltip()
		});

		/*-----защита модалки от закрытия--------*/
		$('#newModal').modal({
			backdrop: 'static',
			keyboard: false
		});
	</script>