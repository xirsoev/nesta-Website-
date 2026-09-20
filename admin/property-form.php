<?php
require '../includes/bootstrap.php'; require_admin();
$id=(int)($_GET['id']??0);
$p=['title'=>'','description'=>'','city'=>'','address'=>'','price'=>'','area'=>'','rooms'=>'','type'=>'Квартира','image'=>'','status'=>'active'];
if($id){$s=$pdo->prepare('SELECT * FROM properties WHERE id=?');$s->execute([$id]);$p=$s->fetch()?:exit('Объект не найден.');}
$errors=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
    if(!csrf_ok())$errors[]='Некорректный запрос.';
    foreach($p as $key=>$value) if(isset($_POST[$key])) $p[$key]=trim($_POST[$key]);
    if(!$p['title']||!$p['city']||!$p['address']||!$p['image'])$errors[]='Заполните название, город, адрес и ссылку на изображение.';
    if(!is_numeric($p['price'])||!is_numeric($p['area'])||!is_numeric($p['rooms']))$errors[]='Цена, площадь и количество комнат должны быть числами.';
    if(!$errors){
        if($id){$q=$pdo->prepare('UPDATE properties SET title=?,description=?,city=?,address=?,price=?,area=?,rooms=?,type=?,image=?,status=? WHERE id=?');$q->execute([$p['title'],$p['description'],$p['city'],$p['address'],$p['price'],$p['area'],$p['rooms'],$p['type'],$p['image'],$p['status'],$id]);}
        else{$q=$pdo->prepare('INSERT INTO properties(title,description,city,address,price,area,rooms,type,image,status) VALUES(?,?,?,?,?,?,?,?,?,?)');$q->execute(array_values($p));}
        $_SESSION['flash']='Объект сохранён.'; header('Location: index.php'); exit;
    }
}
$page_title=$id?'Редактирование объекта':'Новый объект'; require '../includes/header.php';
?>
<main class="auth-wrap wide"><form class="auth-card" method="post"><p class="eyebrow">Админ-панель</p><h1><?=e($page_title)?></h1><?php foreach($errors as $error):?><p class="error"><?=e($error)?></p><?php endforeach?><input type="hidden" name="csrf" value="<?=csrf()?>"><?php foreach(['title'=>'Название','city'=>'Город','address'=>'Адрес','price'=>'Цена','area'=>'Площадь (м²)','rooms'=>'Комнаты','image'=>'Ссылка на изображение'] as $key=>$label):?><label><?=$label?><input name="<?=$key?>" value="<?=e((string)$p[$key])?>"></label><?php endforeach?><label>Тип недвижимости<select name="type"><?php foreach(['Квартира','Дом','Вилла','Лофт'] as $type):?><option <?=$p['type']===$type?'selected':''?>><?=$type?></option><?php endforeach?></select></label><label>Статус<select name="status"><option value="active" <?=$p['status']==='active'?'selected':''?>>Активен</option><option value="draft" <?=$p['status']==='draft'?'selected':''?>>Черновик</option></select></label><label>Описание<textarea name="description" rows="5"><?=e($p['description'])?></textarea></label><button class="block">Сохранить объект</button></form></main>
<?php require '../includes/footer.php'; ?>
