<?php
require 'includes/bootstrap.php';
$id = (int) ($_GET['id'] ?? 0);
$statement = $pdo->prepare("SELECT * FROM properties WHERE id=? AND status='active'");
$statement->execute([$id]);
$p = $statement->fetch();
if (!$p) { http_response_code(404); exit('Объект не найден.'); }
$page_title = property_title($p['title']);
$favoriteIds = favorite_ids($pdo);
$gallery = [$p['image'], 'https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?auto=format&fit=crop&w=1200&q=80', 'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?auto=format&fit=crop&w=1200&q=80'];
require 'includes/header.php';
?>
<main class="container section"><a class="back" href="catalog.php">← Вернуться в каталог</a><div class="detail-grid"><div><img id="main-photo" class="main-photo" src="<?=e($gallery[0])?>" alt="Иллюстрация: <?=e(property_title($p['title']))?>"><div class="thumbs"><?php foreach($gallery as $i=>$im): ?><button class="thumb <?=$i===0?'selected':''?>" data-image="<?=e($im)?>"><img src="<?=e($im)?>" alt="Иллюстрация интерьера"></button><?php endforeach ?></div></div><aside class="detail-card"><div class="card-top"><span class="eyebrow"><?=e(property_type($p['type']))?></span><form method="post" action="toggle-favorite.php"><input type="hidden" name="csrf" value="<?=csrf()?>"><input type="hidden" name="property_id" value="<?=$p['id']?>"><button class="heart <?=in_array((int)$p['id'],$favoriteIds,true)?'active':''?>" aria-label="Добавить в избранное">♥</button></form></div><h1><?=e(property_title($p['title']))?></h1><p class="property-location"><?=e(property_location($p))?></p><div class="price">₽ <?=number_format((float)$p['price'],0,'.',' ')?></div><div class="features"><span><?=e($p['area'])?> м²</span><span><?=e(property_rooms($p))?></span><span><?=e(property_type($p['type']))?></span></div><hr><h3>Об объекте</h3><p><?=nl2br(e($p['description']))?></p><p class="listing-disclaimer">Адрес продавца не публикуется. Фотографии служат иллюстрацией. Цена и наличие могли измениться — уточняйте сведения в источнике объявления.</p><a class="button block" href="https://realty.yandex.ru/primorskiy_kray/kupit/dom/" target="_blank" rel="noopener noreferrer">Смотреть объявления в источнике ↗</a></aside></div></main>
<?php require 'includes/footer.php'; ?>
