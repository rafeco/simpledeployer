    <div id="deploy">
        <h2>Deploy Now</h2>

        <div id="progress">
            <p>Deploying ...</p>
            <p><img src="ajax-loader.gif" /></p>
        </div>

        <form action="deploy.php" method="post" id="deploymentForm">
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
                <input name="push_environment" id="pushToDevelopment" type="submit" value="push to development" />
                <input name="push_environment" id="pushToProduction" type="submit" value="push to production" />
            </div>
        </form>
    </div>
