<!----question----->
<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/system/config.php';
if (!$_SESSION['user'] or $_SESSION['user']->group->access == 2) {
	header('Location: http://staff.ska.su');
}
$obj = new question(array('id'=>$_REQUEST['id']));

?>
<div class="modal fade bd-example-modal-lg" id="newModal" tabindex="-1" role="dialog" aria-labelledby="QuestionModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="QuestionModalLabel">Изменить вопрос</h5>

			</div>
			<div class="modal-body">
				<form id="newForm">
					<div class="form-group">

						<style type="text/css">
							.input-group-text-question {
								width: 140px;
							}
						</style>

						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon1">Вопрос</span>
							</div>
							<input type="text" class="form-control" aria-describedby="basic-addon1" name="text" value="<?php echo $obj->text;?>">
						</div>						


						<div class="input-group mb-3" style="border: 1px solid #ced4da; border-radius: .25rem;">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon2">Тесты</span>
							</div>
							<select class="form-control" aria-describedby="basic-addon2" name="test_id[]" id="multiselect-custom" multiple="multiple">

								<?php

								$collection = api::collection('test');

								foreach ($collection as $test) 
								{

									$check = false;

									foreach ($obj->tests as $test_question) 
									{
										main::printr($obj);

										if($test_question['id'] == $test->id)
										{
											$check = true;
										};
									};

									if($check)
									{
										echo '<option value="'.$test->id.'" selected = "selected">"'.$test->name.'"</option>';
									}
									else
									{
										echo '<option value="'.$test->id.'">"'.$test->name.'"</option>';
									};
								};
								?>
							</select>
						</div>


						<div class="card">
							<div class="card-header" style="background-color: #e9ecef;">
								Тип ответа
							</div>
							<div class="card-body">

								<div class="form-check">
									<input class="form-check-input" type="radio" name="type" id="exampleRadios1" value="0" <?php if($obj->type == 0){echo 'checked';}?>>
									<label class="form-check-label" for="exampleRadios1">
										Текстовый
									</label>
								</div>
								<div class="form-check">
									<input class="form-check-input" type="radio" name="type" id="exampleRadios2" value="1" <?php if($obj->type == 1){echo 'checked';}?>>
									<label class="form-check-label" for="exampleRadios2">
										Один вариант
									</label>
								</div>
								<div class="form-check">
									<input class="form-check-input" type="radio" name="type" id="exampleRadios3" value="2" <?php if($obj->type == 2){echo 'checked';}?>>
									<label class="form-check-label" for="exampleRadios3">
										Несколько вариантов
									</label>
									<input class="form-check-input" type="number" name="col" id="colanswer" <?php echo "value=".$obj->col."";?> style="width: 52px; margin-left: 10px;margin-top: 0px;">
								</div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" id="exampleRadios3" value="3" <?php if($obj->type == 3){echo 'checked';}?>>
                                    <label class="form-check-label" for="exampleRadios4">
                                        Варианты поведения
                                    </label>
                                </div>
							</div>
						</div>

					<hr>
						<button type="button" class="btn btn-outline-secondary addAnswerBtn">Добавить ответ</button>
						<p></p>
						<div>
							<table class="table table-sm">
								<thead class="thead-light">
									<tr>
                                        <th>Порядок ответов</th>
										<th class="answer-text-row">Текст ответа</th>
										<th>Вес</th>
										<th>Удалить</th>
									</tr>
								</thead>
								<tbody id="answer-block">
									<?php
									foreach ($obj->answers as $answer) 
									{
										echo 
										'<tr><th><input type="place" name="answer_place[]" class="form-control" value="'.$answer->place.'"></th><th scope="row"><input type="text" name="answer_text[]" class="form-control" value="'.$answer->text.'"><input  name="answer_id[]" style="display: none;" class="form-control" value="'.$answer->id.'"></th><td><input type="number" name="answer_weight[]" class="form-control answer-weight-input" value="'.$answer->weight.'"></td><td><button type="button" class="btn btn-outline-secondary removeAnswerBtn">-</button></td></tr>';
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
					<button type="button" class="btn btn-primary" id="saveObjBtn" data-toggle="tooltip" title="Сохранить изменения" data-obj="question">Сохранить</button>
				</div>
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