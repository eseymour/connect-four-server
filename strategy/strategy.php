<?php
namespace ConnectFour\Strategy;

if (!defined('ROOT')) define('ROOT', dirname(__DIR__) . '/');

abstract class Strategy
{
    abstract public function nextMove($game);
}