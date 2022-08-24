<?php
session_start();
require_once("../../vendor/autoload.php");
use Taukon\TodoApp\Classes\User;
use Taukon\TodoApp\Classes\Utils;


$result = User::checkLogin();
if(!$result){
    $_SESSION['login_err'] = 'セッションが切れましたので、ログインし直してください。';
    header('Location: login_form.php');
    return;
}

$csrf_token = Utils::setToken();

$user = $_SESSION['login_user']['name'];

$update_err = isset($_SESSION['update_err']) ? $_SESSION['update_err'] : null;
unset($_SESSION['update_err']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザ再登録画面</title>

    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="//cdn.rawgit.com/necolas/normalize.css/master/normalize.css">
    <link rel="stylesheet" href="//cdn.rawgit.com/milligram/milligram/master/dist/milligram.min.css">
</head>
<body class="container">
    <h2>ユーザ再登録フォーム</h2>
    <form action="../Routing/update.php" method="POST">
    <p>
        <label for="name">ユーザ名：</label>
        <input type="text" name="name" value="<?php echo Utils::h($user) ?>">
        <?php if(isset($update_err['name'])) : ?>
            <p><?php echo Utils::h($update_err['name']) ?></p>
        <?php endif; ?>
    </p>
    <p>
        <label for="password">パスワード：</label>
        <input type="password" name="password">
        <?php if(isset($update_err['password'])) : ?>
            <p><?php echo Utils::h($update_err['password']) ?></p>
        <?php endif; ?>
    </p>
    <p>
        <label for="password_conf">パスワード確認：</label>
        <input type="password" name="password_conf">
        <?php if(isset($update_err['password_conf'])) : ?>
            <p><?php echo Utils::h($update_err['password_conf']) ?></p>
        <?php endif; ?>
    </p>
    <input type="hidden" name="csrf_token" value="<?php echo Utils::h($csrf_token) ?>">
    <p>
        <input type="submit" value="再登録">
    </p>
    </form>
    <a href="mypage.php">戻る</a>
</body>
</html>