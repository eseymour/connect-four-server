<?php
namespace ConnectFour;

if(!defined('ROOT')) define('ROOT', dirname(__DIR__).'/');
require_once(ROOT.'config.php');

$info = ['width' => BOARD_WIDTH, 'height' => BOARD_HEIGHT, 'strategies' => STRATEGIES];
echo json_encode($info);
