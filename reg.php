<?php
    require_once('db.php');
    $db = new DB('78.24.223.43','project', 'project_user', '9A1p6S0b');
    function reg($login, $pass, $role, $db){
        $login = base64_encode($login);
        $pass = base64_encode($pass);
        $a = $db -> query("INSERT INTO users (login, pass_h, role) VALUES (FROM_BASE64('$login'), FROM_BASE64('$pass'), $role)");
        if($a) $a = $db -> query("SELECT login FROM users WHERE login = FROM_BASE64('$login') AND pass_h = FROM_BASE64('$pass')"); else return false;
        if(count($a)) return true; else return false;
    }
    if(isset($_GET['login']) && isset($_GET['pass_h']) && isset($_GET['role']) && ($_GET['role'] === '0' || $_GET['role'] === '1')){
        echo json_encode([
            'res' => reg($_GET['login'], $_GET['pass_h'], $_GET['role'], $db)
        ]);
    }
?>