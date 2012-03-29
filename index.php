<?php
    require_once "config.php";
    require_once DEPLOYMENT_SCRIPTS . "/Applications.php";
    require_once "DeploymentDAO.php";
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
        <?php include "deployments.php" ?>
    </div>

    <div class="deploymentResults"></div>

    <!-- JavaScript at the bottom for fast page loading -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#progress').hide();
            $('#deploymentForm input[type="submit"]').click(function (event) {
                var formData = $(this).closest('form').serializeArray();
                formData.push({name: this.name, value: this.value});
                event.preventDefault();
                $('#deploymentForm').hide();
                $('#progress').show();
                $.ajax({
                    type: "POST",
                    url: $(this).closest('form').attr("action"),
                    data: formData,
                    error: function (jqXHR, textStatus, errorThrown) {
                        $('div.deploymentResults').after('<p class="ajaxError">' + errorThrown + '</p>');
                        $('#progress').hide();
                        $('#deploymentForm').show();
                    },
                    success: function () {
                        $('#deploymentHistory').load('deployments.php');
                        $('#deploymentForm textarea[name="comment"]').val('');
                        $('#progress').hide();
                        $('#deploymentForm').show();
                    }
                });
            });
        });
    </script>

</body>
</html>



