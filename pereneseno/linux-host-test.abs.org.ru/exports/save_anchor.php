<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/system/config.php';

$collection = api::collection('result',array('task'=>$_REQUEST['id']));

$balQuestion = array();
foreach ($collection as $result) 
{

	$test = $result->task->test->id;
	
	foreach ($result->registr_result as $rr) 
	{


		array_push($balQuestion, $rr->answer->weight);

	};
};


/*заполнение excel*/

$header = file_get_contents('header_anchor.php');
$footer = file_get_contents('footer_anchor.php');

$user = $collection[0]->task->user->surname.' '.$collection[0]->task->user->name.' '.$collection[0]->task->user->middlename;

$sum1 = $balQuestion[0]+$balQuestion[1]+$balQuestion[2]+$balQuestion[3]+$balQuestion[4];
$sum2 = $balQuestion[5]+$balQuestion[6]+$balQuestion[7]+$balQuestion[8]+$balQuestion[9];
$sum3 = $balQuestion[10]+$balQuestion[11]+$balQuestion[12]+$balQuestion[13]+$balQuestion[14];
$sum4 = $balQuestion[15]+$balQuestion[16]+$balQuestion[17];
$sum5 = $balQuestion[18]+$balQuestion[19]+$balQuestion[20];
$sum6 = $balQuestion[21]+$balQuestion[22]+$balQuestion[23]+$balQuestion[24]+$balQuestion[25];
$sum7 = $balQuestion[26]+$balQuestion[27]+$balQuestion[28]+$balQuestion[29]+$balQuestion[30];
$sum8 = $balQuestion[31]+$balQuestion[32]+$balQuestion[33]+$balQuestion[34]+$balQuestion[35];
$sum9 = $balQuestion[36]+$balQuestion[37]+$balQuestion[38]+$balQuestion[39]+$balQuestion[40];


$user = mb_convert_encoding($user, 'cp1251');
$body = "<table border=0 cellpadding=0 cellspacing=0 width=1108 style='border-collapse:
collapse;table-layout:fixed;width:831pt'>
<col width=64 style='width:48pt'>
<col width=276 style='mso-width-source:userset;mso-width-alt:10093;width:207pt'>
<col width=128 span=6 style='mso-width-source:userset;mso-width-alt:4681;
width:96pt'>
<tr height=32 style='mso-height-source:userset;height:24.0pt'>
<td colspan=8 height=32 class=xl65 width=1108 style='height:24.0pt;
width:831pt'>Результаты оценки</td>
</tr>";

$body .= "<tr height=32 style='mso-height-source:userset;height:24.0pt'>
<td colspan=8 height=32 class=xl65 width=1108 style='height:24.0pt;
width:831pt'>".$user."</td>
</tr>";


$body .= "<tr height=48 style='mso-height-source:userset;height:36.0pt'>
<td height=48 class=xl67 width=64 style='height:36.0pt;width:48pt'>№ п/п</td>
<td class=xl67 width=276 style='border-left:none;width:207pt'>Компетенции</td>
<td class=xl67 width=128 style='border-left:none;width:96pt'>Балл по вопросу</td>
<td class=xl67 width=128 style='border-left:none;width:96pt'>Балл по вопросу</td>
<td class=xl67 width=128 style='border-left:none;width:96pt'>Балл по вопросу</td>
<td class=xl67 width=128 style='border-left:none;width:96pt'>Балл по вопросу</td>
<td class=xl67 width=128 style='border-left:none;width:96pt'>Балл по вопросу</td>
<td class=xl67 width=128 style='border-left:none;width:96pt'>Общая сумма
баллов</td>
</tr>";
$body .= "<tr height=45 style='mso-height-source:userset;height:33.75pt;box-sizing: border-box'>
<td height=45 class=xl66 width=64 style='height:33.75pt;border-top:none;
width:48pt;box-sizing: border-box;padding:0.75rem'>1</td>
<td class=xl66 width=276 style='border-top:none;border-left:none;width:207pt;
box-sizing: border-box;padding:0.75rem'>Профессиональная компетентность</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$balQuestion[0]."</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$balQuestion[1]."</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$balQuestion[2]."</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$balQuestion[3]."</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$balQuestion[4]."</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$sum1."</td></tr>";

$body .= "<tr height=45 style='mso-height-source:userset;height:33.75pt;box-sizing: border-box'>
<td height=45 class=xl66 width=64 style='height:33.75pt;border-top:none;
width:48pt;box-sizing: border-box;padding:0.75rem'>2</td>
<td class=xl66 width=276 style='border-top:none;border-left:none;width:207pt;
box-sizing: border-box;padding:0.75rem'>Менеджмент</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$balQuestion[5]."</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$balQuestion[6]."</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$balQuestion[7]."</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$balQuestion[8]."</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$balQuestion[9]."</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$sum2."</td></tr>";

$body .= "<tr height=45 style='mso-height-source:userset;height:33.75pt;box-sizing: border-box'>
<td height=45 class=xl66 width=64 style='height:33.75pt;border-top:none;
width:48pt;box-sizing: border-box;padding:0.75rem'>3</td>
<td class=xl66 width=276 style='border-top:none;border-left:none;width:207pt;
box-sizing: border-box;padding:0.75rem'>Автономия (независимость)</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$balQuestion[10]."</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$balQuestion[11]."</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$balQuestion[12]."</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$balQuestion[13]."</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$balQuestion[14]."</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$sum3."</td></tr>";

$body .= "<tr height=45 style='mso-height-source:userset;height:33.75pt;box-sizing: border-box'>
<td height=45 class=xl66 width=64 style='height:33.75pt;border-top:none;
width:48pt;box-sizing: border-box;padding:0.75rem'>4</td>
<td class=xl66 width=276 style='border-top:none;border-left:none;width:207pt;
box-sizing: border-box;padding:0.75rem'>Стабильность работы</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$balQuestion[15]."</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$balQuestion[16]."</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$balQuestion[17]."</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'></td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'></td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$sum4."</td></tr>";

$body .= "<tr height=45 style='mso-height-source:userset;height:33.75pt;box-sizing: border-box'>
<td height=45 class=xl66 width=64 style='height:33.75pt;border-top:none;
width:48pt;box-sizing: border-box;padding:0.75rem'>5</td>
<td class=xl66 width=276 style='border-top:none;border-left:none;width:207pt;
box-sizing: border-box;padding:0.75rem'>Стабильность места жительства</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$balQuestion[18]."</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$balQuestion[19]."</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$balQuestion[20]."</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'></td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'></td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$sum5."</td></tr>";

$body .= "<tr height=45 style='mso-height-source:userset;height:33.75pt;box-sizing: border-box'>
<td height=45 class=xl66 width=64 style='height:33.75pt;border-top:none;
width:48pt;box-sizing: border-box;padding:0.75rem'>6</td>
<td class=xl66 width=276 style='border-top:none;border-left:none;width:207pt;
box-sizing: border-box;padding:0.75rem'>Служение</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$balQuestion[21]."</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$balQuestion[22]."</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$balQuestion[23]."</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$balQuestion[24]."</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$balQuestion[25]."</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$sum6."</td></tr>";

$body .= "<tr height=45 style='mso-height-source:userset;height:33.75pt;box-sizing: border-box'>
<td height=45 class=xl66 width=64 style='height:33.75pt;border-top:none;
width:48pt;box-sizing: border-box;padding:0.75rem'>7</td>
<td class=xl66 width=276 style='border-top:none;border-left:none;width:207pt;
box-sizing: border-box;padding:0.75rem'>Вызов</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$balQuestion[26]."</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$balQuestion[27]."</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$balQuestion[28]."</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$balQuestion[29]."</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$balQuestion[30]."</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$sum7."</td></tr>";

$body .= "<tr height=45 style='mso-height-source:userset;height:33.75pt;box-sizing: border-box'>
<td height=45 class=xl66 width=64 style='height:33.75pt;border-top:none;
width:48pt;box-sizing: border-box;padding:0.75rem'>8</td>
<td class=xl66 width=276 style='border-top:none;border-left:none;width:207pt;
box-sizing: border-box;padding:0.75rem'>Интеграция стилей жизни</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$balQuestion[31]."</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$balQuestion[32]."</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$balQuestion[33]."</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$balQuestion[34]."</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$balQuestion[35]."</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$sum8."</td></tr>";

$body .= "<tr height=45 style='mso-height-source:userset;height:33.75pt;box-sizing: border-box'>
<td height=45 class=xl66 width=64 style='height:33.75pt;border-top:none;
width:48pt;box-sizing: border-box;padding:0.75rem'>9</td>
<td class=xl66 width=276 style='border-top:none;border-left:none;width:207pt;
box-sizing: border-box;padding:0.75rem'>Предпринимательство</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$balQuestion[36]."</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$balQuestion[37]."</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$balQuestion[38]."</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$balQuestion[39]."</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$balQuestion[40]."</td>";
$body .= "<td class=xl66 width=128 style='border-top:none;border-left:none;width:96pt;
box-sizing: border-box;padding:0.75rem'>".$sum9."</td></tr>";



$document = $header.$body.$footer;
main::printr($name);

	// Если это файл и он равен удаляемому ... 
try {
	if((is_file("upload/report_anchor.xls"))) 
	{ 
		unlink("upload/report_anchor.xls"); 
		if(!file_exists("upload/report_anchor.xls"))
		{
			echo 'file is delete';
			file_put_contents('upload/report_anchor.xls', $document);
			echo json_encode(array('status'=>'ok'));
		}; 
	}
	else
	{
		echo 'file not found';
		file_put_contents('upload/report_anchor.xls', $document);
		echo json_encode(array('status'=>'ok'));
	}; 
} catch (Exception $e) {
	echo '<pre>';
	print_r($e);
	echo '</pre>';
	echo json_encode(array('status'=>'error'));	
};


?>