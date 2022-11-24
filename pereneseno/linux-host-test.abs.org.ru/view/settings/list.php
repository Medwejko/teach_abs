<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/system/config.php';

$class = 'test';
$collection = api::collection($class);
?>
<h5 style="margin-top:8px;">
	<button style="display:inline-block;" type="button" data-obj="settings" data-toggle="tooltip" title="Добавить изображение для фона" class="btn btn-outline-primary newObjBtn">Добавить изображение для фона</button>
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