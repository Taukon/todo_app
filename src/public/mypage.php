<?php
session_start();
require_once("../../vendor/autoload.php");
use Taukon\TodoApp\Classes\User;
use Taukon\TodoApp\Classes\Todo;
use Taukon\TodoApp\Classes\Utils;

$result = User::checkLogin();
if(!$result){
    $_SESSION['login_err'] = 'ログインしてください';
    header('Location: login_form.php');
    return;
}

$login_user = $_SESSION['login_user'];

$err = isset($_SESSION['todo_err']) ? $_SESSION['todo_err'] : [];
unset($_SESSION['todo_err']);

$csrf_token = Utils::setToken();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>

    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="//cdn.rawgit.com/necolas/normalize.css/master/normalize.css">
    <link rel="stylesheet" href="//cdn.rawgit.com/milligram/milligram/master/dist/milligram.min.css">
</head>
<body class="container">
    
<table class="table table-striped">
    <td>
        <p>ログインユーザ：<?php echo Utils::h($login_user['name']) ?></P>
    </td>
    <td>
        <form action="update_form.php" >
            <input type="submit" value="再登録">
        </form>
    </td>
    <td>
        <form action="../Routing/logout.php" method="POST">
            <input type="submit" name="logout" value="ログアウト">
        </form>
    </td>
</table>

<h2>Todo</h2>
<?php if(count($err) > 0) : ?>
    <?php foreach($err as $e) : ?>
        <p><?php echo Utils::h($e) ?></p>
    <?php endforeach ?>
<?php endif ?>
    <form action="../Routing/todo.php" method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo Utils::h($csrf_token) ?>">
        <input type="text" name="title" >
        <input type="submit" value="Add">
    </form>

<h3>Current Todos</h3>
    <table class="table table-striped">
        <therad><th>Task</th></therad>
        <tbody>
<?php
$list = Todo::getAllTodo();
foreach($list as $row) : 
?>
            <tr>
                <td><?php echo Utils::h($row['title']) ?></td>
                <td>
                    <form method="post" action="../Routing/todo.php">
                        <button type="submit" name="delete">Delete</button>
                        <input type="hidden" name="id" value="<?php echo Utils::h($row['id']) ?>">
                        <input type="hidden" name="csrf_token" value="<?php echo Utils::h($csrf_token) ?>">
                        <input type="hidden" name="delete" value="true">
                    </form>
                </td>
            </tr>
<?php endforeach ?>
        </tbody>
            </table>

</body>
</html>