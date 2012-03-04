<?php

require_once "config.php";

class Deployment {
    var $id, $app, $environment, $deploy_tag, $deployed_by, $deployment_date, $comment, $console_output;

    public function pretty_deployment_date() {
        if ($this->deployment_date > 0) {
            return date('M j, Y H:i:s a', $this->deployment_date);
        } else {
            return "";
        }
    }
}

class DeploymentDAO {
    var $db;

    const DB_URL = 'sqlite:/tmp/deployments.sqlite3';

    public function __construct($db = null) {
        if (null == $db) {
            try {
                $this->db = new PDO(self::DB_URL);
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Connection failed: " + $e->getMessage();
            }
        } else {
            $this->db = $db;
        }

    }

    public function save($deployment) {
        if (null == $deployment) {
            return;
        }

        if (null == $deployment_id) {
            $this->insert($deployment);
        } else {
            $this->update($deployment);
        }
    }

    public function load($id = 0) {
        $stmt = $this->db->prepare("SELECT * FROM deployments WHERE id = :id");

        $stmt->execute(array(":id" => $id));

        $record = $stmt->fetch();

        if (null != $record) {
            return $this->recordToDeployment($record);
        } else {
            return null;
        }
    }

    public function destroy($id) {
        $stmt = $this->db->prepare("DELETE FROM deployments WHERE id = :id");

        $stmt->execute(array(":id", $id));
    }

    public function findRecent($app = null, $environment = null, $page = 1, $count = 15) {
        $query = "SELECT * FROM deployments ";

        $params = array();

        if ($app || $environment) {
            $query .= "WHERE 1 = 1 AND ";
            if ($app) {
                $query .= "app = :app ";
                $params[":app"] = $app;
            }

            if ($environment) {
                $query .= "environment = :environment ";
                $params[":environment"] = $environment;
            }
        }

        $query .= "ORDER BY deployment_date DESC ";
        $query .= "LIMIT $count";

        if ($page > 1) {
            $query .= "OFFSET = :offset";
            $params[":offset"] = ($count * ($page - 1));
        }

        $stmt = $this->db->prepare($query);

        $stmt->execute($params);

        return $this->recordsToDeployments($stmt->fetchAll());
    }

    private function insert($deployment) {
        $query = "INSERT INTO deployments (app, environment, deploy_tag, deployed_by, deployment_date, comment, console_output) ";
        $query .= "VALUES (:app, :environment, :deploy_tag, :deployed_by, :deployment_date, :comment, :console_output)";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':app', $deployment->app);
        $stmt->bindValue(':environment', $deployment->environment);
        $stmt->bindValue(':deploy_tag', $deployment->deploy_tag);
        $stmt->bindValue(':deployed_by', $deployment->deployed_by);
        $stmt->bindValue(':deployment_date', time());
        $stmt->bindValue(':comment', $deployment->comment);
        $stmt->bindValue(':console_output', $deployment->console_output);

        $stmt->execute();
    }

    private function update($deployment) {
        $query = "UPDATE deployments SET ";
        $query .= "app = :app, environment = :environment, deploy_tag = :deploy_tag, deployed_by = :deployed_by, ";
        $query .= "deployment_date = :deployment_date, comment => :comment, console_output = :console_output ";
        $query .= "WHERE id = :id";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':id', $deployment->id);
        $stmt->bindValue(':app', $deployment->app);
        $stmt->bindValue(':environment', $deployment->environment);
        $stmt->bindValue(':deploy_tag', $deployment->deploy_tag);
        $stmt->bindValue(':deployed_by', $deployment->deployed_by);
        $stmt->bindValue(':deployment_date', $deployment->deployment_date);
        $stmt->bindValue(':comment', $deployment->comment);
        $stmt->bindValue(':console_output', $deployment->console_output);

        $stmt->execute();
    }

    private function recordsToDeployments($records) {
        $deployments = array();

        foreach ($records as $record) {
            $deployments[] = $this->recordToDeployment($record);
        }

        return $deployments;
    }

    private function recordToDeployment($record) {
        if (null == $record || empty($record)) {
            return null;
        }

        $d = new Deployment();
        $d->id = $record['id'];
        $d->app = $record['app'];
        $d->environment = $record['environment'];
        $d->deploy_tag = $record['deploy_tag'];
        $d->deployed_by = $record['deployed_by'];
        $d->deployment_date = $record['deployment_date'];
        $d->comment = $record['comment'];
        $d->console_output = $record['console_output'];
        return $d;
    }
}
