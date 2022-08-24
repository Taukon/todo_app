<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use Taukon\TodoApp\Classes\User;

final class UserTest extends TestCase{

    public function testCheckUserByName成功(){
        $this->assertSame(true, User::checkUserByName('testuser'));
    }

    public function testCheckUserByName失敗(){
        $this->assertSame(false, User::checkUserByName('php_test'));
    }
}