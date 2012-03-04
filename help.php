<?php

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

    <div id="deploymentHistory">
        <ul>
        </ul>
    </div>

    <div id="deploy">
        <h2>Deploy Now</h2>

        <form>
            <div>
                <label>app</label>
                <select name="app">
                    <option>main site</option>
                    <option>forums</option>
                    <option>schools</option>
                    <option>q &amp; a</option>
                </select>
            </div>

            <div>
                <label>tag</label>
                <input type="text" size="25" maxlength="25" name="deploy_tag" />
            </div>

            <div>
                <label>comment</label>
                <textarea name="comment"></textarea>
            </div>

            <div>
                <input type="submit" value="deploy" />
            </div>
        </form>
    </div>

    <div class="deploymentResults"></div>

    <!-- JavaScript at the bottom for fast page loading -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

</body>
</html>



