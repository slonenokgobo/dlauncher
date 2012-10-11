<?php

// php launcher.php id launcher command taskname

$process_id = $argv[1];
$remote = $argv[2];
$command = $argv[3];

require_once 'config.php';
chdir($WORK_DIR);

$return_var = 0;
$op = array();
$output = exec($remote." \"".$command."\"", $op, $return_var);

logme("Task output ".$output);
logme("Task exit code ".$return_var);

if (isset($argv[4])) {
	$task = $argv[4];
	
	$message = "Task \"".$task."\" finished";
	if ($return_var != 0) {
		$message = "Task \"".$task."\" failed";
	}

	logme($message);
	
	exec("git add ".$task);
	exec("git commit -m '\"".$task."\" task finished' ".$task);
}
