<?php
/**
 * Created by PhpStorm.
 * User: DUTSIK
 * Date: 9/17/2018
 * Time: 10:51
 */



/**
 * @param $a
 * @param $b
 * @return string
 */
function sum($a, $b)
{
    $maxLength = strlen($a);
    if (strlen($a)<strlen($b)) {
        $maxLength = strlen($b);
        $a = str_repeat('0', $maxLength-strlen($a)).$a;
    } elseif (strlen($a)>strlen($b)) {
        $b = str_repeat('0', $maxLength-strlen($b)).$b;
    }
    $inMind = 0;
    for ($i=$maxLength-1; $i>=0; $i--) {
        $inMind    += (int)$a[$i]+(int)$b[$i];
        $a[$i] = (string)($inMind % 10);
        $inMind     = (int)($inMind/10);

    }
    if ($inMind>0) {
        $a = (string)$inMind.$a;
    }
    
    return $a;
}

if ($argc !== 3 || !preg_match("/^[1-9]{1}[0-9]*$/", $argv[1]) || !preg_match("/^[1-9]{1}[0-9]*$/", $argv[2])) {
    echo 'Input 2 positive integers';
    exit;
}

echo sum($argv[1], $argv[2]);
