<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/system/config.php';
if (!$_SESSION['user'] or $_SESSION['user']->group->access == 2) {
	header('Location: http://staff.ska.su');
}
$task = new task(array('id'=>$_REQUEST['id']));

?>
<!----назначить тест----->
<div class="modal fade bd-example-modal-lg" id="newModal" tabindex="-1" role="dialog" aria-labelledby="taskModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="taskModalLabel">Задачи Битрикс</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="newForm">
					<style type="text/css">
						.input-group-text-question {
							width: 185px;
						}
					</style>
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<?php
							$collection = api::collection('test');
							
							foreach ($collection as $obj) 
							{
								if($task->test->id == $obj->id)
								{
									echo '<b>Тест: &nbsp;</b><output>'.$obj->name.'</output>';
								}

							};						
							?>
						</div>
						
					</div>
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<?php
							$collection = api::collection('user', array('id' =>$task->user->id));
							echo '<b>Оцениваемый: &nbsp;</b><output>'.$collection['0']->surname.' '.$collection['0']->name.' '.$collection['0']->middlename.'</output>';
							?>
						</div>
					</div>


					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text input-group-text-question" id="basic-addon1">Крайний срок задачи</span>
						</div>
						<input type="datetime-local" class="form-control" aria-describedby="basic-addon1"  name="dateBitrix" id="dateBitrix">
					</div>
					<table class="table table-striped table-sm td-list">
						<thead class="thead-dark">
							<tr>
								<th scope="col">ФИО</th>
								<th scope="col">Должность</th>
								<th scope="col">Статус</th>
								
							</tr>
						</thead>
						<tbody>
							<?php

							$usercol = api::userCollection($task->id);
							foreach ($usercol as $user) 
							{
								foreach ($task->registr_task as $rr) 
								{

									if($rr->user->id == $user['id'])
									{

										switch($rr->tus) 
										{
											case '1':
											$status = 'Самооценка';
											break;

											case '2':
											$status = 'Руководитель';
											break;

											case '3':
											$status = 'Коллега';
											break;

											case '4':
											$status = 'Подчиненный';
											break;

											default:
											$status = '0';
											break;
										};
										if (isset($rr->bitrixTask))
										{
											$bitrixTask = $rr->bitrixTask;
										}
										else
										{
											$bitrixTask = 0;
										};
										$statusTask = $rr->status;
										

									};
									
								};
								main::printr($statusTask);
								main::printr($bitrixTask);
								if ($status != '0' and $statusTask == '0' and $bitrixTask == '0')
								{	
									echo '<tr><td>'.$user['surname'].' '.$user['name'].' '.$user['middlename'].'</td><td>'.$user['profession'].'</td><td>'.$status.'</td></tr>';
								};
							};
							?>
						</tbody>
					</table>
					<input type="hidden" id="idBitrix" name="idBitrix" value="<?php echo $task->id;?>">
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-warning" data-toggle="tooltip" title="отправить задачи в Битрикс" data-obj="BitrixCall" id="BitrixCall">Назначить</button>
				<button type="button" class="btn btn-secondary" data-toggle="tooltip" title="Закрыть текущее окно" data-dismiss="modal">Закрыть</button>
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