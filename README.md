
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