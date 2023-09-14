<?php
session_start();
ob_start();
include_once ("class/class_db.php");
$class_pdo =  new class_db;