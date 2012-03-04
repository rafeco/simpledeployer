<?php
    require_once "config.php";
    require_once "Applications.php";
    require_once "DeploymentDAO.php";

    $dao = new DeploymentDAO();

    $deployments = $dao->findRecent();
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

    <?php include "include/deploy_form.php" ?>


    <div id="deploymentHistory">
        <h2>Previous Deployments</h2>
        <ul>
            <?php foreach ($deployments as $d): ?>
                <li><?= $d->deployed_by ?> deployed
                    <a href="deployment.php?id=<?= $d->id ?>"><?= $d->app ?>
                    (tag <?= $d->deploy_tag ?>)</a>
                    to <?= $d->environment ?>
                    on <?= $d->pretty_deployment_date() ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="deploymentResults"></div>

    <!-- JavaScript at the bottom for fast page loading -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

    <script>
        $(document).ready(function () {
            $("#deploy form").submit(function () {
                var form = this;
                $("#deploy form :submit", form).attr('disabled', true);
            });
        });
    </script>

</body>
</html>



