<?php
define('ROOT', __DIR__.'/');
define('DATA_DIR', ROOT.'writable/');

const BOARD_WIDTH = 7;
const BOARD_HEIGHT = 6;
const STRATEGIES = ['Random'];



ini_set('log_errors', 1);
ini_set('display_errors', 0);
ini_set('error_reporting', E_ALL);
ini_set('error_log', DATA_DIR.'log.txt');

assert_options(ASSERT_ACTIVE, true);
assert_options(ASSERT_BAIL, true);
