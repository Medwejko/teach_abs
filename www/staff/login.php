<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/system/config.php';
include_once 'system/config.php';
?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">


	<!-- Include the plugin's CSS and JS: -->
	<link rel="stylesheet" href="css/bootstrap-multiselect.css" type="text/css"/>

	<title>Аутентификация</title>

</head>

<body>
	<div class="input-group mb-3" style="margin-top: 25%" width = "100px">
		<div class="input-group-prepend">
			<span class="input-group-text"></span>
		</div>
		<input type="text" class="form-control" placeholder="Логин" id ="login" aria-label="userLogin" aria-describedby="basic-addon1">

	</div>
	<div class="input-group mb-3">
		<div class="input-group-prepend">
			<span class="input-group-text"></span>
		</div>

		<input type="text" class="form-control" placeholder="Пароль" id ="password" aria-label="userPassword" aria-describedby="basic-addon2">
	</div>




	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script type="text/javascript" src="js/bootstrap-multiselect.js"></script>


	<script type="text/javascript">

		/*---загрузка модального окна нового объекта----------------------------------------*/
		$(document).on('click', '.newObjBtn',function(){
			var obj = $(this).data('obj');
			$('#modalContainer').load('view/' + obj + '/new.php',function(){
				$('#newModal').modal('show');
			});			
		});
		/*----------------------------------------------------------------------------------*/


	</script>
</body>
</html>