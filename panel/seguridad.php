<?php
ini_set('session.save_path', __DIR__ . '/../sessions');
session_start();

if (!isset($_SESSION["admin"]) || $_SESSION["admin"] !== true) {
    header("Location: login.php");
    exit;
}

