<?php
session_start();
require_once("../../vendor/autoload.php");
use Taukon\TodoApp\Classes\User;

$result = User::checkLogin();
if(!$result){
    $_SESSION['login_err'] = 'セッションが切れましたので、ログインし直してください。';
    header('Location: ../Public/login_form.php');
    return;
}

if(!$logout = filter_input(INPUT_POST, 'logout')){  //不正なリクエスト
    header('Location: ../Public/login_form.php');
    return;
}


User::logout();

header('Location: ../Public/logout_complete.html');
return;

?>