<html class="main-page login-page">
<head>
</head>
<body>
<form id="login">
    <input name="login" placeholder="Ваш логин"/>
    <input name="pass" type="password" placeholder="Ваш пароль"/>
    <input type="submit" value="Вход"/>
</form>
Или
<form id="register">
    <input name="login" placeholder="Придумайте логин"/>
    <input name="pass" type="password" placeholder="Придумайте пароль"/>
    <select name="role">
        <option value="0">Пациент</option>
        <option value="1">Врач</option>
    </select>
    <input type="submit" value="Регистрация"/>
</form>
<!-- Должен быть в самом конце -->
<script src="app.js"></script>
</body>
</html>