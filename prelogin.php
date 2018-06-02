<?php
        require_once('db.php');
        require_once('auth.php');
        require_once('const.php');
        $db = new DB('78.24.223.43','project', 'project_user', '9A1p6S0b');
        $login = explode(':', substr(base64_decode($_COOKIE['salt']), 16))[0];
        if(check_auth($_COOKIE['salt'], $db)){
            $res = $db -> query("SELECT role FROM users WHERE login = FROM_BASE64('$login')");
        } else die('Хакер, что-ль?');
        if(count($res) && $res[0]['role'] == '1') $role = 1; else $role = 0;
        function check0($params, $arr){
            $checked = [];
            foreach($params as $what) $checked[$what] = false;
            foreach($arr as $key => $val) if(isset($checked[$key]) && $val !== '') $checked[$key] = true;
            $res = true;
            foreach($checked as $val) $res = $res && $val;
            return $res;
        }
        $to_check = [
            'fn',
            'sn',
            'pn',
            'birthday',
            'sex',
        ];
        $to_check0 = [
            'ih',
            'in',
            'bg',
            'br',
        ];
        $to_check1 = [
            'spec',
            'wc',
            'ed',
        ];
        if($role) $to_check = array_merge($to_check, $to_check1); else $to_check = array_merge($to_check, $to_check0);
        if(check0($to_check, $_REQUEST)){
            $sql = 'INSERT INTO users_meta (login, meta_name, meta_value) VALUES (';
            foreach($to_check as $i => $key){
                if ($i) $sql .= ", (";
                $sql .= "FROM_BASE64('$login'), FROM_BASE64('" . base64_encode($key) . "'), FROM_BASE64('" . base64_encode($_REQUEST[$key]) . "'))";
            }
            if(!$role){
                if(isset($_REQUEST['al']) && $_REQUEST['al'] !== '') $sql .= ", (FROM_BASE64('$login'),FROM_BASE64('" . base64_encode('al') . "'),FROM_BASE64('" . base64_encode($_REQUEST['al']) . "'))";
                if(isset($_REQUEST['ai']) && $_REQUEST['ai'] !== '') $sql .= ", (FROM_BASE64('$login'),FROM_BASE64('" . base64_encode('ai') . "'),FROM_BASE64('" . base64_encode($_REQUEST['ai']) . "'))";
            }
            $db -> query($sql);
            header('Location: ' . SITE_ROOT . 'user_panel.php');
        }
?>
<html class="prelogin-page">
<head>
</head>
<body>
Внесите, пожалуйста, дополнительные данные о себе.
<form id="metadata">
    <input name="sn" placeholder="Фамилия" required/><br/>
    <input name="fn" placeholder="Имя" required/><br/>
    <input name="pn" placeholder="Отчество" required/><br/>
    Дата рождения: <input name="birthday" type="date"/><br/>
    <select name="sex" required>
        <option selected value="0">Мужской</option>
        <option value="1">Женский</option>
    </select><br/>
    <?php
        if($role){ ?>
            
    <select name="spec" required>
        <option selected value="офтальмолог">Аллерголог-иммунолог</option>
        <option value="венеролог">Анестезиолог</option>
        <option value="гинеколог">Венеролог</option>
        <option value="лор">Гастроэнтеролог</option>
		<option value="лор">Гепатолог</option>
		<option value="лор">Гинеколог</option>
		<option value="лор">Госпитализация</option>
		<option value="лор">Дерматолог</option>
		<option value="лор">Диетолог</option>
		<option value="лор">Инфекционист</option>
		<option value="лор">Кардиолог</option>
		<option value="лор">Косметолог</option>
		<option value="лор">ЛОР-врач</option>
		<option value="лор">Маммолог</option>
		<option value="лор">Мануальный терапевт</option>
		<option value="лор">Нарколог</option>
		<option value="лор">Невролог</option>
		<option value="лор">Неонатолог</option>
		<option value="лор">Нефролог</option>
		<option value="лор">Онколог</option>
		<option value="лор">Офтальмолог</option>
		<option value="лор">Педиатр</option>
		<option value="лор">Пластический хирург</option>
		<option value="лор">Проктолог</option>
		<option value="лор">Психиатр</option>
		<option value="лор">Психолог</option>
		<option value="лор">Реабилитолог</option>
		<option value="лор">Репродуктолог</option>
		<option value="лор">Сексолог</option>
		<option value="лор">Сомнолог</option>
		<option value="лор">Сосудистый хирург</option>
		<option value="лор">Спортивный врач</option>
		<option value="лор">Стоматолог</option>
		<option value="лор">Терапевт</option>
		<option value="лор">Травматолог-ортопед</option>
		<option value="лор">Уролог</option>
		<option value="лор">Физиотерапевт</option>
		<option value="лор">Флеболог</option>
		<option value="лор">Хирург</option>
		<option value="лор">Эндокринолог</option>
    </select><br/>
    <input name="wc" type="number" placeholder="Опыт работы (лет)" required/><br/>
    <input name="ed" placeholder="Образование" required/><br/>

  <?php } else { ?>

    <textarea name="ih" placeholder="История болезней" required></textarea><br/>
    <textarea name="in" placeholder="Жалобы на здоровье" required></textarea><br/>
    <input name="al" placeholder="Аллергии"/><br/>
    <input name="ai" placeholder="Хронические болезни"/><br/>
    Группа крови: <select name="bg" required>
        <option selected value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
    </select>, резус-фактор: <select name="br" required>
        <option selected value="+">+</option>
        <option value="-">-</option>
    </select>

      <?php
        }
    ?><br/>
    <input type="submit" value="Сохранить"/>
</form>
<!-- Должен быть в самом конце -->
<script src="app.js"></script>
</body>
</html>