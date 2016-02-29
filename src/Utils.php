<?php

namespace Treffynnon\CmdWrap\Utils {

    function escapeArgument($arg)
    {
        return escapeshellarg($arg);
    }

    function escapeCommand($cmd)
    {
        return escapeshellcmd($cmd);
    }

    function padOrNone($str)
    {
        if ('' !== $str) {
            $str = " $str";
        }
        return $str;
    }

    function arraySort(array $array, callable $f)
    {
        usort($array, $f);
        return $array;
    }
}
