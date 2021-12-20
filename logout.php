<?php
session_start();
session_regenerate_id();
unset($_SESSION['login']);
header('location: index.php');