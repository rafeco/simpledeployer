<?php

require_once "config.php";

$db = new PDO(DEPLOYMENT_DB_URL);

$query = "CREATE TABLE deployments (id INTEGER PRIMARY KEY AUTOINCREMENT, app TEXT, environment TEXT, deploy_tag TEXT, deployed_by TEXT, deployment_date INTEGER, result TEXT, comment TEXT, console_output TEXT)";

$db->exec($query);


