
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
MASTER_LOG_FILE='/var/log/mysql/mysql-bin.000006',
MASTER_LOG_POS=841;

```