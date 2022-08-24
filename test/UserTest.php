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

    protected function tearDown(): void
    {
        $_SESSION = array();
    }

    public static function tearDownAfterClass(): void
    {
        session_destroy();
    }
}