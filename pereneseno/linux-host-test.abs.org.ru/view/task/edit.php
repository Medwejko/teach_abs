<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/system/config.php';
if (!$_SESSION['user'] or $_SESSION['user']->group->access == 2) {
	header('Location: http://staff.ska.su');
}
$task = new task(array('id'=>$_REQUEST['id']));
if ($task->user->id == 7000) 
{
	
	$token = $task->registr_task['0']->token;
	main::printr($token);
	?>
	<div class="modal fade bd-example-modal-lg" id="newModal" tabindex="-1" role="dialog" aria-labelledby="taskModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="taskModalLabel">Назначить тест</h5>

				</div>
				<div class="modal-body">
					<form id="newForm">
						<style type="text/css">
							.input-group-text-question {
								width: 210px;
							}
						</style>
						?>
						<div class="input-group mb-3" style="border: 1px solid #ced4da; border-radius: .25rem;">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon2">Выберите тест</span>
							</div>
							<?php 
							if ($task->status == 0) 
							{
								echo '<select class="form-control" aria-describedby="basic-addon2" name="test" id="soloselect-custom">';
								$collection = api::collection('test');
								foreach ($collection as $obj) 
								{
									if($task->test->id == $obj->id)
									{
										echo '<option value="'.$obj->id.'" selected="selected">"'.$obj->name.'"</option>';
									}
									else
									{
										echo '<option value="'.$obj->id.'">"'.$obj->name.'"</option>';
									};								
								};						
								
								echo'</select>';
							}
							else
							{
								echo $task->test->name;
								echo '<input type="hidden" name="test" value="'.$task->test->id.'">';
							}
							?>
						</div>
						<div class="input-group mb-3" style="border: 1px solid #ced4da; border-radius: .25rem;">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon1">Выберите проект</span>
							</div>
							<select class="form-control" aria-describedby="basic-addon1" name="project" id="soloselect-custom1">
								<?php
								main::printr($task);
								$collection = api::collection('project');

								foreach ($collection as $obj) 
								{
									if($task->project->id == $obj->id)
									{
										echo '<option value="'.$obj->id.'" selected="selected">"'.$obj->name.'"</option>';
									}
									else
									{
										echo '<option value="'.$obj->id.'">"'.$obj->name.'"</option>';
									};								
								};						
								?>
							</select>
						</div>
						<div class="input-group mb-3" style="border: 1px solid #ced4da; border-radius: .25rem;">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon1">Ссылка для прохождения</span>
							</div>

							<span class="form-control"><?php echo "http://staff.ska.su/auth.php?task=".$task->id."&token=".$token; ?></span>
						</div>

						<input type="hidden" name="user" value="7000">
						<input type="hidden" name="tus_self" value="1">
						<input type="hidden" name="tus_boss" value="[]">
						<input type="hidden" name="tus_colleague" value="[]">
						<input type="hidden" name="tus_subject" value="[]">
						<input type="hidden" name="id" value="<?php echo $task->id;?>">
						<input type="hidden" name="subunit" value="<?php echo $_SESSION['user']->subunit->id;?>">
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-toggle="tooltip" title="Закрыть текущее окно" data-dismiss="modal">Закрыть</button>
					<button type="button" class="btn btn-primary" data-toggle="tooltip" title="Сохранить изменения" data-obj="task" id="saveObjBtn">Сохранить</button>
				</div>
			</div>
		</div>
	</div>
	<?php
}
else
{
	?>

	<!----назначить тест----->
	<div class="modal fade bd-example-modal-lg" id="newModal" tabindex="-1" role="dialog" aria-labelledby="taskModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="taskModalLabel">Назначить тест</h5>

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
								<span class="input-group-text input-group-text-question" id="basic-addon2">Выберите тест</span>
							</div>
							<?php 
							if ($task->status == 0) 
							{
								echo '<select class="form-control" aria-describedby="basic-addon2" name="test" id="soloselect-custom">';
								$collection = api::collection('test');
								foreach ($collection as $obj) 
								{
									if($task->test->id == $obj->id)
									{
										echo '<option value="'.$obj->id.'" selected="selected">"'.$obj->name.'"</option>';
									}
									else
									{
										echo '<option value="'.$obj->id.'">"'.$obj->name.'"</option>';
									};								
								};						
								
								echo'</select>';
							}
							else
							{
								echo $task->test->name;
								echo '<input type="hidden" name="test" value="'.$task->test->id.'">';
							}
							?>
						</div>
						<div class="input-group mb-3" style="border: 1px solid #ced4da; border-radius: .25rem;">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon1">Выберите проект</span>
							</div>
							<select class="form-control" aria-describedby="basic-addon1" name="project" id="soloselect-custom1">
								<?php
								main::printr($task);
								$collection = api::collection('project');

								foreach ($collection as $obj) 
								{
									if($task->project->id == $obj->id)
									{
										echo '<option value="'.$obj->id.'" selected="selected">"'.$obj->name.'"</option>';
									}
									else
									{
										echo '<option value="'.$obj->id.'">"'.$obj->name.'"</option>';
									};								
								};						
								?>
							</select>
						</div>

						<div class="input-group mb-3" style="border: 1px solid rgb(128, 189, 255); border-radius: .25rem;">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon2">Кого оцениваем?</span>
							</div>
							<input type="text" class="form-control ds-input" name="user" id="ds-user" data-class="user" data-value="<?php echo $task->user->id;?>" data-properties="['name','surname','middlename']" autocomplete="off" value="<?php echo $task->user->name; echo '&nbsp'; echo $task->user->surname;?>"><div style="display:none" id="ds-user-block" class="ds-block"><table id="ds-user-table" class="table table-sm ds-table table-hover"></table></div>
							<span class="input-group-text input-group-text-question" id="basic-addon2">Самооценка</span>
							<split><input type="checkbox" class="form-check-input" name = "tus_self" id="tus_self" value="0" style="
							width: 25px;
							height: 25px;
							padding-right: 10px;
							margin-right: -40;
							margin-right: 0px;
							right: 15px;

							"<?php 
							$id = $_REQUEST['id'];
							$tus = 1;
							$self = api::dsCollection($id,$tus);

							if(count($self) > 0)
							{
								echo "checked";
							}

							?>>

							<div class="input-group-prepend">

							</div></split>
						</div>



						<div class="input-group mb-3" style="border: 1px solid rgb(128, 189, 255); border-radius: .25rem;">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon2">Руководитель</span>
							</div>
							<input type="text" class="form-control dm-input" noname="tus_boss" id="dm-tus_boss" data-class="user" data-value="0" data-properties="['name','surname','profession']"  AUTOCOMPLETE="off">
							<span class="input-group-text input-group-text-question" id="dm-tus_boss-btn">Выбрано:&nbsp;<span id="dm-count-tus_boss">0</span></span>
							<input type="hidden"  id="dm-tus_boss-store" name="tus_boss">
						</div>
						<?php 
						$id = $_REQUEST['id'];
						$tus = 2;
						$boss = api::dsCollection($id,$tus);
						$tus = 4;
						$subject = api::dsCollection($id,$tus);
						$tus = 3;
						$colleague = api::dsCollection($id,$tus);
						if(count($boss) > 0)
						{
							foreach ($boss as $tus_boss) {
								echo '<input class="dm-tus_boss-edit-store" type="hidden" data-id="'.$tus_boss->id.'" value="'.$tus_boss->name.' '.$tus_boss->surname.'">';
							}
						}
						if(count($subject) > 0)
						{
							foreach ($subject as $tus_subject) {
								echo '<input class="dm-tus_subject-edit-store" type="hidden" data-id="'.$tus_subject->id.'" value="'.$tus_subject->name.' '.$tus_subject->surname.'">';
							}
						}
						if(count($colleague) > 0)
						{
							foreach ($colleague as $tus_colleague) {
								echo '<input class="dm-tus_colleague-edit-store" type="hidden" data-id="'.$tus_colleague->id.'" value="'.$tus_colleague->name.' '.$tus_colleague->surname.'">';
							}
						}
						?>
						<div class="input-group mb-3" style="border: 1px solid rgb(128, 189, 255); border-radius: .25rem;">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon2">Подчиненный</span>
							</div>
							<input type="text" class="form-control dm-input" noname="tus_subject" id="dm-tus_subject" data-class="user" data-value="0" data-properties="['name','surname','profession']"  AUTOCOMPLETE="off">
							<span class="input-group-text input-group-text-question" id="dm-tus_subject-btn">Выбрано:&nbsp;<span id="dm-count-tus_subject">0</span></span>
							<input type="hidden"  id="dm-tus_subject-store" name="tus_subject">
						</div>
						<div class="input-group mb-3" style="border: 1px solid rgb(128, 189, 255); border-radius: .25rem;">
							<div class="input-group-prepend">
								<span class="input-group-text input-group-text-question" id="basic-addon2">Коллега</span>
							</div>
							<input type="text" class="form-control dm-input" noname="tus_colleague" id="dm-tus_colleague" data-class="user" data-value="0" data-properties="['name','surname','profession']"  AUTOCOMPLETE="off">
							<span class="input-group-text input-group-text-question" id="dm-tus_colleague-btn">Выбрано:&nbsp;<span id="dm-count-tus_colleague">0</span></span>
							<input type="hidden"  id="dm-tus_colleague-store" name="tus_colleague">
						</div>

						<input type="hidden" name="id" value="<?php echo $task->id;?>">
						<input type="hidden" name="subunit" value="<?php echo $_SESSION['user']->subunit->id;?>">
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-toggle="tooltip" title="Закрыть текущее окно" data-dismiss="modal">Закрыть</button>
					<button type="button" class="btn btn-primary" data-toggle="tooltip" title="Сохранить изменения" data-obj="task" id="saveObjBtn">Сохранить</button>
				</div>
			</div>
		</div>
	</div>
	<?php
}
?>
<script type="text/javascript">
	$(document).ready(function() {
		$('#multiselect-custom1').multiselect({
			nonSelectedText: 'Не выбраны',
			buttonWidth: '550px',
			delimiterText: '; ',
			maxHeight: 800
		});

	});

	$(document).ready(function() {
		$('#multiselect-custom2').multiselect({
			nonSelectedText: 'Не выбраны',
			buttonWidth: '550px',
			delimiterText: '; ',
			maxHeight: 800
		});

	});

	$(document).ready(function() {
		$('#multiselect-custom3').multiselect({
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

	$('.ds-input').dynamicSelect();
	$('.dm-input').dynamicMultiselect();

</script>