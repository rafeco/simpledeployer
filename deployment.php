<?php

    require_once "DeploymentDAO.php";

    $dao = new DeploymentDAO();

    $deployment = $dao->load($_GET['id']);

    if (null == $deployment) {
        header("Location: index.php");
    }
?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">

    <title>Deployment: <?= $deployment->app ?> (tag <?= $deployment->deploy_tag ?>)</title>

    <!-- Mobile viewport optimized: h5bp.com/viewport -->
    <meta name="viewport" content="width=device-width">

    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <div id="header">
        <h1>Deployment: <?= $deployment->app ?> (tag <?= $deployment->deploy_tag ?>)</h1>
    </div>

    <div id="deployment">
        <h2>Console Output</h2>
        <pre><?= $deployment->console_output ?></pre>

        <p>
            Go back to the <a href="index.php">list of deployments</a>.
        </p>
    </div>

    <!-- JavaScript at the bottom for fast page loading -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

</body>
</html>



