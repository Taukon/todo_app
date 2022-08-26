<?php
session_start();
require_once("../../vendor/autoload.php");
use Taukon\TodoApp\Classes\User;


$token = filter_input(INPUT_POST, 'csrf_token');
if(!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']){  //不正なリクエスト
    header('Location: ../Public/login_form.php');
    return;
}

unset($_SESSION['csrf_token']);

$err = User::validateUser($_POST);

if(count($err) === 0){
    $hasCreated = User::createUser($_POST);
    if(!$hasCreated){
        $err[] = '登録に失敗しました。';
    }
} else {
    $_SESSION['signup_err'] = $err;
    header('Location: ../Public/signup_form.php');
    return;
}

$_SESSION['signup_err'] = $err;
header('Location: ../Public/signup_complete.php');
return;
?>
