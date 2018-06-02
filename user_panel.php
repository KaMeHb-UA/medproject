<?php
    require_once('db.php');
    require_once('auth.php');
    require_once('const.php');
    $db = new DB('78.24.223.43','project', 'project_user', '9A1p6S0b');
    $login = explode(':', substr(base64_decode($_COOKIE['salt']), 16))[0];
    if(check_auth($_COOKIE['salt'], $db)){
        $res = $db -> query("
            SELECT
                fn_meta.meta_value AS FN,
                sn_meta.meta_value AS SN,
                pn_meta.meta_value AS PN
            FROM users_meta AS fn_meta
            INNER JOIN users_meta AS sn_meta ON
                sn_meta.login = FROM_BASE64('$login') AND sn_meta.meta_name = 'sn'
            INNER JOIN users_meta AS pn_meta ON
                pn_meta.login = FROM_BASE64('$login') AND pn_meta.meta_name = 'pn'

                AND
                fn_meta.login = FROM_BASE64('$login') AND fn_meta.meta_name = 'fn'
        ");
        if(count($res)){ // count($res) === 0 <==> query not found all of this
            $res = $res[0];
            echo "Привет, $res[SN] $res[FN] $res[PN]";
        } else {
            header('Location: ' . SITE_ROOT . 'prelogin.php');
            die();
        }
    } else die('Хакер, что-ль?');
?>
<html class="user-panel">
<head>
</head>
<body>
<!-- Должен быть в самом конце -->
<script src="app.js"></script>
</body>
</html>