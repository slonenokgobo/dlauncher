dlauncher
=========

Distributed command launcher written in php.


Requierements

- php interpreter (php-cli package)
- git (you probably already have it)


Features

- parallel commands execution over ssh
- saving command output
- saving the whole hostory of job submission to git repository


Configure you server

- change $WORK_DIR in config.php
- configure the list of hosts in ssh_launchers.php


Run the server

- php job_tracker.php


Submit a job

- create a file with commands (what will be run in parallel) in your $WORK_DIR
