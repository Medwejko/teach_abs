<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/system/config.php';
if (!$_SESSION['user'] or $_SESSION['user']->group->access == 2) {
	header('Location: http://staff.ska.su');
}
$class = 'user';
$option = array();
$filter = array('subunit'=>$_SESSION['user']->subunit->id);
if (isset($_REQUEST['page'])) 
{
	$pagecol = api::pagecol($class);
	$page = $_REQUEST['page'];
	if ($page == 0) {
		$pagemax = $page + 5;
		$pagemin = $page - 2;
	}
	elseif ($page == 1) {
		$pagemax = $page + 4;
		$pagemin = $page - 2;
	}
	elseif ($page == 2) {
		$pagemax = $page + 3;
		$pagemin = $page - 2;
	}
	elseif ($page == $pagecol) {
		$pagemax = 0;
		$pagemin = $page - 6;
	}
	elseif ($page == $pagecol - 1) {
		$pagemax = $page + 1;
		$pagemin = $page - 5;
	}
	elseif ($page == $pagecol - 2) {
		$pagemax = $page + 2;
		$pagemin = $page - 4;
	}
	elseif ($page == $pagecol - 3) {
		$pagemax = $page + 2;
		$pagemin = $page - 3;
	}
	else
	{	
		$pagemin = $page - 2;
		$pagemax = $page + 2;
	};

}
else
{
	$pagecol = api::pagecol($class);
	$page = 0;
	$pagemin = $page - 2;
	$pagemax = $page + 5;
};

if($_SESSION['user']->group->access == 0)
{
	
	$collection = api::listCollection($class, $page);
}
else
{
	$collection = api::listCollection($class, $page);
};

?>
<style type="text/css">
	.input-group-text-question {
		width: 280px;
	}

</style>
<h5 style="margin-top:8px;">
	
	<table width="100%" >
		<tr>
			<td align="left" width="240px">
				<button style="display:inline-block;" type="button" data-obj="user" data-toggle="tooltip" title="Зарегистрировать нового пользователя" class="btn btn-outline-primary newObjBtn">Добавить пользователя</button>
			</td>
			<td width="62%" align="center"><b style="display:inline-block;">Поиск</b>

				<input style="display:inline-block; width:90%; border: 1px solid rgb(128, 189, 255);" type="text" class="form-control dslu-input" id="userList" data-class="user" data-value="0" data-properties="['id','surname','name','middlename','profession','subunit','group','login','password']"  AUTOCOMPLETE="off">
			</td>
			<td width="auto" align="right">
				<?php 
				if($pagecol != 0)
				{
					echo '<ul class="pagination float-right" id="listPag" style="margin-bottom: 0px; padding-right: 0px;">';
					for($i=0; $i<=$pagecol; $i++) 
					{
						if($i == $page)
						{
							echo '<button type="button" data-page="'.$i.'" data-class="'.$class.'" class="btn btn-outline-primary btn-pagination">'.($i+1).'</button>';
						}
						elseif($i >= $pagemin and $i <= $pagemax and $i <= $pagecol - 1)
						{
							echo '<button type="button" data-page="'.$i.'" data-class="'.$class.'" class="btn btn-primary-new btn-pagination">'.($i+1).'</button>';
						}
						elseif($i == $pagecol -1 and $page <= $pagecol - 5)
						{
							echo '<button type="button" data-page="'.$i.'" data-class="'.$class.'" class="btn btn-primary-new btn-pagination material-icons"> skip_next </button>';
						}
						elseif($i == $pagecol -1 and $page == $pagecol - 4)
						{
							echo '<button type="button" data-page="'.$i.'" data-class="'.$class.'" class="btn btn-primary-new btn-pagination">'.($i+1).'</button>';
						}
						elseif($i == 0 and $page >= 4)
						{
							echo '<button type="button" data-page="'.$i.'" data-class="'.$class.'" class="btn btn-primary-new btn-pagination material-icons"> skip_previous </button>';
						}
						elseif($i == 0 and $page == 3)
						{
							echo '<button type="button" data-page="'.$i.'" data-class="'.$class.'" class="btn btn-primary-new btn-pagination">'.($i+1).'</button>';
						};
					};
					echo '</ul>';
				}
				else
				{

				};
				?>
			</td>
		</tr>
	</table>
	
</h5>

<div id="UserDSList" style="display:none;">
	<table class="table table-striped table-sm td-list">
		<thead class="thead-dark">
			<tr><th>id</th><th>Фамилия</th><th>Имя</th><th>Отчество</th><th>Профессия</th><th>Подразделение</th><th>Группа</th><th>Логин</th><th>Пароль</th><th width="160px">Опции</th></tr>
		</thead>
		<tbody class="tds-list">
		</tbody>
	</table>
</div>


<div id="listColl">
	<table class="table table-striped table-sm td-list">
		<thead class="thead-dark">
			<tr><th>id</th><th>Фамилия</th><th>Имя</th><th>Отчество</th><th>Профессия</th><th>Подразделение</th><th>Группа</th><th>Логин</th><th>Пароль</th><th width="160px">Опции</th></tr>
		</thead>
		<tbody>
			<?php
			foreach ($collection as $obj) 
			{
				if ($obj->id != 7000) {
	

					$obj->id;
					echo '<tr>'
					.'<td class="td-list">'.$obj->id.'</td>'
					.'<td class="td-list">'.$obj->surname.'</td>'
					.'<td class="td-list">'.$obj->name.'</td>'
					.'<td class="td-list">'.$obj->middlename.'</td>'
					.'<td class="td-list">'.$obj->profession.'</td>'
					.'<td class="td-list">'.$obj->subunit->name.'</td>'
					.'<td class="td-list">'.$obj->group->name.'</td>'
					.'<td class="td-list">'.$obj->login.'</td>'				
					.'<td class="td-list">'.$obj->password.'</td>'		
					.'<td class="td-list">'.'<button type="button" class="btn btn-outline-secondary castom-menu-button editObjBtn" data-toggle="tooltip" data-placement="top" title="" data-original-title="Изменить пользователя" data-obj="user" data-id="'.$obj->id.'"><i class="material-icons">edit</i></button>'
					.'<button type="button" class="btn btn-outline-secondary castom-menu-button userCardBtn" data-id="'.$obj->id.'" data-toggle="tooltip" data-placement="top" title="" data-original-title="Карточка пользователя"><i class="material-icons">vertical_split</i></button>'
					.'<button type="button" class="btn btn-outline-secondary castom-menu-button deleteElementBtn" data-id="'.$obj->id.'" data-obj="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Удалить пользователя"><i class="material-icons">delete_forever</i></button>'
					.'</td>'
					.'</tr>';
				}
				else
				{

				};
			};
			?>
		</tbody>
	</table>
</div>

<script>		
	$('.dslu-input').dynamicSelectListUser();
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	})
</script>