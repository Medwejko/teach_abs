<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/system/config.php';
/*формирование данных по id*/
$collection = api::collection('result',array('task'=>$_REQUEST['id']));

$textQuestion = array();
$balQuestion = array();
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

		foreach ($result->registr_result as $rr) 
		{
			if($rr->question->type == 0)
			{
				$answer = array(
					'tus' => "Самооценка",
					'user' => $result->user,
					'answer_text' => $rr->answer_text
				);
				$textQuestion[$rr->question->text][] = $answer;
			}
			else
			{
				$answer = array(
					'tus' => "Самооценка",
					'user' => $result->user,
					'answer_text' => $rr->answer->text
				);
				$textQuestion[$rr->question->text][] = $answer;
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
					'tus' => "Руководитель",
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
					'tus' => "Коллега",
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
					'tus' => "Подчиненный",
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

$header = file_get_contents('header_text.php');
$footer = file_get_contents('footer_text.php');

$userTask = $collection[0]->task->user->surname.' '.$collection[0]->task->user->name.' '.$collection[0]->task->user->middlename;

$test = $collection[0]->task->test->name;



$userTask = mb_convert_encoding($userTask, 'cp1251');
$test = mb_convert_encoding($test, 'cp1251');
$test = str_replace("с 2021", " ", $test);
$body = "<table border=0 cellpadding=0 cellspacing=0 width=1408 style='border-collapse:
collapse;table-layout:fixed;width:1056pt'>
<col width=352 span=4 style='mso-width-source:userset;mso-width-alt:12873;
width:264pt'>";

$body .= "<tr height=43 style='mso-height-source:userset;height:32.25pt'>
<td colspan=4 height=43 class=xl67 width=1408 style='border-right:1.0pt solid black;height:32.25pt;
width:1056pt'>".$test."</td>
</tr>";


foreach ($user as $keyuser => $answerUser) 
{
	foreach ($tususer as $keytus => $tus) {
		
		$usertus = $answerUser->surname .' '. $answerUser->name .' '. $answerUser->middlename;
		$usertus = mb_convert_encoding($usertus, 'cp1251');
		if ($keyuser == $keytus) {
			switch ($tus) {
				case '1':
				$body .= "<tr height=43 style='mso-height-source:userset;height:32.25pt'>
				<td colspan=4 height=43 class=xl67 width=1408 style='border-top:1.0pt solid black;border-right:1.0pt solid black;height:32.25pt;
				width:1056pt'>Самооценка ".$userTask."</td>
				</tr>";
				break;

				case '2':

				$body .= "<tr height=43 style='mso-height-source:userset;height:32.25pt'>
				<td colspan=4 height=43 class=xl67 width=1408 style='border-top:1.0pt solid black;border-right:1.0pt solid black;height:32.25pt;
				width:1056pt'>Оцениваемый: ".$userTask."</td>
				</tr>";

				$body .= "<tr height=43 style='mso-height-source:userset;height:32.25pt'>
				<td colspan=4 height=43 class=xl67 width=1408 style='border-top:1.0pt solid black;border-right:1.0pt solid black;height:32.25pt;
				width:1056pt'>Руководитель ".$usertus."</td>
				</tr>";
				break;

				case '3':
				$body .= "<tr height=43 style='mso-height-source:userset;height:32.25pt'>
				<td colspan=4 height=43 class=xl67 width=1408 style='border-top:1.0pt solid black;border-right:1.0pt solid black;height:32.25pt;
				width:1056pt'>Оцениваемый: ".$userTask."</td>
				</tr>";

				$body .= "<tr height=43 style='mso-height-source:userset;height:32.25pt'>
				<td colspan=4 height=43 class=xl67 width=1408 style='border-top:1.0pt solid black; border-right:1.0pt solid black;height:32.25pt;
				width:1056pt'>Коллега ".$usertus."</td>
				</tr>";				
				break;

				case '4':

				$body .= "<tr height=43 style='mso-height-source:userset;height:32.25pt'>
				<td colspan=4 height=43 class=xl67 width=1408 style='border-top:1.0pt solid black;border-right:1.0pt solid black;height:32.25pt;
				width:1056pt'>Оцениваемый: ".$userTask."</td>
				</tr>";

				$body .= "<tr height=43 style='mso-height-source:userset;height:32.25pt'>
				<td colspan=4 height=43 class=xl67 width=1408 style='border-top:1.0pt solid black;border-right:1.0pt solid black;height:32.25pt;
				width:1056pt'>Подчиненный ".$usertus."</td>
				</tr>";
				break;
			}
		}
	}

};


foreach ($textQuestion as $question => $answers) 
{
	$question = mb_convert_encoding($question, 'cp1251');
	$body .= "<tr height=95 style='mso-height-source:userset;height:71.25pt'>
	<td colspan=2 height=95 class=xl70 width=704 style='border-right:1.0pt solid black;
	height:71.25pt;width:528pt'>".$question."</td>";
	foreach ($answers as $data) 
	{
		$data['answer_text'] = mb_convert_encoding($data['answer_text'], 'cp1251');
		$body .= "<td colspan=2 class=xl76 width=704 style='border-right:1.0pt solid black;
		border-left:none;width:528pt;box-sizing: border-box;padding:0.75rem'>".$data['answer_text']."</td>";
	}
};


$document = $header.$body.$footer;
main::printr($name);

	// Если это файл и он равен удаляемому ... 
try {
	if((is_file("upload/report_text.xls"))) 
	{ 
		unlink("upload/report_text.xls"); 
		if(!file_exists("upload/report_text.xls"))
		{
			echo 'file is delete';
			file_put_contents('upload/report_text.xls', $document);
			echo json_encode(array('status'=>'ok'));
		}; 
	}
	else
	{
		echo 'file not found';
		file_put_contents('upload/report_text.xls', $document);
		echo json_encode(array('status'=>'ok'));
	}; 
} catch (Exception $e) {
	echo '<pre>';
	print_r($e);
	echo '</pre>';
	echo json_encode(array('status'=>'error'));	
};


?>