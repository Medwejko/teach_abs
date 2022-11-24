	<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'/system/config.php';
	
	?>
	<!----Subunit----->
	<div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="SubunitModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="SubunitModalLabel">Загрузить изображение для фона</h5>

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
								<span class="input-group-text input-group-text-question" id="basic-addon1">Выберите изображение</span>
							</div>
							<input type="file" name="left_monitor" class="form-control-file" id="left_monitor_file">
						</div>
						
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