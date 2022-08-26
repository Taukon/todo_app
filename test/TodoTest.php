<?php declare(strict_types=1);
session_start();
use PHPUnit\Framework\TestCase;
use Taukon\TodoApp\Classes\Todo;

final class TodoTest extends TestCase{
    
    public function testvalidateTodo成功_create(){
        $_SESSION['login_user']['id'] = 11;

        $arr = [
            'title' => 'testvalidateTodo'
        ];
        $err = [];
        $this->assertSame($err, Todo::validateTodo($arr));
    }

    public function testvalidateTodo成功_delete(){
        $_SESSION['login_user']['id'] = 11;
        $todo = Todo::getAllTodo();
        $id = $todo[count($todo)-1]['id'];

        $arr = [
            'delete' => true,
            'id' => $id
        ];
        $err = [];
        $this->assertSame($err, Todo::validateTodo($arr));
    }

    public function testvalidateTodo失敗_deleteエラー(){
        $arr = [
            'delete' => true,
            'id' => 10000
        ];
        $err = [
            'タスクを削除できませんでした。'
        ];
        $this->assertSame($err, Todo::validateTodo($arr));
    }

    protected function tearDown(): void
    {
        $_SESSION = array();
    }

    public static function tearDownAfterClass(): void
    {
        session_destroy();
    }
}