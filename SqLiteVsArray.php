<?php

/**
 * Author: Shadow aka vanGogh
 * Copyright: Beliani GmbH
 * 
 * Задача:
 * сделать выборку и MySql базы и в цикле обработать эти данные.
 * Сравнение по скорости работы массива и SQLite
 * 
 * Вывод:
 * SQLite медленнее в десятки раз
 */

$stop = 1000;
$chars = array(
    'a','b','c','d','e','f','g','h','i','j','k','l','m',
    'n','o','p','q','r','s','t','u','v','w','x','y','z'
);

$data = [];
$message = '';
$name = '';
$sqlite_db = new SQLite3(':memory:');
$sqlite_db->exec("CREATE TABLE IF NOT EXISTS `test` (
    `id` INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    `master_id` INTEGER DEFAULT 0,
    `slave_id` INTEGER DEFAULT 0,
    `superslave_id` INTEGER DEFAULT 0,
    `message` TEXT DEFAULT '',
    `name` TEXT DEFAULT ''
)");

echo "Data processing\n";

for ($i = 0; $i < $stop; $i++) {
    $id = rand(1,10000000);
    $master_id = rand(1,10000000);
    $slave_id = rand(1,10000000);
    $superslave_id = rand(1,10000000);
    $message = '';
    $name = '';

    for ($ii = 0; $ii < 100000; $ii++) {
        $message .= $chars[rand(0,25)];
        if (!$ii % 10000) {
            $name .= $chars[rand(0,25)];
        }
    }

    $data[] = array(
        'id' => $id,
        'master_id' => $master_id,
        'slave_id' => $slave_id,
        'superslave_id' => $superslave_id,
        'message' => $message,
        'name' => $name
    );

    $sqlite_db->exec("INSERT INTO `test`
                (`master_id`, `slave_id`, `superslave_id`, `message`, `name`)
                VALUES ($master_id, $slave_id, $superslave_id, '$message', '$name')");
}

echo "Ready\n";

$time = microtime(true);
for ($i = 0; $i < $stop; $i++) {
    $a = array_search('Prodigy', array_column($data, 'name'));
}
echo "Time #1 (array): " . (microtime(true) - $time) . "\n";

$time = microtime(true);
for ($i = 0; $i < $stop; $i++) {
    $a = $sqlite_db->query('SELECT * FROM `test` WHERE `name` = "Prodigy"');
}
echo "Time #2 (SQLite): " . (microtime(true) - $time) . "\n";
