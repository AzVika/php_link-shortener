<?php

if(isset($_POST['link']) && !empty($_POST['link']) && isset($_POST['user_id']) && !empty($_POST['user_id'])) {

    include_once "functions.php";
    check_session_user_id();

    if(add_link($_POST['user_id'], $_POST['link'])) {
        $_SESSION['success'] = 'Ссылка успешно добавлена!';
    } else {
        $_SESSION['error'] = 'Во время добавления ссылки произошла ошибка и ссылка не добавлена!';
    }  
}

header('Location: /profile.php');
die;




