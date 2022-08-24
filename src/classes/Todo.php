<?php
namespace Taukon\TodoApp\Classes;
use Taukon\TodoApp\Classes\Dbc;

class Todo extends Dbc{
    /**
     * Todoタスクを作成
     * @param array $todoData
     * @return bool $result
     */
    public static function createTodo($todoData){
        $result = false;
        $sql = 'INSERT INTO todos (title, userid) 
                    VALUES (?, ?)';
                    $arr = [];
                    $arr[] = $todoData['title'];
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
     * ユーザの全てのタスク取得
     * @param void
     * @return array $result
     */
    public static function getAllTodo(){
        $sql = 'SELECT * FROM todos where userid = ?';
        $arr = [];
        $arr[] = $_SESSION['login_user']['id'];

        $stmt = parent::dbConnect()->prepare($sql);
        $stmt->execute($arr);
        $result = $stmt->fetchall(\PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * タスクを削除
     * @param int $id
     * @return bool $result|false
     */
    public static function deleteTodo($id){
        $result = false;

        if(!self::checkTodoById($id)){
            return false;
        }

        $sql = 'DELETE FROM todos where id = ?';
        $arr = [];
        $arr[] = $id;

        $stmt = parent::dbConnect()->prepare($sql);
        $result = $stmt->execute($arr);
        return $result;
    }

    /**
     * idからタスクがあるかチェック
     * @param int $id
     * @return bool $result|false
     */
    public static function checkTodoById($id){

        $sql = 'SELECT * FROM todos where id = ?';
        $arr = [];
        $arr[] = $id;

        try{
            $stmt = parent::dbConnect()->prepare($sql);
            $result = $stmt->execute($arr);
            return $result;
        } catch(\EXception $e){
            return false;
        }
    }
}
?>