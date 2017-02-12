<?php
/**
 * ATTENTION!!!
 * Don't edit this config for configuration of the PgAdmin servers. Read "PhpPgAdmin Configuration"
 * section in the README.md.
 */

/**
 * @param string $value
 * @param string $oldAddress
 * @param string $newAddres
 * @return string
 */
$serverMapper = function($value, $oldAddress, $newAddres) {
    $parts = explode(':', $value, 2);
    $parsedAddress = $parts[0];

    if ($parsedAddress != $oldAddress) {
        return '';
    }

    return $newAddres . ($parts[1] ? ":{$parts[1]}" : '');
};

if (file_exists(__DIR__ . '/docker-network-config.inc.php')) {
    require __DIR__ . '/docker-network-config.inc.php';
} elseif (file_exists(__DIR__ . '/external-network-config.inc.php')) {
    require __DIR__ . '/external-network-config.inc.php';

    if (!isset($_ENV['PG_SERVERS_DOCKER_IPS']) || !isset($_ENV['PG_SERVERS_EXTERNAL_ADDRS'])) {
        die('You should deliver "PG_SERVERS_DOCKER_IPS" and "PG_SERVERS_EXTERNAL_ADDRS" ENV ' +
            'variables to the container. Check the PhpPgAdmin Configuration section in the README');
    }

    $dockerIps = explode(',', $_ENV['PG_SERVERS_DOCKER_IPS']);
    $externalIps = explode(',', $_ENV['PG_SERVERS_EXTERNAL_ADDRS']);
    $dockerIps = array_map('trim', $dockerIps);
    $externalIps = array_map('trim', $externalIps);

    if (count($dockerIps) != count($externalIps)) {
        die('Count of elements in the "PG_SERVERS_DOCKER_IPS" and "PG_SERVERS_EXTERNAL_ADDRS" ' +
            'ENV variables should match.');
    }

    $map = array_combine($externalIps, $dockerIps);

    foreach ($map as $extIp => $dockIp) {
        if (isset($_GET['server'])) {
            $_GET['server'] = $serverMapper($_GET['server'], $extIp, $dockIp);
        }
        if (isset($_POST['server'])) {
            $_POST['server'] = $serverMapper($_POST['server'], $extIp, $dockIp);
        }
    }
} else {
    die('The conf directory should contain a config with "docker-network" or "external-network" ' +
        'prefix. Check the PhpPgAdmin Configuration section in the README');
}
