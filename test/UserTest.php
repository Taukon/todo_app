<?php declare(strict_types=1);
ob_start();
session_start();
use PHPUnit\Framework\TestCase;
use Taukon\TodoApp\Classes\User;

final class UserTest extends TestCase{

    public function testCheckUserByName成功(){
        $this->assertSame(true, User::checkUserByName('testuser'));
    }

    public function testCheckUserByName失敗(){
        $this->assertSame(false, User::checkUserByName('php_test'));
    }

    public function testLogin成功(){
        $this->assertSame(true, User::login('testuser','testuser'));
    }

    public function testLogin失敗(){
        $this->assertSame(false, User::login('testuser','testtesttest'));
    }

    public function testCheckLogin成功(){
        User::login('testuser','testuser');
        $this->assertSame(true, User::checkLogin());
    }

    public function testCheckLogin失敗(){
        $arr = ['id' => '100',
                'name' => 'testuser',
                'password' => 'testuser'];
        $_SESSION['login_user'] = $arr;
        $this->assertSame(false, User::checkLogin());
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