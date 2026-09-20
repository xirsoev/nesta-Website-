<?php
declare(strict_types=1);

$sessionDir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'work' . DIRECTORY_SEPARATOR . 'sessions';
if (!is_dir($sessionDir)) {
    mkdir($sessionDir, 0775, true);
}
session_save_path($sessionDir);
session_start();
require_once __DIR__ . '/../config/config.php';
try { $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4', DB_USER, DB_PASS, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]); }
catch (PDOException $e) { exit('Database connection failed. Check config/config.php and import database.sql.'); }
function e(?string $v): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function user(): ?array { return $_SESSION['user'] ?? null; }
function logged_in(): bool { return isset($_SESSION['user']); }
function require_login(): void { if (!logged_in()) { $_SESSION['flash']='Please sign in to continue.'; header('Location: '.BASE_URL.'/login.php'); exit; } }
function require_admin(): void { require_login(); if ((user()['role'] ?? '') !== 'admin') { http_response_code(403); exit('Access denied.'); } }
function csrf(): string { if (empty($_SESSION['csrf'])) $_SESSION['csrf']=bin2hex(random_bytes(32)); return $_SESSION['csrf']; }
function csrf_ok(): bool { return hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? ''); }
function flash(): ?string { $f=$_SESSION['flash']??null; unset($_SESSION['flash']); return $f; }
function favorite_ids(PDO $pdo): array { if(!logged_in()) return []; $s=$pdo->prepare('SELECT property_id FROM favorites WHERE user_id=?'); $s->execute([user()['id']]); return array_map('intval', $s->fetchAll(PDO::FETCH_COLUMN)); }
function property_title(string $title): string { return ['Modern Apartment'=>'Современная квартира','Ocean View Residence'=>'Резиденция с видом на океан','Minimal House'=>'Минималистичный дом','Downtown Loft'=>'Лофт в центре','Family Residence'=>'Семейная резиденция','Luxury Villa'=>'Роскошная вилла'][$title] ?? $title; }
function property_type(string $type): string { return ['Apartment'=>'Квартира','House'=>'Дом','Villa'=>'Вилла','Loft'=>'Лофт'][$type] ?? $type; }
