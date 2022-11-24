	<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'/system/config.php';
	if (!$_SESSION['user'] or $_SESSION['user']->group->access == 2) {
	header('Location: http://staff.ska.su');
}
	?>
	<!----удалить----->
	<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="deleteModalLabel">Вы действительно хотите удалить?</h5>
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Нет</button>
					<button type="button" class="btn btn-outline-primary deleteYesBtn" data-id="<?php echo $_REQUEST['id'];?>" data-obj="<?php echo $_REQUEST['obj'];?>">Да</button>
				</div>
			</div>
		</div>
	</div>
	<script>


		/*-----защита модалки от закрытия--------*/
		$('#deleteModal').modal({
			backdrop: 'static',
			keyboard: false
		});
	</script>