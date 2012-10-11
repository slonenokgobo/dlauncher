<?php

require_once 'config.php';
require_once 'resource_tracker.php';

function submit_new_jobs() {
	global $WORK_DIR;
	
	exec("git status -s", $output);

	foreach ($output as $i => $line) {
		$words = explode(" ", trim($line));
		$job = $words[1];

		if (strpos($job, ".task.") !== false) {
			logme("New task found $job");
			$task_lines = file($job);
			$task_command = $task_lines[0];
			execute_command($job, $task_command);
		}
		
		if (strpos($job, ".") !== false) {
			continue;
		}

		logme("New job found ".$job);
		$tasks = file($job);
		for ($n=0; $n < count($tasks); $n++) {
			file_put_contents($job.".task.".$n, $tasks[$n]);
		}
		exec("git add ".$job);
		exec("git commit -m '\"".$job."\" job submitted'");
	}
}

if (!is_dir($WORK_DIR)) {
	mkdir($WORK_DIR);
}

chdir($WORK_DIR);

if (!is_dir(".git")) {
	logme("Initializing git repository");
	exec("git init");
}

while (true) {
	logme("Looking for new jobs");
	submit_new_jobs();
	sleep($SCH_PERIOD);
}
