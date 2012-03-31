<?php
    require_once "DeploymentDAO.php";

    $dao = new DeploymentDAO();

    $deployments = $dao->findRecent();
?>
        <h2>Previous Deployments</h2>
        <ul>
            <?php foreach ($deployments as $d): ?>
                <li><?= $d->deployed_by ?> deployed
                    <strong><?= $d->app ?></strong>
                    (<a href="deployment.php?id=<?= $d->id ?>"><?= $d->deploy_tag ?></a>)
                    to <span class="<?= $d->environment ?>"><?= $d->environment ?></span>
                    on <?= $d->pretty_deployment_date() ?></li>
            <?php endforeach; ?>
        </ul>
