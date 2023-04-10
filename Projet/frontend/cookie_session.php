<?php
session_start();

if (isset($_COOKIE['login'])) {
    $_SESSION['login'] = $_COOKIE['login'];
    $login = $_SESSION['login'];
} else {
    $login = null;
}
?>