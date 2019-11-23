<?php

if (!function_exists('newLine')) {
    function newLine()
    {
      return PHP_SAPI === 'cli' ? PHP_EOL : "<br />";
    }
}