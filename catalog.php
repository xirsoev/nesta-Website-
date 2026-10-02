<?php
require 'includes/bootstrap.php';
$page_title = 'Каталог недвижимости';
$favoriteIds = favorite_ids($pdo);
$where = ["status='active'"];
$params = [];
$typeMap = ['Квартира'=>'Apartment','Дом'=>'House','Вилла'=>'Villa','Лофт'=>'Loft'];
foreach (['city'=>'city','type'=>'type'] as $q=>$col) {
    if (!empty($_GET[$q])) {
        $where[] = "$col LIKE ?";
        $value = trim($_GET[$q]);
        $params[] = '%'.($q==='type' ? ($typeMap[$value]??$value) : $value).'%';
    }
}
foreach (['min_price'=>['price','>='],'max_price'=>['price','<='],'rooms'=>['rooms','>='],'min_area'=>['area','>=']] as $q=>$rule) {
    if (isset($_GET[$q]) && $_GET[$q] !== '') {
        $where[] = "$rule[0] $rule[1] ?";
        $params[] = (float)$_GET[$q];
    }
}
$sort = ['new'=>'created_at DESC','cheap'=>'price ASC','expensive'=>'price DESC'][$_GET['sort']??'new'] ?? 'created_at DESC';
$st = $pdo->prepare('SELECT * FROM properties WHERE '.implode(' AND ',$where).' ORDER BY '.$sort);
$st->execute($params);
$properties = $st->fetchAll();
require 'includes/header.php';
?>
<main class="container section catalog-page">
  <div class="catalog-heading"><div><p class="eyebrow">ПОДБОРКА NESTA</p><h1>Дома и места для жизни</h1><p class="catalog-lead">Удобные фильтры, понятные характеристики и пространство для выбора без спешки.</p></div><div class="catalog-count"><strong><?=count($properties)?></strong><span>объектов<br>в подборке</span></div></div>
  <p class="listing-note">Параметры домов собраны по открытым объявлениям в Приморском крае. Точные адреса и контакты скрыты; фотографии — иллюстративные, цена и наличие могут измениться. <a href="https://realty.yandex.ru/primorskiy_kray/kupit/dom/" target="_blank" rel="noopener noreferrer">Источник объявлений ↗</a></p>
  <form class="filters" method="get"><input name="city" value="<?=e($_GET['city']??'')?>" placeholder="Регион / направление"><select name="type"><option value="">Все типы</option><?php foreach(['Квартира','Дом','Вилла','Лофт'] as $x): ?><option <?=$x===($_GET['type']??'')?'selected':''?>><?=$x?></option><?php endforeach ?></select><input type="number" name="min_price" value="<?=e($_GET['min_price']??'')?>" placeholder="Цена от"><input type="number" name="max_price" value="<?=e($_GET['max_price']??'')?>" placeholder="Цена до"><input type="number" name="rooms" value="<?=e($_GET['rooms']??'')?>" placeholder="Комнат от"><input type="number" name="min_area" value="<?=e($_GET['min_area']??'')?>" placeholder="Площадь от, м²"><select name="sort"><option value="new">Сначала новые</option><option value="cheap" <?=($_GET['sort']??'')==='cheap'?'selected':''?>>Сначала дешевле</option><option value="expensive" <?=($_GET['sort']??'')==='expensive'?'selected':''?>>Сначала дороже</option></select><button>Показать варианты <span aria-hidden="true">→</span></button></form>
  <div class="catalog-results-head"><p class="result-count">Найдено вариантов: <strong><?=count($properties)?></strong></p><span>Все цены указаны в рублях</span></div>
  <div class="property-grid"><?php foreach($properties as $p) require 'includes/property-card.php'; ?></div>
  <?php if(!$properties): ?><div class="empty"><span class="empty-mark" aria-hidden="true">⌕</span><h2>Пока нет подходящих вариантов</h2><p>Измените фильтры — возможно, нужный дом уже в подборке.</p><a class="button" href="catalog.php">Сбросить фильтры</a></div><?php endif ?>
</main>
<?php require 'includes/footer.php'; ?>
