<?php
session_start();
require_once('../class/User.php');
require_once('../class/Utils.php');

$result = User::checkLogin();
if($result){
    header('Location: mypage.php');
    return;
}

$csrf_token = Utils::setToken();

$signup_err = isset($_SESSION['signup_err']) ? $_SESSION['signup_err'] : null;
unset($_SESSION['signup_err']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザ登録画面</title>

    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="//cdn.rawgit.com/necolas/normalize.css/master/normalize.css">
    <link rel="stylesheet" href="//cdn.rawgit.com/milligram/milligram/master/dist/milligram.min.css">
</head>
<body class="container">
    <h2>ユーザ登録フォーム</h2>
    <form action="../routing/register.php" method="POST">
    <p>
        <label for="name">ユーザ名：</label>
        <input type="text" name="name">
        <?php if(isset($signup_err['name'])) : ?>
            <p><?php echo Utils::h($signup_err['name']) ?></p>
        <?php endif; ?>
    </p>
    <p>
        <label for="password">パスワード：</label>
        <input type="password" name="password">
        <?php if(isset($signup_err['password'])) : ?>
            <p><?php echo Utils::h($signup_err['password']) ?></p>
        <?php endif; ?>
    </p>
    <p>
        <label for="password_conf">パスワード確認：</label>
        <input type="password" name="password_conf">
        <?php if(isset($signup_err['password_conf'])) : ?>
            <p><?php echo Utils::h($signup_err['password_conf']) ?></p>
        <?php endif; ?>
    </p>
    <input type="hidden" name="csrf_token" value="<?php echo Utils::h($csrf_token) ?>">
    <p>
        <input type="submit" value="新規登録">
    </p>
    </form>
    <a href="login_form.php">ログインする</a>
</body>
</html>