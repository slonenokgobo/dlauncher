<?php
$hosts = file($argv[1]);

echo "<?php\n";
echo "\$opt=\"\";\n";

echo "\$ssh_launchers = array(\n";

foreach($hosts as $line) {
	$arr = explode(" ", trim($line));
	if (strlen($arr[0]) == 0) {
		continue;
	}
	if (count($arr) > 1) {
		$host = $arr[0];
		$num = intval($arr[1]);
		for ($i=0; $i<$num; $i++) {
			echo "\"$arr[0]$i\" => \"ssh \$opt $arr[0] \",\n";
		}
	} else {
		echo "\"$arr[0]\" => \"ssh \$opt $arr[0] \",\n";
	}
}

echo ");\n";