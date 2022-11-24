<link rel="stylesheet" href="/css/globalStyle.css" type="text/css"/>
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/system/config.php';
if (!$_SESSION['user'] or $_SESSION['user']->group->access == 2) {
    header('Location:  http://staff.ska.su');
}
$collection = api::collection('result', array('task' => $_REQUEST['id']));
$task = api::collection('task', array('id' => $_REQUEST['id']));
$textQuestion = array();
$balQuestion = array();

foreach ($collection as $result) {

    $test = $result->task->test->id;

    foreach ($result->task->test->question as $place) {

        foreach ($result->registr_result as $rr) {
            if ($place->id == $rr->question->id) {

                if ($rr->question->type == 0) {

                    $textQuestion[$rr->question->text][] = $rr->answer_text;

                } elseif ($rr->question->type == 3) {
                    if (is_numeric($rr->answer_text)) {
                        $midall1 += $rr->answer_text;
                        $collall1++;
                    }
                    if (isset($balQuestion[$rr->question->text])) {
                        $balQuestion[$rr->question->text][$rr->answer->text] += $rr->answer_text;

                    } else {
                        $balQuestion[$rr->question->text][$rr->answer->text] = $rr->answer_text;
                    }

                }
                elseif ($rr->question->type == 2) {

                    main::printr($balQuestion);
                    main::printr($rr->question->text);
                    if (isset($balQuestion[$rr->question->text])) {
                        $balQuestion[$rr->question->text][$rr->answer->text] += $rr->answer_text;

                    } else {
                        $balQuestion[$rr->question->text][$rr->answer->text] = $rr->answer_text;
                    }

                } else {

                    $balQuestion[$rr->question->text][$rr->answer->text] = $rr->answer->weight;
                };
            };
        }
    }

};


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
            font-size: 22;
            border: 1px solid #ddd;
            padding: .0rem;

        }

    </style>
</head>
<body>

    <div class="container-fluid">


        <h5 style="float: right;" class="btn btn-outline-secondary no-print" onclick="window.print();">Печать</h5>

        <img src="../../png/Logo.jpg" width="300px" alt="СКА">
        <br>
        <hr>
        <table class="table table-bordered">
            <tbody>

                <tr><td colspan="2" style="text-align: center;"><b><?php echo $task['0']->test->name;?></b></td></tr>
                <?php
                main::printr($balQuestion);

                foreach ($balQuestion as $question => $answer_text) {
                    echo '<tr><td colspan="2"><b>' . $question . '</b></td></tr>';
                    foreach ($answer_text as $text => $val) {

                        echo '<tr><td>' . $text . '</td><td>' . $val . '</td></tr>';
                    }
                }



                ?>
            </tbody>
        </table>
        <?php

        if (count($textQuestion) > 0) {

            ?>
            <table class="table table-bordered">
                <tbody>
                    <?php
                    foreach ($textQuestion as $question => $answers) {
                        echo '<tr><td><b>' . $question . '</b></td></tr>';
                        foreach ($answers as $data) {
                            echo '<tr><td>' . $data . '</td></tr>';
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
