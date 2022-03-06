<?php
/* 
Скорость почти равна, но если включить strict_types,
strlen выдаст ошибку при null и int.
Значит при выключенном strict_types, интерпретатор задействует автоматическое
приведение типа, а это лишние операции и в случае с числом засчитает число как
строку, что может привести к неожиданным результатам работы скрипта.
1 - integer
"1" - string
*/

// declare(strict_types=1);

$test = array(
    0 => null,
    1 => 1,
    2 => '',
    3 => 'Prodigy'
);
$stop = 10000000;

/* strlen() */

$st = microtime(true);
$ok = 0;
for ($i = 0; $i < $stop; $i++ ) {
    foreach ($test as $tst) {
        if ( strlen($tst) ) {
            $ok++;
            continue;
        }
    }
}
echo $ok." Time #1: " . (microtime(true) - $st) . "\n";

/* isset() */

$st = microtime(true);
$ok = 0;
for ($i = 0; $i < $stop; $i++ ) {
    foreach ($test as $tst) {
        if (isset($tst[0])) {
            $ok++;
            continue;
        }
    }
}
echo $ok." Time #2: " . (microtime(true) - $st) . "\n";
