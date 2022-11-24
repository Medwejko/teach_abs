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

	$test = $result->task->test->id;
	
	switch ($result->tus) {
		case '1':
		$col1++;
		foreach ($result->registr_result as $rr) 
		{
			if($rr->question->type == 0)
			{
				$answer = array(
					'user' => $result->user,
					'answer_text' => $rr->answer_text
				);
				$textQuestion[$rr->question->text][] = $answer;
			}
			else
			{

				if(isset($rr->answer->weight))
				{

					$balQuestion[$rr->question->text]['sum1'] = $rr->answer->weight;
				}					

			};
		};

		
		break;

		case '2':

		$col2 ++;
		foreach ($result->registr_result as $rr) 
		{
			
			if($rr->question->type == 0)
			{
				$answer = array(
					'user' => $result->user,
					'answer_text' => $rr->answer_text
				);
				$textQuestion[$rr->question->text][] = $answer;
			}
			else
			{

				if(isset($rr->answer->weight))
				{
					if(isset($balQuestion[$rr->question->text]['sum2']))
					{
						$balQuestion[$rr->question->text]['sum2'] += $rr->answer->weight;

					}
					else
					{
						$balQuestion[$rr->question->text]['sum2'] = $rr->answer->weight;
					}
				}
				else
				{
					$balQuestion[$rr->question->text]['sum2'] = 'Нет результатов';
				};
			};
		};
		break;

		case '3':
		$col3 ++;
		foreach ($result->registr_result as $rr) 
		{
			
			if($rr->question->type == 0)
			{
				$answer = array(
					'user' => $result->user,
					'answer_text' => $rr->answer_text
				);
				$textQuestion[$rr->question->text][] = $answer;
			}
			else
			{

				if(isset($rr->answer->weight))
				{
					if(isset($balQuestion[$rr->question->text]['sum3']))
					{
						$balQuestion[$rr->question->text]['sum3'] += $rr->answer->weight;

					}
					else
					{
						$balQuestion[$rr->question->text]['sum3'] = $rr->answer->weight;
					}
				}
				else
				{
					$balQuestion[$rr->question->text]['sum3'] = 'Нет результатов';
				};
			};
		};
		break;
		

		case '4':
		$col4 ++;
		foreach ($result->registr_result as $rr) 
		{
			
			if($rr->question->type == 0)
			{
				$answer = array(
					'user' => $result->user,
					'answer_text' => $rr->answer_text
				);
				$textQuestion[$rr->question->text][] = $answer;
			}
			else
			{

				if(isset($rr->answer->weight))
				{
					if(isset($balQuestion[$rr->question->text]['sum4']))
					{
						$balQuestion[$rr->question->text]['sum4'] += $rr->answer->weight;

					}
					else
					{
						$balQuestion[$rr->question->text]['sum4'] = $rr->answer->weight;
					}
				}
				else
				{
					$balQuestion[$rr->question->text]['sum4'] = 'Нет результатов';
				};
			};
		};
		break;


	};

};


/*заполнение excel*/

$header = file_get_contents('header_process.php');
$footer = file_get_contents('footer_process.php');

$user = $collection[0]->task->user->surname.' '.$collection[0]->task->user->name.' '.$collection[0]->task->user->middlename;

$test = $collection[0]->task->test->name;


$user = mb_convert_encoding($user, 'cp1251');
$test = mb_convert_encoding($test, 'cp1251');
$body = "<table border=0 cellpadding=0 cellspacing=0 width=1256 style='border-collapse:
collapse;table-layout:fixed;width:944pt'>
<col width=36 style='mso-width-source:userset;mso-width-alt:1316;width:27pt'>
<col width=703 style='mso-width-source:userset;mso-width-alt:25709;width:527pt'>
<col width=114 span=4 style='mso-width-source:userset;mso-width-alt:4169;
width:86pt'>
<col width=61 span=20 style='mso-width-source:userset;mso-width-alt:2230;
width:46pt'>
<tr class=xl65 height=33 style='mso-height-source:userset;height:24.75pt'>
<td colspan=4 height=33 class=xl81 width=967 style='height:24.75pt;
width:726pt'>Результаты оценки</td>
<td class=xl68 width=114 style='width:86pt'></td>
<td class=xl68 width=114 style='width:86pt'></td>
<td class=xl65 width=61 style='width:46pt'></td>
</tr>";

$body .= "<tr class=xl65 height=33 style='mso-height-source:userset;height:24.75pt'>
<td colspan=4 height=33 class=xl82 style='height:24.75pt'>".$user."</td>
<td class=xl69></td>
<td class=xl69></td>
<td class=xl65></td>
</tr>";


$body .= "<tr class=xl65 height=33 style='mso-height-source:userset;height:24.75pt'>
<td colspan=4 height=33 class=xl81 width=967 style='height:24.75pt;
width:726pt'>".$test."</td>
<td class=xl68 width=114 style='width:86pt'></td>
<td class=xl68 width=114 style='width:86pt'></td>
<td class=xl65></td>
</tr>";


$body .= "<tr class=xl65 height=33 style='mso-height-source:userset;height:24.75pt'>
<td colspan=4 height=33 class=xl83 style='height:24.75pt'>Анализ по каждой
компетенции</td>
<td class=xl70></td>
<td class=xl70></td>
<td class=xl65></td>
</tr>
<tr height=56 style='mso-height-source:userset;height:42.0pt'>
<td height=56 class=xl67 width=36 style='height:42.0pt;border-top:none;
width:27pt'>№ п/п</td>
<td class=xl67 width=703 style='border-top:none;border-left:none;width:527pt'>Компетенции</td>
<td class=xl67 width=114 style='border-top:none;border-left:none;width:86pt'>да</td>
<td class=xl84 width=114 style='border-top:none;border-left:none;width:86pt'>нет</td>
<td class=xl71 width=114 style='width:86pt'></td>
<td class=xl71 width=114 style='width:86pt'></td>
<td></td>
</tr>";
$i=1;

foreach ($balQuestion as $question => $sum) 
{
	$roundVal = 1;
	
	$question = mb_convert_encoding($question, 'cp1251');
	$body.="<tr height=85 style='mso-height-source:userset;height:63.75pt'>
	<td height=85 class=xl85 width=36 style='height:63.75pt;border-top:none;
	width:27pt'>".$i."</td>
	<td class=xl85 width=703 style='border-top:none;border-left:none;width:527pt'>".$question."</td>";

	main::printr($sum['sum1']);
	if(isset($sum['sum1']))
	{		
		$sum1 = $sum['sum1'];	
		switch (true) {

			case $sum['sum1'] == 1:
			$body.= "<td class=xl85 width=114 style='border-top:none;border-left:none;width:86pt'>1</td>
			<td class=xl85 width=114 style='border-top:none;border-left:none;width:86pt'>&nbsp;</td>";
			break;

			case $sum['sum1'] == 0:
			$body.= "<td class=xl85 width=114 style='border-top:none;border-left:none;width:86pt'>&nbsp;</td>
			<td class=xl85 width=114 style='border-top:none;border-left:none;width:86pt'>0</td>";
			break;

			default:
			$body.= "<td class=xl85 width=114 style='border-top:none;border-left:none;width:86pt'>Н/Д</td>
			<td class=xl85 width=114 style='border-top:none;border-left:none;width:86pt'>Н/Д</td>";
			break;
		};
		$body.= "</tr>";
	}
	else
	{
		$body.= "<td class=xl85 width=114 style='border-top:none;border-left:none;width:86pt'>Н/Д</td>
		<td class=xl85 width=114 style='border-top:none;border-left:none;width:86pt'>Н/Д</td></tr>";
	};

	$i++;
};

$document = $header.$body.$footer;
main::printr($name);

	// Если это файл и он равен удаляемому ... 
try {
	if((is_file("upload/report_process.xls"))) 
	{ 
		unlink("upload/report_process.xls"); 
		if(!file_exists("upload/report_process.xls"))
		{
			echo 'file is delete';
			file_put_contents('upload/report_process.xls', $document);
			echo json_encode(array('status'=>'ok'));
		}; 
	}
	else
	{
		echo 'file not found';
		file_put_contents('upload/report_process.xls', $document);
		echo json_encode(array('status'=>'ok'));
	}; 
} catch (Exception $e) {
	echo '<pre>';
	print_r($e);
	echo '</pre>';
	echo json_encode(array('status'=>'error'));	
};


?>