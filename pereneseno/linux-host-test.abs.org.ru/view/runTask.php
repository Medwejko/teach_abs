<?php
include_once '../system/config.php';
$app = new app(array('query' => 'getQuestion'));


if ($app->question) {
    $_SESSION['type'] = $app->question->type;
    main::printr($_SESSION['task']->test);
    $timer = $_SESSION['timer'];
    main::printr($app);
    $i = 0;
    $registr = api::collection('registr_test_question', array('test' => $_SESSION['task']->test->id));
    foreach ($registr as $key => $reg) {

        if ($reg->question == $app->question->id) {
            if ($reg->place != 0) {
                $place = $reg->place;
            }
            else
            {
                $place = $key++;
            }
            main::printr($place);
        }
    }

    ?>
    <div class="modal fade bd-example-modal-lg" id="newModal" tabindex="-1" role="dialog"
    aria-labelledby="testModalLabel" aria-hidden="true">
    <div class="modal-dialog mw-100 w-80" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5><?php echo 'Вопрос № ' . $place . ' из ' . $app->questionCol . '. Тест: ' . $_SESSION['task']->test->name; ?>
                для <span
                class="badge badge-info"><?php echo $_SESSION['task']->user->surname . ' ' . $_SESSION['task']->user->name . ' ' . $_SESSION['task']->user->middlename; ?></span>
            </h5>
            <?php
            if ($timer > 0) {
                echo '<p id="timer" data-mili="' . $timer . '" style="color: #ff0000; font-size: 120%; font-weight: bold; margin-bottom: 6px;"></p>';
            }; ?>


        </div>
        <div class="modal-header">
            <h5>
                <span class="badge badge-secondary">Инструкции</span><?php echo $_SESSION['task']->test->instruction; ?>
            </h5>
        </div>
        <div class="modal-body">
            <h5><?php echo $app->question->text; ?></h5>
            <form id="newForm">
                <input type="hidden" id="HTimer" value="<?php echo $timer ?>">
                <input type="hidden" id="FTimer" name="timer">

                <?php
                switch ($app->question->type) {
                    case '0':
                    echo '<div class="custom-control">
                    <textarea class="form-control chek-text" name="answer_text"></textarea>
                    </div>';
                    echo '<input type="hidden" name="question" value="' . $app->question->id . '">';
                    break;

                    case '1':
                    foreach ($app->question->answers as $answer) {
                        echo '<div class="custom-control custom-radio">
                        <input type="radio" id="customRadio' . $answer->id . '" name="answer" value="' . $answer->id . '" class="custom-control-input  chek-radio">
                        <label class="custom-control-label" for="customRadio' . $answer->id . '">"' . $answer->text . '"</label>
                        </div>';
                    };
                    echo '<input type="hidden" name="answer_text" value="">';
                    echo '<input type="hidden" name="question" value="' . $app->question->id . '">';

                    break;

                    case '2':
                    foreach ($app->question->answers as $answer) {
                        echo '<div class="custom-control custom-checkbox">
                        <input type="checkbox" id="custom-checkbox' . $answer->id . '" name="' . $answer->id . '" value="1" class="custom-control-input chek-checkbox">
                        <label class="custom-control-label" for="custom-checkbox' . $answer->id . '">"' . $answer->text . '"</label>
                        </div>';
                    };
                    echo '<input type="hidden" name="question" value="' . $app->question->id . '">';
                    echo '<input type="hidden" id="col" value="' . $app->question->col . '">';
                    break;

                    case '3':
                    foreach ($app->question->answers as $answer) {
                        echo '<div class="custom-control">
                        <div class="input-group mb-7">
                        <h5>' . $answer->text . '</h5>
                        <select class="custom-select form-control multi-answer" style = "width: 200px; margin-right: 85%;" id="custom-checkbox"  name="'.$answer->id.'">
                        <option value="0" selected>Выберите оценку </option>
                        <option value="1">Не проявляет себя так, чтобы можно было судить, какое   поведение более свойственно</option>
                        <option value="2">Редко ведет себя так, как описано</option>
                        <option value="3">Часто ведет себя именно так, но не всегда</option>
                        <option value="4">Сотрудник демонстрирует образец поведения</option>
                        </select>
                        </div>
                        <hr>

                        </div>';

                    };
                    echo '<input type="hidden" name="question" value="' . $app->question->id . '">';

                    break;


                };
                ?>
            </form>
        </div>
        <?php
        if ($_SESSION['type'] != '3') {


            echo '<div class="modal-body">
            <ul class="pagination justify-content-start" id="listPag"
            style="margin-bottom: 0px; padding-right: 0px; display: block;">
            <p class="font-weight-bold" style="margin-top: 6px; margin-bottom: 0px;">Вернуться к
            вопросу: </p>';
            $registr = api::collection('result', array('id' => $_SESSION['result']['id']));
            $i = 1;
            $question = 0;
            foreach ($registr['0']->registr_result as $obj) {
                if ($question != $obj->question->id) {
                    echo '<button style ="color: green;" class="btn btn-editAnswer" data-id="' . $obj->id . '" data-answer="' . $obj->answer->id . '" data-position="' . $i . '" data-question="' . $obj->question->id . '">' . $i . '</button>';
                    $i++;
                }
                $question = $obj->question->id;
            }


            echo '</ul>

            </div>';
        };
        ?>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-obj="answer" id="setAnswerBtn">Ответить</button>
        </div>
    </div>
</div>
</div>

<?php
} else if ($_SESSION['timer'] == 0) {
    $endTask = api::endTask($_SESSION['task']->id, $_SESSION['user']->id);
    ?>
    <div class="modal fade bd-example-modal-lg" id="newModal" tabindex="-1" role="dialog"
    aria-labelledby="testModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="testModalLabel">Время закончилось</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-task="<?php echo $_SESSION['task']->id; ?>"
                    data-user="<?php echo $_SESSION['user']->id; ?>" data-dismiss="modal" id="closeBtn">Закрыть
                </button>
            </div>
        </div>
    </div>
</div>
<?php
} else {
    $endTask = api::endTask($_SESSION['task']->id, $_SESSION['user']->id);
    ?>
    <div class="modal fade bd-example-modal-lg" id="newModal" tabindex="-1" role="dialog"
    aria-labelledby="testModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="testModalLabel">Тест пройден</h5>
            </div>
            <?php
            if ($_SESSION['type'] != '3') {


                echo '<div class="modal-body">
                <ul class="pagination justify-content-start" id="listPag"
                style="margin-bottom: 0px; padding-right: 0px; display: block;">
                <p class="font-weight-bold" style="margin-top: 6px; margin-bottom: 0px;">Вернуться к
                вопросу: </p>';
                $registr = api::collection('result', array('id' => $_SESSION['result']['id']));
                $i = 1;
                $question = 0;
                foreach ($registr['0']->registr_result as $obj) {
                    if ($question != $obj->question->id) {
                        echo '<button style ="color: green;" class="btn btn-editAnswer" data-id="' . $obj->id . '" data-answer="' . $obj->answer->id . '" data-position="' . $i . '" data-question="' . $obj->question->id . '">' . $i . '</button>';
                        $i++;
                    }
                    $question = $obj->question->id;
                }


                echo '</ul>

                </div>';
            };
            ?>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-task="<?php echo $_SESSION['task']->id; ?>"
                    data-user="<?php echo $_SESSION['user']->id; ?>" data-dismiss="modal" id="closeBtn">Закрыть
                </button>
            </div>
        </div>
    </div>
</div>
<?php
};
?>
<script>

    /*-----защита модалки от закрытия--------*/
    $('#newModal').modal({
        backdrop: 'static',
        keyboard: false
    });
</script>