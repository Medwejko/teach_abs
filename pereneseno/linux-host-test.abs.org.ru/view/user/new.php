	<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'/system/config.php';
	if (!$_SESSION['user'] or $_SESSION['user']->group->access == 2) {
	header('Location: http://staff.ska.su');
}
	?>
	<!----User----->
	<div class="modal fade bd-example-modal-lg" id="newModal" tabindex="-1" role="dialog" aria-labelledby="UserModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="UserModalLabel">Добавить нового пользователя</h5>

				</div>
				<div class="modal-body">
					<form id="newForm">
						<style type="text/css">
							.input-group-text-question {
								width: 260px;
							}
						</style>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon2">Фамилия</span>
							</div>
							<input type="text" class="form-control" aria-describedby="basic-addon1"  name="surname" id="user_surname" >
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon1">Имя</span>
							</div>
							<input type="text" class="form-control" aria-describedby="basic-addon1"  name="name" id="user_name" >
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon3">Отчество</span>
							</div>
							<input type="text" class="form-control" aria-describedby="basic-addon1" name= "middlename" id="user_middlenamename" >
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon3">Должность</span>
							</div>
							<input type="text" class="form-control" aria-describedby="basic-addon1" name= "profession" id="user_profession" >
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question">Дата рождения</span>
							</div>
							<input type="date" class="form-control" name="birthday" id="user_birthday">
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question">Дата устройства</span>
							</div>
							<input type="date" class="form-control" name="employ" id="user_employ">
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question">Предыдущая должность</span>
							</div>
							<input type="textarea" class="form-control" name= "exEmploy" id="user_exEmploy" rows="10" cols="20" wrap="hard">
						</div>
						<div class="input-group mb-3" style="border: 1px solid rgb(128, 189, 255); border-radius: .25rem;">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon2">Непосредственный руководитель</span>
							</div>
							<input type="text" class="form-control ds-input" name="boss" id="ds-boss" data-class="user" data-value="0" data-properties="['name','surname','profession']" autocomplete="off">
							<div style="display:none" id="ds-boss-block" class="ds-block">
								<table id="ds-boss-table" class="table table-sm ds-table table-hover">

								</table>
							</div>
						</div>
						<div class="input-group mb-3" style="border: 1px solid rgb(128, 189, 255); border-radius: .25rem;">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon2">Функциональный руководитель</span>
							</div>
							<input type="text" class="form-control ds-input" name="functionBoss" id="ds-functionBoss" data-class="user" data-value="0" data-properties="['name','surname','profession']" autocomplete="off">
							<div style="display:none" id="ds-boss-block" class="ds-block">
								<table id="ds-boss-table" class="table table-sm ds-table table-hover">

								</table>
							</div>
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question">Задачи кадрового резерва</span>
							</div>
							<input type="textarea" class="form-control" name= "taskReserv" id="user_taskReserv" rows="10" cols="20" wrap="hard">
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question">Задачи предыдущей оценки</span>
							</div>
							<input type="textarea" class="form-control" name= "taskAssessment" id="user_taskAssessment" rows="10" cols="20" wrap="hard">
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question">Результаты предыдущей оценки</span>
							</div>
							<input type="textarea" class="form-control" name= "resultAssessment" id="user_resultAssessment" rows="10" cols="20" wrap="hard">
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question">Образование</span>
							</div>
							<input type="text" class="form-control" name= "education" id="user_education">
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question">Дополнительное обучение</span>
							</div>
							<input type="textarea" class="form-control" name= "secondEducation" id="user_secondEducation" rows="10" cols="20" wrap="hard">
						</div>
						<div class="input-group mb-3" style="border: 1px solid #ced4da; border-radius: .25rem;">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon5">Подразделение</span>
							</div>
							<select class="form-control" aria-describedby="basic-addon2" name="subunit" id="soloselect-custom" >

								<?php
								$collection = api::collection('subunit');
								foreach ($collection as $obj) 
								{
									echo '<option value="'.$obj->id.'">"'.$obj->name.'"</option>';

								};						
								?>
							</select>
						</div>
						<div class="input-group mb-3" style="border: 1px solid rgb(128, 189, 255); border-radius: .25rem;">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon2">Cостоит в кадровом резерве</span>
							</div>
							<input type="text" class="form-control dm-input" noname="user_reserv-user" id="dm-user_reserv-user" data-class="user" data-value="0" data-properties="['name','surname','profession']"  AUTOCOMPLETE="off">
							<span class="input-group-text input-group-text-question" id="dm-user_reserv-user-btn">Выбрано:&nbsp;<span id="dm-count-user_reserv-user">0</span></span>
							<input type="hidden"  id="dm-user_reserv-user-store" name="user_reserv-user">
						</div>
						<div class="input-group mb-3" style="border: 1px solid rgb(128, 189, 255); border-radius: .25rem;">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon2">Имеет в кадровом резерве</span>
							</div>
							<input type="text" class="form-control dm-input" noname="user_reserv-reserv" id="dm-user_reserv-reserv" data-class="user" data-value="0" data-properties="['name','surname','profession']"  AUTOCOMPLETE="off">
							<span class="input-group-text input-group-text-question" id="dm-user_reserv-reserv-btn">Выбрано:&nbsp;<span id="dm-count-user_reserv-reserv">0</span></span>
							<input type="hidden"  id="dm-user_reserv-reserv-store" name="user_reserv-reserv">
						</div>
						<div class="input-group mb-3" style="border: 1px solid #ced4da; border-radius: .25rem;">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon6">Группа</span>
							</div>
							<select class="form-control" aria-describedby="basic-addon2" name="group" id="soloselect-custom" >

								<?php
								$collection = api::collection('group');
								foreach ($collection as $obj) 
								{

									if ($obj->id == 1) {
										echo '<option value="'.$obj->id.'" selected="selected">"'.$obj->name.'"</option>';
									}
									else if ($obj->id == 3) 
									{
										if ($_SESSION['user']->group->access == 0) 
										{
											echo '<option value="'.$obj->id.'">"'.$obj->name.'"</option>';
										}
									}
									else
									{
										echo '<option value="'.$obj->id.'">"'.$obj->name.'"</option>';
									};
									

								};						
								?>
							</select>
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon7">Логин</span>
							</div>
							<input type="text" class="form-control" aria-describedby="basic-addon1" name= "login" id="user_login" >
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon8">Пароль</span>
							</div>
							<input type="text" class="form-control" aria-describedby="basic-addon1" name= "password" id="user_pass" >
						</div>
					</form>
				</div>
				<div class="modal-footer">

					<button type="button" class="btn btn-secondary" data-toggle="tooltip" title="Закрыть текущее окно" data-dismiss="modal">Закрыть</button>
					<button type="button" class="btn btn-primary" data-toggle="tooltip" title="Сохранить изменения" data-obj="user" id="saveObjBtn">Сохранить</button>
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
		$('.dm-input').dynamicMultiselect();
		$('.ds-input').dynamicSelect();
	</script>