<?php
namespace ConnectFour\Lib;

if (!defined('ROOT')) define('ROOT', __DIR__.'/');
require_once(ROOT.'config.php');

function response($array, $status = null)
{
    if (is_null($status)) {
        $response = $array;
    } else {
        $response = array_merge(['response' => $status], $array);
    }
    echo json_encode($response);
}

function responseSuccess($array)
{
    response($array, true);
}

function responseError($message)
{
    response(['reason' => $message], false);
}

function base64url_encode($data)
{
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function generatePID()
{
    if (function_exists('mcrypt_encrypt')) {
        return base64url_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM));
    } else {
        return uniqid();
  }
}

function assertResponse($file, $line, $expression, $description = 'Generic assertion.')
{
    responseError("Failed assertion: $description");
}
