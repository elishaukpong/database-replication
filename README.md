# Database Replication Setup

After doing some study on highly available systems, I saw how database replication can be used
to seperate read and write queries to speed them up respectively.

The main DB is optimized to support faster writes (no indexes setup and ideally no read requests) 
and used for writes only, while the replica DB is optimized (properly indexed) for faster reads 
and no writes.

This Repo contains a containerized implementation of database replication with one main db for writes
and two replica DBs for reads, you can have as many replicas as possible, you just need to add more
replica mysql containers and follow the steps to listen for the replica events, more on that later.


## Setup Containers

To run this setup, you will need to have `Docker` installed and running on your system.

Open your terminal in the project folder and run `cp .env.example .env` to copy the env file.

Run `docker-compose up -d` and wait for the services to finish build and be available.


## Setup Replication

*Assumption: You have a terminal access open at this project folder*  
  
  

The needed config for the WRITE and READ DBs are already setup and can be found inside the 
`docker/mysql` folder.

### WRITE DATABASE SETUP
We will start with setting up the WRITE DB.

Open the terminal for your WRITE DB and run:

```mysql
docker-compose exec primary-sql bash
```

This will open up a bash command line interface for the primary-sql container, then you 
login to mysql, using:

```shell
mysql -u root -p
```

It will prompt for your password and you provide it, if you're sticking to the env defaults, that would be the word `secret`

After gaining access to the MySQL interface, copy the codes below and run it in there.

```mysql
create user ‘replica’@’%’ identified by ‘password’;
grant replication slave on *.* to ‘replica’@’%’;
flush privileges;
```

This sets up a user that will be in charge of replication, and grants replication abilities to it.

Next, you need to grab the binary log details for the WRITE database which will be used later to provision the READ database

Still in the WRITE database mysql terminal, run:

```mysql
use main_db;
show master status;
```
This will bring out a table containing the binary log file and the position, copy this details to somewhere safe.

Now exit the MySQL terminal and then exit the WRITE database terminal too entirely. We are done with the setup

### READ DATABASE SETUP

Open the terminal for your WRITE DB and run:

```mysql
docker-compose exec replica-sql-1 bash
```

This will open up a bash command line interface for the primary-sql container, then you
login to mysql, using:

```shell
mysql -u root -p
```

It will prompt for your password and you provide it, if you're sticking to the env defaults, that would be the word `secret`

After gaining access to the MySQL interface, copy the codes below and run it in there.

*Before running the command below, change `MASTER_LOG_FILE = 'mysql-bin.000001', MASTER_LOG_POS = 107` values to the values you got from
the master setup.*

```mysql
stop slave; 
CHANGE MASTER TO MASTER_HOST = 'primary-sql', MASTER_USER = 'replica', MASTER_PASSWORD = 'password', MASTER_LOG_FILE = 'mysql-bin.000001', MASTER_LOG_POS = 107; 
start slave;
```
Then run `show slave status\G;` and look out for the following parameters:

```mysql
Slave_IO_State: Waiting for master to send event    
    
Master_Host: primary-sql
Slave_IO_Running: Yes
Slave_SQL_Running: Yes
```

If the last two parameters are not running then there is a setup error and you might need to either look for where you missed a step
or check in with ChatGPT with the specific error code.

That is all the setup, now the replica DB will be picking up commands made on the primary DB

You can repeat this steps on the `replica-sql-2` database and as many databases you want.

## Testing

Run a command on your master mysql terminal, and then check that it is ran too on your replica db.
An easy example would be creating a table on the READ database and checking that same table exists on the replica table.

## The Docker File

The Docker file contains 3 services which are instances of the mysql image:
- primary-sql
- replica-sql-1
- replica-sql-2

The `primary-sql` instance acts as the WRITE DB while the `replica-sql-1` and `replica-sql-2`
acts as the READ DB.

Each respective mysql container has a folder in the `docker/mysql` folder and contains the config
files and logs folder. You can update it to suit your custom needs but the default details there are
just right to get us going.


Implementation Resource Aid: [MySQL DB Replication.](https://thilinamad.medium.com/mysql-db-replication-63786ac8241e) and ChatGPT


### Todo 

[] Add a webserver to visualize the replication