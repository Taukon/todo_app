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

    public function testValidateLogin成功(){
        $arr = [
                'name' => 'testuser',
                'password' => 'testuser'];
        $err = [];
        $this->assertSame($err, User::validateLogin($arr));
    }

    public function testValidateLogin失敗(){
        $arr = [
                'name' => '',
                'password' => ''
            ];
        $err = [
            'name' => 'ユーザ名を記入してください。',
                'password' => 'パスワードを記入してください。'
            ];
        $this->assertSame($err, User::validateLogin($arr));
    }

    public function testValidateUser成功(){
        $arr = [
                'name' => 'testvalidateuser',
                'password' => 'testvalidateuser12',
                'password_conf' => 'testvalidateuser12'
            ];
        $err = [];
        $this->assertSame($err, User::validateUser($arr));
    }

    public function testValidateUser失敗_ユーザ名がすでに使用済みとパスワードエラー(){
        $arr = [
                'name' => 'testuser',
                'password' => 'test',
                'password_conf' => 'testtest'
            ];
        $err = [
                'name' => 'ユーザ名が既に使われています。',
                'password' => 'パスワードは英数字8文字以上100字以下にしてください。',
                'password_conf' => '確認用パスワードと異なっています。'
            ];
        $this->assertSame($err, User::validateUser($arr));
    }

    public function testValidateUser失敗_ユーザ名なしとパスワード成功(){
        $arr = [
                'name' => '',
                'password' => '123456789',
                'password_conf' => '123456789'
            ];
        $err = ['name' => 'ユーザ名を記入してください。'];
        $this->assertSame($err, User::validateUser($arr));
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