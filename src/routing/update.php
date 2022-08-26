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


$token = filter_input(INPUT_POST, 'csrf_token');
if(!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']){  //不正なリクエスト
    header('Location: ../Public/login_form.php');
    return;
}
unset($_SESSION['csrf_token']);


$err = User::validateUpdate($_POST);

if(count($err) === 0){
    $hasCreated = User::updateUser($_POST);

    if(!$hasCreated){
        $err[] = '再登録に失敗しました。';
    } elseif(!User::login($_POST['name'], $_POST['password'])){ //セッションユーザ書き換え
        $err[] =  $_SESSION['msg'];
        $err[] .= '再登録に失敗しました。';
        unset($_SESSION['msg']);
    }
} else{
    $_SESSION['update_err'] = $err;
    header('Location: ../Public/update_form.php');
    return;
}

$_SESSION['update_err'] = $err;
header('Location: ../Public/update_complete.php');
return;
?>