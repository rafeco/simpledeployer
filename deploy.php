<?php

    require_once DEPLOYMENT_SCRIPTS . "/Applications.php";
    require_once "Deployer.php";
    require_once "DeploymentDAO.php";

    // This page is only accessible via POST.
    if (empty($_POST)) {
        header("Location: index.php");
        exit();
    }

    $deployer = new Deployer;

    $deploy_to = preg_replace("/push to /", "", $_POST['push_environment']);

    $application = $application_configs[$_POST['app']];

    $deployment = $deployer->deploy($application, $deploy_to, $_SERVER['PHP_AUTH_USER'], $_POST['comment']);
?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">

    <title>Deployer</title>

    <!-- Mobile viewport optimized: h5bp.com/viewport -->
    <meta name="viewport" content="width=device-width">

    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <div id="header">
        <h1>Deployer</h1>
    </div>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>


</body>
</html>



