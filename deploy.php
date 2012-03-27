<?php

    require_once DEPLOYMENT_SCRIPTS . "/Applications.php";
    require_once "Deployer.php";
    require_once "DeploymentDAO.php";

    // This page is only accessible via POST.
    if (!strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && empty($_POST)) {
        header("Location: index.php");
        exit();
    }

    $deployer = new Deployer;

    $deploy_to = preg_replace("/push to /", "", $_POST['push_environment']);

    $application = $application_configs[$_POST['app']];

    $deployment = $deployer->deploy($application, $deploy_to, $_SERVER['PHP_AUTH_USER'], $_POST['comment']);

    if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        echo json_encode(array("result" => "success"));
    }
    else {
        header("Location: index.php");
    }
