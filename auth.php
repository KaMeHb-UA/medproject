<?php
    require_once('db.php');
    $db = new DB('78.24.223.43','project', 'project_user', '9A1p6S0b');
    function check_auth($salt, $db){
        $salt = base64_decode($salt);
        $pass_16 = base64_encode(substr($salt, 0, 16));
        $tmp = explode(':', substr($salt, 16));
        $login = $tmp[0];
        $ua = $tmp[1];
        if(count($db -> query("SELECT login FROM users WHERE login = FROM_BASE64('$login') AND pass_h LIKE CONCAT('%', FROM_BASE64('$pass_16'))"))){
            return true;
        } else return false;
    }
    function auth($login, $pass_h, $db, $ua){
        $login = base64_encode($login);
        $pass_h = base64_encode($pass_h);
        if(count($db -> query("SELECT login FROM users WHERE login = FROM_BASE64('$login') AND pass_h = FROM_BASE64('$pass_h')"))){
            return base64_encode(substr(base64_decode($pass_h), 16, 16) . $login . ':' . base64_encode($ua));
        } else return false;
    }
    if(isset($_GET['login']) && isset($_GET['pass_h']) && isset($_GET['ua'])){
        echo json_encode([
            'salt' => auth($_GET['login'], $_GET['pass_h'], $db, $_GET['ua'])
        ]);
    }
?>