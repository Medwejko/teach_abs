<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/system/config.php';
/*формирование данных по id*/
$obj = new user(array('id'=>$_REQUEST['id']));
$name = $obj->surname.' '.$obj->name.' '.$obj->middlename;
$subunit = $obj->subunit->name;


$profession = $obj->profession;

date_default_timezone_set('Europe/Moscow');
$currentdate = date("Y-m-d");
$currdate= date('Y');
$currdatem= date('m');
$birthdaydate= date('Y',strtotime($obj->birthday));
$employdate= date('Y',strtotime($obj->employ));
$employdatem= date('m',strtotime($obj->employ));
$employm = $currdatem - $employdatem;
$employ = $currdate - $employdate;
if ($employm < 0) 
{
	$employm = $employm + 12;
	$employ = $employ - 1;
};
$age = $currdate - $birthdaydate;

$exEmploy = $obj->exEmploy;

$education = $obj->education;

$secondEducation = $obj->secondEducation;

$collection = api::collection('user');
foreach ($collection as $user_obj) 
{
	if ($obj->boss == $user_obj->id) 
	{
		$boss = $user_obj->surname.' '.$user_obj->name.' '.$user_obj->middlename.' '.$user_obj->profession;
	}
	elseif ($obj->functionBoss == $user_obj->id) 
	{
		$functionBoss = $user_obj->surname.' '.$user_obj->name.' '.$user_obj->middlename.' '.$user_obj->profession;
	}
};

$reservColl = api::reservCollection($_REQUEST['id']);

$tastReserv = $obj->taskReserv;

$taskAssessment = $obj->taskAssessment;

$resultAssessment = $obj->resultAssessment;
/*заполнение excel*/

$header = file_get_contents('header_userCard.php');
$footer = file_get_contents('footer_userCard.php');



$name = mb_convert_encoding($name, 'cp1251');
$subunit = mb_convert_encoding($subunit, 'cp1251');
$profession = mb_convert_encoding($profession, 'cp1251');
$exEmploy = mb_convert_encoding($exEmploy, 'cp1251');
$education = mb_convert_encoding($education, 'cp1251');
$secondEducation = mb_convert_encoding($secondEducation, 'cp1251');
$boss = mb_convert_encoding($boss, 'cp1251');
$functionBoss = mb_convert_encoding($functionBoss, 'cp1251');
$tastReserv = mb_convert_encoding($tastReserv, 'cp1251');
$taskAssessment = mb_convert_encoding($taskAssessment, 'cp1251');
$resultAssessment = mb_convert_encoding($resultAssessment, 'cp1251');

$body = "<table border=0 cellpadding=0 cellspacing=0 width=1633 style='border-collapse:
collapse;table-layout:fixed;width:1225pt'>
<col width=429 style='mso-width-source:userset;mso-width-alt:15689;width:322pt'>
<col width=1204 style='mso-width-source:userset;mso-width-alt:44032;
width:903pt'>";

$body .= "<tr height=28 style='height:21.0pt'>
<td height=28 class=xl65 width=429 style='height:21.0pt;width:322pt'>ФИО:</td>
<td class=xl66 width=1204 style='border-left:none;width:903pt'>".$name."</td>
</tr>";

$body .= "<tr height=28 style='height:21.0pt'>
<td height=28 class=xl67 style='height:21.0pt;border-top:none'>Подразделение:</td>
<td class=xl68 style='border-top:none;border-left:none'>".$subunit."</td>
</tr>";

$body .= "<tr height=28 style='height:21.0pt'>
<td height=28 class=xl67 style='height:21.0pt;border-top:none'>Должность:</td>
<td class=xl68 style='border-top:none;border-left:none'>".$profession."</td>
</tr>";

$body .= "<tr height=28 style='height:21.0pt'>
<td height=28 class=xl67 style='height:21.0pt;border-top:none'>Возраст:</td>
<td class=xl68 style='border-top:none;border-left:none'>".$age." лет</td>
</tr>";

$body .= "<tr height=28 style='height:21.0pt'>
<td height=28 class=xl67 style='height:21.0pt;border-top:none'>Стаж работы в
организации:</td>
<td class=xl68 style='border-top:none;border-left:none'>".$employ." года ".$employm." месяцев</td>
</tr>";

$body .= "<tr height=28 style='height:21.0pt'>
<td height=28 class=xl67 style='height:21.0pt;border-top:none'>Предыдущие должности, даты перевода:</td>
<td class=xl68 style='border-top:none;border-left:none'>".$exEmploy."</td>
</tr>";

$body .= "<tr height=119 style='mso-height-source:userset;height:89.25pt'>
  <td height=119 class=xl69 width=429 style='height:89.25pt;border-top:none;
  width:322pt'>Образование (что и когда закончил; <br>
специальность; квалификация, год окончания):</td>
<td class=xl68 style='border-top:none;border-left:none'>".$education."</td>
</tr>";

$body .= "<tr height=28 style='height:21.0pt'>
<td height=28 class=xl67 style='height:21.0pt;border-top:none'>Дополнительное
обучение:</td>
<td class=xl68 style='border-top:none;border-left:none'>".$secondEducation."</td>
</tr>";

$body .= "<tr height=28 style='height:21.0pt'>
<td height=28 class=xl67 style='height:21.0pt;border-top:none'>Непосредственный
руководитель:</td>
<td class=xl68 style='border-top:none;border-left:none'>".$boss."</td>
</tr>";

$body .= "<tr height=28 style='height:21.0pt'>
<td height=28 class=xl67 style='height:21.0pt;border-top:none'>Функциональный
руководитель:<span style='mso-spacerun:yes'> </span></td>
<td class=xl68 style='border-top:none;border-left:none'>".$functionBoss."</td>
</tr>";

$body .= "<tr height=28 style='height:21.0pt'>
<td height=28 class=xl67 style='height:21.0pt;border-top:none'>Состоит в
кадровом резерве:</td>
<td class=xl68 style='border-top:none;border-left:none'>";
if(count($reservColl) > 0)
{
	foreach ($reservColl['user'] as $user) {
		if ($user->id != $_REQUEST['id']) 
		{
			$user_reserv = $user->surname." ".$user->name." ".$user->middlename." ".$user->profession;
			$user_reserv = mb_convert_encoding($user_reserv, 'cp1251');
			$body .= $user_reserv."<br>";
		}

	}

}
$body .="</td></tr>";


$body .= "<tr height=28 style='height:21.0pt'>
<td height=28 class=xl67 style='height:21.0pt;border-top:none'>Имеет в кадровом резерве:</td>
<td class=xl68 style='border-top:none;border-left:none'>";
if(count($reservColl) > 0)
{
	foreach ($reservColl['reserv'] as $reserv) 
	{
		if ($reserv->id != $_REQUEST['id']) 
		{
			$reserv_reserv = $reserv->surname." ".$reserv->name." ".$reserv->middlename." ".$reserv->profession;
			$reserv_reserv = mb_convert_encoding($reserv_reserv, 'cp1251');
			$body .= $reserv_reserv."<br>";
		}

	}

}
$body .= "</td></tr>";

$body .= "<tr height=119 style='mso-height-source:userset;height:89.25pt'>
  <td height=119 class=xl69 width=429 style='height:89.25pt;border-top:none;
  width:322pt'>Задачи, поставленные на<br>
    предыдущей оценке. Статус их<br>
    выполнения (в конкретных<br>
    фактических результатах)</td>
  <td class=xl68 style='border-top:none;border-left:none'>".$taskAssessment."</td>
 </tr>";

$body .= "<tr height=65 style='mso-height-source:userset;height:48.75pt'>
  <td height=65 class=xl70 width=429 style='height:48.75pt;border-top:none;
  width:322pt'>Результаты предыдущей оценки<br>
    (основные выводы)</td>
  <td class=xl71 style='border-top:none;border-left:none'>".$resultAssessment."</td>
 </tr>";


$document = $header.$body.$footer;
main::printr($name);

	// Если это файл и он равен удаляемому ... 
try {
	if((is_file("upload/userCard.xls"))) 
	{ 
		unlink("upload/userCard.xls"); 
		if(!file_exists("upload/userCard.xls"))
		{
			echo 'file is delete';
			file_put_contents('upload/userCard.xls', $document);
			echo json_encode(array('status'=>'ok'));
		}; 
	}
	else
	{
		echo 'file not found';
		file_put_contents('upload/userCard.xls', $document);
		echo json_encode(array('status'=>'ok'));
	}; 
} catch (Exception $e) {
	echo '<pre>';
	print_r($e);
	echo '</pre>';
	echo json_encode(array('status'=>'error'));	
};


?>