<?php
namespace ConnectFour\Lib;

define('DATA_DIR', __DIR__.'/Writable/');
define('ROOT', __DIR__.'/');
require_once(ROOT.'config.php');

function response($status, $array) {
  $response = array_merge(['response' => $status], $array);
  echo json_encode($response);
}

function responseSuccess($array) {
  response(true, $array);
}

function responseError($message) {
  response(false, ['reason' => $message]);
}

function base64url_encode($data) {
  return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function generatePID() {
  if(function_exists('mcrypt_encrypt')) {
    return base64url_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM));
  } else {
    return uniqid();
  }
}
