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
    header('Location: http://staff.ska.su');
}
$obj = new user(array('id' => $_REQUEST['id']));
date_default_timezone_set('Europe/Moscow');
$currentdate = date("Y-m-d");
$currdate = date('Y');
$currdatem = date('m');
$birthdaydatem = date('m', strtotime($obj->birthday));
$birthdaydate = date('Y-m-d', strtotime($obj->birthday));
$employdate = date('Y', strtotime($obj->employ));

$employdatem = date('m', strtotime($obj->employ));

$agem = $currdatem - $birthdaydatem;
$age = $currdate - $birthdaydate;
if ($agem < 0) {

    $age = $age - 1;
};
function calculate_age($birthday)
{
    $birthday_timestamp = strtotime($birthday);
    $age = date('Y') - date('Y', $birthday_timestamp);
    if (date('md', $birthday_timestamp) > date('md')) {
        $age--;
    }
    return $age;
}
$employm = $currdatem - $employdatem;
$employ = $currdate - $employdate;
if ($employm < 0) {
    $employm = $employm + 12;
    $employ = $employ - 1;
};
$collection = api::collection('user');

?>

<!Doctype html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <title>Карточка пользователя</title>
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

        td:first-child {
            min-width: 400px !important;
        }
    </style>
</head>

<body>

    <div class="container-fluid">


        <h5 style="float: right;" class="btn btn-outline-secondary no-print HideFontHelper" onclick="window.print();">Печать</h5>
        <h5 style="float: right;" class="btn btn-outline-secondary no-print setExcelUserCard" id="setExcelUserCard" data-id="<?php echo $_REQUEST['id']; ?>">Excel</h5>
        <h5 style="float: right; display:none;" class="btn btn-outline-secondary no-print saveExcelUserCard" id="saveExcelUserCard">Скачать Excel</h5>
        <br>
        <img style="float: left; margin-bottom: 50px;" src="../../png/Logo.jpg" width="300px" alt="СКА">
    </div>
</body>

</html>

<table class="table table-bordered">
    <tbody>
        <tr>
            <td colspan="2" style="text-align: center;"><b>Индивидуальное представление для оценки</b></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;"><b><?php echo $obj->surname . ' ' . $obj->name . ' ' . $obj->middlename; ?></b></td>
        </tr>
        <tr>
            <td>Подразделение:</td>
            <td style="width: 800px;"><?php echo $obj->subunit->name; ?></td>
        </tr>
        <tr>
            <td>Должность:</td>
            <td><?php echo $obj->profession; ?></td>
        </tr>
        <tr>
            <td>Возраст:</td>
            <td><?php echo calculate_age($birthdaydate); ?> лет</td>
        </tr>
        <tr>
            <td>Стаж работы в организации:</td>
            <td><?php echo $employ . " года ";
                echo $employm . " месяцев"; ?></td>
        </tr>
        <tr>
            <td colspan="1">Предыдущие должности, даты перевода:</td>
            <td><?php echo $obj->exEmploy; ?></td>
        </tr>
        <tr>
            <td colspan="1">Образование (что и когда закончил; специальность; квалификация, год окончания):</td>
            <td><?php echo $obj->education; ?></td>
        </tr>
        <tr>
            <td colspan="1">Дополнительное обучение:</td>
            <td><?php echo $obj->secondEducation; ?></td>
        </tr>
        <tr>
            <td colspan="1">Непосредственный руководитель:</td>
            <td>
                <?php
                foreach ($collection as $user_obj) {

                    if ($obj->boss == $user_obj->id) {

                        echo $user_obj->surname . ' ' . $user_obj->name . ' ' . $user_obj->middlename . ' ' . $user_obj->profession;
                    };
                };
                ?>
            </td>
        </tr>
        <tr>
            <td colspan="1">Функциональный руководитель:</td>
            <td>
                <?php
                foreach ($collection as $user_obj) {

                    if ($obj->functionBoss == $user_obj->id) {

                        echo $user_obj->surname . ' ' . $user_obj->name . ' ' . $user_obj->middlename . ' ' . $user_obj->profession;
                    };
                };
                ?>

            </td>
        </tr>
        <tr>
            <td colspan="1">Cостоит в кадровом резерве:</td>
            <td>
                <?php
                $id = $_REQUEST['id'];
                $reservColl = api::reservCollection($id);
                if (count($reservColl) > 0) {
                    foreach ($reservColl['user'] as $user) {
                        if ($user->id != $id) {
                            echo $user->surname . ' ' . $user->name . ' ' . $user->middlename . '<br>';
                        }
                    }
                }
                ?>
            </td>
        </tr>
        <tr>
            <td colspan="1">Имеет в кадровом резерве:</td>
            <td>
                <?php
                if (count($reservColl) > 0) {
                    foreach ($reservColl['reserv'] as $user) {
                        if ($user->id != $id) {
                            echo $user->surname . ' ' . $user->name . ' ' . $user->middlename . '<br>';
                        }
                    }
                }
                ?>
            </td>
        </tr>
        <tr>
            <td colspan="1">Задачи, поставленные на предыдущей оценке. Статус их выполнения (в конкретных фактических результатах):</td>
            <td><?php echo $obj->taskAssessment; ?></td>
        </tr>
        <tr>
            <td colspan="1">Результаты предыдущей оценки (основные выводы):</td>
            <td><?php echo $obj->resultAssessment; ?></td>
        </tr>






    </tbody>
</table>
</table>
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
    /*---Создание excel отчета--------------------------------------*/
    $(document).on('click', '#setExcelUserCard', function() {
        var id = $(this).data('id');

        $.ajax({
            url: '/exports/save_userCard.php?id=' + id,
            dataType: "json",
            type: 'POST',
            success: function(data) {

            }

        });
        $('#saveExcelUserCard').css("display", "block");
        location.reload.bind(location);

    });
    /*----------------------------------------------------------------------------------*/
    /*---сохранение excel отчета--------------------------------------*/
    $(document).on('click', '#saveExcelUserCard', function() {


        window.location = '/exports/upload/userCard.xls';
        $('#saveExcelUserCard').css("display", "none");
        location.reload.bind(location);
    });
    /*----------------------------------------------------------------------------------*/
</script>