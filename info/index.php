<?php
namespace ConnectFour;

if (!defined('ROOT')) define('ROOT', dirname(__DIR__).'/');
require_once(ROOT.'lib.php');

$info = ['width' => BOARD_WIDTH, 'height' => BOARD_HEIGHT, 'strategies' => STRATEGIES];
Lib\response($info);
