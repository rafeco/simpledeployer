<?php

$GLOBALS['application_configs'] = array();

$application_configs['scratch'] = array(
    'name' => 'scratch',
    'script' => DEPLOYMENT_SCRIPTS . '/scratch.php',
    'deployer_class' => 'Apps_Scratch',
    'version_url' => 'http://trudy.rc3.org/scratch/version.txt'
);
