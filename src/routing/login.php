<?php
session_start();
require_once("../../vendor/autoload.php");
use Taukon\TodoApp\Classes\User;


$err = [];

if(!$name = filter_input(INPUT_POST, 'name')){
    $err['name'] = 'ユーザ名を記入してください。';
}

if(!$password=filter_input(INPUT_POST, 'password')){
    $err['password'] = 'パスワードを記入してください。';
}

if(count($err) > 0){
    $_SESSION = $err;
    header('Location: ../public/login_form.php');
    return;
}

$result = User::login($name, $password);

if(!$result){
    header('Location: ../public/login_form.php');
    return;
}

header('Location: ../public/login_complete.php');
return;
?>
