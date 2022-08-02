<?php
require_once(__DIR__ . '/../../todo/class/User.php');

class test extends User{
    public static function getUserByName($name){
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

    public static function login($name, $password){
        $result = false;
        $user = self::getUserByName($name);

        if(!$user){
            $_SESSION['msg'] = 'ユーザ名が一致しません。';
            return $result;
        }

        if(password_verify($password, $user['password'])){
            //session_regenerate_id(true); //for session hijack
            $_SESSION['login_user'] = $user;
            $result = true;
            return $result;
        }
        $_SESSION['msg'] = 'パスワードが一致しません。';
        return $result;
    }
}
?>