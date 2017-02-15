<?php
/**
 * ATTENTION!!!
 *
 * Don't edit this file for configuration of the PgAdmin servers. Read "PhpPgAdmin Configuration"
 * section in the README.md.
 */

if (!file_exists(__DIR__ . '/external-config.inc.php')) {
    die('The conf directory should contain a config with "docker-network" or "external-network" ' .
        'prefix. Check the PhpPgAdmin Configuration section in the README');
}

require __DIR__ . '/external-config.inc.php';

if (isset($_ENV['PG_SERVERS_DOCKER_IPS']) && isset($_ENV['PG_SERVERS_EXTERNAL_ADDRS'])) {
    /**
     * @param string $value
     * @param string $oldAddress
     * @param string $newAddres
     * @return string
     */
    $serverMapper = function($value, $oldAddress, $newAddress) {
        $parts = explode(':', $value, 2);
        $parsedAddress = $parts[0];

        if ($parsedAddress != $oldAddress) {
            return $value;
        }

        return $newAddress . ($parts[1] ? ":{$parts[1]}" : '');
    };
    $ipsMapper = function (&$conf) use ($serverMapper) {
        $dockerIps = explode(',', $_ENV['PG_SERVERS_DOCKER_IPS']);
        $dockerIps = array_map('trim', $dockerIps);
        $externalIps = explode(',', $_ENV['PG_SERVERS_EXTERNAL_ADDRS']);
        $externalIps = array_map('trim', $externalIps);

        if (count($dockerIps) != count($externalIps)) {
            die('Count of elements in the "PG_SERVERS_DOCKER_IPS" and "PG_SERVERS_EXTERNAL_ADDRS" ' .
                'ENV variables should match.');
        }

        $map = array_combine($externalIps, $dockerIps);
        $requestArrays = array(&$_REQUEST, &$_GET, &$_POST);

        foreach ($map as $extIp => $dockIp) {
            // Map configuration
            foreach ($conf['servers'] as &$server) {
                $server['host'] = $serverMapper($server['host'], $extIp, $dockIp);
            }
            // Map parameter of requests
            foreach ($requestArrays as &$array) {
                if (isset($array['server'])) {
                    $array['server'] = $serverMapper($array['server'], $extIp, $dockIp);
                }
            }
        }
    };
    $ipsMapper($conf);
    unset($serverMapper, $ipsMapper);
}
