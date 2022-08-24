<?php
session_start();
require_once('../classes/User.php');

$result = User::checkLogin();
if(!$result){
    $_SESSION['login_err'] = 'セッションが切れましたので、ログインし直してください。';
    header('Location: ../public/login_form.php');
    return;
}

$err = [];

$token = filter_input(INPUT_POST, 'csrf_token');
if(!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']){  //不正なリクエスト
    header('Location: ../public/login_form.php');
    return;
}
unset($_SESSION['csrf_token']);


if(!$name = filter_input(INPUT_POST, 'name')){
    $err['name'] = 'ユーザ名を記入してください。';
} elseif(($name !== $_SESSION['login_user']['name']) && (User::checkUserByName($name))){
    $err['name'] = 'ユーザ名が既に使われています。';
}

$password=filter_input(INPUT_POST, 'password');

if(!preg_match("/\A[a-z\d]{8,100}+\z/i", $password)){   //正規表現
    $err['password'] = 'パスワードは英数字8文字以上100字以下にしてください。';
}

$password_conf=filter_input(INPUT_POST, 'password_conf');
if(!$password_conf === $password){
    $err['password_conf'] = '確認用パスワードと異なっています。';
}

if(count($err) === 0){
    $hasCreated = User::updateUser($_POST);

    if(!$hasCreated){
        $err[] = '再登録に失敗しました。';
    } elseif(!User::login($name, $password)){ //セッションユーザ書き換え
        $err[] =  $_SESSION['msg'];
        $err[] .= '再登録に失敗しました。';
        unset($_SESSION['msg']);
    }
} else{
    $_SESSION['update_err'] = $err;
    header('Location: ../public/update_form.php');
    return;
}

$_SESSION['update_err'] = $err;
header('Location: ../public/update_complete.php');
return;
?>