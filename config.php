<?php
if (!defined('ROOT')) define('ROOT', __DIR__.'/');
define('DATA_DIR', ROOT.'writable/');

const BOARD_WIDTH = 7;
const BOARD_HEIGHT = 6;
const STRATEGIES = ['Random', 'Smart'];

ini_set('log_errors', true);
ini_set('display_errors', false);
ini_set('error_reporting', E_ALL);
ini_set('error_log', DATA_DIR.'log.txt');

assert_options(ASSERT_ACTIVE, true);
assert_options(ASSERT_BAIL, true);
assert_options(ASSERT_CALLBACK, 'ConnectFour\Lib\assertResponse');
