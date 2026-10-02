<?php
require 'includes/bootstrap.php';
require_login();
$page_title = 'Личный кабинет';
$favoriteIds = favorite_ids($pdo);
$s = $pdo->prepare('SELECT p.* FROM properties p JOIN favorites f ON f.property_id=p.id WHERE f.user_id=? AND p.status=\'active\' ORDER BY f.created_at DESC');
$s->execute([user()['id']]);
$properties = $s->fetchAll();
require 'includes/header.php';
?>
<main class="container section account-page">
  <section class="account-welcome">
    <div class="account-welcome-copy">
      <p class="eyebrow">ЛИЧНОЕ ПРОСТРАНСТВО NESTA</p>
      <h1>Рады видеть вас снова</h1>
      <p>Сохраняйте дома, сравнивайте варианты и возвращайтесь к поиску в удобное время.</p>
      <a class="button" href="catalog.php">Продолжить поиск <span aria-hidden="true">→</span></a>
    </div>
    <div class="account-welcome-note"><span>01 / NESTA</span><p>Дом начинается<br>с вашего выбора.</p></div>
  </section>

  <section class="account-info" aria-label="Информация об аккаунте">
    <div><span>Ваш аккаунт</span><strong>Личный профиль</strong></div>
    <div><span>Email для входа</span><strong><?=e(user()['email'])?></strong></div>
    <div><span>Сохранено объектов</span><strong><?=count($properties)?></strong></div>
    <a class="account-logout" href="logout.php">Выйти из аккаунта</a>
  </section>

  <section class="account-favorites">
    <div class="section-head"><div><p class="eyebrow">ВАША ПОДБОРКА</p><h2>Избранные дома</h2></div><a class="text-link" href="favorites.php">Открыть избранное →</a></div>
    <?php if ($properties): ?>
      <div class="property-grid"><?php foreach($properties as $p) require 'includes/property-card.php'; ?></div>
    <?php else: ?>
      <div class="empty account-empty"><span class="empty-mark" aria-hidden="true">♡</span><h3>Здесь появятся дома, которые вам понравились</h3><p>Нажмите на сердечко в карточке, чтобы сохранить объект и быстро вернуться к нему.</p><a class="button" href="catalog.php">Посмотреть каталог</a></div>
    <?php endif; ?>
  </section>
</main>
<?php require 'includes/footer.php'; ?>
