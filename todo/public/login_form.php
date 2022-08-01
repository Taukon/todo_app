<?php
session_start();
require_once('../class/User.php');
require_once('../class/Utils.php');

$result = User::checkLogin();
if($result){
    header('Location: mypage.php');
    return;
}

$login_err = isset($_SESSION['login_err']) ? $_SESSION['login_err'] : null;
unset($_SESSION['login_err']);

$err = $_SESSION;
$_SESSION = array();
session_destroy();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン画面</title>

    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="//cdn.rawgit.com/necolas/normalize.css/master/normalize.css">
    <link rel="stylesheet" href="//cdn.rawgit.com/milligram/milligram/master/dist/milligram.min.css">
</head>
<body class="container">
    <h2>ログインフォーム</h2>
    <?php if(isset($login_err)) : ?>
        <p><?php echo Utils::h($login_err) ?></p>
    <?php endif; ?>

    <?php if(isset($err['msg'])) : ?>
            <p><?php echo Utils::h($err['msg']) ?></p>
    <?php endif; ?>
    <form action="../routing/login.php" method="POST">
    <p>
        <label for="name">ユーザ名：</label>
        <input type="text" name="name">
        <?php if(isset($err['name'])) : ?>
            <p><?php echo Utils::h($err['name']) ?></p>
        <?php endif; ?>
    </p>
    <p>
        <label for="password">パスワード：</label>
        <input type="password" name="password">
        <?php if(isset($err['password'])) : ?>
            <p><?php echo Utils::h($err['password']) ?></p>
        <?php endif; ?>
    </p>

        <input type="submit" value="ログイン">
    </form>
    <a href="signup_form.php">新規登録はこちら</a>
</body>
</html>