SimpleDeployer
==============

SimpleDeployer is a PHP application that enables you to deploy
applications using recipes that you create. There's an example
application included, `scratch`, to show how the recipes work.

Installation
------------

SimpleDeployer can be run out of any subdirectory of a Web site.
Just clone the repository. The next step is to set up the
SQLite3 database. First, specify the database location in
`config.php`. Due to the way SQLite works, both the database
file and the directory in which it resides must be writable
by the Web server. Once you've chosen a location, run the setup
script from the command line:

    php setup.php

Next you'll need to set up authentication for the application.
SimpleDeployer taps into basic authentication to keep track of
which user has run a deployment. The `.htaccess` file already
has an authentication realm set up. You'll need to generate the
user file using `htpasswd`. Read the man page for details.

You'll also need to specify the full path to your password
file in .htaccess. The relative path that's in there by default
will not work.

Adding a New Application
------------------------

Applications are listed in `Applications.php`. Each application
must have the following configuration parameters:

* `name` - The name of the application. Will be displayed in the
  UI.
* `script` - The path to the script containing the deployer
  class.
* `deployer_class` - The class name of the deployment recipe for
  the application.
* `version_url` - Your deployment recipe should not only deploy
  the application but also generate a file containing the version
  of the application that was deployed, accessible from the Web.
  The file should contain only that version designation. The
  deployer will retrieve that file and read the version from it
  so that it can be tracked by the Deployer's internal database.

The script path should be inferred from the deployer class name
or vice versa, but that hasn't happened yet.

Once you've defined an application, you'll need to create the
deployment recipe. Use the sample recipe for the `scratch`
application as a basic template.  The SSH helper is provided to
make it easy to run remote operations, but you're not required
to use it.

Currently, SimpleDeployer is hard-wired to deploy to development
and production. Obviously it will need to be more flexible in the
future. There are functions in the recipe class for each
environment. The recipe is responsible for moving the files to
the proper environment and generating a version file in that
environment at the URL specified in the application configuration.

Command Line Usage
------------------

You can test deployments from the command line by running
`Deployer.php` directly. It detects when it's run in that manner
and prompts the user for the proper arguments.

