<?php

echo 'Hello, world!';

#new mysqli('mariadb', 'root', 'Ma49dfma!');
$dsn = 'mysql:dbname=mydb;host=mysql';
$connection = new PDO($dsn, 'root', 'ma49df');

// throw exceptions, when SQL error is caused
$connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
// prevent emulation of prepared statements
$connection->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);