<?php
session_start();
require_once("../../vendor/autoload.php");
use Taukon\TodoApp\Classes\User;
use Taukon\TodoApp\Classes\Todo;

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

$_SESSION['todo_err'] = Todo::validateTodo($_POST);
header('Location: ../Public/mypage.php');
return;

?>