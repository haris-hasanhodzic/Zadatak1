<?php
$db = new SQLite3('first.db');
$db->exec('CREATE TABLE networks (name STRING)');
$db->exec("INSERT INTO networks (name) VALUES ('127.0.0.0/8')");
$db->exec("INSERT INTO networks (name) VALUES ('10.15.0.0/16')");
$db->exec("INSERT INTO networks (name) VALUES ('192.168.1.0/24')");
$db->exec("INSERT INTO networks (name) VALUES ('10.0.0.0/8')");
$db->exec("INSERT INTO networks (name) VALUES ('127.1.0.0/16')");
$db->exec("INSERT INTO networks (name) VALUES ('127.1.1.0/24')");
$db->exec("INSERT INTO networks (name) VALUES ('127.200.0.0/10')");

$result = $db->query('SELECT name FROM networks');
while($row=$result->fetchArray()["name"])
       echo "mreza: " . $row . "\n"; 
?>
