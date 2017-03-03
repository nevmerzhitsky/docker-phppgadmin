Docker Compose with phpPgAdmin 5.0 application on latest nginx and PHP 5.6.

# Configuration

All sensitive options for building and running a container available via the environment variables:
* NGINX_HTTP_PORT - port of a web-server
* PGADMIN_CONFIG_PATH - path to your local config of phpPgAdmin

Both options are required.

We recommend specify the environment variables vie `.env` file.

# Docker Network Configuration

Because the bridge network driver of Docker is used, if a PostgreSQL server is hosted on 127.0.0.1 IP or something you should make the additional configuration to map these IPs to the IP of the Docker Host(s). Use next two ENV variables to setup this mapping:
* PG_SERVERS_DOCKER_IPS=docker_ip1,docker_ip2,...
* PG_SERVERS_EXTERNAL_ADDRS=external_ip1,external_ip2,...

To understand the networks of this image check this diagram:
![image.png](docs/network-architecture.png)

Define the list of IPs of required hosts from the docker network via `PG_SERVERS_DOCKER_IPS` and define the list of the external addresses via `PG_SERVERS_EXTERNAL_ADDRS`.

For example:
* PG_SERVERS_DOCKER_IPS=172.20.0.1,172.18.0.2
* PG_SERVERS_EXTERNAL_ADDRS=127.0.0.1,127.0.0.2
