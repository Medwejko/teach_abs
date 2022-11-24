<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/system/config.php';

$class = 'test';
$collection = api::collection($class);
?>
<h5 style="margin-top:8px;">
	<label>Выберите изоброжение</label>
	<input type="file" name="left_monitor" class="form-control-file" id="left_monitor_file">
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