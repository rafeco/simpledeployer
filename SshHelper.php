<?php

require "Net/SSH2.php";
require "Crypt/RSA.php";

class SshHelper {
    var $user, $host, $password, $key_path, $port;

    public function __construct($user, $host, $password, $key_path, $port = 22) {
        $this->user = $user;
        $this->host = $host;
        $this->password = $password;
        $this->key_path = $key_path;
        $this->port = $port;
    }

    public function runCommand($cmd) {
        if (!empty($this->key_path)) {
            $key = new Crypt_RSA();
            $key->loadKey(file_get_contents($this->key_path));
        }

        $ssh = new Net_SSH2($this->host, $this->port);

        if ($key) {
            $ssh->login($this->user, $key);
        } else {
            $ssh->login($this->user, $this->password);
        }

        $out = $ssh->exec($cmd);
        return $out;
    }
}
