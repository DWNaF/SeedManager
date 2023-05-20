<?php
require_once '../config/config.php';

if (session_status() != PHP_SESSION_ACTIVE) session_start();
?>

<nav>
    <ul>
        <li><a class="<?= $page == 'home' ? 'active_link' : ''?>" href="<?= PUBLIC_PATH ?>home.php">Home</a></li>
        <li><a class="<?= $page == 'list_seeds' ? 'active_link' : ''?>" href="<?= PUBLIC_PATH ?>list_seeds.php">Seeds</a></li>
        <li><a class="<?= $page == 'calendar' ? 'active_link' : ''?>" href="<?= PUBLIC_PATH ?>calendar.php">Calendar</a></li>
        <?php if (!isset($_SESSION["logged"]) || $_SESSION["logged"] == false) { ?>
            <li><a class="admin_btns" id="login_btn" href="<?= PUBLIC_PATH ?>login.php">Login</a></li>
        <?php } else { ?>
            <li><a class="admin_btns" id="logout_btn" href="<?= HANDLERS_PATH ?>logout.php">Logout</a></li>
        <?php } ?>
    </ul>
</nav>