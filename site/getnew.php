<?php

$pathPlayers = 	"G:\\Spill\\Steam\\steamapps\\common\\Just Cause 2 - Multiplayer Dedicated Server\\scripts\\intermap\\intermap.txt";
$pathTps = 		"G:\\Spill\\Steam\\steamapps\\common\\Just Cause 2 - Multiplayer Dedicated Server\\scripts\\freeroam\\spawns.txt";

$array = array("players" => array(), "tps" => array());

$handle = fopen($pathPlayers, "r");
if($handle){
	while(($line = fgets($handle)) !== false){
		$line = str_replace("\r\n","",$line);
		if(!empty($line)){
			$exp = explode(",", $line);
			$array["players"][] = array("name" => $exp[0], "x" => $exp[1], "y" => $exp[2]);
		}
	}
}
else{
	echo "Error";
}

$handle = fopen($pathTps, "r");
if($handle){
	while(($line = fgets($handle)) !== false){
		$line = str_replace("\r\n","",$line);
		if($line[0] == "T" && !empty($line)){
			$exp = explode(", ", substr($line,2));
			$array["tps"][] = array("name" => $exp[0], "x" => $exp[1], "y" => $exp[3]);
		}
	}
}
else{
	echo "Error";
}

echo json_encode($array);
?>