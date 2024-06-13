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

We will start with setting up the WRITE DB.

Open the terminal for your WRITE DB and run:

```mysql
docker-compose exec primary-sql bash
```

This will open up a bash command line interface for the primary-sql container, then you 
login to mysql, using:

```
mysql -u root -p
```

It will prompt for your password and you provide it, if you're sticking to the env defaults, that would be the word `secret`

After gaining access to the MySQL interface, copy th below codes an run it in there.

```mysql
create user ‘replica’@’%’ identified by ‘password’;
grant replication slave on *.* to ‘replica’@’%’;
flush privileges;
```

This sets up a user that will be in charge of replication, and grants replication abilities to it.

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