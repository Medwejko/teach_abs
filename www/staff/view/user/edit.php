	<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/system/config.php';
	if (!$_SESSION['user'] or $_SESSION['user']->group->access == 2) {
		header('Location: http://staff.ska.su');
	}
	$obj = new user(array('id' => $_REQUEST['id']));
	date_default_timezone_set('Europe/Moscow');
	$currentdate = date("Y-m-d");
	$currdate = date('Y');
	$birthdaydate = date('Y-m-d', strtotime($obj->birthday));
	$employdate = date('Y', strtotime($obj->employ));
	$currdated = date('d');
	$employdated = date('d', strtotime($obj->employ));
	$employd = $currdated - $employdated;
	$currdatem = date('m');
	$employdatem = date('m', strtotime($obj->employ));
	$employm = $currdatem - $employdatem;
	$employ = $currdate - $employdate;
	if ($employd < 0) {
		$employm--;
	}
	if ($employm < 0) {
		$employm = $employm + 12;
		$employ = $employ - 1;
	};
	function calculate_age($birthday)
	{
		$birthday_timestamp = strtotime($birthday);
		$age = date('Y') - date('Y', $birthday_timestamp);
		if (date('md', $birthday_timestamp) > date('md')) {
			$age--;
		}
		return $age;
	}
	$collection = api::collection('user');
	foreach ($collection as $user_obj) {
		if ($obj->boss == $user_obj->id) {
			$boss_name = $user_obj->surname . ' ' . $user_obj->name . ' ' . $user_obj->middlename . ' ' . $user_obj->profession;
			$boss = $user_obj->id;
		} elseif ($obj->functionBoss == $user_obj->id) {
			$functionBoss_name = $user_obj->surname . ' ' . $user_obj->name . ' ' . $user_obj->middlename . ' ' . $user_obj->profession;
			$functionBoss = $user_obj->id;
		};
	};
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
								width: 140px;
							}
						</style>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon1">Фамилия</span>
							</div>
							<input type="text" class="form-control" aria-describedby="basic-addon1" name="surname" id="user_surname" value="<?php echo $obj->surname; ?>">
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon1">Имя</span>
							</div>
							<input type="text" class="form-control" aria-describedby="basic-addon1" name="name" id="user_name" value="<?php echo $obj->name; ?>">
						</div>

						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon1">Отчество</span>
							</div>
							<input type="text" class="form-control" aria-describedby="basic-addon1" name="middlename" id="user_middlenamename" value="<?php echo $obj->middlename; ?>">
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon1">Должность</span>
							</div>
							<input type="text" class="form-control" aria-describedby="basic-addon1" name="profession" id="profession" value="<?php echo $obj->profession; ?>">
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question">Дата рождения</span>
							</div>
							<input type="date" class="form-control" name="birthday" id="user_birthday" value="<?php echo $obj->birthday; ?>">
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question">Возраст</span>
							</div>
							<span class="form-control"><?php echo calculate_age($birthdaydate); ?> лет</span>
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question">Дата устройства</span>
							</div>
							<input type="date" class="form-control" name="employ" id="user_employ" value="<?php echo $obj->employ; ?>">
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question">Стаж работы</span>
							</div>
							<span class="form-control"><?php echo $employ . " года ";
														echo $employm . " месяцев"; ?></span>
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question">Предыдущая должность</span>
							</div>
							<input type="textarea" class="form-control" name="exEmploy" id="user_secondEducation" rows="10" cols="20" wrap="hard" value="<?php echo $obj->exEmploy; ?>">
						</div>
						<div class="input-group mb-3" style="border: 1px solid rgb(128, 189, 255); border-radius: .25rem;">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon2">Непосредственный руководитель</span>
							</div>
							<input type="text" class="form-control ds-input" name="boss" id="ds-boss" data-class="user" data-value="<?php echo $boss; ?>" data-properties="['name','surname','profession']" autocomplete="off" value="<?php echo $boss_name; ?>">
							<div style="display:none" id="ds-boss-block" class="ds-block">
								<table id="ds-boss-table" class="table table-sm ds-table table-hover">

								</table>
							</div>
						</div>
						<div class="input-group mb-3" style="border: 1px solid rgb(128, 189, 255); border-radius: .25rem;">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon2">Функциональный руководитель</span>
							</div>
							<input type="text" class="form-control ds-input" name="functionBoss" id="ds-functionBoss" data-class="user" data-value="<?php echo $functionBoss; ?>" data-properties="['name','surname','profession']" autocomplete="off" value="<?php echo $functionBoss_name; ?>">
							<div style="display:none" id="ds-boss-block" class="ds-block">
								<table id="ds-boss-table" class="table table-sm ds-table table-hover">

								</table>
							</div>
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question">Задачи кадрового резерва</span>
							</div>
							<input type="textarea" class="form-control" name="taskReserv" id="user_taskReserv" rows="10" cols="20" wrap="hard" value="<?php echo $obj->taskReserv; ?>">
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question">Задачи предыдущей оценки</span>
							</div>
							<input type="textarea" class="form-control" name="taskAssessment" id="user_taskAssessment" rows="10" cols="20" wrap="hard" value="<?php echo $obj->taskAssessment; ?>">
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question">Результаты предыдущей оценки</span>
							</div>
							<input type="textarea" class="form-control" name="resultAssessment" id="user_resultAssessment" rows="10" cols="20" wrap="hard" value="<?php echo $obj->resultAssessment; ?>">
						</div>

						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question">Образование</span>
							</div>
							<input type="text" class="form-control" name="education" id="user_education" value='<?php echo $obj->education; ?>'>
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question">Дополнительное обучение</span>
							</div>
							<input type="textarea" class="form-control" name="secondEducation" id="user_secondEducation" value='<?php echo $obj->secondEducation; ?>'>
						</div>
						<div class="input-group mb-3" style="border: 1px solid #ced4da; border-radius: .25rem;">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon2">Подразделение</span>
							</div>
							<select class="form-control" aria-describedby="basic-addon2" name="subunit" id="soloselect-custom">
								<?php
								$collection = api::collection('subunit');
								foreach ($collection as $subunit) {
									$check = false;
									if ($obj->subunit->id == $subunit->id) {
										$check = true;
									};
									if ($check) {
										echo '<option value="' . $subunit->id . '" selected = "selected">"' . $subunit->name . '"</option>';
									} else {
										echo '<option value="' . $subunit->id . '">"' . $subunit->name . '"</option>';
									};
								};
								?>
							</select>
						</div>
						<div class="input-group mb-3" style="border: 1px solid rgb(128, 189, 255); border-radius: .25rem;">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon2">Cостоит в кадровом резерве</span>
							</div>
							<input type="text" class="form-control dm-input" noname="user_reserv-user" id="dm-user_reserv-user" data-class="user" data-value="0" data-properties="['name','surname','profession']" AUTOCOMPLETE="off">
							<span class="input-group-text input-group-text-question" id="dm-user_reserv-user-btn">Выбрано:&nbsp;<span id="dm-count-user_reserv-user">0</span></span>
							<input type="hidden" id="dm-user_reserv-user-store" name="user_reserv-user">
						</div>
						<div class="input-group mb-3" style="border: 1px solid rgb(128, 189, 255); border-radius: .25rem;">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon2">Имеет в кадровом резерве</span>
							</div>
							<input type="text" class="form-control dm-input" noname="user_reserv-reserv" id="dm-user_reserv-reserv" data-class="user" data-value="0" data-properties="['name','surname','profession']" AUTOCOMPLETE="off">
							<span class="input-group-text input-group-text-question" id="dm-user_reserv-reserv-btn">Выбрано:&nbsp;<span id="dm-count-user_reserv-reserv">0</span></span>
							<input type="hidden" id="dm-user_reserv-reserv-store" name="user_reserv-reserv">
						</div>

						<?php
						$id = $_REQUEST['id'];
						$reservColl = api::reservCollection($id);
						main::printr($reservColl);
						if (count($reservColl) > 0) {
							foreach ($reservColl['user'] as $user) {
								if ($user->id != $id) {
									echo '<input class="dm-user_reserv-user-edit-store" type="hidden" data-id="' . $user->id . '" value="' . $user->name . ' ' . $user->surname . '">';
								}
							}
							foreach ($reservColl['reserv'] as $reserv) {
								if ($reserv->id != $id) {
									echo '<input class="dm-user_reserv-reserv-edit-store" type="hidden" data-id="' . $reserv->id . '" value="' . $reserv->name . ' ' . $reserv->surname . '">';
								}
							}
						}
						?>
						<div class="input-group mb-3" style="border: 1px solid #ced4da; border-radius: .25rem;">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon2">Группа</span>
							</div>
							<select class="form-control" aria-describedby="basic-addon2" name="group" id="soloselect-custom">
								<?php
								$collection = api::collection('group');
								foreach ($collection as $group) {
									$check = false;
									if ($obj->group->access == $group->access) {
										$check = true;
									};
									if ($check) {
										echo '<option value="' . $group->id . '" selected = "selected">"' . $group->name . '"</option>';
									} else if ($group->id == 3) {
										if ($_SESSION['user']->group->access == 0) {
											echo '<option value="' . $group->id . '">"' . $group->name . '"</option>';
										}
									} else {
										echo '<option value="' . $group->id . '">"' . $group->name . '"</option>';
									};
								};
								?>
							</select>
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon1">Логин</span>
							</div>
							<input type="text" class="form-control" aria-describedby="basic-addon1" name="login" id="user_login" value="<?php echo $obj->login; ?>">
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon1">Пароль</span>
							</div>
							<input type="text" class="form-control" aria-describedby="basic-addon1" name="password" id="user_pass" value="<?php echo $obj->password; ?>">
						</div>
						<input type="hidden" name="id" value="<?php echo $obj->id; ?>">
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
		/*-----всплывающие подсказки--------*/
		$(function() {
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