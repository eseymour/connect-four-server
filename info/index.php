<?php
namespace EdwardSeymour\ConnectFour;

define('ROOT', dirname(__DIR__).'/');
require_once(ROOT.'lib.php');

$info = ['width' => $width, 'height' => $height, 'strategies' => $strategies];
echo json_encode($info);
