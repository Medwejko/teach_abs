	<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'/system/config.php';
	if (!$_SESSION['user'] or $_SESSION['user']->group->access == 2) {
	header('Location: http://staff.ska.su');
}
	?>
	<!----profession----->
	<div class="modal fade bd-example-modal-lg" id="newModal" tabindex="-1" role="dialog" aria-labelledby="ProjectModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="ProjectModalLabel">Добавить проект</h5>
				</div>
				<div class="modal-body">
					<form id="newForm">
						<style type="text/css">
							.input-group-text-question {
								width: 150px;
							}
						</style>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon1">Название</span>
							</div>
							<input type="text" class="form-control" aria-describedby="basic-addon1"  name="name" id="project_name" >
						</div>
						<div class="input-group mb-3" style="border: 1px solid #ced4da; border-radius: .25rem;">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon2">Администраторы</span>
							</div>
							<select class="form-control" aria-describedby="basic-addon2" name="user_id[]" id="multiselect-custom" multiple="multiple">

								<?php
								$collection = api::collection('user', array('group' => 2));
								foreach ($collection as $obj) 
								{
									echo '<option value="'.$obj->id.'">"'.$obj->surname.' '.$obj->name.' '.$obj->middlename.'"</option>';

								};						
								?>
							</select>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-toggle="tooltip" title="Закрыть текущее окно" data-dismiss="modal">Закрыть</button>
					<button type="button" class="btn btn-primary" data-toggle="tooltip" title="Сохранить изменения" data-obj="project" id="saveObjBtn">Сохранить</button>
				</div>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function() {
			$('#multiselect-custom').multiselect({
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
	</script>