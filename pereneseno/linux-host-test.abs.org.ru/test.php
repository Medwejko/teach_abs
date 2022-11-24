<?php
include_once 'system/config.php';

checkStatus($task = "43");

function checkStatus()
{
	db::init();
	$sql = "SELECT * FROM `registr_task` WHERE `task` = :task AND status = 0";
	$status = db::init()->getAll($sql,array('status'=>$this->status));
	$this->status = array();
	foreach ($status as $check) 
	{
		$this->status[] = new status($check);
	};
}

/*				
---------сортировка-------------	
			<div>
							<table class="table table-sm">
								<thead>
									<tr>
										<th class="answer-text-row">Текст вопроса</th>
										<th>Позиция</th>
									</tr>
								</thead>
								<tbody id="question-block">
									<?php
									foreach ($obj->question as $question) 
									{
										echo 
										'<tr><th scope="row"><input type="text" name="question_text[]" class="form-control" value="'.$question->text.'"></th><td><input type="number" name="question_place[]" class="form-control question-place-input" value="'.$question->place.'"></td></tr>';
									};
									?>
								</tbody>
							</table>
						</div>		



---------------------dms------------------------
											<div class="input-group mb-3" style="border: 1px solid rgb(128, 189, 255); border-radius: .25rem;">
						<div class="input-group-prepend">
							<span class="input-group-text input-group-text-question" id="basic-addon2">Пример 2</span>
						</div>
						<input type="text" class="form-control dm-input" name="user" id="dm-user" data-class="user" data-value="0" data-properties="['name','surname']"  AUTOCOMPLETE="off">
						<span class="input-group-text input-group-text-question" name="tus_boss" id="dm-select">Выбрано: 0</span>
					</div>
-----------------------------------------------


*/
?>