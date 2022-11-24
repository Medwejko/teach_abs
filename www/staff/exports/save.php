<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/system/config.php';
/*формирование данных по id*/
$collection = api::collection('result',array('task'=>$_REQUEST['id']));

$textQuestion = array();
$balQuestion = array();
$col1 = 0;
$col2 = 0;
$col3 = 0;
$col4 = 0;

foreach ($collection as $result) 
{
	$tususer[] = $result->tus;
	$user[] = $result->user;
	$test = $result->task->test->id;
	switch ($result->tus) {

		case '1':
		foreach ($result->task->test->question as $place) {
			foreach ($result->registr_result as $rr) 
			{
				if ($place->id == $rr->question->id) {
					if($rr->question->type == 0)
					{
						$type = 0;
						$answer = array(
							'tus' => "Cамооценка",
							'user' => $result->user,
							'answer_text' => $rr->answer_text
						);
						$textQuestion[$rr->question->text][] = $answer;

					}
					elseif ($rr->question->type == 3)
					{

						if(isset($balQuestion[$rr->question->text]['sum1']))
						{
							$balQuestion[$rr->question->text]['sum1'] += $rr->answer_text;

						}
						else
						{
							$balQuestion[$rr->question->text]['sum1'] = $rr->answer_text;
						}

						if(isset($balQuestion[$rr->question->text]['col1']))
						{

							$balQuestion[$rr->question->text]['col1'] ++;

						}
						else
						{

							$balQuestion[$rr->question->text]['col1'] = 1;
						};

					}

					else
					{
						$balQuestion[$rr->question->text]['sum1'] = $rr->answer->weight;
						$balQuestion[$rr->question->text]['col1'] = 1;
					};
				};
			}
		}
		break;

		case '2':
		foreach ($result->task->test->question as $place) {
			foreach ($result->registr_result as $rr) 
			{
				if ($place->id == $rr->question->id) {
					if($rr->question->type == 0)
					{
						$type = 0;
						$answer = array(
							'tus' => "Руководитель",
							'user' => $result->user,
							'answer_text' => $rr->answer_text
						);
						$textQuestion[$rr->question->text][] = $answer;

					}
					elseif ($rr->question->type == 3)
					{
						if(isset($balQuestion[$rr->question->text]['sum2']))
						{
							$balQuestion[$rr->question->text]['sum2'] += $rr->answer_text;

						}
						else
						{
							$balQuestion[$rr->question->text]['sum2'] = $rr->answer_text;
						}

						if(isset($balQuestion[$rr->question->text]['col2']))
						{

							$balQuestion[$rr->question->text]['col2'] ++;

						}
						else
						{

							$balQuestion[$rr->question->text]['col2'] = 1;
						};

					}

					else
					{
						if(isset($balQuestion[$rr->question->text]['sum2']))
						{
							$balQuestion[$rr->question->text]['sum2'] += $rr->answer->weight;

						}
						else
						{
							$balQuestion[$rr->question->text]['sum2'] = $rr->answer->weight;
						}
						if ($rr->answer->weight != 0) 
						{
							if(isset($balQuestion[$rr->question->text]['col2']))
							{

								$balQuestion[$rr->question->text]['col2'] ++;

							}
							else
							{

								$balQuestion[$rr->question->text]['col2'] = 1;
							};
						};
					};
				};
			};
		};
		break;

		case '3':
		foreach ($result->task->test->question as $place) {
			foreach ($result->registr_result as $rr) 
			{
				if ($place->id == $rr->question->id) {
					if($rr->question->type == 0)
					{
						$type = 0;
						$answer = array(
							'tus' => "Коллега",
							'user' => $result->user,
							'answer_text' => $rr->answer_text
						);
						$textQuestion[$rr->question->text][] = $answer;
					}
					elseif ($rr->question->type == 3)
					{
						if(isset($balQuestion[$rr->question->text]['sum3']))
						{
							$balQuestion[$rr->question->text]['sum3'] += $rr->answer_text;

						}
						else
						{
							$balQuestion[$rr->question->text]['sum3'] = $rr->answer_text;
						}

						if(isset($balQuestion[$rr->question->text]['col3']))
						{

							$balQuestion[$rr->question->text]['col3'] ++;

						}
						else
						{

							$balQuestion[$rr->question->text]['col3'] = 1;
						};

					}

					else
					{
						if(isset($balQuestion[$rr->question->text]['sum3']))
						{
							$balQuestion[$rr->question->text]['sum3'] += $rr->answer->weight;

						}
						else
						{
							$balQuestion[$rr->question->text]['sum3'] = $rr->answer->weight;
						}
						if(isset($balQuestion[$rr->question->text]['col3']))
						{

							$balQuestion[$rr->question->text]['col3'] ++;

						}
						else
						{

							$balQuestion[$rr->question->text]['col3'] = 1;
						};
					};
				};
			};
		};
		break;

		case '4':
		foreach ($result->task->test->question as $place) {
			foreach ($result->registr_result as $rr) 
			{
				if ($place->id == $rr->question->id) {
					if($rr->question->type == 0)
					{
						$type = 0;
						$answer = array(
							'tus' => "Подчиненный",
							'user' => $result->user,
							'answer_text' => $rr->answer_text
						);
						$textQuestion[$rr->question->text][] = $answer;
					}
					elseif ($rr->question->type == 3)
					{
						if(isset($balQuestion[$rr->question->text]['sum4']))
						{
							$balQuestion[$rr->question->text]['sum4'] += $rr->answer_text;

						}
						else
						{
							$balQuestion[$rr->question->text]['sum4'] = $rr->answer_text;
						}

						if(isset($balQuestion[$rr->question->text]['col4']))
						{

							$balQuestion[$rr->question->text]['col4'] ++;

						}
						else
						{

							$balQuestion[$rr->question->text]['col4'] = 1;
						};

					}

					else
					{
						if(isset($balQuestion[$rr->question->text]['sum4']))
						{

							$balQuestion[$rr->question->text]['sum4'] += $rr->answer->weight;

						}
						else
						{

							$balQuestion[$rr->question->text]['sum4'] = $rr->answer->weight;
						}
						if(isset($balQuestion[$rr->question->text]['col4']))
						{

							$balQuestion[$rr->question->text]['col4'] ++;

						}
						else
						{

							$balQuestion[$rr->question->text]['col4'] = 1;
						}
					};
				};
			};
		};
		break;


	};

};

/*заполнение excel*/

$header = file_get_contents('header.php');
$footer = file_get_contents('footer.php');

$user = $collection[0]->task->user->surname.' '.$collection[0]->task->user->name.' '.$collection[0]->task->user->middlename;

$test = $collection[0]->task->test->name;
$low = "<td class=xl75 width=114 style='border-top:none;border-left:none;width:86pt'>";
$middle = "<td class=xl74 width=114 style='border-top:none;border-left:none;width:86pt'>";
$hight = "<td class=xl72 width=114 style='border-top:none;border-left:none;width:86pt'>";
$awsome = "<td class=xl73 width=114 style='border-top:none;border-left:none;width:86pt'>";
$def = "<td class=xl66 width=114 style='border-top:none;border-left:none;width:86pt'>";


$user = mb_convert_encoding($user, 'cp1251');
$test = mb_convert_encoding($test, 'cp1251');
$body = "<table border=0 cellpadding=0 cellspacing=0 width=1195 style='border-collapse:
collapse;table-layout:fixed;width:898pt'>
<col width=36 style='mso-width-source:userset;mso-width-alt:1316;width:27pt'>
<col width=703 style='mso-width-source:userset;mso-width-alt:25709;width:527pt'>
<col width=114 span=4 style='mso-width-source:userset;mso-width-alt:4169;
width:86pt'>
<col width=61 span=20 style='mso-width-source:userset;mso-width-alt:2230;
width:46pt'>
<tr class=xl83 height=33 style='mso-height-source:userset;height:24.75pt'>
<td colspan=7 height=33 class=xl80 width=1195 style='border-right:.5pt solid black;
height:24.75pt;width:898pt'>Результаты оценки</td>
</tr>";

$body .= "<tr class=xl83 height=33 style='mso-height-source:userset;height:24.75pt'>
<td colspan=7 height=33 class=xl84 style='border-right:.5pt solid black;
height:24.75pt'>".$user."</td>
</tr>";


$body .= "<tr class=xl83 height=33 style='mso-height-source:userset;height:24.75pt'>
<td colspan=7 height=33 class=xl80 width=1195 style='border-right:.5pt solid black;
height:24.75pt;width:898pt'>".$test."</td>
</tr>";


$body .= "<tr class=xl83 height=33 style='mso-height-source:userset;height:24.75pt'>
<td colspan=7 height=33 class=xl85 style='border-right:.5pt solid black;
height:24.75pt'>Анализ по каждой компетенции</td>
</tr>
<tr height=55 style='mso-height-source:userset;height:41.25pt'>
<td colspan=7 height=55 class=xl79 width=1195 style='border-right:.5pt solid black;
height:41.25pt;width:898pt'>Этот раздел аналитической части отчета подробно
сравнивается оценка каждой группы опрошенных, средняя оценка, Ваша самооценка
и желаемый уровень для данной компетенции:</td>
</tr>
<tr height=43 style='mso-height-source:userset;height:32.25pt'>
<td height=43 class=xl65 width=36 style='height:32.25pt;border-top:none;
width:27pt'>&nbsp;</td>
<td class=xl66 width=703 style='border-top:none;border-left:none;width:527pt'>3,3
- 4</td>
<td colspan=5 class=xl76 width=456 style='border-right:.5pt solid black;
border-left:none;width:344pt'>желаемый уровень</td>
</tr>
<tr height=43 style='mso-height-source:userset;height:32.25pt'>
<td height=43 class=xl67 width=36 style='height:32.25pt;border-top:none;
width:27pt'>&nbsp;</td>
<td class=xl66 width=703 style='border-top:none;border-left:none;width:527pt'>2,6
-3,2</td>
<td colspan=5 class=xl76 width=456 style='border-right:.5pt solid black;
border-left:none;width:344pt'>оптимальный уровень</td>
</tr>
<tr height=43 style='mso-height-source:userset;height:32.25pt'>
<td height=43 class=xl68 width=36 style='height:32.25pt;border-top:none;
width:27pt'>&nbsp;</td>
<td class=xl66 width=703 style='border-top:none;border-left:none;width:527pt'>1,1
- 2,5</td>
<td colspan=5 class=xl76 width=456 style='border-right:.5pt solid black;
border-left:none;width:344pt'>низкий уровень</td>
</tr>
<tr height=43 style='mso-height-source:userset;height:32.25pt'>
<td height=43 class=xl69 width=36 style='height:32.25pt;border-top:none;
width:27pt'>&nbsp;</td>
<td class=xl66 width=703 style='border-top:none;border-left:none;width:527pt'>1</td>
<td colspan=5 class=xl76 width=456 style='border-right:.5pt solid black;
border-left:none;width:344pt'>отсутствует</td>
</tr>
<tr height=86 style='mso-height-source:userset;height:64.5pt'>
<td height=86 class=xl70 width=36 style='height:64.5pt;border-top:none;
width:27pt'>№ п/п</td>
<td class=xl70 width=703 style='border-top:none;border-left:none;width:527pt'>Компетенции</td>
<td class=xl70 width=114 style='border-top:none;border-left:none;width:86pt'>Самооценка</td>
<td class=xl70 width=114 style='border-top:none;border-left:none;width:86pt'>Оценка
руководителя</td>
<td class=xl70 width=114 style='border-top:none;border-left:none;width:86pt'>Оценка
коллег</td>
<td class=xl70 width=114 style='border-top:none;border-left:none;width:86pt'>Оценка
подчиненных</td>
<td class=xl70 width=114 style='border-top:none;border-left:none;width:86pt'>Средний балл</td>
</tr>";
$i=1;

foreach ($balQuestion as $question => $sum) 
{
	$roundVal = 1;
	
	$question = mb_convert_encoding($question, 'cp1251');
	$body.="<tr height=86 style='mso-height-source:userset;height:64.5pt'>
	<td height=86 class=xl66 width=36 style='height:64.5pt;border-top:none;
	width:27pt'>".$i."</td>
	<td class=xl71 width=703 style='border-top:none;border-left:none;width:527pt'>". $question ."</td>";

	main::printr($sum['sum1']);
	if(isset($sum['sum1']))
	{			
		$sum1 = $sum['sum1'];
		if (isset($sum['col1'])) 
		{
			$self = $sum1 / $sum['col1'];
			$self = round($self, 1);

		}
		else
		{
			$sum['col1'] = 0;
			$self = $sum['sum1'];
		};
		switch (true) {

			case $self <= 1.1:
			$body.= $low;
			break;

			case $self <= 2.5:
			$body.= $middle;
			break;

			case $self <= 3.2:
			$body.= $hight;
			break;

			case $self <= 4:
			$body.= $awsome;
			break;

			default:
			$body.= $def;
			break;
		};
		$self = number_format($self, 1, ',', '');

		$body.= $self .'</td>'; 
	}
	else
	{
		$sum['col1'] = 0;
		$sum['sum1'] = 0;
		$body.= "<td class=xl66 width=114 style='border-top:none;border-left:none;width:86pt'>Н/Д</td>";
	};

	if(isset($sum['sum2']))
	{			
		$sum2 = $sum['sum2'];
		if (isset($sum['col2'])) 
		{
			$boss = $sum2 / $sum['col2'];
			$boss = round($boss, 1);

		}
		else
		{
			$sum['col2'] = 0;
			$boss = $sum['sum2'];
		};
		switch (true) {

			case $boss <= 1.1:
			$body.= $low;
			break;

			case $boss <= 2.5:
			$body.= $middle;
			break;

			case $boss <= 3.2:
			$body.= $hight;
			break;

			case $boss <= 4:
			$body.= $awsome;
			break;
			default:
			$body.= $def;
			break;

		};
		$boss = number_format($boss, 1, ',', '');

		$body.= $boss .'</td>'; 
	}
	else
	{
		$sum['col2'] = 0;
		$sum['sum2'] = 0;
		$body.= "<td class=xl66 width=114 style='border-top:none;border-left:none;width:86pt'>Н/Д</td>";
	};

	if(isset($sum['sum3']))
	{			
		$sum3 = $sum['sum3'];
		if (isset($sum['col3'])) 
		{
			$subject = $sum3 / $sum['col3'];
			$subject = round($subject, 1);

		}
		else
		{
			$sum['col3'] = 0;
			$subject = $sum['sum3'];
		};
		switch (true) {

			case $subject <= 1.1:
			$body.= $low;
			break;

			case $subject <= 2.5:
			$body.= $middle;
			break;

			case $subject <= 3.2:
			$body.= $hight;
			break;

			case $subject <= 4:
			$body.= $awsome;
			break;

			default:
			$body.= $def;
			break;
		};
		$subject = number_format($subject, 1, ',', '');

		$body.= $subject .'</td>'; 
	}
	else
	{
		$sum['col3'] = 0;
		$sum['sum3'] = 0;
		$body.= "<td class=xl66 width=114 style='border-top:none;border-left:none;width:86pt'>Н/Д</td>";
	};

	if(isset($sum['sum4']))
	{			
		$sum4 = $sum['sum4'];
		if (isset($sum['col4'])) 
		{
			$colleague = $sum4 / $sum['col4'];
			$colleague = round($colleague, 1);

		}
		else
		{
			$sum['col4'] = 0;
			$colleague = $sum['sum4'];
		};
		switch (true) {

			case $colleague <= 1.1:
			$body.= $low;
			break;

			case $colleague <= 2.5:
			$body.= $middle;
			break;

			case $colleague <= 3.2:
			$body.= $hight;
			break;

			case $colleague <= 4:
			$body.= $awsome;
			break;
			default:
			$body.= $def;
			break;

		};
		$colleague = number_format($colleague, 1, ',', '');

		$body.= $colleague .'</td>'; 
	}
	else
	{
		$sum['col4'] = 0;
		$sum['sum4'] = 0;
		$body.= "<td class=xl66 width=114 style='border-top:none;border-left:none;width:86pt'>Н/Д</td>";
	};

	$midcol = $sum['col1']+$sum['col2']+$sum['col3']+$sum['col4'];
	$midding = $sum['sum1']+$sum['sum2']+$sum['sum3']+$sum['sum4'];
	if ($midcol != 0) 
	{
		$midResult = $midding / $midcol;
		$midResult = round($midResult, 1);

	}
	else
	{
		$midResult = 0;
	}
	switch (true) {

		case $midResult <= 1.1:
		$body.= $low;
		break;

		case $midResult <= 2.5:
		$body.= $middle;
		break;

		case $midResult <= 3.2:
		$body.= $hight;
		break;

		case $midResult <= 4:
		$body.= $awsome;
		break;

		default:
		$body.= $def;
		break;
	};
	$midResult = number_format($midResult, 1, ',', '');

	$body.= $midResult .'</td>'; 
	$body.="</tr>";

	$i++;
};

$document = $header.$body.$footer;
main::printr($name);

	// Если это файл и он равен удаляемому ... 
try {
	if((is_file("upload/report.xls"))) 
	{ 
		unlink("upload/report.xls"); 
		if(!file_exists("upload/report.xls"))
		{
			echo 'file is delete';
			file_put_contents('upload/report.xls', $document);
			echo json_encode(array('status'=>'ok'));
		}; 
	}
	else
	{
		echo 'file not found';
		file_put_contents('upload/report.xls', $document);
		echo json_encode(array('status'=>'ok'));
	}; 
} catch (Exception $e) {
	echo '<pre>';
	print_r($e);
	echo '</pre>';
	echo json_encode(array('status'=>'error'));	
};


?>