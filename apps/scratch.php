<?php

class Apps_Scratch {
    public function deployProduction() {
    }

    public function deployDevelopment() {
        $remote_host = 'trudy.rc3.org';
        $remote_path = '/home/rafeco/scratch';
        $ssh_port = '22112';
        $remote_user = 'rafeco';

        $out = '';

        echo "Deploying $deployment->app to $remote_host ...\n";

        $out = array();

        $ssh_command = "ssh -p $ssh_port $remote_user@$remote_host";
        $git_fetch = "git --git-dir=$remote_path/.git fetch 2>&1";
        $git_merge = "git --git-dir=$remote_path/.git --work-tree=$remote_path merge origin/master 2>&1";

        // Log into the remote server and pull down the latest code
        $out[] = "$ssh_command '$git_fetch'";
        exec("$ssh_command '$git_fetch'", $out);

        $out[] = "$ssh_command '$git_merge'";
        exec("$ssh_command '$git_merge'", $out);

        $version_cmd = "$ssh_command 'git --git-dir=$remote_path/.git --work-tree=$remote_path describe > $remote_path/version.txt'";
        $out[] = $version_cmd;
        exec($version_cmd);

        return implode("\n", $out);
    }
}
