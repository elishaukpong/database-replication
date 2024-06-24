<?php
include 'PDOConnector.php';

$mainDBConnection = (new PDOConnector)
    ->setHostName('primary-sql')
    ->setUserName('root')
    ->setPassword('secret')
    ->setDBName('main_db')
    ->connect();

$firstReplicaDBConnection = (new PDOConnector)
    ->setHostName('replica-sql-1')
    ->setUserName('user')
    ->setPassword('secret')
    ->setDBName('replica_db')
    ->connect();

$secondReplicaDBConnection = (new PDOConnector)
    ->setHostName('replica-sql-2')
    ->setUserName('user')
    ->setPassword('secret')
    ->setDBName('replica_db')
    ->connect();
