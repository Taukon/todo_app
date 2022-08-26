<?php
session_start();
require_once("../../vendor/autoload.php");
use Taukon\TodoApp\Classes\User;



$err = User::validateLogin($_POST);

if(count($err) > 0){
    $_SESSION = $err;
    header('Location: ../Public/login_form.php');
    return;
}

$result = User::login($_POST['name'], $_POST['password']);

if(!$result){
    header('Location: ../Public/login_form.php');
    return;
}

header('Location: ../Public/login_complete.php');
return;
?>
