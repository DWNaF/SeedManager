<?php

require_once '../../config/config.php';

if (session_status() != PHP_SESSION_ACTIVE) session_start();
session_destroy();

Admin::deleteUnusedImages();

header("Location: " . PUBLIC_PATH . "list_seeds.php");
exit();