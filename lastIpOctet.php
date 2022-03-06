<?php
/*
Задача:
Выделить последний октет IP адреса в отдельную переменную в виде числа.

Вывод:
Преобразование в число и побитовое И быстрее.
*/
declare(strict_types=1);

$stop = 10000000;
$ips = [];

for ($i = 0; $i < $stop; $i++) {
    $ips[] = rand(1,254).'.'.rand(1,254).'.'.rand(1,254).'.'.rand(1,254);
}

/* explode */

$time = microtime(true);
foreach ($ips as $ip) {
	$octet = intval(explode('.',$ip)[3]);
}
echo "Time #1 (explode): " . (microtime(true) - $time) . "\n";

/* ip2long */

$time = microtime(true);
foreach ($ips as $ip) {
	$octet = ip2long($ip) & 0xFF;
}
echo "Time: #2 (ip2long) " . (microtime(true) - $time) . "\n";
