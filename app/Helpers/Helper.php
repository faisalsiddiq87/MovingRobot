<?php

if (!function_exists('newLine')) {
    function newLine()
    {
      return PHP_SAPI === 'cli' ? PHP_EOL : "<br />";
    }

    function reIndexArray($commands, $index)
    {
      return array_values(array_slice($commands, $index, NULL, TRUE));
    }

    function matchPattern($pattern, $cmd)
    {
        return preg_match($pattern, $cmd) ? 1 : 0;
    }
}