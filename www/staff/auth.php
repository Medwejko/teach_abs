<!Doctype html>
<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/system/config.php';
?>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Тестирование и оценка1</title>
  <link rel="icon" type="image/png" sizes="32x32" href="png/logo 32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="png/logo 16x16.png">
  <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/sign-in/">

  <!-- Bootstrap core CSS -->
  <link href="https://getbootstrap.com/docs/4.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>
  <!-- Custom styles for this template -->
  <link href="https://getbootstrap.com/docs/4.3/examples/sign-in/signin.css" rel="stylesheet">
</head>
<body class="text-center" style="background-image: url(png/Background.png); background-repeat: no-repeat; background-size: 100% 100%;">
  <form class="form-signin" action="system/app.php" >
    <div class="card" style="width: 18rem;">
      <div class="card-header">
        <?php
        if (isset($_REQUEST['token']) and $_REQUEST['token'] != '') {
          $sql = "SELECT `user` FROM `registr_task` WHERE `token` = :token"; 
          $param = array('token'=>$_REQUEST['token']);
          $login = db::init()->getObj($sql, $param);
          main::printr($task);
          $_SESSION['user'] = new user(array('id'=>$login->user));
          $task = $_REQUEST['task'];
          header('Location: ../user_interface.php?task=' . $task);

        }
        elseif(isset($_REQUEST['error']))
        {
          switch ($_REQUEST['error']) 
          {
            case '1':
            echo '<h5 class="card-title">Не правильный логин или пароль. Попробуйте еще раз.</h5>';
            break;

            default:
            echo '<h5 class="card-title">Не правильный логин или пароль. Попробуйте еще раз.</h5>';
            break;
          }
        }
        else
        {
          echo '<h5 class="card-title">Тестирование и оценка персонала</h5>';
        };
        ?>

      </div>
      <ul class="list-group list-group-flush" style="padding-left: 10px; padding-right: 10px;">
        <input type="text" id="inputEmail" class="form-control" placeholder="Имя пользователя" required="" autofocus="" name="login">
        <input style="margin-bottom: 10px; margin-top: 10px;" type="password" id="inputPassword" class="form-control" placeholder="Пароль" required="" name="password">
        <button style="margin-bottom: 10px;" class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
        <input type="hidden" name="query" value="auth">
      </ul>
    </div>
  </form>
</body>
</html>