<?php
namespace Taukon\TodoApp\Classes;
use Taukon\TodoApp\Classes\Dbc;

class User extends Dbc{

    /**
     * ユーザを登録する
     * @param array $userData
     * @return bool $result
     */
    public static function createUser($userData){
        $result = false;
        $sql = 'INSERT INTO users (name, password) 
                    VALUES (?, ?)';
        $arr = [];
        $arr[] = $userData['name'];
        $arr[] = password_hash($userData['password'], PASSWORD_DEFAULT);

        $dbh = parent::dbConnect();
        $dbh->beginTransaction();
        try{
            $stmt = $dbh->prepare($sql);
            $result = $stmt->execute($arr);
            $dbh->commit();
            return $result;
        } catch(\EXception $e){
            $dbh->rollBack();
            return $result;
        }
    }

    /**
     * ユーザ登録のバリデーションチェック
     * @param array $data
     * @return array $err
     */
    public static function validateUser($data){
        $err = [];

        if(!$data['name']){
            $err['name'] = 'ユーザ名を記入してください。';
        } elseif(User::checkUserByName($data['name'])){
            $err['name'] = 'ユーザ名が既に使われています。';
        }

        if(!preg_match("/\A[a-z\d]{8,100}+\z/i", $data['password'])){   //正規表現
            $err['password'] = 'パスワードは英数字8文字以上100字以下にしてください。';
        }

        if(!($data['password_conf'] === $data['password'])){
            $err['password_conf'] = '確認用パスワードと異なっています。';
        }

        return $err;
    }

    /**
     * ユーザを再登録する
     * @param array $userData
     * @return bool $result
     */
    public static function updateUser($userData){
        $result = false;
        $sql = 'UPDATE users SET
                    name = ?, password = ? 
                WHERE id = ?';

        $arr = [];
        $arr[] = $userData['name'];
        $arr[] = password_hash($userData['password'], PASSWORD_DEFAULT);
        $arr[] = $_SESSION['login_user']['id'];

        $dbh = parent::dbConnect();
        $dbh->beginTransaction();
        try{
            $stmt = $dbh->prepare($sql);
            $result = $stmt->execute($arr);
            $dbh->commit();
            return $result;
        } catch(\EXception $e){
            $dbh->rollBack();
            return $result;
        }
    }

    /**
     * 再登録時のバリデーションチェック
     * @param array $data
     * @return array $err
     */
    public static function validateUpdate($data){
        $err = [];

        if(!$data['name']){
            $err['name'] = 'ユーザ名を記入してください。';
        } elseif(($data['name'] !== $_SESSION['login_user']['name']) && (User::checkUserByName($data['name']))){
            $err['name'] = 'ユーザ名が既に使われています。';
        }

        if(!preg_match("/\A[a-z\d]{8,100}+\z/i", $data['password'])){   //正規表現
            $err['password'] = 'パスワードは英数字8文字以上100字以下にしてください。';
        }

        if(($data['password_conf'] !== $data['password'])){
            $err['password_conf'] = '確認用パスワードと異なっています。';
        }

        return $err;
    }

    /**
     * ログインのバリデーションチェック
     * @param array $logindata
     * @return array $err
     */
    public static function validateLogin($logindata){
        $err = [];

        if(!$logindata['name']){
            $err['name'] = 'ユーザ名を記入してください。';
        }

        if(!$logindata['password']){
            $err['password'] = 'パスワードを記入してください。';
        }

        return $err;
    }

    /**
     * ログイン処理
     * @param string $name
     * @param string $password
     * @return bool $result
     */
    public static function login($name, $password){
        $result = false;
        $user = self::getUserByName($name);

        if(!$user){
            $_SESSION['msg'] = 'ユーザ名が一致しません。';
            return $result;
        }

        if(password_verify($password, $user['password'])){
            session_regenerate_id(true); //for session hijack
            $_SESSION['login_user'] = $user;
            $result = true;
            return $result;
        }
        $_SESSION['msg'] = 'パスワードが一致しません。';
        return $result;
    }

    /**
     * ユーザ名からユーザを取得
     * @param string $name
     * @return array|bool $user|false
     */
    private static function getUserByName($name){
        $sql = 'SELECT * FROM users WHERE name = ?';
        $arr = [];
        $arr[] = $name;

        try{
            $stmt = parent::dbConnect()->prepare($sql);
            $result = $stmt->execute($arr);
            $user = $stmt->fetch();
            return $user;
        } catch(\EXception $e){
            return false;
        }
    }

    /**
     * ユーザ名が使われているかチェック
     * @param string $name
     * @return bool $result
     */
    public static function checkUserByName($name){
        $result = false;
        if(self::getUserByName($name)){
            $result = true;
        }
        return $result;
    }

    /**
     * ログインチェック
     * @param void
     * @return bool $result
     */
    public static function checkLogin(){
        $result = false;

        if(isset($_SESSION['login_user']) && $_SESSION['login_user']['id'] > 0){
            
            $user = self::getUserByName($_SESSION['login_user']['name']);
            if($user['id'] === $_SESSION['login_user']['id'] 
                && $user['password'] === $_SESSION['login_user']['password']){
                    $result = true;
            }
        }

        return $result;
    }

    /**
     * ログアウト処理
     * @param void
     */
    public static function logout(){
        $_SESSION = array();
        session_destroy();
    }

}

?>