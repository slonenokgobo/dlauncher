<?php

require_once 'ssh_launchers.php';

function get_free_launcher() {
	global $ssh_launchers;

	foreach ($ssh_launchers as $launcher_id=>$launcher_command) {
		$output = array();
		exec("ps -ef | grep $launcher_id", $output);
		if (count($output) > 2) {
			continue;
		}
		return array("id"=>$launcher_id, "command"=>$launcher_command);
	}

	return null;
}


function execute_command($task_name, $command) {
	echo time().": Trying to execute $task_name\n";
	$launcher = get_free_launcher();
	$command = trim($command);

	if ($launcher) {
		logme("Found free launcher ".$launcher["id"]." for $task_name");
		logme("php ".dirname(__FILE__)."/launcher.php ".$launcher["id"]." \"".$launcher["command"]."\" \"".$command."\" $task_name 1>> $task_name 2>&1 &");
		exec("php ".dirname(__FILE__)."/launcher.php ".$launcher["id"]." \"".$launcher["command"]."\" \"".$command."\" $task_name 1>> $task_name 2>&1 &");
	}
}

