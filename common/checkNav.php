<?php if(isset($_SESSION['user'])) {
    if($_SESSION['user']['role'] === 'admin') {
        require_once 'common/navAdmin.php';
    } elseif($_SESSION['user']['role'] === 'moderator') {
        require_once 'common/navModerator.php';
    } else {
        require_once 'common/nav.php';
    }
} ?>