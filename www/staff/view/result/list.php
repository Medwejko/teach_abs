<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/system/config.php';
if (!$_SESSION['user'] or $_SESSION['user']->group->access == 2) {
	header('Location: http://staff.ska.su');
}
$class = 'test';
$collection = api::collection($class);
?>
<h5 style="margin-top:8px;">
	<table class="table table-striped table-sm td-list">
		<thead class="thead-light">
			<tr>
				<th style="width: 20%; text-align: center;">Выберите форму отчета
					
				</th>
				<th style="width: 40%; text-align: center;">Выберите тест
					
				</th>
				<th style="width: 40%; text-align: center;">Выберите проект

				</th>
				<th>
					<button type="button" data-obj="result" data-toggle="tooltip" title="Добавить новую задачу" class="btn btn-outline-primary resultBtn">Выбрать</button>
				</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<select class="form-control" aria-describedby="basic-addon2" name="report" id="soloselect-custom">
						<option value="1">Отчет по проектам</option>
						<option value="2">Отчет за период</option>
					</select>
				</td>
				<td style="text-align: center;">
					<select class="form-contro multiselect-custom" aria-describedby="basic-addon2" name="test" multiple="multiple" id="testSelect">
						<?php
						$collection = api::collection('test');
						foreach ($collection as $obj) 
						{
							echo '<option value="'.$obj->id.'">"'.$obj->name.'"</option>';

						};						
						?>
					</select>
				</td>
				<td style="text-align: center;">
					<select class="form-control multiselect-custom" aria-describedby="basic-addon2" name="project" multiple="multiple" id="projectSelect">
						<?php
						$collection = api::collection('project');
						foreach ($collection as $obj) 
						{
							echo '<option value="'.$obj->id.'">"'.$obj->name.'"</option>';

						};						
						?>
					</select>
				</td>
				<td>
					
				</td>
			</tr>
		</tbody>
	</table>


</h5>


<script>	
	$('.ds-input').dynamicSelect();

	$(function () {

		$('[data-toggle="tooltip"]').tooltip()
	});

	$(document).ready(function() {
		$('#soloselect-custom').multiselect({
			nonSelectedText: 'Не выбраны',
			buttonWidth: '100%',
			delimiterText: '; ',
			maxHeight: 800
		});

	});

	$(document).ready(function() {
		$('.multiselect-custom').multiselect({
			nonSelectedText: 'Не выбраны',
			buttonWidth: '400px',
			delimiterText: '; ',
			maxHeight: 500
		});

	});




</script>