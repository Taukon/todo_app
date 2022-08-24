<?php
session_start();
require_once('../classes/User.php');

$result = User::checkLogin();
if(!$result){
    $_SESSION['login_err'] = 'セッションが切れましたので、ログインし直してください。';
    header('Location: ../public/login_form.php');
    return;
}

if(!$logout = filter_input(INPUT_POST, 'logout')){  //不正なリクエスト
    header('Location: ../public/login_form.php');
    return;
}


User::logout();

header('Location: ../public/logout_complete.html');
return;

?>