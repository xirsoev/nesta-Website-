<?php require 'includes/bootstrap.php'; $_SESSION=[];session_destroy();session_start();$_SESSION['flash']='Вы вышли из аккаунта.';header('Location: index.php');
