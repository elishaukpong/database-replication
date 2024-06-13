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

## The Docker File


### Todo 

[] Add a webserver to visualize the replication