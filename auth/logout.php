<?php
include '../database/config.php';
session_unset();
session_destroy();
header('Location: login.php');
?>