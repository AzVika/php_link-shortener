<?php

if(!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: /profile.php');
    die;
}

include_once "functions.php";

check_session_user_id();

$temp = delete_link($_SESSION['user_id'], $_GET['id']);

if($temp == 0) {
    $_SESSION['error'] = "Произошла ошибка, ссылка не удалена!";
    header('Location: /profile.php');
    die;
}

$_SESSION['success'] = "Ссылка успешно удалена!";
header('Location: /profile.php');
die;