<?php

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

    <title>SDN Deployer</title>

    <!-- Mobile viewport optimized: h5bp.com/viewport -->
    <meta name="viewport" content="width=device-width">

    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <div id="header">
        <h1>SDN Deployer</h1>
    </div>

    <div id="deploy">
        <h2>Deploy Now</h2>

        <form action="deploy.php" method="post">
            <div>
                <label>app</label>
                <select name="app">
                    <?php foreach (array_keys($application_configs) as $app): ?>
                        <option><?= $app ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label>comment</label>
                <textarea name="comment"></textarea>
            </div>

            <div>
                <input name="push_environment" type="submit" value="push to development" />
                <input name="push_environment" type="submit" value="push to production" />
            </div>
        </form>
    </div>

    <div id="deploymentHistory">
        <h2>Previous Deployments</h2>
        <ul>
            <?php foreach ($deployments as $d): ?>
                <li><?= $d->deployed_by ?> deployed <a href="deployment.php?id=<?= $d->id ?>"><?= $d->app ?> (tag <?= $d->deploy_tag ?>)</a> on <?= $d->pretty_deployment_date() ?></li>
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



