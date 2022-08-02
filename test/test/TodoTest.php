<?php
session_start();
require_once(__DIR__ . '/../../todo/class/Todo.php');
require_once(__DIR__ . '/test.php');

use PHPUnit\Framework\TestCase;


class TodoTest extends TestCase{

    public function testCreateTodo(){
        test::login('testuser','testuser');

        $todo = new Todo();
        //$todoData[] = ['title' => 'phpunitのテスト'];
        $todoData['title'] =  'phpunitのテスト';
        $this->assertSame(true, $todo->createTodo($todoData));

        //test::logout();
        $_SESSION = array();
    }

    public function testGetAllTodo(){
        test::login('testuser','testuser');

        $todo = new Todo();
        $this->assertNotSame(false, $todo->getAllTodo());

        //test::logout();
        $_SESSION = array();
    }

    /**
     * @depends testGetAllTodo
     */
    public function testCheckTodoById(){
        test::login('testuser','testuser');

        $todo = new Todo();
        $array = $todo->getAllTodo();
        //$task = array_shift($array);

        $task = end($array);

        $this->assertSame(true, $todo->checkTodoById($task['id']));
        //$this->assertSame(true, $todo->checkTodoById(4));

        //test::logout();
        $_SESSION = array();
    }

    /**
     * @depends testCheckTodoById
     */
    public function testDeleteTodo(){
        test::login('testuser','testuser');

        $todo = new Todo();
        $array = $todo->getAllTodo();
        //$task = array_shift($array);
        $task = end($array);

        $this->assertSame(true, $todo->deleteTodo($task['id']));

        //test::logout();
        $_SESSION = array();
    }
}

?>