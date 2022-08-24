<?php
session_start();
require_once('../classes/User.php');
require_once('../classes/Utils.php');

if(!isset($_SESSION['signup_err'])){
    header('Location: login_form.php');
    return;
}

$err = $_SESSION['signup_err'];
unset($_SESSION['signup_err']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザ登録完了画面</title>

    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="//cdn.rawgit.com/necolas/normalize.css/master/normalize.css">
    <link rel="stylesheet" href="//cdn.rawgit.com/milligram/milligram/master/dist/milligram.min.css">
</head>
<body class="container">
<?php if(count($err) > 0) : ?>
    <?php foreach($err as $e) : ?>
        <p><?php echo Utils::h($e) ?></p>
    <?php endforeach ?>

<?php else :  ?>    
<p>ユーザ登録が完了しました。</p>
<?php endif ?>
<a href="login_form.php">ログイン画面へ</a>
</body>
</html>