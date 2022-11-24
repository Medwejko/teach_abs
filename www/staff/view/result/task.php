<link rel="stylesheet" href="/css/globalStyle.css" type="text/css" />

<div style=" height: 15px;margin: 14px">
    <div id="FontHelper" style="display:flex; flex-flow:row;justify-content: center;background-color:grey">
        <div>Размер шрифта: <input style="position: relative;bottom: -5px;" type="range" min="7" max="50" id="TableFontsize" oninput="sizeTableFontSize()" value="14"></div>
        <div id='FontSizeInfo'> 14</div>px
    </div>
</div>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/system/config.php';
if (!$_SESSION['user'] or $_SESSION['user']->group->access == 2) {
    header('Location:  http://staff.ska.su');
}
$collection = api::collection('result', array('task' => $_REQUEST['id']));
$task = api::collection('task', array('id' => $_REQUEST['id']));
$textQuestion = array();
$balQuestion = array();

$type = 1;



$midall1 = 0;
$collall1 = 0;
$midall2 = 0;
$collall2 = 0;
$midall3 = 0;
$collall3 = 0;
$midall4 = 0;
$collall4 = 0;
foreach ($collection as $result) {
    $test = $result->task->test->id;
    $tususer[] = $result->tus;
    $user[] = $result->user;
    switch ($result->tus) {

        case '1':



            foreach ($result->task->test->question as $place) {
                main::printr($result->task->test->id);
                foreach ($result->registr_result as $rr) {
                    main::printr($place->id);
                    main::printr($rr->question->id);
                    if ($place->id == $rr->question->id) {

                        if ($rr->question->type == 0) {
                            $type = 0;
                            $answer = array(
                                'tus' => "Cамооценка",
                                'user' => $result->user,
                                'answer_text' => $rr->answer_text
                            );
                            $textQuestion[$rr->question->text][] = $answer;
                        } elseif ($rr->question->type == 3) {


                            if (is_numeric($rr->answer_text)) {
                                $midall1 += $rr->answer_text;
                                $collall1++;
                            }
                            $type = 3;
                            main::printr($rr->answer_text);

                            if (isset($balQuestion[$rr->question->text][$rr->answer->text]['sum1'])) {
                                $balQuestion[$rr->question->text][$rr->answer->text]['sum1'] += $rr->answer_text;
                            } else {
                                $balQuestion[$rr->question->text][$rr->answer->text]['sum1'] = $rr->answer_text;
                            }

                            if (isset($balQuestion[$rr->question->text][$rr->answer->text]['col1'])) {

                                $balQuestion[$rr->question->text][$rr->answer->text]['col1']++;
                            } else {

                                $balQuestion[$rr->question->text][$rr->answer->text]['col1'] = 1;
                            };
                        } else {
                            $answer = array(
                                'tus' => "Cамооценка",
                                'user' => $result->user,
                                'answer_text' => $rr->answer->text
                            );
                            $balQuestion[$rr->question->text]['sum1'] = $rr->answer->weight;
                            $balQuestion[$rr->question->text]['col1'] = 1;
                        };
                    };
                }
            }
            break;

        case '2':
            foreach ($result->task->test->question as $place) {
                foreach ($result->registr_result as $rr) {
                    if ($place->id == $rr->question->id) {
                        if ($rr->question->type == 0) {
                            $type = 0;
                            $answer = array(
                                'tus' => "Руководитель",
                                'user' => $result->user,
                                'answer_text' => $rr->answer_text
                            );
                            $textQuestion[$rr->question->text][] = $answer;
                        } elseif ($rr->question->type == 3) {
                            if (is_numeric($rr->answer_text)) {
                                $midall2 += $rr->answer_text;
                                $collall2++;
                            }
                            $type = 3;

                            if (isset($balQuestion[$rr->question->text][$rr->answer->text]['sum2'])) {
                                $balQuestion[$rr->question->text][$rr->answer->text]['sum2'] += $rr->answer_text;
                            } else {
                                $balQuestion[$rr->question->text][$rr->answer->text]['sum2'] = $rr->answer_text;
                            }

                            if (isset($balQuestion[$rr->question->text][$rr->answer->text]['col2'])) {

                                $balQuestion[$rr->question->text][$rr->answer->text]['col2']++;
                            } else {

                                $balQuestion[$rr->question->text][$rr->answer->text]['col2'] = 1;
                            };
                        } else {
                            if (isset($balQuestion[$rr->question->text]['sum2'])) {
                                $balQuestion[$rr->question->text]['sum2'] += $rr->answer->weight;
                            } else {
                                $balQuestion[$rr->question->text]['sum2'] = $rr->answer->weight;
                            }
                            if ($rr->answer->weight != 0) {
                                if (isset($balQuestion[$rr->question->text]['col2'])) {

                                    $balQuestion[$rr->question->text]['col2']++;
                                } else {

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
                foreach ($result->registr_result as $rr) {
                    if ($place->id == $rr->question->id) {
                        if ($rr->question->type == 0) {
                            $type = 0;
                            $answer = array(
                                'tus' => "Коллега",
                                'user' => $result->user,
                                'answer_text' => $rr->answer_text
                            );
                            $textQuestion[$rr->question->text][] = $answer;
                        } elseif ($rr->question->type == 3) {
                            if (is_numeric($rr->answer_text)) {
                                $midall3 += $rr->answer_text;
                                $collall3++;
                            }
                            $type = 3;

                            if (isset($balQuestion[$rr->question->text][$rr->answer->text]['sum3'])) {
                                $balQuestion[$rr->question->text][$rr->answer->text]['sum3'] += $rr->answer_text;
                            } else {
                                $balQuestion[$rr->question->text][$rr->answer->text]['sum3'] = $rr->answer_text;
                            }

                            if (isset($balQuestion[$rr->question->text][$rr->answer->text]['col3'])) {

                                $balQuestion[$rr->question->text][$rr->answer->text]['col3']++;
                            } else {

                                $balQuestion[$rr->question->text][$rr->answer->text]['col3'] = 1;
                            };
                        } else {
                            if (isset($balQuestion[$rr->question->text]['sum3'])) {
                                $balQuestion[$rr->question->text]['sum3'] += $rr->answer->weight;
                            } else {
                                $balQuestion[$rr->question->text]['sum3'] = $rr->answer->weight;
                            }
                            if (isset($balQuestion[$rr->question->text]['col3'])) {

                                $balQuestion[$rr->question->text]['col3']++;
                            } else {

                                $balQuestion[$rr->question->text]['col3'] = 1;
                            };
                        };
                    };
                };
            };
            break;

        case '4':
            foreach ($result->task->test->question as $place) {
                foreach ($result->registr_result as $rr) {
                    if ($place->id == $rr->question->id) {
                        if ($rr->question->type == 0) {
                            $type = 0;
                            $answer = array(
                                'tus' => "Подчиненный",
                                'user' => $result->user,
                                'answer_text' => $rr->answer_text
                            );
                            $textQuestion[$rr->question->text][] = $answer;
                        } elseif ($rr->question->type == 3) {
                            if (is_numeric($rr->answer_text)) {
                                $midall4 += $rr->answer_text;
                                $collall4++;
                            }
                            $type = 3;

                            if (isset($balQuestion[$rr->question->text][$rr->answer->text]['sum4'])) {
                                $balQuestion[$rr->question->text][$rr->answer->text]['sum4'] += $rr->answer_text;
                            } else {
                                $balQuestion[$rr->question->text][$rr->answer->text]['sum4'] = $rr->answer_text;
                            }

                            if (isset($balQuestion[$rr->question->text][$rr->answer->text]['col4'])) {

                                $balQuestion[$rr->question->text][$rr->answer->text]['col4']++;
                            } else {

                                $balQuestion[$rr->question->text][$rr->answer->text]['col4'] = 1;
                            };
                        } else {
                            if (isset($balQuestion[$rr->question->text]['sum4'])) {

                                $balQuestion[$rr->question->text]['sum4'] += $rr->answer->weight;
                            } else {

                                $balQuestion[$rr->question->text]['sum4'] = $rr->answer->weight;
                            }
                            if (isset($balQuestion[$rr->question->text]['col4'])) {

                                $balQuestion[$rr->question->text]['col4']++;
                            } else {

                                $balQuestion[$rr->question->text]['col4'] = 1;
                            }
                        };
                    };
                };
            };
            break;
    };
};

if ($type == 0) {
?>
    <!Doctype html>
    <html>

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

        <title>Отчет</title>
        <style>
            @media print {

                .no-print,
                .no-print * {
                    display: none !important;
                }
            }

            table,
            th,
            td {
                font-size: 22;
                border: 1px solid #ddd;
                padding: .0rem;

            }
        </style>
    </head>

    <body>

        <div class="container-fluid">


            <h5 style="float: right;" class="btn btn-outline-secondary no-print HideFontHelper " onclick="window.print();">Печать</h5>
            <h5 style="float: right;" class="btn btn-outline-secondary no-print setExcel" id="setExcelText" data-id="<?php echo $_REQUEST['id']; ?>">Excel</h5>
            <h5 style="float: right; display:none;" class="btn btn-outline-secondary no-print saveExcelText" id="saveExcelText">Скачать Excel</h5>
            <img src="../../png/Logo.jpg" width="300px" alt="СКА">
            <br>
            <hr>
            <!--вопросы со свободным ответом-->
            <?php
            if (count($textQuestion) > 0) {

            ?>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td colspan="3" style="text-align: center;"><b><?php echo str_replace("с 2021", " ", $collection[0]->task->test->name); ?></b></td>
                        </tr>
                        
                        <?php
                                           $boss_count =0;
                                           foreach ($textQuestion as $question => $answers) {
                                                $boss_count = count($answers);
                                                break;
                                            }

                        $bufer='';
                        foreach ($user as $keyuser => $answerUser) {
                            foreach ($tususer as $keytus => $tus) {
                                if ($keyuser == $keytus) {
                                    switch ($tus) {
                                        case '1':
                                            echo '<tr><td colspan="3" style="text-align: center;">Самооценка: ' . $collection[0]->task->user->surname . ' ' . $collection[0]->task->user->name . ' ' . $collection[0]->task->user->middlename;
                                            '.</td><tr>';
                                            break;

                                        case '2':

                                            if($boss_count>1){
                                                if($bufer != $collection[0]->task->user->surname . ' ' . $collection[0]->task->user->name . ' ' . $collection[0]->task->user->middlename){
                                                    echo '<tr><td colspan="3" style="text-align: center;">Оцениваемый: ' . $collection[0]->task->user->surname . ' ' . $collection[0]->task->user->name . ' ' . $collection[0]->task->user->middlename;
                                                    '.</td><tr>';
                                                    $bufer = $collection[0]->task->user->surname . ' ' . $collection[0]->task->user->name . ' ' . $collection[0]->task->user->middlename;
                                                }
                                            }else{
                                                echo '<tr><td colspan="3" style="text-align: center;">Оцениваемый: ' . $collection[0]->task->user->surname . ' ' . $collection[0]->task->user->name . ' ' . $collection[0]->task->user->middlename;
                                                '.</td><tr>';
                                                echo '<tr><td colspan="3" style="text-align: center;"> Руководитель: ' . $answerUser->surname . ' ' . $answerUser->name . ' ' . $answerUser->middlename . '</td><tr>';
                                            }

                                           break;
                                        case '3':
                                            echo '<tr><td colspan="3" style="text-align: center;">Оцениваемый: ' . $collection[0]->task->user->surname . ' ' . $collection[0]->task->user->name . ' ' . $collection[0]->task->user->middlename;
                                            '.</td><tr>';
                                            echo '<tr><td colspan="3" style="text-align: center;"> Коллега: ' . $answerUser->surname . ' ' . $answerUser->name . ' ' . $answerUser->middlename . '</td><tr>';
                                            break;
                                        case '4':
                                            echo '<tr><td colspan="3" style="text-align: center;">Оцениваемый: ' . $collection[0]->task->user->surname . ' ' . $collection[0]->task->user->name . ' ' . $collection[0]->task->user->middlename;
                                            '.</td><tr>';
                                            echo '<tr><td colspan="3" style="text-align: center;"> Подчиненный: ' . $answerUser->surname . ' ' . $answerUser->name . ' ' . $answerUser->middlename . '</td><tr>';
                                            break;
                                    }
                                }
                            }
                        };
                        ?>
                        <?php   
                                    if($boss_count>1){
                                           echo '<tr><td></td>';
                                           foreach ($textQuestion as $question => $answers) {
                                               foreach ($answers as $Answer) {
                                                    echo '<td>Руководитель: '. $Answer['user']->surname . ' ' . $Answer['user']->name . ' ' .$Answer['user']->middlename .' </td>';
                                               }
                                               break;
                                           }
                                           echo '</tr>';
                                       }

                    foreach ($textQuestion as $question => $answers) {

                            echo '<tr><td width="50%" ><b>' . $question . '</b></td>';
                            foreach ($answers as $data) {
                                echo '<td>'. $data['answer_text'] . '</td>';
                            }
                            echo '</tr>';
                        };
                        ?>
                    </tbody>
                </table>
                
            <?php
            };
            ?>
            <hr>
        </div>
    </body>

    </html>
<?php
} elseif ($type == 3) {
?>
    <!Doctype html>
    <html>

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

        <title>Отчет</title>
        <style>
            @media print {

                .no-print,
                .no-print * {
                    display: none !important;
                }
            }

            table,
            th,
            td {
                border: 1px solid #ddd;
                padding: .0rem;

            }
        </style>
    </head>

    <body>

        <div class="container-fluid">
            <h5 style="float: right;" class="btn btn-outline-secondary no-print HideFontHelper" onclick="window.print();">Печать</h5>
            <h5 style="float: right;" class="btn btn-outline-secondary no-print setExcel" id="setExcel2021" data-id="<?php echo $_REQUEST['id']; ?>">Excel</h5>
            <h5 style="float: right; display:none;" class="btn btn-outline-secondary no-print saveExcel" id="saveExcel2021">
                Скачать Excel</h5>
            <h4 align="center"><b>Результаты оценки</b></h4>
            <h4 align="center">
                <b><?php echo $collection[0]->task->user->surname . ' ' . $collection[0]->task->user->name . ' ' . $collection[0]->task->user->middlename; ?></b>
            </h4>
            <h4 align="center"><b><?php echo $collection[0]->task->test->name; ?></b></h4>
            <h6 align="center">Анализ по каждой компетенции</h6><br />
            <h6 align="center">Этот раздел аналитической части отчета подробно сравнивается оценка каждой группы опрошенных,
                средняя оценка, Ваша самооценка и желаемый уровень для данной компетенции:</h6>

            <table style="width: 100%;">
                <tr align="center">
                    <td style="background-color: RGB(0, 176, 80);">&nbsp;</td>
                    <td>3,3 - 4</td>
                    <td>желаемый уровень</td>
                </tr>
                <tr align="center">
                    <td style="background-color: RGB(255, 255, 0);">&nbsp;</td>
                    <td>2,6 -3,2</td>
                    <td>оптимальный уровень</td>
                </tr>
                <tr align="center">
                    <td style="background-color: RGB(255, 0, 0);">&nbsp;</td>
                    <td>1,1 - 2,5</td>
                    <td>низкий уровень</td>
                </tr>
                <tr align="center">
                    <td style="background-color: RGB(0, 0, 0); color: #fff;">&nbsp;</td>
                    <td>1</td>
                    <td>отсутствует</td>
                </tr>
            </table>

            <!--вопросы со средним баллом-->
            <hr>
            <table>
                <thead style="background-color: #86cfda;">
                    <tr>
                        <th>Компетенции</th>
                        <th>Самооценка</th>
                        <th>Оценка руководителя</th>
                        <th>Оценка коллег</th>
                        <th>Оценка подчиненных</th>
                        <th>Средний балл</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="table-info">
                        <td><b>Средний балл по всем компетенциям<b></td>
                        <?php
                        $i = 0;
                        $sumall1 = 0;
                        $sumall2 = 0;
                        $sumall3 = 0;
                        $sumall4 = 0;
                        $midcollall = 0;

                        if ($collall1 > 0) {
                            $sumall1 = $midall1 / $collall1;
                            $sumall1 = round($sumall1, 1);

                            $midcollall++;
                        }
                        if ($collall2 > 0) {
                            $sumall2 = $midall2 / $collall2;
                            $sumall2 = round($sumall2, 1);
                            $midcollall++;
                        }
                        if ($collall3 > 0) {
                            $sumall3 = $midall3 / $collall3;
                            $sumall3 = round($sumall3, 1);
                            $midcollall++;
                        }
                        if ($collall4 > 0) {
                            $sumall4 = $midall4 / $collall4;
                            $sumall4 = round($sumall4, 1);
                            $midcollall++;
                        }
                        $midall = $sumall1 + $sumall2 + $sumall3 + $sumall4;
                        $midall = $midall / $midcollall;
                        $midall = round($midall, 1);

                        switch (true) {
                            case $sumall1 <= 0.1:
                                echo '<td>';
                                break;

                            case $sumall1 <= 1.1:
                                echo '<td style="background-color: RGB(0, 0, 0); color: #fff;">';
                                break;

                            case $sumall1 <= 2.5:
                                echo '<td style="background-color: RGB(255, 0, 0);">';
                                break;

                            case $sumall1 <= 3.2:
                                echo '<td style="background-color: RGB(255, 255, 0);">';
                                break;

                            case $sumall1 <= 4:
                                echo '<td style="background-color: RGB(0, 176, 80);">';
                                break;
                            default:
                                echo '<td>';
                                break;
                        };
                        echo $sumall1 . '</td>';
                        switch (true) {
                            case $sumall2 <= 0.1:
                                echo '<td>';
                                break;

                            case $sumall2 <= 1.1:
                                echo '<td style="background-color: RGB(0, 0, 0); color: #fff;">';
                                break;

                            case $sumall2 <= 2.5:
                                echo '<td style="background-color: RGB(255, 0, 0);">';
                                break;

                            case $sumall2 <= 3.2:
                                echo '<td style="background-color: RGB(255, 255, 0);">';
                                break;

                            case $sumall2 <= 4:
                                echo '<td style="background-color: RGB(0, 176, 80);">';
                                break;
                            default:
                                echo '<td>';
                                break;
                        };
                        echo $sumall2 . '</td>';
                        switch (true) {
                            case $sumall3 <= 0.1:
                                echo '<td>';
                                break;

                            case $sumall3 <= 1.1:
                                echo '<td style="background-color: RGB(0, 0, 0); color: #fff;">';
                                break;

                            case $sumall3 <= 2.5:
                                echo '<td style="background-color: RGB(255, 0, 0);">';
                                break;

                            case $sumall3 <= 3.2:
                                echo '<td style="background-color: RGB(255, 255, 0);">';
                                break;

                            case $sumall3 <= 4:
                                echo '<td style="background-color: RGB(0, 176, 80);">';
                                break;
                            default:
                                echo '<td>';
                                break;
                        };
                        echo $sumall3 . '</td>';
                        switch (true) {
                            case $sumall4 <= 0.1:
                                echo '<td>';
                                break;

                            case $sumall4 <= 1.1:
                                echo '<td style="background-color: RGB(0, 0, 0); color: #fff;">';
                                break;

                            case $sumall4 <= 2.5:
                                echo '<td style="background-color: RGB(255, 0, 0);">';
                                break;

                            case $sumall4 <= 3.2:
                                echo '<td style="background-color: RGB(255, 255, 0);">';
                                break;

                            case $sumall4 <= 4:
                                echo '<td style="background-color: RGB(0, 176, 80);">';
                                break;
                            default:
                                echo '<td>';
                                break;
                        };
                        echo $sumall4 . '</td>';
                        switch (true) {
                            case $midall <= 0.1:
                                echo '<td>';
                                break;

                            case $midall <= 1.1:
                                echo '<td style="background-color: RGB(0, 0, 0); color: #fff;">';
                                break;

                            case $midall <= 2.5:
                                echo '<td style="background-color: RGB(255, 0, 0);">';
                                break;

                            case $midall <= 3.2:
                                echo '<td style="background-color: RGB(255, 255, 0);">';
                                break;

                            case $midall <= 4:
                                echo '<td style="background-color: RGB(0, 176, 80);">';
                                break;
                            default:
                                echo '<td>';
                                break;
                        };
                        echo $midall . '</td></tr>';


                        foreach ($balQuestion as $question => $answer) {

                            $sum1answercol = 0;
                            $sum2answercol = 0;
                            $sum3answercol = 0;
                            $sum4answercol = 0;

                            $sum1answersum = 0;
                            $sum2answersum = 0;
                            $sum3answersum = 0;
                            $sum4answersum = 0;

                            foreach ($answer as $answer_text => $sum) {

                                if (isset($sum['sum1']) and is_numeric($sum['sum1'])) {
                                    $sum1answersum = $sum1answersum += $sum['sum1'];
                                    $sum1answercol += $sum['col1'];
                                }
                                if (isset($sum['sum2']) and is_numeric($sum['sum2'])) {
                                    $sum2answersum += $sum['sum2'];
                                    $sum2answercol += $sum['col2'];
                                }
                                if (isset($sum['sum3']) and is_numeric($sum['sum3'])) {
                                    $sum3answersum += $sum['sum3'];
                                    $sum3answercol += $sum['col3'];
                                }
                                if (isset($sum['sum4']) and is_numeric($sum['sum4'])) {
                                    $sum4answersum += $sum['sum4'];
                                    $sum4answercol += $sum['col4'];
                                }
                            }
                            $mid1 = 0;
                            $mid2 = 0;
                            $mid3 = 0;
                            $mid4 = 0;

                            $sum1mid = 0;
                            $sum2mid = 0;
                            $sum3mid = 0;
                            $sum4mid = 0;

                            $midcoll = 0;
                            if ($sum1answersum > 0) {
                                $sum1mid = $sum1answersum / $sum1answercol;
                                $sum1mid = round($sum1mid, 1, PHP_ROUND_HALF_ODD);
                                $mid1 = $sum1mid;
                                $midcoll++;
                            }
                            if ($sum2answersum > 0) {
                                $sum2mid = $sum2answersum / $sum2answercol;
                                $sum2mid = round($sum2mid, 1, PHP_ROUND_HALF_ODD);
                                $mid2 = $sum2mid;
                                $midcoll++;
                            }
                            if ($sum3answersum > 0) {
                                $sum3mid = $sum3answersum / $sum3answercol;
                                $sum3mid = round($sum3mid, 1, PHP_ROUND_HALF_ODD);
                                $mid3 = $sum3mid;
                                $midcoll++;
                            }
                            if ($sum4answersum > 0) {
                                $sum4mid = $sum4answersum / $sum4answercol;
                                $sum4mid = round($sum4mid, 1, PHP_ROUND_HALF_ODD);
                                $mid4 = $sum4mid;
                                $midcoll++;
                            }
                            $sum5 = $mid1 + $mid2 + $mid3 + $mid4;
                            if ($midcoll != 0) {
                                $mid5 = $sum5 / $midcoll;
                                $mid5 = round($mid5, 1, PHP_ROUND_HALF_ODD);
                            } else {
                                $mid5 = 0;
                            };
                            $i++;
                            echo '<tr class="question_tr" data-id="' . $i . '" data-view="hide"><td style="font-size: large;">' . $question . '</td>';

                            switch (true) {
                                case $sum1mid <= 0.1:
                                    echo '<td>';
                                    break;

                                case $sum1mid <= 1.1:
                                    echo '<td style="background-color: RGB(0, 0, 0); color: #fff;">';
                                    break;

                                case $sum1mid <= 2.5:
                                    echo '<td style="background-color: RGB(255, 0, 0);">';
                                    break;

                                case $sum1mid <= 3.2:
                                    echo '<td style="background-color: RGB(255, 255, 0);">';
                                    break;

                                case $sum1mid <= 4:
                                    echo '<td style="background-color: RGB(0, 176, 80);">';
                                    break;
                                default:
                                    echo '<td>';
                                    break;
                            };
                            echo $sum1mid . '</td>';
                            switch (true) {
                                case $sum2mid <= 0.1:
                                    echo '<td>';
                                    break;

                                case $sum2mid <= 1.1:
                                    echo '<td style="background-color: RGB(0, 0, 0); color: #fff;">';
                                    break;

                                case $sum2mid <= 2.5:
                                    echo '<td style="background-color: RGB(255, 0, 0);">';
                                    break;

                                case $sum2mid <= 3.2:
                                    echo '<td style="background-color: RGB(255, 255, 0);">';
                                    break;

                                case $sum2mid <= 4:
                                    echo '<td style="background-color: RGB(0, 176, 80);">';
                                    break;
                                default:
                                    echo '<td>';
                                    break;
                            };
                            echo $sum2mid . '</td>';
                            switch (true) {
                                case $sum3mid <= 0.1:
                                    echo '<td>';
                                    break;

                                case $sum3mid <= 1.1:
                                    echo '<td style="background-color: RGB(0, 0, 0); color: #fff;">';
                                    break;

                                case $sum3mid <= 2.5:
                                    echo '<td style="background-color: RGB(255, 0, 0);">';
                                    break;

                                case $sum3mid <= 3.2:
                                    echo '<td style="background-color: RGB(255, 255, 0);">';
                                    break;

                                case $sum3mid <= 4:
                                    echo '<td style="background-color: RGB(0, 176, 80);">';
                                    break;
                                default:
                                    echo '<td>';
                                    break;
                            };
                            echo $sum3mid . '</td>';
                            switch (true) {
                                case $sum4mid <= 0.1:
                                    echo '<td>';
                                    break;

                                case $sum4mid <= 1.1:
                                    echo '<td style="background-color: RGB(0, 0, 0); color: #fff;">';
                                    break;

                                case $sum4mid <= 2.5:
                                    echo '<td style="background-color: RGB(255, 0, 0);">';
                                    break;

                                case $sum4mid <= 3.2:
                                    echo '<td style="background-color: RGB(255, 255, 0);">';
                                    break;

                                case $sum4mid <= 4:
                                    echo '<td style="background-color: RGB(0, 176, 80);">';
                                    break;
                                default:
                                    echo '<td>';
                                    break;
                            };
                            echo $sum4mid . '</td>';
                            switch (true) {
                                case $mid5 <= 0.1:
                                    echo '<td>';
                                    break;

                                case $mid5 <= 1.1:
                                    echo '<td style="background-color: RGB(0, 0, 0); color: #fff;">';
                                    break;

                                case $mid5 <= 2.5:
                                    echo '<td style="background-color: RGB(255, 0, 0);">';
                                    break;

                                case $mid5 <= 3.2:
                                    echo '<td style="background-color: RGB(255, 255, 0);">';
                                    break;

                                case $mid5 <= 4:
                                    echo '<td style="background-color: RGB(0, 176, 80);">';
                                    break;
                                default:
                                    echo '<td>';
                                    break;
                            };
                            echo $mid5 . '</td></tr>';

                            foreach ($answer as $answer_text => $sum) {
                                echo '<tr class="answer_' . $i . '" style="display:none;"><td>' . $answer_text . '</td>';
                                if (isset($sum['sum1']) and is_numeric($sum['sum1'])) {

                                    $sum1 = $sum['sum1'];
                                    if (isset($sum['col1'])) {
                                        $self = $sum1 / $sum['col1'];
                                        $self = round($self, 1);
                                    } else {
                                        $sum['col1'] = 0;
                                        $self = $sum['sum1'];
                                    };
                                    switch (true) {

                                        case $self <= 1.1:
                                            echo '<td style="background-color: RGB(0, 0, 0); color: #fff;">';
                                            break;

                                        case $self <= 2.5:
                                            echo '<td style="background-color: RGB(255, 0, 0);">';
                                            break;

                                        case $self <= 3.2:
                                            echo '<td style="background-color: RGB(255, 255, 0);">';
                                            break;

                                        case $self <= 4:
                                            echo '<td style="background-color: RGB(0, 176, 80);">';
                                            break;
                                        default:
                                            echo '<td>';
                                            break;
                                    };
                                    echo $self . '</td>';
                                } else {
                                    $sum['col1'] = 0;
                                    $sum['sum1'] = 0;
                                    echo '<td>Н/Д</td>';
                                };

                                if (isset($sum['sum2'])) {
                                    $sum2 = $sum['sum2'];
                                    if (isset($sum['col2'])) {
                                        $boss = $sum2 / $sum['col2'];
                                        $boss = round($boss, 1);
                                    } else {
                                        $sum['col2'] = 0;
                                        $boss = $sum['sum2'];
                                    };
                                    switch (true) {

                                        case $boss <= 1.1:
                                            echo '<td style="background-color: RGB(0, 0, 0); color: #fff;">';
                                            break;

                                        case $boss <= 2.5:
                                            echo '<td style="background-color: RGB(255, 0, 0);">';
                                            break;

                                        case $boss <= 3.2:
                                            echo '<td style="background-color: RGB(255, 255, 0);">';
                                            break;

                                        case $boss <= 4:
                                            echo '<td style="background-color: RGB(0, 176, 80);">';
                                            break;
                                        default:
                                            echo '<td>';
                                            break;
                                    };
                                    echo $boss . '</td>';
                                } else {
                                    $sum['col2'] = 0;
                                    $sum['sum2'] = 0;
                                    echo '<td>Н/Д</td>';
                                };

                                if (isset($sum['sum3'])) {
                                    $sum3 = $sum['sum3'];
                                    if (isset($sum['col3'])) {
                                        $subject = $sum3 / $sum['col3'];
                                        $subject = round($subject, 1);
                                    } else {
                                        $sum['col3'] = 0;
                                        $subject = $sum['sum3'];
                                    };
                                    switch (true) {

                                        case $subject <= 1.1:
                                            echo '<td style="background-color: RGB(0, 0, 0); color: #fff;">';
                                            break;

                                        case $subject <= 2.5:
                                            echo '<td style="background-color: RGB(255, 0, 0);">';
                                            break;

                                        case $subject <= 3.2:
                                            echo '<td style="background-color: RGB(255, 255, 0);">';
                                            break;

                                        case $subject <= 4:
                                            echo '<td style="background-color: RGB(0, 176, 80);">';
                                            break;

                                        default:
                                            echo '<td>';
                                            break;
                                    };
                                    echo $subject . '</td>';
                                } else {
                                    $sum['col3'] = 0;
                                    $sum['sum3'] = 0;
                                    echo '<td>Н/Д</td>';
                                };

                                if (isset($sum['sum4'])) {
                                    $sum4 = $sum['sum4'];
                                    if (isset($sum['col4'])) {
                                        $colleague = $sum4 / $sum['col4'];
                                        $colleague = round($colleague, 1);
                                    } else {
                                        $sum['col4'] = 0;
                                        $colleague = $sum['sum4'];
                                    };
                                    switch (true) {

                                        case $colleague <= 1.1:
                                            echo '<td style="background-color: RGB(0, 0, 0); color: #fff;">';
                                            break;

                                        case $colleague <= 2.5:
                                            echo '<td style="background-color: RGB(255, 0, 0);">';
                                            break;

                                        case $colleague <= 3.2:
                                            echo '<td style="background-color: RGB(255, 255, 0);">';
                                            break;

                                        case $colleague <= 4:
                                            echo '<td style="background-color: RGB(0, 176, 80);">';
                                            break;
                                        default:
                                            echo '<td>';
                                            break;
                                    };
                                    echo $colleague . '</td>';
                                } else {
                                    $sum['col4'] = 0;
                                    $sum['sum4'] = 0;
                                    echo '<td>Н/Д</td>';
                                };
                                $midcol = $sum['col1'] + $sum['col2'] + $sum['col3'] + $sum['col4'];
                                $midding = $sum['sum1'] + $sum['sum2'] + $sum['sum3'] + $sum['sum4'];
                                if ($midcol != 0) {
                                    $midResult = $midding / $midcol;
                                    $midResult = round($midResult, 1);
                                } else {
                                    $midResult = 0;
                                }
                                switch (true) {

                                    case $midResult <= 1.1:
                                        echo '<td style="background-color: RGB(0, 0, 0); color: #fff;">';
                                        break;

                                    case $midResult <= 2.5:
                                        echo '<td style="background-color: RGB(255, 0, 0);">';
                                        break;

                                    case $midResult <= 3.2:
                                        echo '<td style="background-color: RGB(255, 255, 0);">';
                                        break;

                                    case $midResult <= 4:
                                        echo '<td style="background-color: RGB(0, 176, 80);">';
                                        break;

                                    default:
                                        echo '<td>';
                                        break;
                                };
                                echo $midResult . '</td>';
                            }
                        }


                        ?>
                </tbody>
            </table>


        </div>
    </body>

    </html>
<?php
} else {
?>
    <!Doctype html>
    <html>

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

        <title>Отчет</title>
        <style>
            @media print {

                .no-print,
                .no-print * {
                    display: none !important;
                }
            }

            table,
            th,
            td {
                border: 1px solid #ddd;
                padding: .75rem;

            }
        </style>
    </head>

    <body>

        <div class="container-fluid">
            <h5 style="float: right;" class="btn btn-outline-secondary no-print HideFontHelper " onclick="window.print();">Печать</h5>
            <h5 style="float: right;" class="btn btn-outline-secondary no-print setExcel" id="setExcel" data-id="<?php echo $_REQUEST['id']; ?>">Excel</h5>
            <h5 style="float: right; display:none;" class="btn btn-outline-secondary no-print saveExcel" id="saveExcel">
                Скачать Excel</h5>
            <h4 align="center"><b>Результаты оценки</b></h4>
            <h4 align="center">
                <b><?php echo $collection[0]->task->user->surname . ' ' . $collection[0]->task->user->name . ' ' . $collection[0]->task->user->middlename; ?></b>
            </h4>
            <h4 align="center"><b><?php echo $collection[0]->task->test->name; ?></b></h4>
            <h6 align="center">Анализ по каждой компетенции</h6><br />
            <h6 align="center">Этот раздел аналитической части отчета подробно сравнивается оценка каждой группы опрошенных,
                средняя оценка, Ваша самооценка и желаемый уровень для данной компетенции:</h6>

            <table style="width: 100%;">
                <tr align="center">
                    <td style="background-color: RGB(0, 176, 80);">&nbsp;</td>
                    <td>3,3 - 4</td>
                    <td>желаемый уровень</td>
                </tr>
                <tr align="center">
                    <td style="background-color: RGB(255, 255, 0);">&nbsp;</td>
                    <td>2,6 -3,2</td>
                    <td>оптимальный уровень</td>
                </tr>
                <tr align="center">
                    <td style="background-color: RGB(255, 0, 0);">&nbsp;</td>
                    <td>1,1 - 2,5</td>
                    <td>низкий уровень</td>
                </tr>
                <tr align="center">
                    <td style="background-color: RGB(0, 0, 0); color: #fff;">&nbsp;</td>
                    <td>1</td>
                    <td>отсутствует</td>
                </tr>
            </table>

            <!--вопросы со средним баллом-->
            <hr>


            <table>
                <thead style="background-color: #86cfda;">
                    <tr>
                        <th>№ п/п</th>
                        <th>Компетенции</th>
                        <th>Самооценка</th>
                        <th>Оценка руководителя</th>
                        <th>Оценка коллег</th>
                        <th>Оценка подчиненных</th>
                        <th>Средний бал</th>
                    </tr>
                </thead>
                <tbody>
                    <?php


                    $i = 1;
                    foreach ($balQuestion as $question => $sum) {
                        echo '<tr><td>' . $i . '</td><td style="font-size: large;">' . $question . '</td>';
                        if (isset($sum['sum1'])) {

                            $sum1 = $sum['sum1'];
                            if (isset($sum['col1'])) {
                                $self = $sum1 / $sum['col1'];
                                $self = round($self, 1);
                            } else {
                                $sum['col1'] = 0;
                                $self = $sum['sum1'];
                            };
                            switch (true) {

                                case $self <= 1.1:
                                    echo '<td style="background-color: RGB(0, 0, 0); color: #fff;">';
                                    break;

                                case $self <= 2.5:
                                    echo '<td style="background-color: RGB(255, 0, 0);">';
                                    break;

                                case $self <= 3.2:
                                    echo '<td style="background-color: RGB(255, 255, 0);">';
                                    break;

                                case $self <= 4:
                                    echo '<td style="background-color: RGB(0, 176, 80);">';
                                    break;
                                default:
                                    echo '<td>';
                                    break;
                            };
                            echo $self . '</td>';
                        } else {
                            $sum['col1'] = 0;
                            $sum['sum1'] = 0;
                            echo '<td>Нет результатов</td>';
                        };

                        if (isset($sum['sum2'])) {
                            $sum2 = $sum['sum2'];
                            if (isset($sum['col2'])) {
                                $boss = $sum2 / $sum['col2'];
                                $boss = round($boss, 1);
                            } else {
                                $sum['col2'] = 0;
                                $boss = $sum['sum2'];
                            };
                            switch (true) {

                                case $boss <= 1.1:
                                    echo '<td style="background-color: RGB(0, 0, 0); color: #fff;">';
                                    break;

                                case $boss <= 2.5:
                                    echo '<td style="background-color: RGB(255, 0, 0);">';
                                    break;

                                case $boss <= 3.2:
                                    echo '<td style="background-color: RGB(255, 255, 0);">';
                                    break;

                                case $boss <= 4:
                                    echo '<td style="background-color: RGB(0, 176, 80);">';
                                    break;
                                default:
                                    echo '<td>';
                                    break;
                            };
                            echo $boss . '</td>';
                        } else {
                            $sum['col2'] = 0;
                            $sum['sum2'] = 0;
                            echo '<td>Нет результатов</td>';
                        };

                        if (isset($sum['sum3'])) {
                            $sum3 = $sum['sum3'];
                            if (isset($sum['col3'])) {
                                $subject = $sum3 / $sum['col3'];
                                $subject = round($subject, 1);
                            } else {
                                $sum['col3'] = 0;
                                $subject = $sum['sum3'];
                            };
                            switch (true) {

                                case $subject <= 1.1:
                                    echo '<td style="background-color: RGB(0, 0, 0); color: #fff;">';
                                    break;

                                case $subject <= 2.5:
                                    echo '<td style="background-color: RGB(255, 0, 0);">';
                                    break;

                                case $subject <= 3.2:
                                    echo '<td style="background-color: RGB(255, 255, 0);">';
                                    break;

                                case $subject <= 4:
                                    echo '<td style="background-color: RGB(0, 176, 80);">';
                                    break;

                                default:
                                    echo '<td>';
                                    break;
                            };
                            echo $subject . '</td>';
                        } else {
                            $sum['col3'] = 0;
                            $sum['sum3'] = 0;
                            echo '<td>Нет результатов</td>';
                        };

                        if (isset($sum['sum4'])) {
                            $sum4 = $sum['sum4'];
                            if (isset($sum['col4'])) {
                                $colleague = $sum4 / $sum['col4'];
                                $colleague = round($colleague, 1);
                            } else {
                                $sum['col4'] = 0;
                                $colleague = $sum['sum4'];
                            };
                            switch (true) {

                                case $colleague <= 1.1:
                                    echo '<td style="background-color: RGB(0, 0, 0); color: #fff;">';
                                    break;

                                case $colleague <= 2.5:
                                    echo '<td style="background-color: RGB(255, 0, 0);">';
                                    break;

                                case $colleague <= 3.2:
                                    echo '<td style="background-color: RGB(255, 255, 0);">';
                                    break;

                                case $colleague <= 4:
                                    echo '<td style="background-color: RGB(0, 176, 80);">';
                                    break;
                                default:
                                    echo '<td>';
                                    break;
                            };
                            echo $colleague . '</td>';
                        } else {
                            $sum['col4'] = 0;
                            $sum['sum4'] = 0;
                            echo '<td>Нет результатов</td>';
                        };
                        $midcol = $sum['col1'] + $sum['col2'] + $sum['col3'] + $sum['col4'];
                        $midding = $sum['sum1'] + $sum['sum2'] + $sum['sum3'] + $sum['sum4'];
                        if ($midcol != 0) {
                            $midResult = $midding / $midcol;
                            $midResult = round($midResult, 1);
                        } else {
                            $midResult = 0;
                        }
                        switch (true) {

                            case $midResult <= 1.1:
                                echo '<td style="background-color: RGB(0, 0, 0); color: #fff;">';
                                break;

                            case $midResult <= 2.5:
                                echo '<td style="background-color: RGB(255, 0, 0);">';
                                break;

                            case $midResult <= 3.2:
                                echo '<td style="background-color: RGB(255, 255, 0);">';
                                break;

                            case $midResult <= 4:
                                echo '<td style="background-color: RGB(0, 176, 80);">';
                                break;

                            default:
                                echo '<td>';
                                break;
                        };
                        echo $midResult . '</td>';

                        $i++;
                    };
                    ?>
                </tbody>
            </table>


        </div>
    </body>

    </html>
<?php
};


?>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
    /*--- Интерактивная настройка шрифта----------------------------------------*/
    $("td").css("fontSize", 14);

    function sizeTableFontSize() {
        size = document.getElementById("TableFontsize").value;
        $("td").css("fontSize", size);

        FSI = document.getElementById("FontSizeInfo");
        FSI.textContent = size;


    }
    $(document).on('mouseover', '.HideFontHelper', function() {

        $('#FontHelper').css("display", "none");
        console.log('hide FontHelper')
    });
    // $(document).on('mouseleave', '.table', function() {
    $(document).on('mouseleave', '.HideFontHelper', function() {
        //$(document).mouseout(function() {
        $('#FontHelper').css("display", "flex");
        console.log('show FontHelper')
    });
</script>
<script type="text/javascript">
    /*--- раскрытие вопросов----------------------------------------*/
    $(document).on('click', '.question_tr', function() {
        var id = $(this).data('id');
        var mod = $(this).data('view');

        if (mod == "hide") {
            $('.answer_' + id).css("display", "table-row");
            $(this).data('view', 0);
        } else {
            $('.answer_' + id).css("display", "none");
            $(this).data('view', 'hide');
        }
    });
    /*----------------------------------------------------------------------------------*/
    /*---Создание excel отчета--------------------------------------*/
    $(document).on('click', '#setExcel', function() {
        var id = $(this).data('id');

        $.ajax({
            url: '/exports/save.php?id=' + id,
            dataType: "json",
            type: 'POST',
            success: function(data) {

            }

        });
        $('#saveExcel').css("display", "block");
        location.reload.bind(location);

    });
    /*----------------------------------------------------------------------------------*/
    /*---Создание excel отчета--------------------------------------*/
    $(document).on('click', '#setExcel2021', function() {
        var id = $(this).data('id');

        $.ajax({
            url: '/exports/save_2021.php?id=' + id,
            dataType: "json",
            type: 'POST',
            success: function(data) {

            }

        });
        $('#saveExcel2021').css("display", "block");
        location.reload.bind(location);

    });
    /*----------------------------------------------------------------------------------*/
    /*---Создание excel отчета--------------------------------------*/
    $(document).on('click', '#setExcelText', function() {
        var id = $(this).data('id');

        $.ajax({
            url: '/exports/save_text.php?id=' + id,
            dataType: "json",
            type: 'POST',
            success: function(data) {

            }

        });
        $('#saveExcelText').css("display", "block");
        location.reload.bind(location);

    });
    /*----------------------------------------------------------------------------------*/
    /*---сохранение excel отчета--------------------------------------*/
    $(document).on('click', '#saveExcel', function() {


        window.location = '/exports/upload/report.xls';
        $('#saveExcel').css("display", "none");
        location.reload.bind(location);
    });
    /*----------------------------------------------------------------------------------*/
    /*---сохранение excel отчета--------------------------------------*/
    $(document).on('click', '#saveExcel2021', function() {


        window.location = '/exports/upload/report_2021.xls';
        $('#saveExcel2021').css("display", "none");
        location.reload.bind(location);
    });
    /*----------------------------------------------------------------------------------*/
    /*---сохранение excel отчета--------------------------------------*/
    $(document).on('click', '#saveExcelText', function() {


        window.location = '/exports/upload/report_text.xls';
        $('#saveExcelText').css("display", "none");
        location.reload.bind(location);
    });
    /*----------------------------------------------------------------------------------*/
</script>