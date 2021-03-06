<?php

require_once "DeploymentDAO.php";
require_once DEPLOYMENT_SCRIPTS . "/Applications.php";

// If this script is being called from the command line,
// go ahead and try to deploy using the command line
// arguments.

if ("cli" == php_sapi_name()) {
    set_include_path(get_include_path() . PATH_SEPARATOR . "lib/phpseclib0");

    $deployer = new Deployer();

    if (count($argv) < 4) {
        echo "Usage: php Deployer.php APP environment [deployed by]\n";
        exit();
    }

    if (!array_key_exists($argv[1], $application_configs)) {
        echo "Invalid application.\n";
        exit();
    }

    $application = $application_configs[$argv[1]];;

    $deployer->deploy($application, $argv[2], $argv[3]);
}

class Deployer {
    var $dao;

    public function __construct($dao = null) {
        if (null == $dao) {
            $this->dao = new DeploymentDAO();
        } else {
            $this->dao = $dao;
        }
    }

    public function deploy($application, $environment = 'production', $deployed_by = null, $comment = null) {
        $deployment = new Deployment();
        $deployment->app = $application['name'];
        $deployment->environment = $environment;
        $deployment->deployed_by = $deployed_by;
        $deployment->comment = $comment;

        include $application['script'];
        $worker = new $application['deployer_class'];

        $out = '';

        if ($environment == 'production') {
            $out = $worker->deployProduction();
        } else if ($environment == 'development') {
            $out = $worker->deployDevelopment();
        }

        $application['version_url'] = $application[$environment . "_version_url"];

        $deployment->console_output = $out;

        $result = $this->getVersion($application['version_url']);

        if ($result) {
            $deployment->deploy_tag = trim($result);
        }

        $this->dao->save($deployment);
    }

    private function getVersion($url = '') {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);

        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ('200' != $http_status) {
            $result = "missing_version_file";
        } elseif (strlen($result) > 40) {
            $result = "invalid_tag";
        }

        return $result;
    }
}

