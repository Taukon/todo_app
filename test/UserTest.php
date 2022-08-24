<?php
session_start();
require_once(__DIR__ . '/../../todo/class/User.php');
require_once(__DIR__ . '/test.php');

use PHPUnit\Framework\TestCase;


class UserTest extends TestCase {

    public function testGetUserByName()
    {
        $arr = 'testuser';
        $this->assertCount(6, test::getUserByName($arr));
    }

    /**
     * @depends testGetUserByName
     */
    public function testLogin()
    {
        $name = 'testuser';
        $password = 'testuser';
        $this->assertSame(true, test::login($name, $password));
        $_SESSION = array();
    }


    /**
     * @depends testGetUserByName
     */
    public function testUpdateUser()
    {
        $user = new User();
        $arr = ['name' => 'testuser',
                'password' => 'testuser'];

        $testuser = test::getUserByName('testuser');
        $_SESSION['login_user'] = $testuser;

        $this->assertSame(true, $user->updateUser($arr));
        $_SESSION = array();
    }


    /**
     * @depends testGetUserByName
     */
    public function testCheckUserByName()
    {
        $user = new User();
        $this->assertSame(true, $user->checkUserByName('testuser'));
        $this->assertSame(false, $user->checkUserByName('php_test'));
    }


    /**
     * @depends testGetUserByName
     */
    public function testCheckLogin()
    {
        $user = new User();
        $testuser = test::getUserByName('testuser');
        $_SESSION['login_user'] = $testuser;

         $this->assertSame(true, $user->checkLogin());
         $_SESSION = array();

         $arr = ['id' => '100',
                'name' => 'testuser',
                'password' => 'testuser'];
         $_SESSION['login_user'] = $arr;
         $this->assertSame(false, $user->checkLogin());
         $_SESSION = array();
    }

    /*
    public function testCreateUser()
    {
        $user = new User();
        $arr = ['name' => 'phpUnit',
                'password' => 'phpUnit'];

        $this->assertSame(true, $user->createUser($arr));
    }*/
}

?>