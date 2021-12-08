<?php

define('SITE_NAME', "Cut your URL");
define('HOST', "http://" . $_SERVER['HTTP_HOST']);
define('DB_HOST', 'localhost');
define('DB_NAME', 'cut_url');
define('DB_USER', 'root');
define('DB_PASS', 'root');

define('URL_CHARS', "abcdefghijklmnopqrstuvwxwz0123456789-");
define('PATTERN_LOGIN', '/^[A-Za-z0-9-_]*$/');

session_start();
