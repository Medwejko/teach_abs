	<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'/system/config.php';	
	if (!$_SESSION['user'] or $_SESSION['user']->group->access == 2) {
	header('Location: http://staff.ska.su');
}
	$obj = new test(array('id'=>$_REQUEST['id']));
	?>
	<div class="modal fade bd-example-modal-lg" id="newModal" tabindex="-1" role="dialog" aria-labelledby="testModalLabel" aria-hidden="true">
		<div class="modal-dialog mw-100 w-75" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="testModalLabel">Изменить тест</h5>

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
							<input type="text" class="form-control" aria-describedby="basic-addon1" name="name" value="<?php echo $obj->name;?>">
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon1">Приветствие</span>
							</div>
							<input type="text" class="form-control" aria-describedby="basic-addon1" name="greeting" value="<?php echo $obj->greeting;?>">
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon1">Инструкции</span>
							</div>
							<input type="text" class="form-control" aria-describedby="basic-addon1" name="instruction" value="<?php echo $obj->instruction;?>">
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon1">Сообщение для Битрикс</span>
							</div>
							<input type="text" class="form-control" aria-describedby="basic-addon1" name="BitrixMess" value="<?php echo $obj->BitrixMess;?>">
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon1">Ограничение по времени</span>
							</div>
							<input type="time" class="form-control" aria-describedby="basic-addon1" name="countdown" step="1" value="<?php echo $obj->countdown;?>">
						</div>
						<?php 
						if ($_SESSION['user']->group->access == 0) 
						{
							echo '<div class="input-group mb-3" style="border: 1px solid #ced4da; border-radius: .25rem;">
							<div class="input-group-prepend">
							<span class="input-group-text input-group-text-question" id="basic-addon5">Права редактирования</span>
							</div>
							<select class="form-control" aria-describedby="basic-addon2" name="admin" id="soloselect-custom" >';

							if($obj->admin == 0)
							{
								echo '<option value="0" selected = "selected">Aдминистратор</option><option value="1">Глобальный администратор</option>';
							}
							else
							{
								echo '<option value="1" selected = "selected">Глобальный администратор</option><option value="0">Администратор</option>';
							}
							echo '</select></div>';
						}
						?>

						<div>
							<table class="table table-sm">
								<thead class="thead-light">
									<tr>
										<th class="answer-text-row">Текст вопроса</th>
										<th>Позиция</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$i = 1;
									foreach ($obj->question as $question) 
									{

										echo 
										'<tr><th scope="row"><span class="input-text" >'.$question->text.'</span></th><td><input type="number" class="form-control question-place-input" name="place[]" value="'.$i.'"></td></tr>';
										echo '<input type="hidden" name="question[]" value="'.$question->id.'">';
										$i++;
									};
									?>
								</tbody>
							</table>
						</div>		
						<input type="hidden" name="id" value="<?php echo $obj->id;?>">
					</form>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-toggle="tooltip" title="Закрыть текущее окно" data-dismiss="modal">Закрыть</button>
					<?php
					if ($_SESSION['user']->group->access == 1) 
					{
						if ($obj->admin == 0) {
							echo '<button type="button" class="btn btn-primary" id="saveObjBtn" data-toggle="tooltip" title="Сохранить изменения" data-obj="test">Сохранить</button>';
						};
					}
					else
					{
						echo '<button type="button" class="btn btn-primary" id="saveObjBtn" data-toggle="tooltip" title="Сохранить изменения" data-obj="test">Сохранить</button>';
					};

					?>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
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