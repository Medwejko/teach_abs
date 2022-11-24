<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/system/config.php';
if (!$_SESSION['user'] or $_SESSION['user']->group->access == 2) {
    header('Location: http://staff.ska.su');
}

$collection = api::collection('result', array('task' => $_REQUEST['id'], 'user' => $_REQUEST['user']));
$userColl = api::collection('user', array('id' => $_REQUEST['user']));
$user = $userColl[0];
$textQuestion = array();
$balQuestion = array();
$type = 1;
main::printr($collection);
foreach ($collection as $result) {

    $test = $result->task->test->id;
    main::printr($result->tus);

    foreach ($result->registr_result as $rr) {
        if ($rr->question->type == 0 ) {
            $type = 0;
            $answer = array(
                'tus' => "Cамооценка",
                'user' => $result->user,
                'answer_text' => $rr->answer_text
            );
            $textQuestion[$rr->question->text][] = $answer;
        } else {
            $type = 1;
            if (isset($rr->answer->weight) and $rr->answer->weight > 0 ) {

                $balQuestion[$rr->question->text]['sum1'] = $rr->answer->weight;
                
            }
            else{
                $balQuestion[$rr->question->text]['sum1'] = $rr->answer_text;
            }
            ;

        };
    };
};
if ($type == 0)
{
?>
<!Doctype html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <title>Отчет</title>
    <style>
        @media print {
            .no-print, .no-print * {
                display: none !important;
            }
        }

        table, th, td {
            font-size: 22;
            border: 1px solid #ddd;
            padding: .0rem;

        }
    </style>
</head>
<body>

<div class="container-fluid">


    <h5 style="float: right;" class="btn btn-outline-secondary no-print" onclick="window.print();">Печать</h5>
    <h5 style="float: right;" class="btn btn-outline-secondary no-print setExcel" id="setExcelText"
        data-id="<?php echo $_REQUEST['id']; ?>">Excel</h5>
    <h5 style="float: right; display:none;" class="btn btn-outline-secondary no-print saveExcelText" id="saveExcelText">
        Скачать Excel</h5>
    <img src="../../png/Logo.jpg" height="50%" width="250px" alt="СКА">
    <br>
    <hr>
    <!--вопросы со свободным ответом-->
    <?php
    if (count($textQuestion) > 0)
    {

    ?>
    <table class="table table-bordered">
        <tbody>
        <tr>
            <td colspan="3" style="text-align: center;"><b><?php echo str_replace("с 2021", " ", $collection[0]->task->test->name); ?></b></td>
        </tr>



        <?php
        switch ($collection[0]->tus) {

            case '1':
                echo '<tr><td colspan="3" style="text-align: center;"><b>Самооценка: ' . $collection[0]->task->user->surname . ' ' . $collection[0]->task->user->name . ' ' . $collection[0]->task->user->middlename . '</b></td></tr>';
                break;
            case '2':
                echo '<tr><td colspan="3" style="text-align: center;"><b>Оцениваемый: ' . $collection[0]->task->user->surname . ' ' . $collection[0]->task->user->name . ' ' . $collection[0]->task->user->middlename . '</b></td></tr>';
                echo '<tr><td colspan="3" style="text-align: center;"><b>Руководитель: ' . $user->surname . ' ' . $user->name . ' ' . $user->middlename . '</b></td></tr>';
                break;
            case '3':
                echo '<tr><td colspan="3" style="text-align: center;"><b>Оцениваемый: ' . $collection[0]->task->user->surname . ' ' . $collection[0]->task->user->name . ' ' . $collection[0]->task->user->middlename . '</b></td></tr>';
                echo '<tr><td colspan="3" style="text-align: center;"><b>Коллега: ' . $user->surname . ' ' . $user->name . ' ' . $user->middlename . '</b></td></tr>';
                break;
            case '4':
                echo '<tr><td colspan="3" style="text-align: center;"><b>Оцениваемый: ' . $collection[0]->task->user->surname . ' ' . $collection[0]->task->user->name . ' ' . $collection[0]->task->user->middlename . '</b></td></tr>';
                echo '<tr><td colspan="3" style="text-align: center;"><b>Подчиненный: ' . $user->surname . ' ' . $user->name . ' ' . $user->middlename . '</b></td></tr>';
                break;
        }
        foreach ($textQuestion as $question => $answers) {
            main::printr($answers);
            echo '<tr><td width="50%" colspan="2"><b>' . $question . '</b></td>';
            foreach ($answers as $data) {
                echo '<td colspan="2">' . $data['answer_text'] . '</td></tr>';
            }
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
}
else {
    ?>
    <!Doctype html>
    <html>
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
              integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
              crossorigin="anonymous">

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
              integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr"
              crossorigin="anonymous">

        <title>Отчет</title>
        <style>
            @media print {
                .no-print, .no-print * {
                    display: none !important;
                }
            }

            table, th, td {
                border: 1px solid #ddd;
                padding: .75rem;

            }
        </style>
    </head>
    <body>

    <div class="container-fluid">
        <h5 style="float: right;" class="btn btn-outline-secondary no-print" onclick="window.print();">Печать</h5>
        <h3 align="center"><b>Результаты прохождения тестирования
                пользователем <?php echo $user->surname . ' ' . $user->name . ' с позиции ';
                switch ($collection[0]->tus) {
                    case '1':
                        echo 'самооценки';
                        break;

                    case '2':
                        echo 'руководителя';
                        break;

                    case '3':
                        echo 'коллеги';
                        break;

                    case '4':
                        echo 'подчиненного';
                        break;

                };

                ?></b></h3>
        <h3 align="center">
            <b>Оцениваемый <?php echo $collection[0]->task->user->surname . ' ' . $collection[0]->task->user->name . ' ' . $collection[0]->task->user->middlename; ?>
        </h3>

        <h3 align="center"><b><?php echo $collection[0]->task->test->name; ?></b></h3>
        <h5 style="float: left;">Анализ по каждой компетенции</h5>
        <h6 style="float: left;">Этот раздел аналитической части отчета подробно сравнивается оценка каждой группы
            опрошенных, средняя оценка, Ваша самооценка и желаемый уровень для данной компетенции:</h6>

        <table style="width: 100%;">
            <tr align="center">
                <td class="table-success"></td>
                <td>3,3 - 4</td>
                <td>желаемый уровень</td>
            </tr>
            <tr align="center">
                <td class="table-warning"></td>
                <td>2,6 -3,2</td>
                <td>оптимальный уровень</td>
            </tr>
            <tr align="center">
                <td class="table-danger"></td>
                <td>1 - 2,5</td>
                <td>низкий уровень</td>
            </tr>
            <tr align="center">
                <td class="table-dark"></td>
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
                <th>Оценка</th>
            </tr>
            </thead>
            <tbody>
            <?php


            $i = 1;
            foreach ($balQuestion as $question => $sum) {

                echo '<tr><td>' . $i . '</td><td>' . $question . '</td>';
                if (isset($sum['sum1'])) {
                    switch (true) {

                        case $sum['sum1'] <= 1:
                            echo '<td class="table-dark">';
                            break;

                        case $sum['sum1'] <= 2.5:
                            echo '<td class="table-danger">';
                            break;

                        case $sum['sum1'] <= 3.2:
                            echo '<td class="table-warning">';
                            break;

                        case $sum['sum1'] <= 4:
                            echo '<td class="table-success">';
                            break;
                    };
                    echo $sum['sum1'] . '</td>';
                } else {
                    echo '<td>Нет результатов</td>';
                };
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
    /*---Создание excel отчета--------------------------------------*/
    $(document).on('click', '#setExcel', function () {
        var id = $(this).data('id');

        $.ajax({
            url: '/exports/save.php?id=' + id,
            dataType: "json",
            type: 'POST',
            success: function (data) {

            }

        });
        $('#saveExcel').css("display", "block");
        location.reload.bind(location);

    });
    /*----------------------------------------------------------------------------------*/
    /*---Создание excel отчета--------------------------------------*/
    $(document).on('click', '#setExcelText', function () {
        var id = $(this).data('id');

        $.ajax({
            url: '/exports/save_text.php?id=' + id,
            dataType: "json",
            type: 'POST',
            success: function (data) {

            }

        });
        $('#saveExcelText').css("display", "block");
        location.reload.bind(location);

    });
    /*----------------------------------------------------------------------------------*/
    /*---сохранение excel отчета--------------------------------------*/
    $(document).on('click', '#saveExcel', function () {


        window.location = '/exports/upload/report.xls';
        $('#saveExcel').css("display", "none");
        location.reload.bind(location);
    });
    /*----------------------------------------------------------------------------------*/
    /*---сохранение excel отчета--------------------------------------*/
    $(document).on('click', '#saveExcelText', function () {


        window.location = '/exports/upload/report_text.xls';
        $('#saveExcelText').css("display", "none");
        location.reload.bind(location);
    });
    /*----------------------------------------------------------------------------------*/
</script>