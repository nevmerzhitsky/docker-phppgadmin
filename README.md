Docker image only phpPgAdmin 5.0 application on latest nginx and PHP 5.6.

TODO Maybe it's a good idea to switch to https://github.com/bitnami/bitnami-docker-php-fpm.

# PhpPgAdmin Configuration

You can use two strategies for setup IPs/addresses of the PostgreSQL servers in PhpPgAdmin config.
You should select the one.

## Docker network

If you can setup IPs/addresses strictly in the docker network (a bridge network usually), you should
mount it to the container as file with name `docker-network-config.inc.php`. For this just add to you
`.env` file:
* PGADMIN_CONFIG_MODE=docker
* PGADMIN_CONFIG_PATH=/c/Users/admin/config.pgsql.php

## External network

Else if you want setup config via IPs/addresses from external to the container network (a host system
network usually) you should mount it to the container as file with name `external-network-config.inc.php`.
For this just add to you `.env` file:
* PGADMIN_CONFIG_MODE=external
* PGADMIN_CONFIG_PATH=/c/Users/admin/config.pgsql.php

In this case the special config proxy in the container will map external addresses to a docker network,
but fow this you also required to add more environment variables to `.env` file:
* PG_SERVERS_DOCKER_IPS=docker_ip1,docker_ip2,...
* PG_SERVERS_EXTERNAL_ADDRS=external_ip1,external_ip2,...

This mapping usually required when you want connect from the container to the PostgreSQL server which
runs on the host machine at 127.0.0.1 IP, but the container network doesn't see the host machine at
this IP. Thus you define via `PG_SERVERS_DOCKER_IPS` list of the IPs of required hosts from the
docker network and define via `PG_SERVERS_EXTERNAL_ADDRS` list of the addresses

For example:...
* PG_SERVERS_DOCKER_IPS=172.0.0.1,172.0.1.1
* PG_SERVERS_EXTERNAL_ADDRS=127.0.0.1,127.0.0.2
