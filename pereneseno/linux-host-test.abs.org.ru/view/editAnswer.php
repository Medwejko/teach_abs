<?php
include_once '../system/config.php';

$id = $_REQUEST['id'];
$answer = $_REQUEST['answer'];
$question = $_REQUEST['question'];
$position = $_REQUEST['position'];
$app = new app(array('query'=>'getQuestionCol'));
$questText = api::collection('question', array('id' => $question));
$result = api::collection('result', array('id' =>$_SESSION['result']['id']));
foreach ($result['0']->registr_result as $registr_result) {
	if ($registr_result->id == $id) 
	{
		$text = $registr_result->answer_text;
	};
};
$timer = $_SESSION['timer'];

?>
<div class="modal fade bd-example-modal-lg" id="newModal" tabindex="-1" role="dialog" aria-labelledby="testModalLabel" aria-hidden="true">
	<div class="modal-dialog mw-100 w-80" role="document" >
		<div class="modal-content">
			<div class="modal-header" >
				<h5><?php echo 'Вопрос № ' . $position . ' из ' . $app->questionCol . '. Тест: ' . $_SESSION['task']->test->name;?> для <span class="badge badge-info"><?php echo $_SESSION['task']->user->surname.' '.$_SESSION['task']->user->name.' '.$_SESSION['task']->user->middlename;?></span></h5>				
					<?php 
					if ($timer > 0) {
						echo '<p id="timer" data-mili="'. $timer .'" style="color: #f00; font-size: 120%; font-weight: bold; margin-bottom: 6px;"></p>';
					};?>

			</div>
			<div class="modal-header">
				<h5><span class="badge badge-secondary">Инструкции</span><?php echo $_SESSION['task']->test->instruction;?> </h5>				
			</div>
			<div class="modal-body">
				<h5><?php echo $questText['0']->text;?></h5>
				<form id="newForm">
					<input type="hidden" id="HTimer" value="<?php echo $timer?>">

					<input type="hidden" id="FTimer" name="timer">

					<?php
					switch ($questText['0']->type) {
						case '0':
						echo '<div class="custom-control">
						<textarea class="form-control chek-text" name="answer_text">'.$text.'</textarea>
						</div>';
						echo '<input type="hidden" name="question" value="'.$questText['0']->id.'">';
						echo '<input type="hidden" name="registr_res" value="'.$id.'">';
						break;

						case '1':
						foreach ($questText['0']->answers as $answers) 
						{
							if ($answers->id == $answer) 
							{
								echo '<div class="custom-control custom-radio">
								<input type="radio" id="customRadio'.$answers->id.'" name="answer" value="'.$answers->id.'" class="custom-control-input  chek-radio" checked>
								<label class="custom-control-label" for="customRadio'.$answers->id.'">"'.$answers->text.'"</label>
								</div>';
							}
							else
							{
								echo '<div class="custom-control custom-radio">

								<input type="radio" id="customRadio'.$answers->id.'" name="answer" value="'.$answers->id.'" class="custom-control-input  chek-radio">
								<label class="custom-control-label" for="customRadio'.$answers->id.'">"'.$answers->text.'"</label>
								</div>';
							};
						};

						echo '<input type="hidden" name="answer_text" value="">';	
						echo '<input type="hidden" name="question" value="'.$questText['0']->id.'">';
						echo '<input type="hidden" name="registr_res" value="'.$id.'">';

						break;

						case '2':
						foreach ($questText['0']->answers as $answers) 
						{
							echo '<div class="custom-control custom-checkbox">
							<input type="checkbox" id="custom-checkbox'.$answers->id.'" name="answer" value="'.$answers->id.'" class="custom-control-input chek-checkbox">
							<label class="custom-control-label" for="custom-checkbox'.$answers->id.'">"'.$answers->text.'"</label>
							</div>';		
						};
						echo '<input type="hidden" name="answer_text" value="">';	
						echo '<input type="hidden" name="question" value="'.$questText['0']->id.'">';
						echo '<input type="hidden" name="registr_res" value="'.$id.'">';
						break;
					};
					?>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-obj="answer" data-id="<?php echo $id;?>" id="updateAnswerBtn">Ответить</button>
			</div>
		</div>
	</div>
</div>

<script>

	/*-----защита модалки от закрытия--------*/
	$('#newModal').modal({
		backdrop: 'static',
		keyboard: false
	});
</script>