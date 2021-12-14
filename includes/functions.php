<?php
include_once "config.php";

function get_url($page = '') {
    return HOST . "/$page";
}

function db() {
   try {
    return new PDO("mysql:host=". DB_HOST . "; dbname=" . DB_NAME . "; charset=utf8", DB_USER, DB_PASS, [
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
   } catch (PDOException $e) {
    die($e->getMessage());
   }
}

function db_query($sql = '') {
    if(empty($sql)) return false;

    return db()->query($sql);
}


function db_prepared_query($sql, $params = []) {
    if(!is_string($sql)) return;
    $query = db()->prepare($sql);
    $query->execute($params);
    return  $query;
}

// пример вызова
// $data = db_prepared_query('SELECT * FROM users WHERE name = :name', [':name' => 'Vasia']);



function get_users_count() {
    return db_query("SELECT COUNT(id) FROM `users`;")->fetchColumn();
}

function get_links_count() {
    return db_query("SELECT COUNT(id) FROM `links`;")->fetchColumn();
}

function get_views_count() {
    return db_query("SELECT SUM(views) FROM `links`;")->fetchColumn();
}



function get_link_info($url) {
    if(empty($url)) return [];
    $sql = "SELECT * FROM `links` WHERE `short_link`=:url;";
    $params = [':url' => $url];
    return db_prepared_query($sql, $params)->fetch();
}

function get_user_info($login) {
    if(empty($login)) return [];
    $sql = "SELECT * FROM `users` WHERE `login`=:login;";
    $params = [':login' => $login];
    return db_prepared_query($sql, $params)->fetch();
}

function update_views($url) {
    if(empty($url)) return false;

    $sql = "UPDATE `links` SET `views` = `views` + 1 WHERE `short_link` = :url;";
    $params = [':url' => $url];
    db_prepared_query($sql, $params);

}



function get_session_success() {
    if(isset($_SESSION['success']) && !empty($_SESSION['success'])) {
        $success = $_SESSION['success'];
        $_SESSION['success'] = '';
        return $success;
    }
    return false;
}

function get_session_error() {
    if(isset($_SESSION['error']) && !empty($_SESSION['error'])) {
        $error = $_SESSION['error'];
        $_SESSION['error'] = '';
        return $error;
    }
    return false;
}


function check_session_user_id() {
    if(!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
        header('Location: ' . HOST);
        die;
    }
}



function add_user($login, $pass) {
    $password = password_hash($pass, PASSWORD_DEFAULT);

    $sql = "INSERT INTO `users` (`id`, `login`, `password`) VALUES (NULL, :login, :password);";
    $params = [':login' => $login, ':password' => $password];
    return db_prepared_query($sql, $params);
}

// function clear_data($val){
//     $val = trim($val);
//     $val = stripslashes($val);
//     $val = strip_tags($val);
//     $val = htmlspecialchars($val);
//     return $val;
// }

function data_validation($data) {
    
    $pattern_name = '/^[A-Za-z0-9-_]*$/';
    if(preg_match($pattern_name, $data)) return $data;
    return "Error";
    // $pattern = "/[^\w-+]/";  // "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_+"
    // $string = trim($data);
    // return preg_replace($pattern, "", $data);
}




function register_user($auth_data) {
    if(empty($auth_data) || !isset($auth_data['login']) || empty($auth_data['login']) || !isset($auth_data['pass']) || !isset($auth_data['pass2'])) return false;
    
    $_SESSION['login_temp'] = $auth_data['login'];

    if(!preg_match(PATTERN_LOGIN, $auth_data['login'])) {
        $_SESSION['error'] = "Для логина допускаются в использовании только латинские буквы, цифры, дефис и нижнее подчеркивание!";
        $_SESSION['info-valid'] = "login";
        header('Location: register.php');
        die;
    }

    $user = get_user_info($auth_data['login']);
    if(!empty($user)) {
        $_SESSION['error'] = "Пользователь '" . $auth_data['login'] . "' уже существует";
        $_SESSION['info-valid'] = "login";
        header('Location: register.php');
        die;
    }

    if(empty($auth_data['pass'])) {
        $_SESSION['error'] = "Вы не ввели пароль при регистации!";
        $_SESSION['info-valid'] = "pass";
        header('Location: register.php');
        die;
    }

    if(!preg_match(PATTERN_LOGIN, $auth_data['pass'])) {
        $_SESSION['error'] = "Вы используете в пароле недопустимые символы!";
        $_SESSION['info-valid'] = "pass";
        header('Location: register.php');
        die;
    }

    if($auth_data['pass'] !== $auth_data['pass2']) {
        $_SESSION['error'] = "Пароли не совпадают!";
        $_SESSION['info-valid'] = "pass2";
        header('Location: register.php');
        die;
    }

    if(add_user($auth_data['login'], $auth_data['pass'])) {
        $_SESSION['success'] = "Регистрация прошла успешно!";
        $_SESSION['info-valid'] = "";
        unset($_SESSION['login_temp']);
        header('Location: login.php');
        die;
    }

    return true;
}


function login($auth_data) {
    if(empty($auth_data) || !isset($auth_data['login']) || empty($auth_data['login']) || !isset($auth_data['pass']) || empty($auth_data['pass'])) {
        $_SESSION['error'] = "Логин или пароль не может быть пустым!";
        header('Location: login.php');
        die;
    };

    $_SESSION['login_temp'] = $auth_data['login'];

    if(!preg_match(PATTERN_LOGIN, $auth_data['login'])) {
        $_SESSION['error'] = "Логин имеет недопустимые символы!";
        header('Location: login.php');
        die;
    }

    if(!preg_match(PATTERN_LOGIN, $auth_data['pass'])) {
        $_SESSION['error'] = "Пароль имеет недопустимые символы!";
        header('Location: login.php');
        die;
    }

    $user = get_user_info($auth_data['login']);

    if(empty($user)) {
        $_SESSION['error'] = "Логин или пароль неверен!";
        header('Location: login.php');
        die;
    }

    if(password_verify($auth_data['pass'], $user['password'])) {
        $_SESSION['user_login'] = $user['login'];
        $_SESSION['user_id'] = $user['id'];
        unset($_SESSION['login_temp']);
        header('Location: profile.php');
        die;
    } else {
        $_SESSION['error'] = "Пароль неверен!";
        header('Location: login.php');
        die;
    }
}


function get_user_links($user_id) {
    if(empty($user_id) || !filter_var($user_id, FILTER_VALIDATE_INT)) return [];

    $sql = "SELECT * FROM `links` WHERE `user_id` = :user_id;";
    $params = [':user_id' => $user_id];
    return db_prepared_query($sql, $params)->fetchAll();
}

function get_long_link_info($user_id, $link_id) {
    if(empty($user_id) || empty($link_id)) return [];

    $sql = "SELECT `long_link` FROM `links` WHERE `id` = :link_id AND `user_id`= :user_id;";
    $params = [':link_id' => $link_id, ':user_id' => $user_id];
    return db_prepared_query($sql, $params)->fetch();
}

function edit_link($user_id, $link_id, $long_link) {
    if(empty($user_id) || empty($link_id) || empty($long_link)) return false;

    if(!filter_var($long_link, FILTER_VALIDATE_URL)) {
        $_SESSION['error'] = "Ссылка не была изменена, так как указана некорректно или содержит нелатинские символы!";
        header('Location: /profile.php');
        die;
    }

    $sql = "UPDATE `links` SET `long_link` = :long_link WHERE `id` = :link_id AND `user_id` = :user_id;";
    $params = [':long_link' => $long_link, ':link_id' => $link_id, ':user_id' => $user_id];
    $edit_success = db_prepared_query($sql, $params);

    if($edit_success == 0) {
        $_SESSION['error'] = "Произошла ошибка. Ссылка не изменилась!";
    } else {
        $_SESSION['success'] = "Ссылка успешно изменена!";
    }
}

function delete_link($user_id, $link_id) {
    if(empty($user_id) || empty($link_id)) return false;

    if(!filter_var($link_id, FILTER_VALIDATE_INT) || !filter_var($user_id, FILTER_VALIDATE_INT)) {
        $_SESSION['error'] = "Ошибка! Ссылка не была найдена!";
        header('Location: /profile.php');
        die;
    }

    $sql = "DELETE FROM `links` WHERE `id` = :link_id AND `user_id`= :user_id;";
    $params = [':link_id' => $link_id, ':user_id' => $user_id];
    return db_prepared_query($sql, $params);
}

function add_link($user_id, $link) {
    $_SESSION['link_temp'] = $link;
    if(!filter_var($link, FILTER_VALIDATE_URL)) {
        $_SESSION['error'] = "Ссылка указана некорректно или содержит нелатинские символы!";
        header('Location: /profile.php');
        die;
    }

    $short_link = check_duplicate_short_link();
    if($short_link) {
        unset($_SESSION['link_temp']);

        $sql = "INSERT INTO `links` (`id`, `user_id`, `long_link`, `short_link`, `views`) VALUES (NULL, :user_id, :link, :short_link, '0');";
        $params = [':user_id' => $user_id, ':link' => $link, ':short_link' => $short_link];
        return db_prepared_query($sql, $params);
    }  
}

function generate_string($size = 6) {
    $new_str = str_shuffle(URL_CHARS); // перемешивание элементов в стороке
    return substr($new_str, 0, $size);
}

function check_duplicate_short_link() {
    $short_link = generate_string();

    $sql = "SELECT COUNT(id) FROM `links` WHERE `short_link` = ':short_link';";
    $params = [':short_link' => $short_link];
    $count_dupticate_link = db_prepared_query($sql, $params)->fetchColumn();

    if($count_dupticate_link > 0) {
        check_duplicate_short_link();
    } else {
        return $short_link;
    }
}

