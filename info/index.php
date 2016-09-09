<?php
define('__ROOT__', dirname(__DIR__).'/');
require_once(__ROOT__.'lib.php');

$info = array('width' => $width, 'height' => $height, 'strategies' => $strategies);
echo json_encode($info);
