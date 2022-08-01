<?php

class Utils{
    
    /**
     * XSS対策
     * @param string $str
     * @return string 処理された文字列
     */
    public static function h($str){
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }

    /**
     * CSRF対策
     * @param void
     * @return string $csrf_token
     */
    public static function setToken(){
        $csrf_token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $csrf_token;

        return $csrf_token;
    }

}
?>