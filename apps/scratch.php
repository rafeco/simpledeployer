<?php

require_once "SshHelper.php";

class Apps_Scratch {
    public function deployProduction() {
    }

    public function deployDevelopment() {
        $host = 'trudy.rc3.org';
        $remote_path = '/home/rafeco/scratch';
        $ssh_port = '22112';
        $user = 'rafeco';
        $key_path = "keys/deployment_key";

        $ssh_helper = new SshHelper($user, $host, $key_path, $ssh_port);

        $out = array();

        $git_fetch = "git --git-dir=$remote_path/.git --work-tree=$remote_path fetch 2>&1";

        // Log into the remote server and pull down the latest code
        $out[] = $ssh_helper->runCommand($git_fetch);

        $git_merge = "git --git-dir=$remote_path/.git --work-tree=$remote_path merge origin/master 2>&1";

        $out[] = $ssh_helper->runCommand($git_merge);

        $version_cmd = "git --git-dir=$remote_path/.git --work-tree=$remote_path describe > $remote_path/version.txt";

        $out[] = $ssh_helper->runCommand($version_cmd);

        return implode("\n", $out);
    }
}
