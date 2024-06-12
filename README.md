# Database Replication Setup

After doing some study on highly available systems, I saw how database replication can be used
to seperate read and write queries to speed them up respectively.

The main DB is optimized to support faster writes (no indexes setup and ideally no read requests) 
and used for writes only, while the replica DB is optimized (properly indexed) for faster reads 
and no writes.

This Repo contains a containerized implementation of database replication with one main db for writes
and two replica DBs for reads, you can have as many replicas as possible, you just need to add more
replica mysql containers and follow the steps to listen for the replica events, more on that later.


## Setup




Create a replication user on the master server with the necessary privileges:

```
CREATE USER 'replica_user'@'%' IDENTIFIED BY 'password';
GRANT REPLICATION SLAVE ON *.* TO 'replica_user'@'%';
FLUSH PRIVILEGES;
```


```
CHANGE MASTER TO
MASTER_HOST='primary-sql',
MASTER_USER='replica_user',
MASTER_PASSWORD='password',
MASTER_LOG_FILE='/var/log/mysql/mysql-bin.000001',
MASTER_LOG_POS=941;

```


```CREATE TABLE userss (
user_id INT AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(50) NOT NULL,
email VARCHAR(100) NOT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);```