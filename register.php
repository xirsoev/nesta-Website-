<?php
require 'includes/bootstrap.php';
if (logged_in()) { header('Location: account.php'); exit; }
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_ok()) $errors[] = 'Некорректный запрос.';
    $name = trim($_POST['name'] ?? '');
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $pass = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';
    if (!$name) $errors[] = 'Укажите имя.';
    if (!$email) $errors[] = 'Введите корректный email.';
    if (strlen($pass) < 8) $errors[] = 'Пароль должен содержать не менее 8 символов.';
    if ($pass !== $confirm) $errors[] = 'Пароли не совпадают.';
    if (!$errors) {
        $query = $pdo->prepare('SELECT id FROM users WHERE email=?'); $query->execute([$email]);
        if ($query->fetch()) $errors[] = 'Этот email уже зарегистрирован.';
        else { $query = $pdo->prepare('INSERT INTO users(name,email,password,role) VALUES(?,?,?,"user")'); $query->execute([$name, $email, password_hash($pass, PASSWORD_DEFAULT)]); $_SESSION['user'] = ['id'=>(int)$pdo->lastInsertId(), 'name'=>$name, 'email'=>$email, 'role'=>'user']; header('Location: account.php'); exit; }
    }
}
$page_title = 'Регистрация';
require 'includes/header.php';
?>
<main class="auth-wrap"><form class="auth-card" method="post" novalidate><p class="eyebrow">Добро пожаловать в NESTA</p><h1>Создать аккаунт</h1><?php foreach($errors as $error): ?><p class="error"><?=e($error)?></p><?php endforeach ?><input type="hidden" name="csrf" value="<?=csrf()?>"><label>Имя<input required name="name" value="<?=e($_POST['name']??'')?>"></label><label>Email<input required type="email" name="email" value="<?=e($_POST['email']??'')?>"></label><label>Пароль<span class="password-field"><input required type="password" name="password"><button type="button" class="toggle-password" aria-label="Показать пароль">◉</button></span></label><label>Повторите пароль<span class="password-field"><input required type="password" name="confirm_password"><button type="button" class="toggle-password" aria-label="Показать пароль">◉</button></span></label><button class="block">Создать аккаунт</button><p>Уже есть аккаунт? <a href="login.php">Войти</a></p></form></main>
<?php require 'includes/footer.php'; ?>
