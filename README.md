Docker image only phpPgAdmin 5.0 application on latest nginx and PHP 5.6.

TODO Maybe it's a good idea to switch to https://github.com/bitnami/bitnami-docker-php-fpm.

# PhpPgAdmin Configuration

Because the bridge network driver of Docker is used, if a PostgreSQL server is hosted on 127.0.0.1 IP
or the same you should make additional configuration to map these IPs to the IP of the Docker Host(s).
Use next two ENV variables to setup this mapping:
* PG_SERVERS_DOCKER_IPS=docker_ip1,docker_ip2,...
* PG_SERVERS_EXTERNAL_ADDRS=external_ip1,external_ip2,...

You define the list of IPs of required hosts from the docker network via `PG_SERVERS_DOCKER_IPS`
and define the list of the addresses via `PG_SERVERS_EXTERNAL_ADDRS`.

For example:
* PG_SERVERS_DOCKER_IPS=172.20.0.1,172.18.0.2
* PG_SERVERS_EXTERNAL_ADDRS=127.0.0.1,127.0.0.2
