	<!-- Include Twitter Bootstrap and jQuery: -->
	
	<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'/system/config.php';	
	if (!$_SESSION['user'] or $_SESSION['user']->group->access == 2) {
	header('Location: http://staff.ska.su');
}
	?>
	<div class="modal fade bd-example-modal-lg" id="newModal" tabindex="-1" role="dialog" aria-labelledby="testModalLabel" aria-hidden="true">
		<div class="modal-dialog mw-100 w-75" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="testModalLabel">Новый тест</h5>

				</div>
				<div class="modal-body">
					<form id="newForm">
						<style type="text/css">
							.input-group-text-question {
								width: 215px;
							}
						</style>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon1">Название теста</span>
							</div>
							<input type="text" class="form-control" aria-describedby="basic-addon1" name="name" >
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon1">Приветствие</span>
							</div>
							<input type="text" class="form-control" aria-describedby="basic-addon1" name="greeting" >
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon1">Инструкции</span>
							</div>
							<input type="text" class="form-control" aria-describedby="basic-addon1" name="instruction" >
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon1">Сообщение для Битрикс</span>
							</div>
							<input type="text" class="form-control" aria-describedby="basic-addon1" name="BitrixMess" >
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon1">Ограничение по времени</span>
							</div>
							<input type="time" class="form-control" aria-describedby="basic-addon1" name="countdown" step="1">
						</div>
						<?php 
						if ($_SESSION['user']->group->access == 0) 
						{
							echo '<div class="input-group mb-3" style="border: 1px solid #ced4da; border-radius: .25rem;">
							<div class="input-group-prepend">
							<span class="input-group-text input-group-text-question" id="basic-addon5">Права редактирования</span>
							</div>
							<select class="form-control" aria-describedby="basic-addon2" name="admin" id="soloselect-custom" >
							<option value="0">Aдминистратор</option>
							<option value="1">Глобальный администратор</option>
							</select>
							</div>';
						}
						?>
					</form>
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-toggle="tooltip" title="Закрыть текущее окно" data-dismiss="modal">Закрыть</button>
					<button type="button" class="btn btn-primary" data-toggle="tooltip" title="Сохранить изменения" data-obj="test" id="saveObjBtn">Сохранить</button>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">

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