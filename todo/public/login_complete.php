<?php
session_start();
require_once('../class/User.php');

$result = User::checkLogin();
if(!$result){
    $_SESSION['login_err'] = 'ログインしてください';
    header('Location: login_form.php');
    return;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン完了</title>

    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="//cdn.rawgit.com/necolas/normalize.css/master/normalize.css">
    <link rel="stylesheet" href="//cdn.rawgit.com/milligram/milligram/master/dist/milligram.min.css">
</head>
<body class="container">
<h2>ログイン完了</h2>

<p>ログインしました。</p>

<a href="mypage.php">マイページへ</a>
</body>
</html>