<?php

//je me connecte à la DB

$dsn = 'mysql:dbname=mcapp_sql1;host=192.168.210.84;charset=utf8';

//connection à la base de donnée (utilkisateur + password)
$pdo = new PDO($dsn,'mcapp_sql1', 'webforce3');