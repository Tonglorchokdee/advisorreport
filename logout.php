<?php
require_once 'config/sessionname.php';
session_start();
session_destroy();

header('location: login.php');
exit();