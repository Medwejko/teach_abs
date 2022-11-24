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

$header = file_get_contents('header_client.php');
$footer = file_get_contents('footer_client.php');

$user = $collection[0]->task->user->surname.' '.$collection[0]->task->user->name.' '.$collection[0]->task->user->middlename;

$test = $collection[0]->task->test->name;
$low = "<td class=xl75 width=114 style='border-top:none;border-left:none;width:86pt'>";
$middle = "<td class=xl74 width=114 style='border-top:none;border-left:none;width:86pt'>";
$hight = "<td class=xl72 width=114 style='border-top:none;border-left:none;width:86pt'>";
$awsome = "<td class=xl73 width=114 style='border-top:none;border-left:none;width:86pt'>";
$def = "<td class=xl66 width=114 style='border-top:none;border-left:none;width:86pt'>";


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
  <td colspan=3 height=33 class=xl73 width=853 style='border-right:.5pt solid black;
  height:24.75pt;width:640pt'>Результаты оценки</td>
  <td class=xl85 width=114 style='width:86pt'></td>
  <td class=xl85 width=114 style='width:86pt'></td>
  <td class=xl85 width=114 style='width:86pt'></td>
  <td class=xl65 width=61 style='width:46pt'></td>
 </tr>";

$body .= "<tr class=xl65 height=33 style='mso-height-source:userset;height:24.75pt'>
  <td colspan=3 height=33 class=xl76 style='border-right:.5pt solid black;
  height:24.75pt'>".$user."</td>
  <td class=xl86></td>
  <td class=xl86></td>
  <td class=xl86></td>
  <td class=xl65></td>
 </tr>";


$body .= "<tr class=xl65 height=33 style='mso-height-source:userset;height:24.75pt'>
  <td colspan=3 height=33 class=xl78 width=853 style='border-right:.5pt solid black;
  height:24.75pt;width:640pt'>".$test."</td>
  <td class=xl85 width=114 style='width:86pt'></td>
  <td class=xl85 width=114 style='width:86pt'></td>
  <td class=xl85 width=114 style='width:86pt'></td>
  <td class=xl65></td>
 </tr>";


$body .= "<tr class=xl65 height=33 style='mso-height-source:userset;height:24.75pt'>
  <td colspan=3 height=33 class=xl80 style='border-right:.5pt solid black;
  height:24.75pt'>Анализ по каждой компетенции</td>
  <td class=xl87></td>
  <td class=xl87></td>
  <td class=xl87></td>
  <td class=xl65></td>
 </tr>
 <tr height=56 style='mso-height-source:userset;height:42.0pt'>
  <td height=56 class=xl82 width=36 style='height:42.0pt;width:27pt'>№ п/п</td>
  <td class=xl71 width=703 style='width:527pt'>Компетенции</td>
  <td class=xl72 width=114 style='width:86pt'>Оценка</td>
  <td class=xl88 width=114 style='width:86pt'></td>
  <td class=xl88 width=114 style='width:86pt'></td>
  <td class=xl88 width=114 style='width:86pt'></td>
  <td></td>
 </tr>";
$i=1;

foreach ($balQuestion as $question => $sum) 
{
	$roundVal = 1;
	
	$question = mb_convert_encoding($question, 'cp1251');
	$body.="<tr height=85 style='mso-height-source:userset;height:63.75pt'>
  <td height=85 class=xl83 width=36 style='height:63.75pt;width:27pt'>".$i."</td>
  <td class=xl66 width=703 style='width:527pt'>".$question."</td>";

	main::printr($sum['sum1']);
	if(isset($sum['sum1']))
	{		
		
		$body.= "<td class=xl96 width=114 style='width:86pt'>".$sum['sum1']."</td>"; 
	}
	else
	{
		$body.= "<td class=xl96 width=114 style='width:86pt'>Н/Д</td>";
	};
	
	$body.="</tr>";

	$i++;
};

$document = $header.$body.$footer;
main::printr($name);

	// Если это файл и он равен удаляемому ... 
try {
	if((is_file("upload/report_client.xls"))) 
	{ 
		unlink("upload/report_client.xls"); 
		if(!file_exists("upload/report_client.xls"))
		{
			echo 'file is delete';
			file_put_contents('upload/report_client.xls', $document);
			echo json_encode(array('status'=>'ok'));
		}; 
	}
	else
	{
		echo 'file not found';
		file_put_contents('upload/report_client.xls', $document);
		echo json_encode(array('status'=>'ok'));
	}; 
} catch (Exception $e) {
	echo '<pre>';
	print_r($e);
	echo '</pre>';
	echo json_encode(array('status'=>'error'));	
};


?>