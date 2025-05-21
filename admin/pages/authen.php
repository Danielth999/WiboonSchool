<?php

require_once '../../service/connect.php';
if (!isset($_SESSION['user']['role'])) {
    header('Location: ../../login.php');
}
